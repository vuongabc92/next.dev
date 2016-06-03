@extends('frontend::layouts._settings')

@section('body')

<div class="row">
    <div class="_fl col-md-9 col-xs-12">
        <div class="_fwfl profile">
            
            @include('frontend::sections.setting-employment')
            
            
            
<!--            
            include('frontend::sections.setting-header')
            include('frontend::sections.setting-publish')
            include('frontend::sections.setting-email')
            include('frontend::sections.setting-slug')
            include('frontend::sections.setting-password')
            include('frontend::sections.setting-personal')
            include('frontend::sections.setting-contact')-->
        </div>
    </div>
    <div class="_fr col-md-3 hidden-xs">
        @include('frontend::layouts.settings-vertical-navigation')
    </div>
</div>
@stop