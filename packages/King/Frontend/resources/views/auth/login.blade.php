@extends('frontend::layouts._layout')

@section('link_style')
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/auth.css') }}">
@stop

@section('title')
    {{ _t('signin.title') }}
@stop

@section('body')
<div class="_fwfl">
    <div class="auth-box login-box">
        @include('frontend::inc.auth')
        @yield('auth_login')
    </div>
</div>
@stop