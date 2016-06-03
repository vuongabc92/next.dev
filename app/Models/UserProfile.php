<?php

namespace App\Models;

class UserProfile extends Base {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_profile';
    
    /**
     * Get the user profile record associated with the gender.
     */
    public function gender() {
        return $this->hasOne('App\Models\Gender');
    }
}
