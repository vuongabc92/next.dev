<?php
/**
 * HomeController
 */

namespace King\Backend\Http\Controllers;

use App\Models\User;
use App\Models\Theme;

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
        
        return view('backend::dashboard.index', [
            'totalUser'  => User::all()->count(),
            'totalTheme' => Theme::all()->count()
        ]);
    }
    
}