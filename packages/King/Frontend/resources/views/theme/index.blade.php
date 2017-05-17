@extends('frontend::layouts._settings')

@section('body')
<div class="row">
    <div class="theme-filter-bar _r2">
        <div class="theme-filter-elements">
            <ul role="tablist">
                <li><span>2712</span></li>
                <li role="presentation"><a href="#yourThemes" aria-controls="yourThemes" role="tab" data-toggle="tab">Your themes</a></li>
                <li role="presentation" class="active"><a href="#themes" aria-controls="themes" role="tab" data-toggle="tab">Themes</a></li>
            </ul>
        </div>
        <form class="theme-search-frm">
            <input type="text" class="theme-search-txt" placeholder="{{ _t('theme.search') }}" />
        </form>
    </div>
    <div class="_fwfl tab-content">
        <div role="tabYourThemes" class="tab-pane" id="yourThemes">
            <ol class="_fwfl _lsn _p0 theme-tree">
                @foreach($themes as $theme)
                <li>
                    <div class="theme-leaf">
                        <a href="#" class="theme-screenshot" data-theme-details data-theme-id="{{ $theme->id }}">
                            <ul class="theme-view-mode">
                                @if($theme->getViewMode() && count($theme->getViewMode()))
                                    @foreach($theme->getViewMode() as $mode)
                                        <li><i class="fa fa-{{ $mode }}"></i></li>
                                    @endforeach
                                @endif
                            </ul>
                            <img src="{{ asset('uploads/themes/' . $theme->slug . '/thumbnail.png') }}" />
                            <div class="theme-toggle-info">
                                <strong>{{ $theme->name }}</strong>
                                <span>{{ $theme->getJson()->description }}</span>
                            </div>
                        </a>
                        <ul class="theme-counting-bar">
                            <li><i class="fa fa-download"></i> <span>16317</span></li>
                            <li><i class="fa fa-thumb-tack"></i> <span>2317</span></li>
                            <li><i class="fa fa-eye"></i> <span>35267</span></li>
                        </ul>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
        <div role="tabThemes" class="tab-pane active" id="themes">
            <ol class="_fwfl _lsn _p0 theme-tree" data-theme-details-url="{{ route('front_theme_details') }}">
                @foreach($themes as $theme)
                <li>
                    <div class="theme-leaf">
                        <a href="#" class="theme-screenshot" data-theme-details data-theme-id="{{ $theme->id }}">
                            <ul class="theme-view-mode">
                                @if($theme->getViewMode() && count($theme->getViewMode()))
                                    @foreach($theme->getViewMode() as $mode)
                                        <li><i class="fa fa-{{ $mode }}"></i></li>
                                    @endforeach
                                @endif
                            </ul>
                            <img src="{{ asset('uploads/themes/' . $theme->slug . '/thumbnail.png') }}" />
                            <div class="theme-toggle-info">
                                <strong>{{ $theme->name }}</strong>
                                <span>{{ $theme->getJson()->description }}</span>
                            </div>
                        </a>
                        <ul class="theme-counting-bar">
                            <li><i class="fa fa-download"></i> <span>16317</span></li>
                            <li><i class="fa fa-thumb-tack"></i> <span>2317</span></li>
                            <li><i class="fa fa-eye"></i> <span>35267</span></li>
                        </ul>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
    </div>
</div>

<div class="modal fade modal-theme-details" id="themeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="themeDetailsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="_fwfl modal-content">
            <div class="_fwfl modal-body">
                <div class="_fwfl theme-details-header" id="themeDetailsHeader">
                    <a href="#" id="themeAuthorAvatar">
                        <img class="_r50" src="" />
                    </a>
                    <h1><span id="themeName"></span> <span class="theme-details-version label label-info" id="themeVersion"></span></h1>
                    <h2>
                        <span class="theme-by">by <a href="#">The Next Team</a></span>
                        <span class="theme-date">on <span class="_tgb">May 28, 2017</span></span>
                    </h2>
                </div>
                <div class="_fwfl theme-details-content">
                    <div class="theme-details-screenshot" id="themeScreenshot">
                        <img src="" />
                    </div>
                    <div class="theme-details-meta">
                        <div class="_fwfl theme-details-actions" id="themeAction">
                            <form action="{{ route('front_theme_install') }}" method="post" data-install-theme>
                                {{ csrf_field() }}
                                <input type="hidden" name="theme_id" />
                                <button type="submit" class="btn _btn _btn-blue-navy" data-finished-text="{{ _t('theme.installed') }}">
                                    {{ _t('theme.install') }}
                                </button>
                            </form>
                            <a href="#" class="btn _btn _btn-gray">Preview</a>
                        </div>
                    </div>
                    <div class="theme-details-desc" id="themeDesc">
                        Creative Market is a platform for handcrafted, mousemade design content from independent creatives around the world. We're passionate about making beautiful design simple and accessible to everyone.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop