<?php

namespace App\Helpers\Theme;

class Config {
    
    /**
     *  Configuration list
     * 
     * @var array 
     */
    protected $config;
    
    public $defaultConfig; 


    public function __construct($config) {
        $this->config        = $config;
        $this->defaultConfig = config('frontend.wkhtmltopdf');
    }
    
    public function getConfigPdf() {
        if (count($this->config)) {
            $configPdf = [];
            foreach($this->config as $one) {
                $configSplit = explode(':', $one);
                $checkCogPdf = substr($configSplit[0], 0, 4);
                
                if ($checkCogPdf === 'pdf-') {
                    $realCogKey             = substr($configSplit[0], 4, strlen($configSplit[0]) - 4);
                    $configPdf[$realCogKey] = isset($configSplit[1]) ? $configSplit[1] : null;
                }
            }
            
            return $configPdf;
        }
        
        return [];
    }
}
    