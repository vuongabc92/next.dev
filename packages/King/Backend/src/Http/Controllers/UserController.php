<?php
/**
 * HomeController
 */

namespace King\Backend\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
    
    public function updateStatus(Request $request) {
        $userId = (int) $request->get('user_id');
        $user   = User::find($userId);
        
        if (null === $user) {
            return redirect()->back();
        }
        
        if ($user->activated) {
            $user->activated = 0;
        } else {
            $user->activated = 1;
        }
        
        $user->save();
        
        return redirect()->back();
    }
    
    public function remove(Request $request) {
        $userId = (int) $request->get('user_id');
        $user   = User::find($userId);
        
        if (null === $user) {
            return redirect(route('back_users'));
        }
        
        $user->delete();
        
        return redirect(route('back_users'));
    }
    
}