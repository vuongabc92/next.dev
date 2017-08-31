@extends('frontend::layouts._layout')

@section('link_style')
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/aboutus.css') }}">
@stop

@section('body')
<div class="container">
    <div class="aboutus-wrap">
        <div class="_fwfl about-us">
            <ul class="_fwfl _lsn _p0 _m0 chat-tree ">
                <li>
                    <div class="chat-left"><b class="chatbot">^^</b></div>
                    <div class="chat-right"><span class="chatbox"><i class="fa fa-caret-left"></i>Contact Us?</span></div>
                </li>
                <li>
                    <div class="chat-left">&nbsp;</div>
                    <div class="chat-right"><span class="chatbox">Hummmm...Sure we can hangout and talk about everything in the whole world ^^!</span></div>
                </li>
                <li>
                    <div class="chat-left">&nbsp;</div>
                    <div class="chat-right"><span class="chatbox">Please call me at 0909090989.</span></div>
                </li>
                <li>
                    <div class="chat-left">&nbsp;</div>
                    <div class="chat-right"><span class="chatbox">Or send me an email by <a href="mailto:vuongabc92@gmail.com">vuongabc92@gmail.com</a></span></div>
                </li>
                <li>
                    <div class="chat-left">&nbsp;</div>
                    <div class="chat-right"><span class="chatbox">I'm also always available on Skype vuongabc92.</span></div>
                </li>
                <li>
                    <div class="chat-left">&nbsp;</div>
                    <div class="chat-right"><span class="chatbox">Everything, everythingggggg... Sure I can share with you ^^!</span></div>
                </li>
            </ul>
        </div>
    </div>
</div>
@stop