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
    
    public function isInstalled() {
        return ($this->id === Auth::user()->userProfile->theme_id);
    }

}
