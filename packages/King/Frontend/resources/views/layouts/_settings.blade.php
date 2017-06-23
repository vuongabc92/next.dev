<!DOCTYPE html>
<html>
    <head>
        <title>:)</title>
        <meta charset="UTF-8">
        <meta id="viewport" name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="msapplication-tap-highlight" content="no"/>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="ajax-error" content="{{ _t('oops') }}" />
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/settings.css') }}">
    </head>
    <body>
        <main>
            @include('frontend::inc.layout-parts')
            @yield('user_header')
            <div class="container">
                <div class="settings">
                    @yield('body')
                </div>
            </div>
            
            <div class="alert-bar alert fade out" role="alert" id="alertBar">
                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="container">
                    <span class="_fs13 _fwb" id="alertText"></span>
                </div>
            </div>
        </main>
        <script>
            SETTINGS = {
                AJAX_OK: 'OK',
                AJAX_ERROR: 'ERROR',
                TOKEN: '{{ csrf_token() }}',
                AJAX_SAVE_INFO: '{{ route('front_settings_save_info') }}',
                AJAX_KILL_TAG: '{{ route('front_settings_killtag') }}',
                AJAX_KILL_SOCIAL: '{{ route('front_settings_killsocial') }}',
                AJAX_PUBLISH_PROFILE_URL: '{{ route('front_setting_publish_profile') }}',
                AJAX_SELECT_PLACE_URL: '{{ route('front_settings_select_place') }}',
                AJAX_GET_EMPLOYMENTBYID: '{{ route('front_settings_employmentbyid') }}',
                AJAX_GET_EDUCATIONBYID: '{{ route('front_settings_educationbyid') }}',
                AJAX_GET_SEARCHSKILL: '{{ route('front_settings_searchskill') }}',
                AJAX_GET_EMPLOYMENTREMOVEBYID: '{{ route('front_settings_employmentremovebyid') }}',
                AJAX_GET_EDUCATIONREMOVEBYID: '{{ route('front_settings_educationremovebyid') }}',
                LOADING_BLUE_NAVY_24: '{{ asset('packages/king/frontend/images/loading_blue_navy_24x24.gif') }}',
                LOADING_GRAY_24: '{{ asset('packages/king/frontend/images/loading_gray_24x24.gif') }}',
            }
        </script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/jquery_v1.11.1.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/jquery-ui-1.11.4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/bootstrap.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/bootstrap-switch.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/script.js') }}"></script>
    </body>
</html>
