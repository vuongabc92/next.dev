<?php
/**
 * HomeController
 */

namespace King\Backend\Http\Controllers;

use App\Models\User;

class UserController extends BackController {
       
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function index() {
        
        $maxPerPage = config('backend.pagination.max_per_page');
        $users      = User::paginate($maxPerPage);
        
        return view('backend::users.index',[
            'users'      => $users,
            'maxPerPage' => $maxPerPage
        ]);
    }
    
    public function view($id) {
        
        $user = User::find($id);
        
        if (null === $user) {
            return redirect()->back();
        }
        
        return view('backend::users.view',[
            'user' => $user
        ]);
    }
    
}