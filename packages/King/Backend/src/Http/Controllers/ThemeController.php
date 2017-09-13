<?php
/**
 * HomeController
 */

namespace King\Backend\Http\Controllers;

use App\Models\Theme;
use App\Models\Expertise;
use Illuminate\Http\Request;
use File;

class ThemeController extends BackController {
       
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function index(Request $request) {
        
        $maxPerPage = config('backend.pagination.max_per_page');
        $filterUser = (int) $request->query('user');
        
        if($filterUser) {
            $themes = Theme::where('user_id', $filterUser)->paginate($maxPerPage);
            $themes->appends(['user' => $filterUser]);
        } else {
            $themes = Theme::paginate($maxPerPage);
        }
        
        return view('backend::themes.index',[
            'themes'     => $themes,
            'maxPerPage' => $maxPerPage
        ]);
    }
    
    public function view($id) {
        
        $theme = Theme::find($id);
        
        if (null === $theme) {
            return redirect()->back();
        }
        
        return view('backend::themes.view',[
            'theme' => $theme
        ]);
    }
    
    public function edit($id) {
        
        $theme     = Theme::find($id);
        $expertise = Expertise::all();
        
        if (null === $theme) {
            return redirect()->back();
        }
        
        return view('backend::themes.edit', [
            'theme'     => $theme,
            'themeExpt' => array_map('intval', unserialize($theme->expertises)),
            'devices'   => ($theme->devices !== '') ? unserialize($theme->devices) : [],
            'expertise' => ['' => _t('theme.upload.themeallExpertises')] + $expertise->pluck('name', 'id')->toArray()
        ]);
    }
    
    public function save(Request $request) {
        if ($request->isMethod('post')) {
            $id    = (int) $request->get('theme_id');
            $theme = Theme::find($id);
            
            if (null === $theme) {
                return redirect()->back();
            }
            
            $rules      = $this->saveThemeValidateRules();
            $devices    = $request->get('devides');
            $themeName  = $request->get('theme_name');
            $expertises = array_filter($request->get('expertise_id'));
            $formData   = $request->all();
            
            if( ! count($expertises)) {
                $rules = remove_rules($rules, 'expertise_id');
            }

            $formData['expertise_id'] = $expertises;

            if ($themeName === $theme->name) {
                $rules = remove_rules($rules, 'theme_name.unique:themes,name');
                
            }
            
            $validator = validator($request->all(), $rules, $this->saveThemeValidateMessages());
            
            $validator->after(function($validator) use($devices) {
                if (is_array($devices) && count($devices)) {
                    foreach($devices as $device) {
                        if( ! in_array($device, ['desktop', 'tablet', 'mobile'])) {
                            $validator->errors()->add('theme_path', _t('theme.validate.devicesin'));
                        }
                    }
                }
            });
            
            if ($validator->fails()) {
                return back()->withErrors($validator);
            }
            
            $theme->name        = $request->get('theme_name');
            $theme->slug        = $request->get('theme_slug');
            $theme->version     = $request->get('theme_version');
            $theme->description = $request->get('theme_desc');
            $theme->devices     = (is_array($devices))    ? serialize($devices)    : '';
            $theme->expertises  = (is_array($expertises)) ? serialize($expertises) : '';
            $theme->tags        = $request->get('theme_tags');
            $theme->save();
            
            if(null !== $request->file('thumbnail')) {
                $thumbnail = $request->file('thumbnail');

                if ($thumbnail->isValid()) {
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
            }
            
            return back();
        }
    }
    
    public function updateStatus(Request $request) {
        $themeId = (int) $request->get('theme_id');
        $theme   = Theme::find($themeId);
        
        if (null === $theme) {
            return redirect()->back();
        }
        
        if ($theme->activated) {
            $theme->activated = 0;
        } else {
            $theme->activated = 1;
        }
        
        $theme->save();
        
        return redirect()->back();
    }
    
    public function remove(Request $request) {
        $themeId     = (int) $request->get('theme_id');
        $theme       = Theme::find($themeId);
        $themeFolder = config('frontend.themesFolder');
        
        if (null === $theme) {
            return redirect(route('back_themes'));
        }
        
        $deleteFolder = $themeFolder . '/' . $theme->slug;
        
        if (file_exists($deleteFolder)) {
            File::deleteDirectory($deleteFolder);
        }
        
        $theme->delete();
        
        return redirect(route('back_themes'));
    }
    
    /**
     * Save theme validate rules.
     * 
     * @return array
     */
    protected function saveThemeValidateRules() {
        return [
            '__file'        => 'mimes:png',
            'theme_name'    => 'required|alpha_spaces|min:3|max:250|unique:themes,name',
            'theme_slug'    => 'required|min:2|max:250',
            'theme_version' => 'required|min:2|max:10',
            'theme_desc'    => 'required|min:20',
            'expertise_id'  => 'exists:expertises,id'
        ];
    }
    
    protected function saveThemeValidateMessages() {
        return [
            'theme_name.alpha_spaces' => _t('theme.validate.themenamealdash'),
        ];  
    }

}