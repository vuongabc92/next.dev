<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Hash;

trait SaveSettings {
    
    /**
     * User validate rules
     * @var array 
     */
    protected $userValidateRules;
    
    /**
     * User validate messages
     *
     * @var array 
     */
    protected $userValidateMessages;
    
    public function __construct() {
        $this->userValidateRules    = user()->getRegisterRules();
        $this->userValidateMessages = user()->getRegisterMessages();
    }

    /**
     * Save settings email.
     * 
     * @param Request $request
     * 
     * @return boolean|JSON
     */
    public function saveEmail(Request $request) {
        
        $validator = validator($request->all(), $this->_saveEmailValidateRules(), $this->userValidateMessages);
        $validator->after(function($validator) use($request) {
            if ( ! Hash::check($request->get('password'), user()->password)) {
                $validator->errors()->add('password', _t('auth.login.pass_wrong'));
            }
        });
        
        if ($validator->fails()) {
            return $validator;
        }
        
        user()->email = $request->get('email');
        user()->save();
        
        return true;
    }
    
    /**
     * Save settings slug.
     * 
     * @param Request $request
     * 
     * @return boolean|JSON
     */
    public function saveSlug(Request $request) {
        
        $validator = validator($request->all(), $this->_saveSlugValidateRules(),$this->_saveSlugValidateMessages());
        if ($validator->fails()) {
            return $validator;
        }
        
        $userProfile = user()->userProfile;
        $slug        = $request->get('slug');

        if (is_null($userProfile)) {
            $userProfile          = new UserProfile();
            $userProfile->user_id = user_id();
        }
        
        $userProfile->slug = $slug;
        $userProfile->save();
        
        return true;
    }
    
    /**
     * Save settings password.
     * 
     * @param Request $request
     * 
     * @return boolean|JSON
     */
    public function savePassword(Request $request) {
        $validator = validator($request->all(), $this->_savePasswordValidateRules(), $this->_savePasswordValidateMessages());
        
        $validator->after(function($validator) use($request) {
            if ( ! Hash::check($request->get('old_password'), user()->password)) {
                $validator->errors()->add('old_password', _t('auth.login.pass_wrong'));
            }
        });
        
        if ($validator->fails()) {
            return $validator;
        }
        
        user()->password = bcrypt($request->get('new_password'));
        user()->save();
        
        return true;
    }

    /**
     * Save email validate rules
     * 
     * @return array
     */
    protected function _saveEmailValidateRules() {
        return [
            'email'    => 'required|email|max:128|unique:users,email,' . user_id() . ',id', 
            'password' => 'required'
        ];
    }
    
    /**
     * Save slug validate rules
     * 
     * @return array
     */
    protected function _saveSlugValidateRules() {
        return ['slug' => 'required|min:2|max:128|unique:user_profile,slug,' . user_id() . ',user_id'];
    }
    
    /**
     * Save slug validate messages
     * 
     * @return array
     */
    protected function _saveSlugValidateMessages() {
        return [
            'slug.required' => _t('setting.profile.slug_req'),
            'slug.min'      => _t('setting.profile.slug_min'),
            'slug.max'      => _t('setting.profile.slug_max'),
            'slug.unique'   => _t('setting.profile.slug_uni'),
        ];
    }
    
    /**
     * Save slug validate rules
     * 
     * @return array
     */
    protected function _savePasswordValidateRules() {
        return [
            'old_password'              => 'required',
            'new_password'              => 'required|min:6|max:60|confirmed',
            'new_password_confirmation' => 'required|min:6|max:60',
        ];
    }
    
    /**
     * Save slug validate messages
     * 
     * @return array
     */
    protected function _savePasswordValidateMessages() {
        return [
            'old_password.required'              => _t('setting.profile.oldpass_req'),
            'old_password.min'                   => _t('setting.profile.oldpass_min'),
            'old_password.max'                   => _t('setting.profile.oldpass_max'),
            'new_password.required'              => _t('setting.profile.newpass_req'),
            'new_password.min'                   => _t('setting.profile.newpass_min'),
            'new_password.max'                   => _t('setting.profile.newpass_max'),
            'new_password.confirmed'             => _t('setting.profile.newpass_con'),
            'new_password_confirmation.required' => _t('setting.profile.renewpass_req'),
            'new_password_confirmation.min'      => _t('setting.profile.renewpass_min'),
            'new_password_confirmation.max'      => _t('setting.profile.renewpass_max'),
        ];
    }
     
}