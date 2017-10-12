@extends('frontend::layouts._layout')

@section('link_style')
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/contact.css') }}">
@stop

@section('body')
<div class="_fwfl">
    <header class="page-header" style="background-image: url({{ user()->userProfile->cover('big') }})">
        <div class="constraint">
            <h1>Contact</h1>
        </div>
    </header>
    
    <div class="page-container">
        <div class="_fwfl page-inside">

            <div class="_fwfl page-content">
                <div class="page-left">
                    {!! ($page) ? $page->content : '' !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop