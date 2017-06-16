@extends('frontend::layouts._auth')

@section('title')
    {{ _t('signin.title') }}
@stop

@section('button')
    <a href="{{ route('front_register') }}" class="_fr btn _btn _btn-white-link signup-btn">{{ _t('signup') }}</a>
@stop

@section('body')
    <div class="auth-box login-box">
        @include('frontend::inc.auth')
        @yield('auth_login')
    </div>
@stop