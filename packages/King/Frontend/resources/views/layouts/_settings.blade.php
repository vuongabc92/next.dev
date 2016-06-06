<!DOCTYPE html>
<html>
    <head>
        <title>Bui Thanh Vuong - Next</title>
        <meta charset="UTF-8">
        <meta id="viewport" name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="msapplication-tap-highlight" content="no"/>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="ajax-error" content="{{ _t('opps') }}" />
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/bootstrap-switch.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/font-awesome.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/common.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/style.css') }}">
    </head>
    <body>
        <main>
            <div class="_mt20 _mb20 container settings">
                @yield('body')
            </div>
            <div class="setting-messages _dn">
                <div class="container">
                    <div class="_fl col-md-9 col-xs-12">
                        <b class="_fl _fs13 message" id="message"></b>
                    </div>
                </div>
            </div>
        </main>
        <script>
            SETTINGS = {
                AJAX_OK: 'OK',
                AJAX_ERROR: 'ERROR',
                TOKEN: '{{ csrf_token() }}',
                AJAX_PUBLISH_PROFILE_URL: '{{ route('front_setting_publish_profile') }}',
                AJAX_SELECT_PLACE_URL: '{{ route('front_settings_select_place') }}',
                LOADING_BLUE_NAVY_24: '{{ asset('packages/king/frontend/images/loading_blue_navy_24x24.gif') }}'
            }
        </script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/jquery_v1.11.1.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/jquery-ui-1.11.4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/bootstrap.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/bootstrap-switch.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/webtoolkit.aim.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/script.js') }}"></script>
    </body>
</html>
