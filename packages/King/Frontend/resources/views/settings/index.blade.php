@extends('frontend::layouts._settings')

@section('body')

<div class="row">
    <div class="_fl col-md-9 col-xs-12">
        <div class="_fwfl profile">
            <section>
                <div class="_fwfl cover" style="background-image: url('{{ check_file($coverMedium) ? $coverMedium : asset('uploads/covers/__default.jpg') }}');">
                    {!! Form::open(['route' => 'front_settings_upload_cover','files' => true, 'method' => 'POST', 'class' => '_fwfl _dn', 'id' => 'upload_cover_form', 'data-upload-cover']) !!}
                    {!! Form::file('__file', ['class' => '_dn', 'id' => 'cover_file_input', 'accept' => 'image/*', 'data-event-trigger' => '#upload_cover_form', 'data-event' => 'change|submit']) !!}
                    {!! Form::close() !!}
                    <button class="_r2 edit-btn" data-event-trigger='#cover_file_input'  data-event='click|click'>
                        <img src="{{ asset('packages/king/frontend/images/loading_white_16x16.gif') }}" class="_dn"/>
                        <i class="fa fa-pencil"></i>
                    </button>
                </div>
                <div class="_fwfl appearance">
                    <div class="_fr col-md-offset-3 col-md-9 col-xs-12">
                        <div class="_fl avatar">
                            {!! Form::open(['route' => 'front_settings_upload_avatar','files' => true, 'method' => 'POST', 'class' => '_fwfl _dn', 'id' => 'upload_avatar_form', 'data-upload-avatar']) !!}
                            {!! Form::file('__file', ['class' => '_dn', 'id' => 'avatar_file_input', 'accept' => 'image/*', 'data-event-trigger' => '#upload_avatar_form', 'data-event' => 'change|submit']) !!}
                            {!! Form::close() !!}
                            <button class="_r2 edit-btn" data-event-trigger='#avatar_file_input'  data-event='click|click'>
                                <img src="{{ asset('packages/king/frontend/images/loading_white_16x16.gif') }}" class="_dn"/>
                                <i class="fa fa-pencil"></i>
                            </button>
                            <img class="_r50 _fwfl _fh avatar-img" src="{{ check_file($avatarMedium) ? $avatarMedium : asset('uploads/avatars/__default.jpg') }}" />
                            
                        </div>
                        <div class="_fwfl _mt15">
                            <h3 class="_p0 _m0 _tg6">Bui Thanh Vuong</h3>
                            <p class="_m0"><strong class="_fs12 _tg8">Visit:</strong> <a href="#" class="_tb _fs12">next.com/vuongabc92</a></p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="_mt20">
                <div class="_fwfl settings-row">
                    <div class="_fl col-md-3 col-xs-12">
                        <b class="settings-row-title">{{ _t('setting.profile.publish') }}</b>
                    </div>
                    <div class="_fr col-md-9 col-xs-12">
                        <button class="_fl _btn btn {{ ($userProfile->publish) ? '_btn-blue1' : '_btn-orange' }}" data-publish-profile>
                            <i class="fa fa-check {{ ($userProfile->publish) ? '_dlb' : '_dn' }}"></i>
                            <span>{{ ($userProfile->publish) ? _t('setting.profile.published_btn') : _t('setting.profile.publish_btn') }}</span>
                        </button>
                        <span class="_mt10 settings-help-text">{{ _t('setting.profile.publish_note') }}</span>
                    </div>
                </div>
            </section>
            
            {!! Form::open(['route' => 'front_settings_upload_avatar', 'method' => 'POST', 'class' => '_fl settings-form']) !!}
            <section>
                <div class="_fwfl settings-row">
                    <div class="_fl col-md-3 col-xs-12">
                        <b class="settings-row-title">{{ _t('setting.profile.email') }}</b>
                    </div>
                    <div class="_fl col-md-9 col-xs-12">
                        <div class="_fl col-no-padding col-md-11 col-xs-11 settings-displaying">
                            <b class="_fwfl _tb _fs13">{{ user()->email }}</b>
                        </div>
                        <div class="_fr col-no-padding col-md-1 col-xs-1 settings-displaying">
                            <button type="button" class="settings-expand-btn" data-show-form><i class="fa fa-pencil"></i></button>
                        </div>
                        <div class="_fwfl settings-group-wrapper">
                            <div class="settings-field-wrapper">
                                {!! Form::text('username', user()->email, ['class' => 'settings-field', 'placeholder' => 'Email address']) !!}
                            </div>
                            <div class="settings-field-wrapper">
                                {!! Form::password('password', ['class' => 'settings-field', 'placeholder' => 'Confirm password']) !!}
                            </div>
                            <button type=submit" class="btn _btn _btn-sm _btn-blue1 _mr8">Save</button>
                            <button type="reset" class="btn _btn _btn-sm _btn-gray" data-hide-form>Cancel</button>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="_fwfl settings-row">
                    <div class="_fl col-md-3 col-xs-12">
                        <b class="settings-row-title">{{ _t('setting.profile.url') }}</b>
                    </div>
                    <div class="_fl col-md-9 col-xs-12">
                        <div class="_fl col-no-padding col-md-11 col-xs-11">
                            <b class="_fwfl"><a href="#" class="_tg6 _fs13 _tdn">next.com/vuongabc92</a></b>
                        </div>
                        <div class="_fr col-no-padding col-md-1 col-xs-1">
                            <button class="settings-expand-btn"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="_fwfl settings-row">
                    <div class="_fl col-md-3 col-xs-12">
                        <b class="settings-row-title">{{ _t('setting.profile.pass') }}</b>
                    </div>
                    <div class="_fl col-md-9 col-xs-12">
                        <span class="settings-help-text">{!! _t('setting.profile.pass_note') !!}</span>
                        <span class="btn _btn _btn-red _mt10">{{ _t('setting.profile.pass_btn') }}</span>
                    </div>
                </div>
            </section>
            <section>
                <div class="_fwfl settings-row">
                    <div class="_fl col-md-3 col-xs-12">
                        <b class="settings-row-title">{{ _t('setting.profile.personal') }}</b>
                    </div>
                    <div class="_fl col-md-9 col-xs-12">
                        <div class="_fl col-no-padding col-md-11 col-xs-11">
                            <b class="_fl _tg8 _fs13">Bui Thanh Vuong, 24 years old, ...</b>
                        </div>
                        <div class="_fr col-no-padding col-md-1 col-xs-1">
                            <button class="settings-expand-btn"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="_fwfl settings-row">
                    <div class="_fl col-md-3 col-xs-12">
                        <b class="settings-row-title">{{ _t('setting.profile.contact') }}</b>
                    </div>
                    <div class="_fl col-md-9 col-xs-12">
                        <div class="_fl col-no-padding col-md-11 col-xs-11">
                            <b class="_fl _tg8 _fs13">12 Le Van Khuong, ..., Ho Chi Minh city</b>
                        </div>
                        <div class="_fr col-no-padding col-md-1 col-xs-1">
                            <button class="settings-expand-btn"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                </div>
            </section>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="_fr col-md-3 hidden-xs">
        @include('frontend::layouts.settings-vertical-navigation')
    </div>
</div>
@stop