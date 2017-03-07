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
        <meta name="ajax-error" content="{{ _t('oops') }}" />
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/bootstrap-switch.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/font-awesome.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/common.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/settings.css') }}">
    </head>
    <body>
        <main>
            <div class="header">
                <div class="container">
                    <nav class="navbar navbar-default navbar-master">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="{{ route('front_home') }}">
                                    <span class="logo"></span>
                                </a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav navbar-right">
                                    <li><a href="#">Explode</a></li>
                                    <li><a href="#">Wtf</a></li>
                                    <li><a href="#">Develop</a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="header-login">{{ user()->username }}</span> <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('front_settings') }}">Settings</a></li>
                                            <li><a href="#">Help</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href={{ route('front_logout') }}>Logout</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                </div>
            </div>
            
            <div class="container">
                <div class="settings">
                    @yield('body')
                </div>
            </div>
            
            <div class="message-bar _dn" id="messageBar">
                <div class="container">
                    <div class="_fl col-md-9 col-xs-12">
                        <b class="_fl _fs13 message-txt" id="messageTxt"></b>
                    </div>
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
