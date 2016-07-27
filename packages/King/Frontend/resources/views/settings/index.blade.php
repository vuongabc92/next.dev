@extends('frontend::layouts._settings')

@section('body')
<div class="row" data-settings-page-view>
    <div class="_fl col-md-9 col-xs-12">
        <div class="_fwfl settings-page profile" id="profile">
            @include('frontend::sections.setting-header')
            @include('frontend::sections.setting-publish')
            @include('frontend::sections.setting-email')
            @include('frontend::sections.setting-slug')
            @include('frontend::sections.setting-password')
            @include('frontend::sections.setting-personal')
            @include('frontend::sections.setting-contact')
        </div>
        <div class="_fwfl settings-page employment" id="employment">
            @include('frontend::sections.setting-employment')
        </div>
        
        <div class="_fwfl settings-page skills" id="skills">
            @include('frontend::sections.setting-skills')
        </div>
        
        <div class="_fwfl settings-page education" id="education">
            @include('frontend::sections.setting-education')
        </div>
    </div>
    <div class="_fr col-md-3 hidden-xs">
        @include('frontend::layouts.settings-vertical-navigation')
    </div>
</div>
@stop