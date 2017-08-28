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
        <style>
            @yield('style')
        </style>
    </head>
    <body>
        <header class="main-header">
            <nav class="navbar navbar-expand-lg navbar-main">
                <a class="navbar-brand" href="#"><span class="logo logo-header"></span></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <ul class="navbar-nav navbar-auth ml-auto">
                    @if(auth()->check())
                        <li><a href="{{ route('front_settings') }}"><img src="{{ user()->userProfile->avatar() }}" class="avatar" /></a></li>
                        <li><a class="btn _btn" href="{{ route('front_logout') }}">{{ _t('logout') }}</a></li>
                    @else
                        <li><a class="btn _btn btn-primary" href="{{ route('front_login') }}">{{ _t('login') }}</a></li>
                        <li><a class="btn _btn" href="{{ route('front_register') }}">{{ _t('register') }}</a></li>
                    @endif
                </ul>
            </nav>
        </header>
        @yield('body')
        
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