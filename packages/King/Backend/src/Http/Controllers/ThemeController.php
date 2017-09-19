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
       
    protected $theme;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Theme $theme) {
        $this->theme = $theme;
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function index(Request $request) {
        
        $maxPerPage = config('backend.pagination.max_per_page');
        $filter     = $request->query();
        
        if (count($filter)) {
            $themes = $this->theme;
            
            if (isset($filter['q']) && $filter['q'] !== '') {
                $themes = $themes->where(function($query) use($filter) {
                    $query->where('slug', 'like',  '%' . $filter['q'] . '%')
                          ->orWhere('name', 'like', '%' . $filter['q'] . '%')
                          ->orWhere('description', 'like', '%' . $filter['q'] . '%');
                });    
            }
            
            if (isset($filter['status']) && $filter['status'] !== '') {
                $themes = $themes->where('activated', $filter['status']);
            }
            
            if (isset($filter['user_id']) && $filter['user_id'] !== '') {
                $themes = $themes->where('user_id', (int) $filter['user_id']);
            }
            
            $themes = $themes->paginate($maxPerPage);
            
            if (isset($filter['q'])) {
                $themes->appends(['q' => $filter['q']]);
            }
            
            if (isset($filter['status'])) {
                $themes->appends(['status' => $filter['status']]);
            }
            
            if (isset($filter['user_id'])) {
                $themes->appends(['user_id' => $filter['user_id']]);
            }
            
        } else {
            $themes = Theme::paginate($maxPerPage);
        }
        
        return view('backend::themes.index',[
            'themes'     => $themes,
            'maxPerPage' => $maxPerPage,
            'filterQ'    => isset($filter['q'])      ? $filter['q']      : null,
            'filterStat' => isset($filter['status']) ? $filter['status'] : null,
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
            $expertises = ($request->get('expertise_id')) ? array_filter($request->get('expertise_id')) : [];
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
            //$theme->slug        = $request->get('theme_slug');
            $theme->version     = $request->get('theme_version');
            $theme->description = $request->get('theme_desc');
            $theme->devices     = (is_array($devices))    ? serialize($devices)    : '';
            $theme->expertises  = (is_array($expertises)) ? serialize($expertises) : '';
            $theme->tags        = $request->get('theme_tags');
            $theme->save();
            
            $storagePath = config('frontend.themesFolder') . '/' . $theme->slug;
            
            $this->uploadThemeImg([
                'file'         => $request->file('thumbnail'),
                'type'         => 'thumbnail',
                'storage_path' => $storagePath
            ]);
            
            $this->uploadThemeImg([
                'file'         => $request->file('screenshot'),
                'type'         => 'screenshot',
                'storage_path' => $storagePath
            ]);
            
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
    
    protected function uploadThemeImg($options = []) {
        $type        = isset($options['type'])         ? $options['type']         : '';
        $file        = isset($options['file'])         ? $options['file']         : '';
        $storagePath = isset($options['storage_path']) ? $options['storage_path'] : '';

        if($file && $file->isValid()) {

            $fileStr   = random_string(16, $available_sets = 'lud');
            $fileExt   = $file->getClientOriginalExtension();
            $fileName  = $fileStr . '.' . $fileExt;

            try {
                if ($file->move($storagePath, $fileName)) {
                    delete_file($storagePath . "/{$type}.png");
                    File::move($storagePath . '/' . $fileName, $storagePath . "/{$type}.png");
                }
            } catch (Exception $ex) {
                Log::error($ex->getMessage());
            }
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Save theme validate rules.
     * 
     * @return array
     */
    protected function saveThemeValidateRules() {
        return [
            'thumbnail'     => 'mimes:png|dimensions:width=200,height=150',
            'screenshot'    => 'mimes:png|dimensions:width=800,height=600',
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