<?php

namespace King\Frontend\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserProfile;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/settings';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm() {
        return view('frontend::auth.register');
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * 
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, $this->getRegisterRules(), $this->getRegisterMessages());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * 
     * @return User
     */
    protected function create(array $data) {
        
        $user = User::create([
            'email'    => $data['email'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);
        
        $userProfile          = new UserProfile();
        $userProfile->user_id = $user->id;
        $userProfile->slug    = $data['username'];
        $userProfile->save();
        
        return $user;
    }
    
    /**
     * Get register validation rules
     *
     * @return type
     */
    public function getRegisterRules() {
        return [
            'email'    => 'required|email|max:128|unique:users,email',
            'username' => 'required|min:6:|max:64|unique:users,username',
            'password' => 'required|min:6|max:60',
        ];
    }
    
    /**
     * Get register validation messages
     * 
     * @return array
     */
    public function getRegisterMessages() {
        return [
            'email.required'    => _t('register.email.req'),
            'email.email'       => _t('register.email.email'),
            'email.max'         => _t('register.email.max'),
            'email.unique'      => _t('register.email.uni'),
            'username.required' => _t('register.uname.req'),
            'username.min'      => _t('register.uname.min'),
            'username.max'      => _t('register.uname.max'),
            'username.unique'   => _t('register.uname.uni'),
            'password.required' => _t('register.pass.req'),
            'password.min'      => _t('register.pass.min'),
            'password.max'      => _t('register.pass.max'),
        ];
    }
}
