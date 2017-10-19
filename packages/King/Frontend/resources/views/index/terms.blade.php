@extends('frontend::layouts._layout')

@section('link_style')
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/page.css') }}">
@stop

@section('body')
<div class="_fwfl">
    <header class="page-header" style="background-image: url({{ asset(($page) ? $page->getBannerImage() : '') }})">
        <div class="constraint">
            <h1><i class="fa fa-cog"></i> {!! ($page) ? $page->name : 'Developer' !!}</h1>
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