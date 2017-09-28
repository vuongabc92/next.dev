@extends('frontend::layouts._layout')

@section('link_style')
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/aboutus.css') }}">
@stop

@section('body')
<div class="container">
    <div class="aboutus-wrap">
        <div class="_fwfl about-us">
            <ul class="_fwfl _lsn _p0 _m0 chat-tree ">
                @if(count($about))
                    @foreach($about as $k => $one)
                        <li>
                            @if($k === 0)
                            <div class="chat-left"><b class="chatbot">^^</b></div>
                            @else
                            <div class="chat-left">&nbsp;</div>
                            @endif
                            <div class="chat-right"><span class="chatbox"><i class="fa fa-caret-left"></i>{!! $one !!}</span></div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
@stop