<?php

namespace King\Backend\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends BackController {
       
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function aboutus() {
        $configSlug = config('backend.page.slug.about_us');
        $page       = Page::where('slug', $configSlug)->first();
        $default    =  $this->defaultPageClass();
        
        return view('backend::pages.aboutus', [
            'aboutus' => ($page) ? $page : $default,
            'slug'    => $configSlug
        ]);
    }
    
    public function saveAboutus(Request $request) {
        if ($request->isMethod('post')) {
            $configSlug = config('backend.page.slug.about_us');
            $page       = Page::where('slug', $configSlug)->first();
            
            if (null === $page) {
                $page = new Page;
            }
            
            $page->name    = $request->get('name');
            $page->slug    = $configSlug;
            $page->content = serialize(array_filter($request->get('content')));
            $page->save();
            
            return back()->with('success', 'Saved!');
        }
    }
    
    public function saveContact(Request $request) {
        if ($request->isMethod('post')) {
            $configSlug = config('backend.page.slug.contact');
            $page       = Page::where('slug', $configSlug)->first();
            
            if (null === $page) {
                $page = new Page;
            }
            
            $page->name    = $request->get('name');
            $page->slug    = $configSlug;
            $page->content = $request->get('content');
            $page->save();
            
            return back()->with('success', 'Saved!');
        }
    }
    
    public function contact() {
        $configSlug = config('backend.page.slug.contact');
        $page       = Page::where('slug', $configSlug)->first();
        $default    = $this->defaultPageClass();
        
        return view('backend::pages.contact', [
            'contact' => ($page) ? $page : $default,
            'slug'    => $configSlug
        ]);
    }
    
    public function developer() {
        $configSlug = config('backend.page.slug.developer');
        $page       = Page::where('slug', $configSlug)->first();
        $default    =  $this->defaultPageClass();
        
        return view('backend::pages.developer', [
            'developer' => ($page) ? $page : $default,
            'slug'      => $configSlug
        ]);
    }
    
    public function saveDeveloper(Request $request) {
        if ($request->isMethod('post')) {
            $configSlug = config('backend.page.slug.developer');
            $page       = Page::where('slug', $configSlug)->first();
            
            if (null === $page) {
                $page = new Page;
            }
            
            $page->name    = $request->get('name');
            $page->slug    = $configSlug;
            $page->content = $request->get('content');
            $page->save();
            
            return back()->with('success', 'Saved!');
        }
    }
    
    public function privacy() {
        $configSlug = config('backend.page.slug.privacy');
        $page       = Page::where('slug', $configSlug)->first();
        $default    =  $this->defaultPageClass();
        
        return view('backend::pages.privacy', [
            'privacy' => ($page) ? $page : $default,
            'slug'    => $configSlug
        ]);
    }
    
    public function savePrivacy(Request $request) {
        if ($request->isMethod('post')) {
            $configSlug = config('backend.page.slug.privacy');
            $page       = Page::where('slug', $configSlug)->first();
            
            if (null === $page) {
                $page = new Page;
            }
            
            $page->name    = $request->get('name');
            $page->slug    = $configSlug;
            $page->content = $request->get('content');
            $page->save();
            
            return back()->with('success', 'Saved!');
        }
    }
    
    public function terms() {
        $configSlug = config('backend.page.slug.terms');
        $page       = Page::where('slug', $configSlug)->first();
        $default    =  $this->defaultPageClass();
        
        return view('backend::pages.terms', [
            'terms' => ($page) ? $page : $default,
            'slug'  => $configSlug
        ]);
    }
    
    public function saveTerms(Request $request) {
        if ($request->isMethod('post')) {
            $configSlug = config('backend.page.slug.terms');
            $page       = Page::where('slug', $configSlug)->first();
            
            if (null === $page) {
                $page = new Page;
            }
            
            $page->name    = $request->get('name');
            $page->slug    = $configSlug;
            $page->content = $request->get('content');
            $page->save();
            
            return back()->with('success', 'Saved!');
        }
    }
    
    protected function defaultPageClass() {
        
        $default          = new \stdClass();
        $default->name    = null;
        $default->content = null;
        
        return $default;
    }
}

//CREATE TABLE `king_pages` (
//  `id` int(11) NOT NULL AUTO_INCREMENT,
//  `name` varchar(250) DEFAULT NULL,
//  `slug` varchar(250) DEFAULT NULL,
//  `content` longtext,
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8