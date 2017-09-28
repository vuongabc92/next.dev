<!DOCTYPE html>
<html lang="en">
    <head>
        <title>:)</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="msapplication-tap-highlight" content="no"/>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="ajax-error" content="{{ _t('oops') }}" />
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/master.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/layout.css') }}">
        @yield('link_style')
        <style>
            @yield('inline_style')
        </style>
    </head>
    <body>
        <header class="_fwfl header">
            <div class="header-inside">
                <nav class="header-nav">
                    @if ( ! auth()->check())
                        <a href="{{ route('front_register') }}" class="_fr btn _btn _btn-blue header-register-btn">{{ _t('register') }}</a>
                    @endif
                    <ul class="_fr _lsn _p0 _m0 navlist">
                        <li><a href="{{ route('front_contact') }}"><span>{{ _t('contact') }}</span></a></li>
                        <li><a href="{{ route('front_developer') }}"><span><i class="fa fa-cog"></i> {{ _t('developer') }}</span></a></li>
                        
                        @if ( ! auth()->check())
                            <li><a href="{{ route('front_login') }}"><span>{{ _t('login') }}</span></a></li>
                        @else
                            <li><a href="{{ route('front_logout') }}"><span>{{ _t('logout') }}</span></a></li>
                            <li><a href="{{ route('front_settings') }}"><img src="{{ user()->userProfile->avatar() }}" class="avatar" /></a></li>
                        @endif
                    </ul>
                </nav>

            </div>
        </header>
        @yield('body')
<!--        <footer class="_fwfl main-footer">
            <div class="footer-logo-wrap">
                <a href="/">
                    <span class="logo logo-footer"></span>
                </a>
            </div>
            <div class="_fwfl footer-navs">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('front_about') }}">{{ _t('aboutus') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ _t('help') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">{{ _t('feedback') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cog _fs13"></i> {{ _t('developers') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front_terms') }}">{{ _t('privacy') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front_privacy') }}">{{ _t('terms') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front_contact') }}">{{ _t('contact') }}</a>
                    </li>
                </ul>
            </div>
            <div class="_fwfl _tc _tga copyright"><i class="fa fa-heart-o"></i> With love &COPY; {{ date('Y') }} NEXT. All rights reserved.</div>
        </footer>-->
        
        <div class="alert alert-bar fade _dn" role="alert" id="alertBar">
            <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="container">
                <span class="_fs13 _fwb" id="alertText"></span>
            </div>
        </div>
        
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/jquery_v1.11.1.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/jquery-ui-1.11.4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/popper.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/bootstrap4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/bootstrap-switch.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/script.js') }}"></script>
        <script>
            @yield('script')
        </script>
    </body>
</html>