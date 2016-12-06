<?php
/**
 * Theme Controller
 */

namespace King\Frontend\Http\Controllers;

class ThemeController extends FrontController {
    
    public function index() {
        return view('frontend::theme.index');
    }
}
