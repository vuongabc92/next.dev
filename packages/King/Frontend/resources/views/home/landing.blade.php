@extends('frontend::layouts._layout')

@section('link_style')
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/theme-tree.css') }}">
@stop

@section('body')
<div class="_fwfl magic-show">
    @if( ! auth()->check())
    <div class="_fwfl text-center welcome-bar">
        <span class="_fwfl welcome-msg">What are you looking for? NEXT is where a lot of beautiful CV are created.</span>
        <a href="{{ route('front_register') }}" class="btn _btn _btn-blue-navy">Continue &RightArrow;</a>
    </div>
    @endif
    <div class="_fwfl filter-wrap{{ (auth()->check()) ? ' authfilter-wrap' : '' }}">
        <div class="filter-inside">
            <ul class="nav filter-list justify-content-center">
                <li><a class="nav-link" href="#"><span>ALL</span></a></li>
                <li class="dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Experience</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">No experiences</a>
                        <a class="dropdown-item" href="#">1 - 3 years</a>
                        <a class="dropdown-item" href="#">> 3 years</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Color</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Dark</a>
                        <a class="dropdown-item" href="#">Light</a>
                        <a class="dropdown-item" href="#">Colored</a>
                        <a class="dropdown-item" href="#">Black and white</a>
                    </div>
                </li>
                <li><a class="nav-link search-theme-btn" href="#"><i class="fa fa-search"></i></a></li>
            </ul>
            <form class="_dn search-theme-frm">
                <input type="text" placeholder="Search..."/>
                <i class="fa fa-remove close-search-btn"></i>
            </form>
        </div>
    </div>
    <div class="_fwfl themes-wrapper">
        <div class="_fwfl themes-inside">
            @if($themes->count())
                <ol class="_lsn _p0 _m0 theme-tree">
                @foreach($themes as $theme)
                    <li>
                        <a href="{{ route('front_theme_details', ['theme_id' => $theme->id]) }}" data-theme-details>
                        <div class="theme-leaf">
                            <img src="/{{ $theme->getThumbnail() }}" class="screenshot"/>
                            <div class="quick-info">
                                <h5>{{ $theme->name }}</h5>
                                <div>{{ str_limit($theme->description, 100) }}</div>
                            </div>
                        </div>
                        </a>
                    </li>
                @endforeach
                </ol>
            @endif
            
            <div class="_fwfl text-center loadmore-wrap">
                @if( ! auth()->check())
                    <div class="_fwfl">
                        <a href="{{ route('front_register') }}" class="load-more-btn">Sign up to continue</a>
                    </div>
                    <div class="_fwfl _mt15">
                        <a href="{{ route('front_login') }}" class="load-more-signin">Or sign in</a>
                    </div>
                @else
                    <a href="#" class="load-more-btn">Load more...</a>
                @endif
            </div>
        </div>
    </div>
</div>
@include('frontend::inc.theme-details-popup')
@stop