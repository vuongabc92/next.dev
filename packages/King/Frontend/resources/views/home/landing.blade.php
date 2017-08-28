@extends('frontend::layouts._layout')

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
            <nav class="navbar navbar-expand-lg filter-nav">
                <ul class="nav filter-list justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Newest</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Latest</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Experience</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">In college</a>
                            <a class="dropdown-item" href="#">No experiences</a>
                            <a class="dropdown-item" href="#">1 - 3 years</a>
                            <a class="dropdown-item" href="#">> 3 years</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Color</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Dark</a>
                            <a class="dropdown-item" href="#">Light</a>
                            <a class="dropdown-item" href="#">Colored</a>
                            <a class="dropdown-item" href="#">Black and white</a>
                        </div>
                    </li>
                </ul>
                <form class="form-inline ml-auto">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search">
                </form>
            </nav>
        </div>
    </div>
    <div class="_fwfl themes-wrapper">
        <div class="themes-inside">
            @if($themes->count())
                <ul class="_fwfl _lsn _p0 _m0 theme-tree">
                @foreach($themes as $theme)
                    <li>
                        <a href="{{ route('front_theme_details', ['theme_id' => $theme->id]) }}" data-theme-details>
                        <div class="theme-leaf">
                            <img src="{{ asset('uploads/themes/' . $theme->slug . '/screenshot.png') }}" class="screenshot"/>
                            <div class="quick-info">
                                <h5>{{ $theme->name }}</h5>
                                <div>{{ str_limit($theme->description, 100) }}</div>
                            </div>
                        </div>
                        </a>
                    </li>
                @endforeach
                </ul>
            @endif
            
        </div>
    </div>
</div>
<!-- Theme details modal -->
<div class="modal fade modal-theme-details" id="themeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="themeDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="_fwfl theme-details-header" id="themeDetailsHeader">
                    <a href="#" id="themeAuthorAvatar">
                        <img class="_r50" src="" />
                    </a>
                    <h1><span id="themeName"></span> <span class="theme-details-version badge badge-secondary" id="themeVersion"></span></h1>
                    <h2>
                        <span class="theme-by">{{ _t('theme.details_by') }} <a href="#"></a></span>
                        <span class="theme-date">{{ _t('theme.details_on') }} <span class="_tgb"></span></span>
                    </h2>
                </div>
                <div class="_fwfl theme-details-content">
                    <div class="theme-details-screenshot" id="themeScreenshot">
                        <img src="" />
                    </div>
                    @if(auth()->check())
                    <div class="theme-details-meta">
                        <div class="_fwfl theme-details-actions" id="themeAction">
                            <form action="{{ route('front_theme_install') }}" method="post" data-install-theme>
                                {{ csrf_field() }}
                                <input type="hidden" name="theme_id" />
                                <input type="hidden" name="cv_url" value="{{ user()->userProfile->cvUrl() }}"/>
                                <button type="submit" class="btn _btn _btn-blue-navy" data-finished-text="{{ _t('theme.installed') }}">
                                    {{ _t('theme.install') }}
                                </button>
                            </form>
                            <a href="#" class="btn _btn _btn-gray" target="_blank" id="themePreviewBtn">{{ _t('theme.preview') }}</a>
                        </div>
                    </div>
                    @endif
                    <div class="theme-details-desc" id="themeDesc"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop