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
            @yield('user_header')
            <div class="_fwfl theme-filter-bar">
                <div class="container">
                    <ul class="_fwfl _lsn _p0 _m0 theme-filter-list">
                        <li><a href="#"><i class="fa fa-bars"></i></a></li>
                        <li><a href="#">Your themes</a></li>
                        <li><a href="#">All themes</a></li>
                        <li><a href="#">Popular themes</a></li>
                        <li><a href="#" class="add-theme-btn" data-toggle="modal" data-target="#addThemeModal"><i class="fa fa-plus"></i> Add theme</a></li>
                    </ul>
                </div>
            </div>
            <div class="container">
                <div class="settings">
                    <div class="row">
                        <div role="tabThemes" class="tab-pane active" id="themes">
                            <ol class="_fwfl _lsn _p0 theme-tree" data-theme-details-url="{{ route('front_theme_details') }}">
                                @foreach($themes as $theme)
                                <li>
                                    <div class="theme-leaf">
                                        <a href="#" data-theme-details data-theme-id="{{ $theme->id }}">
                                            <img src="{{ asset('uploads/themes/' . $theme->slug . '/screenshot.png') }}" />
                                        </a>
                                    </div>
                                </li>
                                @endforeach
                            </ol>
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
                                    <button type="button" class="btn _btn _btn-sm _btn-blue" id="uploadThemeBtn" data-event-trigger="#theme_file_input" data-event="click|click" data-loading="blue24">Upload your theme</button>
                                    <input type="hidden" name="theme_path"/>
                                </div>
                                <div class="settings-field-wrapper">
                                    {!! Form::text('theme_name', '', ['class' => 'settings-field', 'placeholder' => _t('theme.upload.themename')]) !!}
                                </div>
                                <div class="settings-field-wrapper">
                                    {!! Form::text('theme_version', '', ['class' => 'settings-field', 'placeholder' => _t('theme.upload.themeversion')]) !!}
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
                                    {!! Form::text('theme_tags', '', ['class' => 'settings-field', 'placeholder' => _t('theme.upload.themetags')]) !!}
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
            <div class="alert-bar alert fade out" role="alert" id="alertBar">
                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="container">
                    <span class="_fs13 _fwb" id="alertText"></span>
                </div>
            </div>
        </main>
        
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/jquery_v1.11.1.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/jquery-ui-1.11.4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/bootstrap.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/bootstrap-switch.js') }}"></script>
        <script type="text/javascript" src="{{ asset('packages/king/frontend/js/script.js') }}"></script>
    </body>
</html>