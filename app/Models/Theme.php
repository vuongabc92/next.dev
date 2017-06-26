<?php

namespace App\Models;

use Auth;

class Theme extends Base {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'themes';
    
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    public function devices() {
        return ($this->devices) ? unserialize($this->devices) : [];
    }
    
    /**
     * Check current user intalled this theme or not
     * 
     * @return boolean
     */
    public function isInstalled() {
        return ($this->id === Auth::user()->userProfile->theme_id);
    }
}
