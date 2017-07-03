<!DOCTYPE html>
<html>
    <head>
        <title>LienK - Professional CV For All</title>
        <meta charset="UTF-8">
        <meta id="viewport" name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="msapplication-tap-highlight" content="no"/>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/auth.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/landing.css') }}">
    </head>
    <body>
        <main class="_fwfl">
            <div class="left border-dot">
                <div class="left-inner">
                    <header class="_fwfl">
                        <a href="/"><span class="logo"></span></a>
                        <button class="btn _btn _btn-blue-navy" id="landingLoginBtn">{{ _t('login') }}</button>
                        <button class="btn _btn _btn-blue-navy" id="landingRegisterBtn">{{ _t('register') }}</button>
                    </header>
                    <div class="_fwfl auth-wrap">
                        @include('frontend::inc.auth')
                        @yield('auth_login')
                        @yield('auth_register')
                    </div>
                    <footer class="_fwfl border-dot">
                        <ul class=" _lsn _p0 _m0 footer-nav">
                            <li><a href="{{ route('front_about') }}">{{ _t('aboutus') }}</a></li>
                            <li><a href="#">{{ _t('help') }}</a></li>
                            <li><a href="#">{{ _t('developers') }}</a></li>
                            <li><a href="#">{{ _t('privacy') }}</a></li>
                            <li><a href="#">{{ _t('terms') }}</a></li>
                        </ul>
                    </footer>
                </div>
            </div>
            <div class="right">
<!--                <div class="right-inner">
                    <div class="_fwfl landing-cv">
                        <div class="header">
                            <div class="_fwfl avatar-box">
                                <span class="logo avatar"></span>
                            </div>
                            <h1 class="_fwfl name">Next.Com</h1>
                            <h3 class="_fwfl job">Free CV For Everyone</h3>
                        </div>
                        <div class="_fwfl cv-body">
                            <div class="_fwfl content-box">
                                <h1 class="title">Profile</h1>
                                <div class="content">
                                    <p>HELLO THERE!!</p> 
                                    <p>Are you looking for a GREAT CV? If so you are in the RIGHT PLACE.</p> 
                                    <p>We have HUNDREDS OF BEAUTIFUL CV that make you go crazy at the first time looking at them, because they are all too good, it's so hard to pick one ^^!</p>
                                    <p>Enough talk! Let's explore moreeeeee....</p>
                                    <a href="#" class="explode-btn">Explore</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
        </main>
        
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
