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
                    <div class="chat-right"><span class="chatbox"><i class="fa fa-caret-left"></i>About Us?</span></div>
                </li>
                <li>
                    <div class="chat-left">&nbsp;</div>
                    <div class="chat-right"><span class="chatbox">Hummm....</span></div>
                </li>
                <li>
                    <div class="chat-left">&nbsp;</div>
                    <div class="chat-right"><span class="chatbox">Well, there is not much things to tell about us.</span></div>
                </li>
                <li>
                    <div class="chat-left">&nbsp;</div>
                    <div class="chat-right"><span class="chatbox">Next was born to help people create a CV fast, free but a super double nice CV.</span></div>
                </li>
                <li>
                    <div class="chat-left">&nbsp;</div>
                    <div class="chat-right"><span class="chatbox">That's it.</span></div>
                </li>
                <li>
                    <div class="chat-left">&nbsp;</div>
                    <div class="chat-right"><span class="chatbox">It's all about us.</span></div>
                </li>
                <li>
                    <div class="chat-left">&nbsp;</div>
                    <div class="chat-right"><span class="chatbox">Wanna say something about us? <a href="mailto:vuongabc92@gmail.com">vuongabc92@gmail.com</a></span></div>
                </li>
            </ul>
        </div>
    </div>
</div>
@stop