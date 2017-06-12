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
                <div class="logo">
                    <div class="crown">
                        <b></b>
                        <span>
                            <i></i>
                            <i></i>
                            <i></i>
                        </span>
                    </div>
                </div>
                <ul class="_fr _lsn main-nav">
                    <li><a href="#" class="btn _btn _btn-blue-navy" data-toggle="modal" data-target="#loginModal">Log in</a></li>
                    <li><a href="#" class="btn _btn _btn-gray" data-toggle="modal" data-target="#registerModal">Sign up</a></li>
                </ul>
            </div>
        </header>
        
        <div class="_fwfl wrap">
            <div class="_fwfl filter-bar">
                <ul class="_p0 _lsn filter-list">
                    <li><a href="#"><span><i></i><i></i><i></i></span></a></li>
                    <li><a href="#">Your theme</a></li>
                    <li><a href="#">All themes</a></li>
                    <li><a href="#">Popular</a></li>
                </ul>
            </div>
            <div class="_fwfl wrap-inner">
                <div class="theme-tree-wrap">
                    <ol class="_fwfl _lsn _p0 theme-tree">
                        @foreach($themes as $theme)
                        <li>
                            <div class="theme-leaf">
                                <a href="#">
                                    <img src="{{ asset('uploads/themes/' . $theme->slug . '/screenshot.png') }}" />
                                    <div class="theme-overlay">
                                        <h3>{{ $theme->name }}</h3>
                                        <span>{{ $theme->getJson()->description }}</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
        
        <footer class="_fwfl">
            <div class="footer-inner">
                <div class="logo">
                    <div class="crown">
                        <b></b>
                        <span>
                            <i></i>
                            <i></i>
                            <i></i>
                        </span>
                    </div>
                </div>
            </div>
        </footer>
        
        <div class="classical modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-inner">
                        <div class="modal-header">
                            <h4 class="modal-title" id="loginModalLabel">LOG IN TO NEXT</h4>
                        </div>
                        <div class="modal-body">
                            <div class="_fwfl outworld-auth">
                                <button class="btn _fwfl _btn btn-fb"><i class="fa fa-facebook"></i> <span>Continue with Facebook</span></button>
                                <button class="btn _fwfl _btn btn-google"><i class="fa fa-google"></i> <span>Continue with Google</span></button>
                            </div>
                            {!! Form::open(['route' => 'front_login_post', 'method' => 'POST', 'class' => '_fwfl auth-form', 'data-required' => 'email|password']) !!}
                                <span class="or-login">Or</span>
                                <div class="_fwfl auth-field-group">
                                    {!! Form::text('email', '', ['class' => '_fwfl  _ff0 _r2 auth-field', 'id' => 'email', 'maxlength' => '128', 'autocomplete' => 'off', 'placeholder' =>  _t('common.email') ]) !!}
                                </div>
                                <div class="_fwfl auth-field-group">
                                    {!! Form::password('password', ['class' => '_ff0 _r2 _fwfl auth-field', 'id' => 'password', 'maxlength' => '60', 'autocomplete' => 'off', 'placeholder' =>  _t('common.pass')]) !!}
                                </div>
                                <div class="_fwfl auth-field-group">
                                    <label>
                                        {!! Form::checkbox('remember', '1', true, ['class' => '_fl _mr5']) !!}
                                        <span class="_fl _ml5 _fwn">{{ _t('signin.remember') }}</span>
                                    </label>
                                </div>
                                <div class="_fwfl auth-field-group">
                                    <button type="submit" class="_fwfl btn _btn _btn-blue-navy"><i class="fa fa-arrow-right"></i></button>
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
                            <h4 class="modal-title" id="registerModalLabel">CREATE NEXT ACCOUNT</h4>
                        </div>
                        <div class="modal-body">
                            <div class="_fwfl outworld-auth">
                                <button class="btn _fwfl _btn btn-fb"><i class="fa fa-facebook"></i> <span>Connect with Facebook</span></button>
                                <button class="btn _fwfl _btn btn-google"><i class="fa fa-google"></i> <span>Connect with Google</span></button>
                            </div>
                            {!! Form::open(['route' => 'front_register_post', 'method' => 'POST', 'class' => '_fwfl auth-form', 'data-required' => 'email|username|password']) !!}
                                <span class="or-login">Or</span>
                                <div class="_fwfl auth-field-group first-field-group">
                                    {!! Form::text('email', '', ['class' => '_fwfl  _ff0 _r2 auth-field', 'id' => 'email', 'maxlength' => '128', 'autocomplete' => 'off', 'placeholder' =>  _t('common.email') ]) !!}
                                </div>
                                <div class="_fwfl auth-field-group">
                                    {!! Form::text('username', '', ['class' => '_fwfl  _ff0 _r2 auth-field', 'id' => 'username', 'maxlength' => '64', 'autocomplete' => 'off', 'placeholder' =>  _t('common.uname') ]) !!}
                                </div>
                                <div class="_fwfl auth-field-group">
                                    {!! Form::password('password', ['class' => '_ff0 _r2 _fwfl auth-field', 'id' => 'password', 'maxlength' => '60', 'autocomplete' => 'off', 'placeholder' =>  _t('common.pass') ]) !!}
                                </div>
                                <div class="_fwfl _tg5 auth-field-group">
                                {!! _t('signup.agree', ['termsUrl' => '#']) !!}
                                </div>
                                <div class="_fwfl auth-field-group">
                                    <button class="_fwfl btn _btn _btn-blue-navy auth-btn"><i class="fa fa-arrow-right"></i></button>
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
