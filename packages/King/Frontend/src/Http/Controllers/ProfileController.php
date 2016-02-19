<?php
/**
 * ProfileController
 */

namespace King\Frontend\Http\Controllers;

class ProfileController extends FrontController {
    
    public function index() {
        return view('frontend::profile.index');
    }
}