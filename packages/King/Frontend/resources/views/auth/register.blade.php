@extends('frontend::layouts._auth')

@section('title')
    {{ _t('signup.title') }}
@stop

@section('button')
    <a href="{{ route('front_login') }}" class="_fr btn _btn _btn-white-link signup-btn">{{ _t('signin') }}</a>
@stop

@section('body')
    <div class="auth-box register-box">
        {!! Form::open(['route' => 'front_register_post', 'method' => 'POST', 'class' => '_fwfl auth-form']) !!}
            <h1 class="_fwfl _m0 _p0 auth-form-title">{{ _t('signup.form.title') }}</h1>
            <div class="_fwfl auth-field-group first-field-group">
                <label class="_fwfl _fs14 _fwn _tg5" for="email">
                    @if ($errors->has('email'))
                        <span class="_tr5">{{ $errors->first('email') }}</span>
                    @else
                        {{ _t('common.email') }}
                    @endif
                </label>
                <div class="_fwfl">
                    {!! Form::text('email', '', ['class' => '_fwfl  _ff0 _r2 auth-field', 'id' => 'email', 'maxlength' => '128', 'autocomplete' => 'off']) !!}
                </div>
            </div>
            <div class="_fwfl auth-field-group">
                <label class="_fwfl _fs14 _fwn _tg5" for="username">
                    @if ($errors->has('username'))
                        <span class="_tr5">{{ $errors->first('username') }}</span>
                    @else
                        {{ _t('common.uname') }}
                    @endif
                </label>
                <div class="_fwfl">
                    {!! Form::text('username', '', ['class' => '_fwfl  _ff0 _r2 auth-field', 'id' => 'username', 'maxlength' => '64', 'autocomplete' => 'off']) !!}
                </div>
            </div>
            <div class="_fwfl auth-field-group">
                <label class="_fwfl _fs14 _fwn _tg5" for="password">
                    @if ($errors->has('password'))
                        <span class="_tr5">{{ $errors->first('password') }}</span>
                    @else
                        {{ _t('common.pass') }}
                    @endif

                </label>
                <div class="_fwfl">
                    {!! Form::password('password', ['class' => '_ff0 _r2 _fwfl auth-field', 'id' => 'password', 'maxlength' => '60', 'autocomplete' => 'off']) !!}
                </div>
            </div>
            <div class="_fwfl _tg5 auth-field-group">
            {!! _t('signup.agree', ['termsUrl' => '#']) !!}
            </div>
            <div class="_fwfl auth-field-group">
                <button class="_fwfl btn _btn _btn-blue auth-btn"><i class="fa fa-arrow-right"></i></button>
            </div>
        {!! Form::close() !!}
    </div>
@stop