<?php
/**
 * HomeController
 */

namespace King\Frontend\Http\Controllers;

use App\Models\Theme;
use App\Models\Page;

class IndexController extends FrontController {
       
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function index() {
        $perPage    = config('frontend.lazy_loading.per_page');
        $configSlug = config('backend.page.slug.home');
        $page       = Page::where('slug', $configSlug)->first();
        $themes     = Theme::paginate($perPage);
        
        return view('frontend::index.index', [
            'themes' => $themes,
            'page'   => $page
        ]);
    }
    
    public function contact() {
        $configSlug = config('backend.page.slug.contact');
        $contact    = Page::where('slug', $configSlug)->first();
        
        return view('frontend::index.contact', [
            'page' => $contact
        ]);
    }
    
    public function developer() {
        $configSlug = config('backend.page.slug.developer');
        $developer  = Page::where('slug', $configSlug)->first();
        
        return view('frontend::index.developer', [
            'page' => $developer
        ]);
    }
    
}