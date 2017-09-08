<?php
/**
 * HomeController
 */

namespace King\Backend\Http\Controllers;

class DashboardController extends BackController {
       
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function index() {
        return view('backend::dashboard.index');
    }
    
}