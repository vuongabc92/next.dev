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
    <body>     
        <header class="_fwfl">
            <div class="header-inner">
                <a href="/" class="logo"><img src="{{ asset('packages/king/frontend/images/logo.png') }}" /></a>
                <ul class="_fr _lsn main-nav">
                    <li class="h-fb"><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li class="h-tw"><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#" class="btn _btn landing-btn" data-toggle="modal" data-target="#loginModal">{{ _t('login') }}</a></li>
                    <li><a href="#" class="btn _btn landing-btn" data-toggle="modal" data-target="#registerModal">{{ _t('register') }}</a></li>
                </ul>
            </div>
        </header>
        
        <div class="wrap">
            <div class="wrap-inner">
                <h1 class="big-slogan">Free, Fast <span>and BeautiFul CV</span></h1>
                <div class="_fwfl btn-wrap">
                    <a href="#" class="explode-btn">EXPLORE &nbsp;<i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        
        <footer class="_fwfl">
            <ul class="_lsn footer-nav" id="homeFooterNav">
                <li><a href="#"><i class="fa fa-bars"></i></a></li>
                <li><a href="/"><i class="fa fa-home"></i> Kpages</a></li>
                <li><a href="#">{{ _t('aboutus') }}</a></li>
                <li><a href="#">{{ _t('feedback') }}</a></li>
                <li><a href="#">{{ _t('help') }}</a></li>
                <li class="f-dev"><a href="#">{{ _t('developers') }}</a></li>
                <li><a href="#">{{ _t('privacy') }}</a></li>
                <li><a href="#">{{ _t('terms') }}</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">English <span class="caret"></span></a>
                    <ul class="dropdown-menu lang-list">
                        <li><a href="#">Vietnamese</a></li>
                    </ul>
                </li>
            </ul>
        </footer>
        
        <div class="classical modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-inner">
                        <div class="modal-header">
                            <h4 class="modal-title" id="loginModalLabel">{{ _t('loginin.form.title') }}</h4>
                            <button type="button" class="close auth-modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="_fw outworld-auth">
                                <p>{{ _t('login.bysocial') }}</p>
                                <button class="btn _btn btn-fb">Facebook</span></button>
                                <button class="btn _btn btn-google">Google</span></button>
                            </div>
                            {!! Form::open(['route' => 'front_login_post', 'method' => 'POST', 'class' => '_fwfl auth-form', 'data-required' => 'email|password']) !!}
                                <p class="_fwfl _tc _tg7">{{ _t('login.byemail') }}</p>
                                <div class="_fwfl auth-field-group">
                                    {!! Form::text('email', '', ['class' => '_fwfl  _ff0 _r2 auth-field', 'id' => 'email', 'maxlength' => '128', 'autocomplete' => 'off', 'placeholder' =>  _t('common.email') ]) !!}
                                </div>
                                <div class="_fwfl auth-field-group">
                                    {!! Form::password('password', ['class' => '_ff0 _r2 _fwfl auth-field', 'id' => 'password', 'maxlength' => '60', 'autocomplete' => 'off', 'placeholder' =>  _t('common.pass')]) !!}
                                </div>
                                <div class="_fwfl auth-field-group">
                                    <label>
                                        {!! Form::checkbox('remember', '1', true, ['class' => '_fl _mr5']) !!}
                                        <span class="_fl _ml5 _fwn _tg7">{{ _t('signin.remember') }}</span>
                                    </label>
                                </div>
                                <div class="_fwfl auth-field-group">
                                    <button type="submit" class="_fwfl btn _btn _btn-blue"><i class="fa fa-arrow-right"></i></button>
                                </div>
                                <div class="_fwfl">
                                    <a href="{{ route('front_forgotpass') }}" class="_fr _tb">{{ _t('signin.lostpass') }}</a>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="classical modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-inner">
                        <div class="modal-header">
                            <h4 class="modal-title" id="registerModalLabel">{{ _t('register.joinus') }}</h4>
                            <button type="button" class="close auth-modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="_fwfl outworld-auth">
                                <p>{{ _t('register.bysocial') }}</p>
                                <button class="btn _btn btn-fb">FACEBOOK</button>
                                <button class="btn _btn btn-google">GOOGLE</button>
                            </div>
                            {!! Form::open(['route' => 'front_register_post', 'method' => 'POST', 'class' => '_fwfl auth-form', 'data-required' => 'email|username|password']) !!}
                                <p class="_fwfl _tc _tg7">{{ _t('register.byemail') }}</p>
                                <div class="_fwfl auth-field-group first-field-group">
                                    {!! Form::text('email', '', ['class' => '_fwfl  _ff0 _r2 auth-field', 'id' => 'email', 'maxlength' => '128', 'autocomplete' => 'off', 'placeholder' =>  _t('common.email') ]) !!}
                                </div>
                                <div class="_fwfl auth-field-group">
                                    {!! Form::text('username', '', ['class' => '_fwfl  _ff0 _r2 auth-field', 'id' => 'username', 'maxlength' => '64', 'autocomplete' => 'off', 'placeholder' =>  _t('common.uname') ]) !!}
                                </div>
                                <div class="_fwfl auth-field-group">
                                    {!! Form::password('password', ['class' => '_ff0 _r2 _fwfl auth-field', 'id' => 'password', 'maxlength' => '60', 'autocomplete' => 'off', 'placeholder' =>  _t('common.pass') ]) !!}
                                </div>
                                <div class="_fwfl _tg7 auth-field-group">
                                {!! _t('signup.agree', ['termsUrl' => '#']) !!}
                                </div>
                                <div class="_fwfl auth-field-group">
                                    <button class="_fwfl btn _btn _btn-blue auth-btn"><i class="fa fa-arrow-right"></i></button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
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
