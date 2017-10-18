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
    
    public function home() {
        $configSlug = config('backend.page.slug.home');
        $page       = Page::where('slug', $configSlug)->first();
        $default    = $this->defaultPageClass();
        
        return view('backend::pages.home', [
            'home' => ($page) ? $page : $default,
            'slug' => $configSlug
        ]);
    }
    
    public function saveHome(Request $request) {
        if ($request->isMethod('post')) {
            $configSlug  = config('backend.page.slug.home');
            $page        = Page::where('slug', $configSlug)->first();
            $storagePath = config('backend.page.upload');
            
            if (null === $page) {
                $page = new Page;
            }
            
            if ($request->file('banner')) {
                $upload = $this->uploadBannerImg([
                    'old_file'     => $page->banner,
                    'file'         => $request->file('banner'),
                    'storage_path' => $storagePath
                ]);

                if ( ! $upload) {
                    return back()->with('error', 'Could not upload image!!!');
                }

                $page->banner  = $upload;
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
    
    public function saveContact(Request $request) {
        if ($request->isMethod('post')) {
            $configSlug  = config('backend.page.slug.contact');
            $page        = Page::where('slug', $configSlug)->first();
            $storagePath = config('backend.page.upload');
            
            if (null === $page) {
                $page = new Page;
            }
            
            if ($request->file('banner')) {
                $upload = $this->uploadBannerImg([
                    'old_file'     => $page->banner,
                    'file'         => $request->file('banner'),
                    'storage_path' => $storagePath
                ]);

                if ( ! $upload) {
                    return back()->with('error', 'Could not upload image!!!');
                }

                $page->banner  = $upload;
            }
            
            $page->name    = $request->get('name');
            $page->slug    = $configSlug;
            $page->content = $request->get('content');
            $page->save();
            
            return back()->with('success', 'Saved!');
        }
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
            $configSlug  = config('backend.page.slug.developer');
            $page        = Page::where('slug', $configSlug)->first();
            $storagePath = config('backend.page.upload');
            
            if (null === $page) {
                $page = new Page;
            }
            
            if ($request->file('banner')) {
                $upload = $this->uploadBannerImg([
                    'old_file'     => $page->banner,
                    'file'         => $request->file('banner'),
                    'storage_path' => $storagePath
                ]);

                if ( ! $upload) {
                    return back()->with('error', 'Could not upload image!!!');
                }

                $page->banner  = $upload;
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
    
    protected function uploadBannerImg($options = []) {
        $file        = isset($options['file'])         ? $options['file']         : '';
        $oldFile     = isset($options['old_file'])     ? $options['old_file']     : '';
        $storagePath = isset($options['storage_path']) ? $options['storage_path'] : '';

        if($file && $file->isValid()) {

            $fileStr   = random_string(16, $available_sets = 'lud');
            $fileExt   = $file->getClientOriginalExtension();
            $fileName  = $fileStr . '.' . $fileExt;

            try {
                if ($file->move($storagePath, $fileName)) {
                    delete_file($storagePath . '/' . $oldFile);
                    
                    return $fileName;
                }
            } catch (Exception $ex) {
                Log::error($ex->getMessage());
            }
            
            return false;
        }
        
        return false;
    }
}