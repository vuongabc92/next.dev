<?php
/**
 * HomeController
 */

namespace King\Frontend\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use King\Frontend\Http\Controllers\FrontController;
use Validator;
use App\Models\User;
use App\Models\UserProfile;
class AuthController extends FrontController {

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/settings';
    
    /**
     * Where to redirect users after logout.
     *
     * @var string
     */
    protected $redirectAfterLogout = '/';
    
    /**
     * User model
     *
     * @var App\Model\User 
     */
    protected $user; 


/**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(User $user) {
        $this->middleware('guest', ['except' => 'logout']);
        $this->user = $user;
    }

    /**
     * Show the application login form.
     *
     * @return type
     */
    public function showLoginForm() {
        return view('frontend::auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request) {
        $this->validate($request, $this->getLoginRules(), $this->getLoginMessages());

        return $this->login($request);
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
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        $user = User::create([
            'email'    => $data['email'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);
        
        $slug = $data['username'];
        $i    = 0;
        
        while(null !== UserProfile::where('slug', $slug)->first()) {
            $i++;
            $slug .= $i;
        }
        
        $userProfile = new UserProfile();
        $userProfile->user_id = $user->id;
        $userProfile->slug    = $slug;
        $userProfile->save();
        
        return $user;
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, $this->user->getRegisterRules(), $this->user->getRegisterMessages());
    }

    /**
     * Get login error rules
     *
     * @return array
     */
    protected function getLoginRules() {
        return [
            'email'    => 'required',
            'password' => 'required',
        ];
    }

    /**
     * Get login error messages
     *
     * @return array
     */
    protected function getLoginMessages() {
        return [
            'email.required'    => _t('auth.email.required'),
            'password.required' => _t('auth.pass.required'),
        ];
    }

    /**
     * Get the login lockout error message.
     *
     * @param  int  $seconds
     * @return string
     */
    protected function getLockoutErrorMessage($seconds) {
        return _t('auth.login.throttles', ['second' => $seconds]);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage() {
        return _t('auth.login.failed');
    }
}