<!DOCTYPE html>
<html>
    <head>
        <title>:)</title>
        <meta charset="UTF-8">
        <meta id="viewport" name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <meta name="msapplication-tap-highlight" content="no"/>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="ajax-error" content="{{ _t('oops') }}" />
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/settings.css') }}">
        <link rel="stylesheet" href="{{ asset('packages/king/frontend/css/theme.css') }}">
    </head>
    <body>
        <main>
            @include('frontend::inc.layout-parts')
            @yield('header')
            <div class="_fwfl theme-filter-bar">
                <div class="container">
                    <ul class="_fwfl _lsn _p0 _m0 theme-filter-list" role="tablist">
                        <li><a href="#"><i class="fa fa-bars"></i></a></li>
                        @if(auth()->check())
                        <li role="presentation"><a href="#yourThemes" aria-controls="yourThemes" role="tab" data-toggle="tab" id="navTabYourThemes">{{ _t('theme.bar.your') }}</a></li>
                        @endif
                        <li role="presentation" class="active"><a href="#allThemes" aria-controls="allThemes" role="tab" data-toggle="tab" id="navTabAllThemes">{{ _t('theme.bar.all') }}</a></li>
                        <li role="presentation"><a href="#popularThemes" aria-controls="popularThemes" role="tab" data-toggle="tab">{{ _t('theme.bar.popular') }}</a></li>
                        @if(auth()->check())
                        <li role="presentation"><a href="#" class="add-theme-btn" data-toggle="modal" data-target="#addThemeModal"><i class="fa fa-plus"></i> {{ _t('theme.bar.add') }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="container">
                <div class="settings">
                    <div class="row">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane" id="yourThemes">
                                @if($currentTheme)
                                <div class="_fwfl current-activated-theme">
                                    <div class="screenshot">
                                        <span class="label label-info"><i class="fa fa-check"></i> {{ _t('theme.curActivated') }}</span>
                                        <img src="{{ asset('uploads/themes/' . $currentTheme->slug . '/screenshot.png') }}">
                                    </div>
                                    <div class="_fwfl _mt20 activated-info">
                                        <a href="{{ route('front_theme_details', ['theme_id' => $currentTheme->id]) }}" data-theme-details class="_fl _btn btn _btn-blue-navy">{{ _t('theme.details') }}</a>
                                        <button data-event-trigger="#navTabAllThemes" data-event="click|click" class="_fl _btn btn _btn-gray">{{ _t('theme.change') }}</button>
                                    </div>
                                </div>
                                @endif
                                <div class="_fwfl uploaded-themes">
                                    <h3>{{ _t('theme.yourUploaded') }}</h3>
                                    <ol class="_fwfl _lsn _p0 theme-tree" id="uploadedThemeTree">
                                        @if($uploadedThemes->count())
                                            @foreach($uploadedThemes as $theme)
                                                @include('frontend::inc.theme-item', ['theme' => $theme])
                                            @endforeach
                                        @endif
                                    </ol>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane active" id="allThemes">
                                <ol class="_fwfl _lsn _p0 theme-tree">
                                    @if($themes->count())
                                        @foreach($themes as $theme)
                                            @include('frontend::inc.theme-item', ['theme' => $theme])
                                        @endforeach
                                    @endif
                                </ol>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="popularThemes">Popular themes</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Theme details modal -->
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
                                    <span class="theme-by">{{ _t('theme.details_by') }} <a href="#"></a></span>
                                    <span class="theme-date">{{ _t('theme.details_on') }} <span class="_tgb"></span></span>
                                </h2>
                            </div>
                            <div class="_fwfl theme-details-content">
                                <div class="theme-details-screenshot" id="themeScreenshot">
                                    <img src="" />
                                </div>
                                @if(auth()->check())
                                <div class="theme-details-meta">
                                    <div class="_fwfl theme-details-actions" id="themeAction">
                                        <form action="{{ route('front_theme_install') }}" method="post" data-install-theme>
                                            {{ csrf_field() }}
                                            <input type="hidden" name="theme_id" />
                                            <input type="hidden" name="cv_url" value="{{ user()->userProfile->cvUrl() }}"/>
                                            <button type="submit" class="btn _btn _btn-blue-navy" data-finished-text="{{ _t('theme.installed') }}">
                                                {{ _t('theme.install') }}
                                            </button>
                                        </form>
                                        <a href="#" class="btn _btn _btn-gray" target="_blank" id="themePreviewBtn">{{ _t('theme.preview') }}</a>
                                    </div>
                                </div>
                                @endif
                                <div class="theme-details-desc" id="themeDesc"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(auth()->check())
            <!-- Add theme modal -->
            <div class="modal fade king-modal add-theme-modal" id="addThemeModal" tabindex="-1" role="dialog" aria-labelledby="addThemeModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="addThemeModalLabel">{{ _t('theme.upload.modaltitle') }}</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(['route' => 'front_settings_save_info', 'method' => 'POST', 'class' => 'add-theme-form', 'data-save-form' => '', 'data-requires' => 'theme_name|theme_version|theme_desc']) !!}
                                <div class="settings-field-wrapper">
                                    <button type="button" class="btn _btn _btn-sm _btn-blue" id="uploadThemeBtn" data-event-trigger="#theme_file_input" data-event="click|click" data-loading="blue24">{{ _t('theme.upload.addThemebtn') }}</button>
                                    <input type="hidden" name="theme_path"/>
                                </div>
                                <div class="settings-field-wrapper">
                                    {!! Form::text('theme_name', '', ['class' => 'settings-field', 'placeholder' => _t('theme.upload.themename'), 'autocomplete' => 'off']) !!}
                                </div>
                                <div class="settings-field-wrapper">
                                    {!! Form::text('theme_version', '', ['class' => 'settings-field', 'placeholder' => _t('theme.upload.themeversion'), 'autocomplete' => 'off']) !!}
                                </div>
                                <div class="settings-field-wrapper">
                                    {!! Form::textarea('theme_desc', '', ['class' => 'settings-textarea', 'placeholder' => _t('theme.upload.themedesc')]) !!}
                                </div>
                                <div class="settings-field-wrapper devices-field">
                                    <span class="_fwfl _tg5 _mb10 devices-title">{{ _t('theme.upload.themedevices') }}</span>
                                    <div class="devices-col">
                                        <label>
                                            <input type="checkbox" name="devices[]" value="desktop"/>
                                            <span>{{ _t('theme.upload.themedesktop') }}</span>
                                        </label>
                                    </div>
                                    <div class="devices-col">
                                        <label>
                                            <input type="checkbox" name="devices[]" value="tablet"/>
                                            <span>{{ _t('theme.upload.themetablet') }}</span>
                                        </label>
                                    </div>
                                    <div class="devices-col">
                                        <label>
                                            <input type="checkbox" name="devices[]" value="mobile"/>
                                            <span>{{ _t('theme.upload.thememobile') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="settings-field-wrapper">
                                    <span class="_fwfl _tg5 _mb10 devices-title">{{ _t('setting.theme.pickexpertise') }}</span>
                                    {!! Form::select('expertise_id[]', $expertises, null, ['id' => 'theme-expertise', 'class' => 'settings-field theme-expertise', 'multiple' => '']) !!}
                                </div>
                                <div class="settings-field-wrapper">
                                    {!! Form::text('theme_tags', '', ['class' => 'settings-field', 'placeholder' => _t('theme.upload.themetags'), 'autocomplete' => 'off']) !!}
                                </div>
                                
                                <button type="submit" class="btn _btn _btn-sm _btn-blue-navy _mr8">{{ _t('save') }}</button>
                                <button type="reset" class="btn _btn _btn-sm _btn-gray" data-hide-form>{{ _t('cancel') }}</button>
                                <input type="hidden" name="type" value="_THEME"/>
                            {!! Form::close() !!}
                            
                            {!! Form::open(['route' => 'front_theme_add_new','files' => true, 'method' => 'POST', 'class' => '_fwfl _dn', 'id' => 'upload_theme_form', 'data-upload-theme']) !!}
                            {!! Form::file('__file', ['class' => '_dn', 'id' => 'theme_file_input', 'accept' => '.zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed', 'data-event-trigger' => '#upload_theme_form', 'data-event' => 'change|submit']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="alert-bar alert fade out" role="alert" id="alertBar">
                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="container">
                    <span class="_fs13 _fwb" id="alertText"></span>
                </div>
            </div>
            <div id="themeItemTemplate" class="_dn">
                <li> 
                    <div class="theme-leaf">
                        <a href="{{ route('front_theme_details', ['theme_id' => 'THEME_ID']) }}" data-theme-details>
                            <img src="">
                            <div class="theme-dataOverlay">
                                <div class="_fwfl view-mode-wrap">
                                    <ul class="_fr _lsn _m0 _p0 view-mode-list"></ul>
                                </div>
                                <h3></h3>
                                <span></span>
                            </div>
                        </a>
                    </div>
                </li>
            </div>
        </main>
        
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/jquery_v1.11.1.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/jquery-ui-1.11.4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/bootstrap.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/bootstrap-switch.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/script.js') }}"></script>
    </body>
</html>