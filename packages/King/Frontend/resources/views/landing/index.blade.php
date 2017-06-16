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
                            <li><a href="#">{{ _t('aboutus') }}</a></li>
                            <li><a href="#">{{ _t('help') }}</a></li>
                            <li><a href="#">{{ _t('developers') }}</a></li>
                            <li><a href="#">{{ _t('privacy') }}</a></li>
                            <li><a href="#">{{ _t('terms') }}</a></li>
                        </ul>
                    </footer>
                </div>
            </div>
            <div class="right">
                <div class="right-inner">
                    <div class="_fwfl">
                        <div class="_fwfl">
                            <span class="logo"></span>
                        </div>
                        <div class="_fwfl olleh">
                            <ol class="_lsn _p0 _m0 chatbot-tree">
                                <li>
                                    <div class="left">
                                        <i class="chatbox-narrow"></i>
                                        <span class="chatbox-txt">HELLO THERE!</span>
                                    </div>
                                    <div class="right">
                                        <a href="#"><span class="botface">^^</span></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="left">
                                        <span class="chatbox-txt">Are you looking for a great CV?</span>
                                    </div>
                                    <div class="right"></div>
                                </li>
                                <li>
                                    <div class="left">
                                        <span class="chatbox-txt">If so, you are in the right place babe ^^.</span>
                                    </div>
                                    <div class="right"></div>
                                </li>
                                <li>
                                    <div class="left">
                                        <span class="chatbox-txt">I have hundreds of beautiful CV that you will go crazy at the first time looking at them.</span>
                                    </div>
                                    <div class="right"></div>
                                </li>
                                <li>
                                    <div class="left">
                                        <span class="chatbox-txt">Because they are all too good, it's so hard to select one ^^.</span>
                                    </div>
                                    <div class="right"></div>
                                </li>
                                <li>
                                    <div class="left">
                                        <span class="chatbox-txt">Enough talk! Let's <a href="#">EXPLORE!</a></span>
                                    </div>
                                    <div class="right"></div>
                                </li>
                            </ol>
                        </div>
                    </div>
<!--                    <ol class="_fwfl _lsn _p0 _m0 theme-tree-preview">
                        @foreach($themes as $theme)
                        <li>
                            <div class="cv-leaf">
                                <img src="{{ asset('uploads/themes/' . $theme->slug . '/screenshot.png') }}" />
                            </div>
                        </li>
                        @endforeach
                    </ol>-->
                </div>
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
