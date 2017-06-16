@extends('frontend::layouts._auth')

@section('title')
    {{ _t('signup.title') }}
@stop

@section('button')
    <a href="{{ route('front_login') }}" class="_fr btn _btn _btn-white-link signup-btn">{{ _t('signin') }}</a>
@stop

@section('body')
    <div class="auth-box register-box">
        @include('frontend::inc.auth')
        @yield('auth_register')
    </div>
@stop