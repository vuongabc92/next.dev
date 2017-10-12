<?php
/**
 * HomeController
 */

namespace King\Frontend\Http\Controllers;

use App\Models\Theme;
use App\Models\Page;

class HomeController extends FrontController {
       
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function landing() {
        $perPage = config('frontend.lazy_loading.per_page');
        $themes  = Theme::paginate($perPage);
        
        return view('frontend::home.landing', [
            'themes' => $themes
        ]);
    }
    
    public function about() {
        $configSlug = config('backend.page.slug.about_us');
        $about      = Page::where('slug', $configSlug)->first();
        
        return view('frontend::home.about', [
            'about' => (null !== $about) ? $about->getContent() : []
        ]);
    }
    
    public function contact() {
        $configSlug = config('backend.page.slug.contact');
        $contact    = Page::where('slug', $configSlug)->first();
        
        return view('frontend::home.contact', [
            'page' => $contact
        ]);
    }
    
    public function developer() {
        $configSlug = config('backend.page.slug.developer');
        $developer  = Page::where('slug', $configSlug)->first();
        
        return view('frontend::home.developer', [
            'content' => (null !== $developer) ? $developer->content : ''
        ]);
    }
    
    public function terms() {
        $configSlug = config('backend.page.slug.terms');
        $terms      = Page::where('slug', $configSlug)->first();
        
        return view('frontend::home.terms', [
            'content' => (null !== $terms) ? $terms->content : ''
        ]);
    }
    
    public function privacy() {
        $configSlug = config('backend.page.slug.privacy');
        $privacy    = Page::where('slug', $configSlug)->first();
        
        return view('frontend::home.privacy', [
            'content' => (null !== $privacy) ? $privacy->content : ''
        ]);
    }
}