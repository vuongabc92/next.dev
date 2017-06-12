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

        $currentThemeId = (auth()->check()) ? auth()->user()->userProfile->theme_id : null;
        
        if (null === $currentThemeId) {
            $themes = Theme::all();
        } else {
            $themes = Theme::where('id', '!=', $currentThemeId)->get();
        }
        
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
    
    public function themeDetails(Request $request) {
        $themeId     = (int) $request->get('theme_id');
        $theme       = Theme::find($themeId);
        $userProfile = $theme->user->userProfile;
        
        if ( $theme !== null ) {
            return pong(['data' => [
                'theme_id'   => $theme->id,
                'theme_name'  => $theme->name,
                'screenshot'  => asset(config('frontend.themesFolder') . '/' . $theme->slug . '/screenshot.png'),
                'version'     => 'Version ' . $theme->getJson()->version,
                'description' => $theme->getJson()->description,
                'created_at'  => $theme->createdAtFormat('M d, Y'),
                'author'      => [
                    'name'   => (empty($userProfile->first_name)) ? $theme->user->username : $userProfile->first_name . ' ' . $userProfile->last_name,
                    'avatar' => $userProfile->avatar()
                ]
            ]]);
        }
        
        return pong(['message' => _t('oops')], _error(), 403);
    }
}
