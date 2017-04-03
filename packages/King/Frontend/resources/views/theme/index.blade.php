@extends('frontend::layouts._settings')

@section('body')
<div class="row">
    <div class="theme-filter-bar">
        <form class="theme-search-frm">
            <input type="text" class="theme-search-txt" placeholder="{{ _t('theme.search') }}" />
        </form>
    </div>
    <ol class="_fwfl _lsn _p0 theme-tree">
        @foreach($themes as $theme)
        <li>
            <div {{ $theme->isInstalled() ? 'class=installed' : '' }}>
                <a href="#">
                    <div class="theme-screenshot"><img src="{{ asset('uploads/themes/' . $theme->slug . '/screenshoot.png') }}" /></div>
                    <h3>{{ $theme->name }}</h3>
                    <span>{{ _t('theme.moreinf') }}</span>
                </a>
                
                @if ($theme->isInstalled())
                    <form><button type="button" class="btn _btn _btn-sm _btn-blue" >{{ _t('theme.installed') }}</button></form>
                @else
                    <form action="{{ route('front_theme_install') }}" method="post" data-install-theme>
                        {{ csrf_field() }}
                        <input type="hidden" name="theme_id" value="{{ $theme->id }}" />
                        <button type="submit" class="btn _btn _btn-sm _btn-blue-navy" data-finished-text="{{ _t('theme.installed') }}">
                            <img class="install-theme-loading _dn" src="{{ asset('packages/king/frontend/images/loading_blue_navy_24x24.gif') }}" />
                            <i class="fa fa-check _dn"></i>
                            <span>{{ _t('theme.install') }}</span>
                        </button>
                    </form>
                @endif
                
            </div>
        </li>
        @endforeach
    </ol>
</div>
@stop