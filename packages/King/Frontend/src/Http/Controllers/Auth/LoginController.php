<?php

namespace King\Frontend\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use King\Frontend\Http\Controllers\FrontController;
use App\Models\User;
use App\Models\UserProfile;
use Log;
use App\Helpers\OutWorldAuth;
use Google_Service_Oauth2_Userinfoplus;

class LoginController extends FrontController {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    use OutWorldAuth {
        OutWorldAuth::__construct as private __owaConstruct;
    }
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/settings';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
        $this->__owaConstruct();
    }
    
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm() {
        
        if ( ! session_id()) session_start();
        
        return view('frontend::auth.login', [
            'fbLoginUrl'     => $this->facebookAuthUrl(),
            'googleLoginUrl' => $this->googleAuthUrl(),
        ]);
    }
    
    /**
     * Signup/Login with facebook
     * 
     * @return type void
     */
    public function loginWithFBCallback() {
        if ( ! session_id()) session_start();
        
        $fb     = $this->facebook();
        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            Log::error('Graph returned an error: ' . $e->getMessage());
            return redirect(route('front_login'));
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            Log::error('Facebook SDK returned an error: ' . $e->getMessage());
            return redirect(route('front_login'));
        }

        if ( ! isset($accessToken)) {
            return redirect(route('front_login'));
        }
        
        session('fb_access_token', $accessToken->getValue());
        
        $fb->setDefaultAccessToken($accessToken->getValue());
        
        $response  = $fb->get('/me?locale=en_US&fields=email,picture.width(512).height(512),first_name,last_name');
        $userNode  = $response->getGraphUser();
        $fbEmail   = $userNode->getField('email');
        
        if ($fbEmail) {
            $this->logUserInFromOutWorld([
                'email'      => $fbEmail,
                'avatar'     => $userNode->getField('picture')->getUrl(),
                'first_name' => $userNode->getField('first_name'),
                'last_name'  => $userNode->getField('last_name'),
            ]);
            
            return redirect(route('front_settings'));
        }
        
        return redirect(route('front_login'));
    }

    /**
     * Signup/Login with google
     * 
     * @return void
     */
    public function loginWithGoogle() {
        
        $client = $this->googleClient();
        
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $client->setAccessToken($client->getAccessToken());
           
            $userAuthenticated = $this->googleUserInfo();
            
            if ($userAuthenticated instanceof Google_Service_Oauth2_Userinfoplus && $userAuthenticated->email) {
                $this->logUserInFromOutWorld([
                    'email'      => $userAuthenticated->email,
                    'avatar'     => $userAuthenticated->picture,
                    'first_name' => $userAuthenticated->givenName,
                    'last_name'  => $userAuthenticated->familyName,
                ]);
            
                return redirect(route('front_settings'));
            }
        }  
        
        return redirect(route('front_login'));
    }
    
    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request) {
        $this->validate($request, ['email' => 'required', 'password' => 'required'], ['email.required' => _t('auth.email.required'), 'password.required' => _t('auth.pass.required')]);
    }
    
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request) {
        return redirect(route('front_login'))
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => \Lang::get('auth.failed'),
            ]);
    }
    
    /**
     * Login/Signup user by email
     * 
     * @param type $data
     * 
     * @return void
     */
    public function logUserInFromOutWorld($data) {
        
        $email     = isset($data['email'])      ? $data['email']      : '';
        $avatar    = isset($data['avatar'])     ? $data['avatar']     : '';
        $firstName = isset($data['first_name']) ? $data['first_name'] : '';
        $lastName  = isset($data['last_name'])  ? $data['last_name']  : '';
        $user      = User::where('email', $email)->first();
        $emailSplit = explode('@', $email);
            
        if (is_null($user)) {
            $user        = new User();
            $user->email = $email;
            $user->save();
            
            $userProfile          = new UserProfile();
            $userProfile->user_id = $user->id;
            $userProfile->slug    = $this->_randomSlug($emailSplit[0]);
            
            if ($avatar) {
                $avatar                    = $this->saveOutWorldAvatar($avatar);
                $userProfile->avatar_image = serialize($avatar);
            }
            
            if ($firstName) {$userProfile->first_name = $firstName;}
            if ($lastName) {$userProfile->last_name = $lastName;}
            
            $userProfile->save();
        }
        
        auth()->loginUsingId($user->id);
    }
    
    /**
     * Save avatar from social
     * 
     * @param type $avatarUrl
     * @return type
     */
    public function saveOutWorldAvatar($avatarUrl) {
        try {
            $storagePath = config('frontend.avatarsFolder');
            $sizes       = config('frontend.avatarSizes');
            $fileinfo    = pathinfo($avatarUrl, PATHINFO_EXTENSION);
            $extension   = explode('?', $fileinfo);
            
            unset($sizes['original']);
            
            foreach ($sizes as $size) {
                $name = generate_filename($storagePath, $extension[0], [
                    'prefix' => 'avatar_', 
                    'suffix' => "_{$size['w']}x{$size['h']}"
                ]);
                
                file_put_contents($storagePath . '/' . $name, file_get_contents($avatarUrl));

                $names[$size['w']] = $name;
            }
            
            return $names;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }
    
    /**
     * Random slug
     * 
     * @param $prefix string
     * 
     * @return string
     */
    protected function _randomSlug($prefix) {
        
        $userProfile = UserProfile::where('slug', $prefix)->first();
        
        if ($userProfile === null) {
            return $prefix;
        }
        
        $slug        = $prefix . random_string(6, $available_sets = 'lud');
        $userProfile = UserProfile::where('slug', $slug)->first();
        
        if ($userProfile) {
            $this->_randomSlug($prefix);
        }
        
        return $slug;
    }
}
