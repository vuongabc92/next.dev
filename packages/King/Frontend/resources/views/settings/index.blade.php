@extends('frontend::layouts._settings')

@section('body')
<div class="row" data-settings-page-view>
    <div class="_fl col-md-9 col-xs-12">
        <div class="_fwfl settings-page profile" id="profile">
            @include('frontend::settings.sections.setting-header')
            @include('frontend::settings.sections.setting-publish')
            @include('frontend::settings.sections.setting-email')
            @include('frontend::settings.sections.setting-slug')
            @include('frontend::settings.sections.setting-password')
            @include('frontend::settings.sections.setting-expertise')
            @include('frontend::settings.sections.setting-personal')
            @include('frontend::settings.sections.setting-contact')
        </div>
        <div class="_fwfl settings-page employment" id="employment">
            @include('frontend::settings.sections.setting-employment')
        </div>
        
        <div class="_fwfl settings-page skills" id="skills">
            @include('frontend::settings.sections.setting-skills')
        </div>
        
        <div class="_fwfl settings-page education" id="education">
            @include('frontend::settings.sections.setting-education')
        </div>
        
        <div class="_fwfl settings-page projects" id="projects">
            @include('frontend::settings.sections.setting-projects')
        </div>
    </div>
    <div class="_fr col-md-3 hidden-xs">
        @include('frontend::settings.settings-nav')
    </div>
</div>
@stop