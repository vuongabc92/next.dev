<?php

namespace App\Helpers;

use Blade as BladeTemplate;
use Form;

class Blade {

    public function __construct() {

        BladeTemplate::extend(function($value) {
            return preg_replace('/\@set(.+)/', '<?php ${1}; ?>', $value);
        });
        
        Form::component('kingSelect', 'frontend::components.form.select', ['name', 'value', 'default', 'attributes', 'present']); 
    }
}