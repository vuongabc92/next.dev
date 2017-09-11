<?php
/**
 * HomeController
 */

namespace King\Backend\Http\Controllers;

use App\Models\Theme;
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
    
    public function index() {
        
        $maxPerPage = config('backend.pagination.max_per_page');
        $themes     = Theme::paginate($maxPerPage);
        
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
        
        $theme = Theme::find($id);
        
        if (null === $theme) {
            return redirect()->back();
        }
        
        return view('backend::themes.edit',[
            'theme' => $theme
        ]);
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
    
}