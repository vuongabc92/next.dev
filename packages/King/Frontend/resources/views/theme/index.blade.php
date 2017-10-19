@extends('frontend::layouts._layout')

@section('link_style')
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/theme-tree.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/user-theme.css') }}">
@stop


@section('body')
    <div class="container">
        <div class="_fwfl add-theme-row">
            @if(user()->isAdmin())
            <button class="btn _btn _btn-blue" data-toggle="modal" data-target="#addThemeModal"><i class="fa fa-plus"></i> UPLOAD NEW THEME</button>
            @endif
        </div>
        @if($currentTheme)
        <div class="_fwfl current-activated-theme">
            <h3 class="user-themes-title">Your current theme</h3>
            <div class="screenshot">
                <span class="badge badge-info badge-current-theme"><i class="fa fa-check"></i> {{ _t('theme.curActivated') }}</span>
                <img src="/{{ $currentTheme->getScreenshot() }}">
            </div>
            <div class="_fwfl _mt20 activated-info">
                <a href="{{ route('front_theme_details', ['theme_id' => $currentTheme->id]) }}" data-theme-details class="_fl _btn btn _btn-blue-navy">{{ _t('theme.details') }}</a>
                <a href="/" class="_fl _btn btn _btn-gray">{{ _t('theme.change') }}</a>
            </div>
        </div>
        @endif
        
        @if($themes->count())
        <div class="_fwfl uploaded-themes">
            <h3 class="user-themes-title">{{ _t('theme.yourUploaded') }}</h3>
            @if($themes->count())
                <ol class="_lsn _p0 _m0 theme-tree" @if (auth()->check()) data-go-lazy data-current="0" data-url="{{ route('front_themes_lazy') }}" @endif data-theme-details>
                    @include('frontend::theme.theme-item')
                </ol>
            @endif
            
            <div class="_fwfl text-center loadmore-wrap">
                <div class="_fwfl">
                    <span class="loading-more">Loading more...</span>
                </div>
                <div class="_fwfl">
                    @if (auth()->check())
                        <a href="#" class="load-more-btn" data-load-more data-target=".theme-tree">{{ _t('load_more') }}</a>
                    @else
                        <a href="{{ route('front_login') }}" class="load-more-btn">{{ _t('load_more') }}</a>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
    @include('frontend::inc.theme-details-popup')
    
    @if(user()->isAdmin())
        @include('frontend::inc.add-theme-popup')
    @endif

    
    <div id="themeItemTemplate" class="_dn">
        <li> 
            <div class="theme-leaf">
                <a href="{{ route('front_theme_details', ['theme_id' => 'THEME_ID']) }}" data-theme-details>
                    <img src="">
                    <div class="theme-dataOverlay">
                        <div class="_fwfl view-mode-wrap">
                            <ul class="_fr _lsn _m0 _p0 view-mode-list"></ul>
                        </div>
                        <h3></h3>
                        <span></span>
                    </div>
                </a>
            </div>
        </li>
    </div>
@stop