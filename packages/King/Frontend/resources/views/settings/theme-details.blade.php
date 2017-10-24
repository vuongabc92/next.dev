@extends('frontend::layouts._layout')

@section('link_style')
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/settings.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/theme-tree.css') }}">
@stop

@section('body')
<div class="_fwfl">
    <div class="theme-details-wrap">
        <div class="_fwfl theme-details-inside">
            <div class="_fwfl _mb10 theme-details-header">
                <a href="#">
                    <img class="_r50" src="{{ asset($userProfile->avatar()) }}" />
                </a>
                <h1><span>{{ $theme->name }}</span> <span class="theme-details-version badge badge-secondary">{{ $theme->version }}</span></h1>
                <h2>
                    <span class="theme-by">{{ _t('theme.details_by') }} <a href="#">{{ (empty($userProfile->first_name)) ? $theme->user->username : $userProfile->first_name . ' ' . $userProfile->last_name }}</a></span>
                    <span class="theme-date">{{ _t('theme.details_on') }} <span class="_tgb">{{ $theme->createdAtFormat('M d, Y') }}</span></span>
                </h2>
                <button type="button" class="close theme-popup-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="_fwfl _pr _mt20">
                <img class="screenshot" src="{{ asset($theme->getScreenshot()) }}" />
                <ul class="_pa _lsn _p0 theme-devices">
                    @if ($theme->devices())
                        @foreach ($theme->devices() as $device)
                            <li><i class="fa fa-{{ $device }}"></i></li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@stop