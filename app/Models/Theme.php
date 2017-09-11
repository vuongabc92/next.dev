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
    
    public function expertises() {
        return ($this->expertises) ? unserialize($this->expertises) : [];
    }
    
    /**
     * Check current user intalled this theme or not
     * 
     * @return boolean
     */
    public function isInstalled() {
        return ($this->id === Auth::user()->userProfile->theme_id);
    }
    
    public function getThumbnail() {
        $themesFolder = config('frontend.themesFolder');
        
        return $themesFolder . '/' . $this->slug . '/thumbnail.png';
    }
    
    public function getScreenshot() {
        $themesFolder = config('frontend.themesFolder');
        
        return $themesFolder . '/' . $this->slug . '/screenshot.png';
    }
}
