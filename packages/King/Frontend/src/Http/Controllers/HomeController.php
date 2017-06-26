<?php
/**
 * HomeController
 */

namespace King\Frontend\Http\Controllers;

use App\Models\Theme;
use Facebook\Facebook;

class HomeController extends FrontController {
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function landing() {
        if ( ! session_id()) {
            session_start();
        }
        
        $fb_api      = config('frontend.facebook_api');
        $fb          = new Facebook($fb_api);
        $helper      = $fb->getRedirectLoginHelper();
        $permissions = ['email'];
        $fbloginUrl  = $helper->getLoginUrl(route('front_login_with_fbcallback'), $permissions);
        
        return view('frontend::landing.index', [
            'fbLoginUrl' => $fbloginUrl
        ]);
    }
}