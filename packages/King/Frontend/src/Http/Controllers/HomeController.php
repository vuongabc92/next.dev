<?php
/**
 * HomeController
 */

namespace King\Frontend\Http\Controllers;

use App\Models\Theme;

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
        $themes = Theme::all();
        
        return view('frontend::home.landing', [
            'themes' => $themes
        ]);
    }
    
    public function about() {
        return view('frontend::home.about');
    }
    
    public function contact() {
        return view('frontend::home.contact');
    }
}