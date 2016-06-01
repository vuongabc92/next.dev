<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * Get the user profile record associated with the user.
     */
    public function userProfile() {
        return $this->hasOne('App\Models\UserProfile');
    }
    
    /**
     * Get register error rules
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
     * Get register error messages
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
