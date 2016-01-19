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
class AuthController extends FrontController {

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, $this->getRegisterRules(), $this->getRegisterMessages());
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
     * Get register error rules
     *
     * @return type
     */
    protected function getRegisterRules() {
        return [
            'email'    => 'required|email|max:128|unique:users',
            'username' => 'required|min:6:|max:64|unique:users',
            'password' => 'required|min:6',
        ];
    }

    public function getRegisterMessages() {
        return [
            'email.required'    => _t('front.register.email.req'),
            'email.email'       => _t('front.register.email.email'),
            'email.max'         => _t('front.register.email.max'),
            'email.unique'      => _t('front.register.email.uni'),
            'username.required' => _t('front.register.uname.req'),
            'username.min'      => _t('front.register.uname.min'),
            'username.max'      => _t('front.register.uname.max'),
            'username.unique'   => _t('front.register.uname.uni'),
            'password.required' => _t('front.register.pass.req'),
            'password.min'      => _t('front.register.pass.min'),
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