@extends('frontend::layouts._layout')

@section('link_style')
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/theme-tree.css') }}">
@stop

@section('body')
<div class="_fwfl magic-show">
    @if ( ! auth()->check())
    <div class="_fwfl banner-wrap">
        <div class="banner-inside">
            <div class="_fwfl banner" style="background-image: url({{ asset('packages/king/frontend/images/landing-banner.jpg') }})">
                <h1 class="_fwfl">Free CV For Everyone</h1>
            </div>
        </div>
    </div>
    @endif
    <div class="_fwfl themes-wrapper">
        <div class="_fwfl themes-inside">
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
    </div>
</div>
@include('frontend::inc.theme-details-popup')
@stop