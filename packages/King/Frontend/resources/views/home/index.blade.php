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
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/home.css') }}">
        @yield('link_style')
        <style>
            @yield('inline_style')
        </style>
    </head>
    <body>
        <div class="root home">
            <header class="_fwfl header">
                <div class="header-inside">
                    <nav class="_fwfl navbar-header">
                        <a href="#" class="_fl nav-home"><span class="logo">WOCV</span></a>
                        <a href="#" class="_fr header-btn register-btn">Sign Up</a>
                    </nav>
                </div>
            </header>
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