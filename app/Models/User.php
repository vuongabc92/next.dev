<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use King\Frontend\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable {
    
    use Notifiable;
    
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
     * Get the employment history record associated with the user.
     */
    public function employmentHistories() {
        return $this->hasMany('App\Models\EmploymentHistory');
    }
    
    /**
     * Get the education record associated with the user.
     */
    public function educations() {
        return $this->hasMany('App\Models\Education');
    }
      
    /**
     * Get the skill record associated with the user.
     */
    public function skills() {
        return $this->hasMany('App\Models\UserSkill');
    }
    
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPasswordNotification($token));
    }
}
