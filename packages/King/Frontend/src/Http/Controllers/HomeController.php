<?php
/**
 * HomeController
 */

namespace King\Frontend\Http\Controllers;

use App\Helpers\OutWorldAuth;

class HomeController extends FrontController {
    
    use OutWorldAuth {
        OutWorldAuth::__construct as private __owaConstruct;
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
        $this->__owaConstruct();
    }
    
    public function landing() {
        if ( ! session_id()) {
            session_start();
        }
        
        return view('frontend::home.landing', [
            'fbLoginUrl'     => $this->facebookAuthUrl(),
            'googleLoginUrl' => $this->googleAuthUrl(),
        ]);
    }
    
    public function about() {
        return view('frontend::home.about');
    }
}