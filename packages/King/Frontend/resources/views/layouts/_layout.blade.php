<!DOCTYPE html>
<html>
    <head>
        <title>LienK - Professional CV For All</title>
        <meta charset="UTF-8">
        <meta id="viewport" name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="msapplication-tap-highlight" content="no"/>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/bootstrap-switch.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/font-awesome.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/common.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/style.css') }}">
    </head>
    <body class="home" style="background-image: url({{ asset('packages/king/frontend/images/home-bg.jpg') }})">
        <header>
            <div class="container-fluid">
                <nav>
                    <a href="#" class="logo">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                    <ul>
                        <li><a href="#">Explode</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">Terms</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">English <span class="caret"></span></a>
                            <ul class="dropdown-menu language-dropdown-menu">
                                <li><a href="#">Français</a></li>
                                <li><a href="#">Tiếng Việt</a></li>
                                <li><a href="#">Italiano</a></li>
                                <li><a href="#">日本語</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        
        <div class="container">
            <div class="home-wrapper">
                <section class="home-btn-group">
                    <div class="btn-twice">
                        <a href="{{ route('front_login') }}" class="btn-home _r2">Login</a>
                        <a href="{{ route('front_login') }}" class="btn-home _r2">Register</a>
                    </div>
                    <a href="{{ route('front_developer') }}" class="btn-home btn-developer _r2"><i class="fa fa-code"></i> Developer</a>
                </section>
            </div>
        </div>
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/jquery_v1.11.1.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/jquery-ui-1.11.4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/bootstrap.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/bootstrap-switch.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/script.js') }}"></script>
    </body>
</html>
