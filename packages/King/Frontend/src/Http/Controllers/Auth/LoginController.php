<?php

namespace King\Frontend\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use King\Frontend\Http\Controllers\FrontController;
use Facebook\Facebook;

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
        return view('frontend::auth.login');
    }
    
    public function loginWithFBCallback() {
        if (!session_id()) {
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
            if ($helper->getError()) {
                Log::error('Error: ' . $helper->getError());
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }
        
        session('fb_access_token', $accessToken->getValue());
        
        $fb->setDefaultAccessToken($accessToken->getValue());
        $response = $fb->get('/me?locale=en_US&fields=name,email');
        $userNode = $response->getGraphUser();
        var_dump($userNode->getFirstName(),
            $userNode->getField('email'), $userNode['email']
        );
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
}
