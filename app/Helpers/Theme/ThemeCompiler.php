<?php
namespace App\Helpers\Theme;

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
     * Array of opening and closing tags for regular echos.
     *
     * @var array
     */
    protected $contentTags = ['{{', '}}'];
    
    protected $variables = [
        'ASSET',
        'FIRST_NAME',
        'LAST_NAME',
        'AVATAR_256'
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
        
        return $contents;
    }
    
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
        
        return config('frontend.avatarsFolder') . '/' . $avatarImg['256'];
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