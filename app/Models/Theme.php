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
    
    /**
     * Check current user intalled this theme or not
     * 
     * @return boolean
     */
    public function isInstalled() {
        return ($this->id === Auth::user()->userProfile->theme_id);
    }

    /**
     * Get theme's json info
     * 
     * @return boolean|array
     */
    public function getJson() {
        
        $filePath = public_path(config('frontend.themesFolder') . "/{$this->slug}/{$this->slug}.json");
        
        if (check_file($filePath)) {
            return (object) json_decode(file_get_contents($filePath), true);
        }
        
        return false;
    }
    
    public function getViewMode() {
        if ($this->getJson() && property_exists($this->getJson(), 'view_mode')) {
            $viewMode = $this->getJson()->view_mode;
            
            return ($viewMode !== '') ? explode('|', $viewMode) : [];
        }
        
        return false;
    }
}
