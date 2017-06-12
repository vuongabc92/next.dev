<?php
/**
 * HomeController
 */

namespace King\Frontend\Http\Controllers;

use App\Models\Theme;

class HomeController extends FrontController {

    public function index() {
        
        $currentThemeId = (auth()->check()) ? auth()->user()->userProfile->theme_id : null;
        
        if (null === $currentThemeId) {
            $themes = Theme::all();
        } else {
            $themes = Theme::where('id', '!=', $currentThemeId)->get();
        }
        
        return view('frontend::home.index', [
            'themes' => $themes
        ]);
    }
}