<?php
/**
 * Theme Controller
 */

namespace King\Frontend\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends FrontController {
    
    /**
     * List themes
     * 
     * @return void
     */
    public function index() {
        $themes = Theme::all();
        
        return view('frontend::theme.index', [
            'themes' => $themes
        ]);
    }
    
    /**
     * Update user cv theme
     * 
     * @param Request $request
     * @param type $id
     */
    public function install(Request $request) {
//        if ($request->ajax() && $request->isMethod('post')) {
//            
//            $id = (int) $request->get('id');
//            
//            if (Theme::find($id) !== null) {
//                user()->userProfile->theme_id = $id;
//                user()->userProfile->save();
//                
//                return pong(['message' => _t('saved')]);
//            } 
//            
//            return pong(['message' => _t('oops')], _error(), 403);
//        }
    }
}
