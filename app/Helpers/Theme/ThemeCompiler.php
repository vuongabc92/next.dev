<?php
namespace App\Helpers\Theme;

use Carbon\Carbon;

class ThemeCompiler extends Compiler{
    
    /**
     * The path currently being compiled.
     *
     * @var string
     */
    protected $path;

    /**
     * The file name currently being compiled.
     *  
     * @var string 
     */
    protected $filename = 'index.html';

    /**
     * Folder name that container all themes
     *  
     * @var string 
     */
    protected $themesFolder = 'themes';

    /**
     * Public folder
     * 
     * @var string 
     */
    protected $publicFolder = 'public';

    /**
     * Array of opening and closing tags for function.
     *
     * @var array
     */
    protected $contentTags = ['{{', '}}'];
    
    /**
     * Array of opening and closing tags for regular echos.
     *
     * @var array
     */
    protected $functionTags = ['{%', '%}'];
    
    /**
     * Array of opening and closing tags for regular echos.
     *
     * @var array
     */
    protected $foreachPatterm = '/foreach(.*)/';
    
    /**
     * Experience variables name
     * 
     * @var string 
     */
    protected $experienceVariable = 'experiences';
    
    /**
     * Education variables name
     * 
     * @var string 
     */
    protected $educationVariable = 'education';
    
    /**
     * Skill variables name
     * 
     * @var string 
     */
    protected $skillVariable = 'skills';
    
    /**
     * Experience available properties
     * 
     * @var array 
     */
    protected $experienceProperties = [
        'TIME',
        'COMPANY_NAME',
        'POSITION',
        'DESCRIPTION'
    ];
    
    /**
     * Experience available properties
     * 
     * @var array 
     */
    protected $educationProperties = [
        'TIME',
        'COLLEGE_NAME',
        'SUBJECT',
        'QUALIFICATION'
    ];
    
    /**
     * Skill available properties
     * 
     * @var array 
     */
    protected $skillProperties = [
        'NAME',
        'RATES'
    ];

    /**
     * Array of variables
     *
     * @var array 
     */
    protected $variables = [
        'ASSET',
        'FIRST_NAME',
        'LAST_NAME',
        'ABOUT_ME',
        'MONTH_OF_BIRTH',
        'DATE_OF_BIRTH',
        'YEAR_OF_BIRTH',
        'BIRTHDAY',
        'AGE',
        'MARITAL_STATUS',
        'GENDER',
        'AVATAR_256',
        'STREET',
        'COUNTRY',
        'COUNTRY_CODE',
        'CITY',
        'CITY_TYPE',
        'DISTRICT',
        'DISTRICT_TYPE',
        'WARD',
        'WARD_TYPE',
        'WEBSITE',
        'EMAIL',
        'PHONE_NUMBER',
    ];
    
    /**
     * Compile the view at the given path.
     *
     * @param  string  $path
     * @return void
     */
    public function compile() {
        
        $file     = $this->generateFilenamePath();
        $contents = $this->compileString($this->files->get($file));
        $contents = $this->compileFunctions($contents);
        
        return $contents;
    }
    
    /**
     * Compile string variables
     * 
     * @param string $contents
     * 
     * @return string
     */
    protected function compileString($contents) {
        $pattern  = sprintf('/%s\s*(.+?)\s*%s(\r?\n)?/s', $this->contentTags[0], $this->contentTags[1]);
        $callback = function($matches) {
            
            if (in_array($matches[1], $this->variables)) {
                $methodSplit = explode('_', $matches[1]);
                $method      = 'compile';
                
                foreach ($methodSplit as $item) {
                    $method .= ucfirst($item);
                }
                
                if (method_exists($this, $method)) {
                    return $this->$method();
                }
            }
            
            return $matches[0];
        };
        
        return preg_replace_callback($pattern, $callback, $contents);
    }
    
    protected function compileFunctions($contents) {
        $pattern  = sprintf('/%s(.*?)%s(.*?)%s(.*?)%s/s', $this->functionTags[0], $this->functionTags[1], $this->functionTags[0], $this->functionTags[1]);
        $callback = function($matches) {
            
            $method = 'compile';
            if (preg_match($this->foreachPatterm, trim($matches[1]))) {
                $method .= 'Foreach';
            }
            
            return $this->$method($matches);
        };
        
        return preg_replace_callback($pattern, $callback, $contents);
    }
    
    protected function compileForeach($pregMatch) {
        if (preg_match('/foreach\((.*?)\)/', $pregMatch[1], $matches)) {
            
            $content = $matches[0];
            
            switch (strtolower(trim($matches[1]))) {
                case $this->experienceVariable:
                    $content = $this->compileExperience($pregMatch[2]);
                    break;
                
                case $this->educationVariable:
                    $content = $this->compileEducation($pregMatch[2]);
                    break;
                
                case $this->skillVariable:
                    $content = $this->compileSkill($pregMatch[2]);
                    break;
            }
            
            return $content;
        }
    }

    /**
     * Compile experiences
     * 
     * @param string $experienceRaw
     * 
     * @return string
     */
    protected function compileExperience($experienceRaw) {
        $employments = $this->resume->getEmployments();
        $content     = '';
        
        foreach ($employments as $one) {
            $content .= preg_replace_callback('/\[\[(.*?)\]\]/s', function($matches) use($one) {
                $expProperty = trim($matches[1]);
                
                if (in_array($expProperty, $this->experienceProperties)) {
                    switch($expProperty) {
                        case 'COMPANY_NAME':
                            return $one->company_name;
                            
                        case 'TIME':
                            $startTime = Carbon::parse($one->start_date)->format('m/Y');
                            $endTime   = ($one->is_current) ? _t('setting.employment.current') : Carbon::parse($one->end_date)->format('m/Y');
                            
                            return $startTime . ' - ' . $endTime; 
                            
                        case 'POSITION':
                            return $one->position;
                            
                        case 'DESCRIPTION':
                            return $one->achievement;
                            
                        default;
                    }
                }
            }, $experienceRaw);
        }
        
        return $content;
    }
    
    /**
     * Compile experiences
     * 
     * @param string $educationRaw
     * 
     * @return string
     */
    protected function compileEducation($educationRaw) {
        $education = $this->resume->getEducations();
        $content   = '';
        
        foreach ($education as $one) {
            $content .= preg_replace_callback('/\[\[(.*?)\]\]/s', function($matches) use($one) {
                $educationProperty = trim($matches[1]);
                
                if (in_array($educationProperty, $this->educationProperties)) {
                    switch($educationProperty) {
                        case 'COLLEGE_NAME':
                            return $one->college_name;
                            
                        case 'TIME':
                            $startTime = Carbon::parse($one->start_date)->format('m/Y');
                            $endTime   = Carbon::parse($one->end_date)->format('m/Y');
                            
                            return $startTime . ' - ' . $endTime; 
                            
                        case 'SUBJECT':
                            return $one->subject;
                            
                        case 'QUALIFICATION':
                            return $one->qualification->name;
                            
                        default;
                    }
                }
            }, $educationRaw);
        }
        
        return $content;
    }
    
    /**
     * Compile skills
     * 
     * @param string $skillRaw
     * 
     * @return string
     */
    protected function compileSkill($skillRaw) {
        $skills  = $this->resume->getSkills();
        $content = '';
        
        foreach ($skills as $one) {
            $content .= preg_replace_callback('/\[\[(.*?)\]\]/s', function($matches) use($one) {
                $skillProperty = trim($matches[1]);
                
                if (in_array($skillProperty, $this->skillProperties)) {
                    switch($skillProperty) {
                        case 'NAME':
                            return $one->skill->name;
                            
                        case 'RATES':
                            return $one->votes;
                            
                        default;
                    }
                }
            }, $skillRaw);
        }
        
        return $content;
    }
    
    /**
     * Compile asset path
     * 
     * @return string 
     */
    protected function compileAsset() {
        return asset($this->themesFolder . '/' . $this->getThemeName());
    }
    
    /**
     * Compile first name
     * 
     * @return string 
     */
    protected function compileFirstName() {
        return $this->resume->getFirstName();
    }
    
    /**
     * Compile last name
     * 
     * @return string 
     */
    protected function compileLastName() {
        return $this->resume->getLastName();
    }
    
    /**
     * Compile last name
     * 
     * @return string 
     */
    protected function compileAvatar256() {
        $avatarImg = unserialize($this->resume->getAvatarImages());
        
        return asset(config('frontend.avatarsFolder') . '/' . $avatarImg['256']);
    }
    
    /**
     * Compile contact website
     * 
     * @return string
     */
    protected function compileWebsite() {
        return $this->resume->getWebsite();
    }
    
    /**
     * Compile contact phone number
     * 
     * @return string
     */
    protected function compilePhoneNumber() {
        return $this->resume->getPhoneNumber();
    }
    
    /**
     * Compile contact email
     * 
     * @return string
     */
    protected function compileEmail() {
        return $this->resume->getEmail();
    }
    
    /**
     * Compile country name
     * 
     * @return string
     */
    protected function compileStreet() {
        return $this->resume->getStreetName();
    }
    
    /**
     * Compile country name
     * 
     * @return string
     */
    protected function compileCountry() {
        $country = $this->resume->getCountry();
        
        return $country['country_name'];
    }
    
    /**
     * Compile country code
     * 
     * @return string
     */
    protected function compileCountryCode() {
        $country = $this->resume->getCountry();
        
        return $country['country_code'];
    }
    
    /**
     * Compile city name
     * 
     * @return string
     */
    protected function compileCity() {
        $city = $this->resume->getCity();
        
        return $city['name'];
    }
    
    /**
     * Compile city type
     * 
     * @return string
     */
    protected function compileCityType() {
        $city = $this->resume->getCity();
        
        return $city['type'];
    }
    
    /**
     * Compile district name
     * 
     * @return string
     */
    protected function compileDistrict() {
        $district = $this->resume->getDistrict();
        
        return $district['name'];
    }
    
    /**
     * Compile district type
     * 
     * @return string
     */
    protected function compileDistrictType() {
        $district = $this->resume->getDistrict();
        
        return $district['type'];
    }
    
    /**
     * Compile ward name
     * 
     * @return string
     */
    protected function compileWard() {
        $ward = $this->resume->getWard();
        
        return $ward['name'];
    }
    
    /**
     * Compile about me
     * 
     * @return string
     */
    protected function compileAboutMe() {
        return $this->resume->getAboutMe();
    }
    
    /**
     * Compile gender
     * 
     * @return string
     */
    protected function compileGender() {
        $gender = $this->resume->getGender();
        
        return $gender['gender_name'];
    }
    
    /**
     * Compile date of birth
     * 
     * @return string
     */
    protected function compileDatefBirth() {
        return (($d = ((int) $this->getDobDateTime()->format('d'))) < 10) ? "0$d" : $d;
    }
    
    /**
     * Compile month of birth
     * 
     * @return string
     */
    protected function compileMonthOfBirth() {
         return (($m = ((int) $this->getDobDateTime()->format('m'))) < 10) ? "0$m" : $m;
    }
    
    /**
     * Compile year of birth
     * 
     * @return string
     */
    protected function compileYearOfBirth() {
         return $this->getDobDateTime()->format('Y');
    }
    
    /**
     * Compile birthday
     * 
     * @return string
     */
    protected function compileBirthDay() {
         return $this->resume->getDob();
    }
    
    /**
     * Compile marital status
     * 
     * @return string
     */
    protected function compileMaritalStatus() {
        $status = $this->resume->getMaritalStatus();
        
        return $status['name'];
    }
    
    /**
     * Compile age
     * 
     * @return string
     */
    protected function compileAge() {
        return ((int) date('Y')) - ((int) $this->getDobDateTime()->format('Y'));
    }
    
    protected function getDobDateTime() {
        return new \DateTime($this->resume->getDob());
    }

    /**
     * Generate the path to the file currently being compiled
     * 
     * @return string
     */
    protected function generateFilenamePath() {
        return base_path($this->publicFolder . '/' . $this->themesFolder . '/' . $this->getThemeName() . '/' . $this->filename);
    }
}
