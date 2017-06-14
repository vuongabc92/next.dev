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
                <a href="#"><img src="{{ asset('packages/king/frontend/images/logo.png') }}" /></a>
                <ul class="_fr _lsn main-nav">
                    <li><a href="#" class="btn _btn landing-btn" data-toggle="modal" data-target="#loginModal">{{ _t('login') }}</a></li>
                    <li><a href="#" class="btn _btn landing-btn" data-toggle="modal" data-target="#registerModal">{{ _t('register') }}</a></li>
                </ul>
            </div>
        </header>
        
        <div class="_fwfl wrap">
            <div class="wrap-inner">
                <h1 class="big-slogan">Free, Fast and BeautiFul CV</h1>
                <h3 class="why-join">There are hundreds of CV template are waiting for your exploring.</h3>
                <div class="_fwfl _mt20">
                    <a href="#" class="explode-btn">Let's go</a>
                </div>
            </div>
        </div>
        
        <footer class="_fwfl">
            <ul class="_lsn footer-nav">
                <li><a href="#">About</a></li>
                <li><a href="#">Help</a></li>
                <li><a href="#">Developers</a></li>
                <li><a href="#">Privacy</a></li>
                <li><a href="#">Terms</a></li>
                <li><a href="#">English <i class="caret"></i></a></li>
            </ul>
        </footer>
        
        <div class="classical modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-inner">
                        <div class="modal-header">
                            <h4 class="modal-title" id="loginModalLabel">{{ _t('loginin.form.title') }}</h4>
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
