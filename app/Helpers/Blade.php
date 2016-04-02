<?php

namespace App\Helpers;

use Blade as BladeTemplate;

class Blade {

    public function __construct() {

        BladeTemplate::extend(function($value) {
            return preg_replace('/\@set(.+)/', '<?php ${1}; ?>', $value);
        });
    }
}