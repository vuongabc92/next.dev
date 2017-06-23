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
        
        $themes = Theme::limit(6)->get();
        
        return view('frontend::landing.index', [
            'themes' => $themes
        ]);
    }
}