<?php

namespace King\Frontend\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use King\Frontend\Http\Controllers\FrontController;
use Facebook\Facebook;
use App\Models\User;
use App\Models\UserProfile;
use Log;

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
    }
    
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm() {
        if ( ! session_id()) {
            session_start();
        }
        
        $fb_api      = config('frontend.facebook_api');
        $fb          = new Facebook($fb_api);
        $helper      = $fb->getRedirectLoginHelper();
        $permissions = ['email', 'public_profile'];
        $fbloginUrl  = $helper->getLoginUrl(route('front_login_with_fbcallback'), $permissions);
        
        
        return view('frontend::auth.login', [
            'fbLoginUrl' => $fbloginUrl
        ]);
    }
    
    public function loginWithFBCallback() {
        if ( ! session_id()) {
            session_start();
        }
        
        $fb_api = config('frontend.facebook_api');
        $fb     = new Facebook($fb_api);
        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            Log::error('Graph returned an error: ' . $e->getMessage());
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            Log::error('Facebook SDK returned an error: ' . $e->getMessage());
            exit;
        }

        if ( ! isset($accessToken)) {
            return redirect(route('front_login'));
        }
        
        session('fb_access_token', $accessToken->getValue());
        
        $fb->setDefaultAccessToken($accessToken->getValue());
        $response  = $fb->get('/me?locale=en_US&fields=name,email');
        $userNode  = $response->getGraphUser();
        $userFBEmail = $userNode->getField('email');
        
        if ($userFBEmail) {
            $userByEmail = User::where('email', $userFBEmail)->first();
            
            if ($userByEmail) {
                auth()->loginUsingId($userByEmail->id);
            } else {
                $user        = new User();
                $user->email = $userFBEmail;
                $user->save();
                
                $userProfile          = new UserProfile();
                $userProfile->user_id = $user->id;
                $userProfile->slug    = $this->_randomSlug();
                $userProfile->save();
            }
            
            return redirect(route('front_settings'));
        }
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
    
    protected function _randomSlug() {
        
        $slug        = random_string(16, $available_sets = 'lud');
        $userProfile = UserProfile::where('slug', $slug)->first();
        
        if ($userProfile) {
            $this->_randomSlug();
        }
        
        return $slug;
        
    }
}
