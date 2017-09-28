@extends('frontend::layouts._layout')

@section('link_style')
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/aboutus.css') }}">
@stop

@section('body')
<div class="container">
    {!! $content !!}
</div>
@stop