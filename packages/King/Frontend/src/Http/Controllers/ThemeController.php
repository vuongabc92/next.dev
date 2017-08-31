<?php
/**
 * Theme Controller
 */

namespace King\Frontend\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use App\Models\Expertise;
use Validator;
use File;


class ThemeController extends FrontController {
    
    /**
     * List themes
     * 
     * @return void
     */
    public function index() {
        $currentTheme   = null;
        $expertises     = Expertise::all()->sortBy('name')->pluck('name', 'id')->toArray();
        $uploadedThemes = collect([]);
        
        if(auth()->check()) {
            $currentTheme   = user()->userProfile->theme;
            $uploadedThemes = user()->themes;
        }
        
        if ($currentTheme === null) {
            $currentTheme = Theme::where('slug', config('frontend.defaultThemeName'))->first();
        }
        
        return view('frontend::theme.index', [
            'expertises'     => ['' => _t('theme.upload.themeallExpertises')] + $expertises,
            'uploadedThemes' => $uploadedThemes,
            'currentTheme'   => $currentTheme,
        ]);
    }
    
    /**
     * Update user cv theme
     * 
     * @param Request $request
     * @param type $id
     */
    public function install(Request $request) {
        if ($request->ajax() && $request->isMethod('post')) {
            
            $id = (int) $request->get('theme_id');
            
            if (Theme::find($id) !== null) {
                user()->userProfile->theme_id = $id;
                user()->userProfile->save();
                
                return pong(['message' => _t('saved')]);
            } 
            
            return pong(['message' => _t('oops')], _error(), 403);
        }
    }
    
    public function themeDetails($themeId) {
        $theme       = Theme::find($themeId);
        $userProfile = $theme->user->userProfile;
        
        if ( $theme !== null ) {
            return pong(['data' => [
                'theme_id'   => $theme->id,
                'theme_name'  => $theme->name,
                'screenshot'  => asset(config('frontend.themesFolder') . '/' . $theme->slug . '/screenshot.png'),
                'version'     => $theme->version,
                'description' => $theme->description,
                'created_at'  => $theme->createdAtFormat('M d, Y'),
                'preview_url' => route('front_theme_preview', ['slug' => $theme->slug]),
                'author'      => [
                    'name'   => (empty($userProfile->first_name)) ? $theme->user->username : $userProfile->first_name . ' ' . $userProfile->last_name,
                    'avatar' => $userProfile->avatar()
                ]
            ]]);
        }
        
        return pong(['message' => _t('oops')], _error(), 403);
    }
    
    /**
     * Add new theme
     * 
     * @param Request $request
     * 
     * @return type
     */
    public function addNewTheme(Request $request) {
        if ($request->isMethod('POST')) {
            $rules     = $this->_getThemeRules();
            $messages  = $this->_getThemeMessages();
            $validator = Validator::make($request->all(), $rules, $messages);
            $file      = $request->file('__file');
            
            if ($validator->fails()) {
                return file_pong(['message' => $validator->errors()->first()], _error(), 403);
            }
            
            if ($file->isValid()) {
                $storagePath = config('frontend.themesTmpFolder');
                $fileStr     = random_string(16, $available_sets = 'lud');
                $fileExt     = $file->getClientOriginalExtension();
                $fileName    = $fileStr . '.' . $fileExt;
                
                try {
                    if ($file->move($storagePath, $fileName)) {
                        $error = $this->checkThemeFilesCorrect($storagePath . '/' . $fileStr, $storagePath . '/' . $fileName);
                        
                        if ($error !== true) {
                            return file_pong(['message' => $error], _error(), 403);
                        }
                        
                        return file_pong(['theme_path' => $storagePath . '/' . $fileStr]);
                    }
                } catch (Exception $ex) {
                    Log::error($ex->getMessage());
                }
                
            }
            
            return file_pong(['message' => _t('oops')], _error(), 403);
        }
    }
    
    /**
     * Check is the uploaded theme correct
     * 
     * @param string $folder
     * @param string $file
     * 
     * @return boolean
     */
    protected function checkThemeFilesCorrect($folder, $file) {
        $extAllow      = config('frontend.themeFileExtensionsAllow');
        $filesRequired = config('frontend.themeFilesRequired');
        $extUnallow    = [];
        $fileNames     = [];
        
        $zipArchive    = new \ZipArchive();
        $result        = $zipArchive->open($file);
        
        if ($result === TRUE) {
            $zipArchive->extractTo($folder);
            $zipArchive->close();
            
            $files = File::allFiles($folder);
            
            foreach ($files as $file) {
                $fileExt = File::extension($file);
                
                if ( ! in_array($fileExt, $extAllow)) {
                    $extUnallow[] = '.' . $fileExt;
                }
                
                $fileNames[] = File::name($file) . '.' . $fileExt;
            }
            
            if (count($extUnallow)) {
                $extUnallowStr = strtoupper(implode(', ', array_unique($extUnallow)));
                
                return _t('theme.upload.unallowExt', ['extUnallow' => $extUnallowStr]);
            }
            
            $fileMissing = array_diff($filesRequired, $fileNames);
            
            if (count($fileMissing)) {
                $fileMissingStr = strtoupper(implode(', ', $fileMissing));
                
                return _t('theme.upload.mising', ['fileMissing' => $fileMissingStr]);
            }
            
            return true;
            
        } else {
            return _t('theme.upload.unknow');
        }
    }

    /**
     * Get theme validation rules
     *
     * @return array
     */
    protected function _getThemeRules() {
        return [
            '__file' => 'required|mimes:zip|max:' . config('frontend.themeMaxFileSize')
        ];
    }

    /**
     * Get theme validation messages
     *
     * @return array
     */
    protected function _getThemeMessages() {
        return [
            '__file.required' => _t('no_file'),
            '__file.mimes'    => _t('file_compress_mimes'),
            '__file.max'      => _t('theme_max', ['fileSize' => config('frontend.themeMaxFileSizeMessage')]),
        ];
    }
}
