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
                            <p class="_m0">
                                <strong class="_fs12 _tg8">Visit:</strong> 
                                <a href="{{ url($userProfile->slug) }}" class="_tb _fs12 current-slug">{{ preg_replace('/^http:\/\//', '', url($userProfile->slug)) }}</a>
                            </p>
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
                        <form action="{{ route('front_setting_publish_profile') }}" method="POST" class="_fwfl">
                            <span class="_fl"><input type="checkbox" name="publish_profile" id="publish-cv-swicher" {{ ($userProfile->publish) ? 'checked' : '' }}></span>
                            <label class="_fl _m0 _ml10 _mt3 _fs13 _tg7" for="publish-cv-swicher">{{ _t('setting.profile.publishcs_msg') }}</label>
                            <span class="inline-notification success">{{ _t('saved') }}</span>
                            <span class="inline-notification error">{{ _t('opps') }}</span>
                        </form>
                        <span class="_mt5 settings-help-text">{{ _t('setting.profile.publish_note') }}</span>
                    </div>
                </div>
            </section>
            
            <section>
                <div class="_fwfl settings-row">
                    <div class="_fl col-md-3 col-xs-12">
                        <b class="settings-row-title">{{ _t('setting.profile.email') }}</b>
                    </div>
                    <div class="_fl col-md-9 col-xs-12">
                        <div class="settings-show">
                            <div class="_fl col-no-padding col-md-11 col-xs-11 ">
                                <b class="_fwfl _tb _fs13">{{ user()->email }}</b>
                            </div>
                            <div class="_fr col-no-padding col-md-1 col-xs-1">
                                <button type="button" class="settings-expand-btn" data-show-form><i class="fa fa-pencil"></i></button>
                            </div>
                        </div>
                        {!! Form::open(['route' => 'front_settings_save_info', 'method' => 'POST', 'class' => 'settings-form', 'data-save-form' => '', 'data-requires' => 'email|password']) !!}
                            <div class="settings-field-wrapper">
                                {!! Form::text('email', user()->email, ['class' => 'settings-field', 'placeholder' => _t('setting.profile.emailaddress')]) !!}
                            </div>
                            <div class="settings-field-wrapper">
                                {!! Form::password('password', ['class' => 'settings-field', 'placeholder' => _t('setting.profile.repass')]) !!}
                            </div>
                            <button type=submit" class="btn _btn _btn-sm _btn-blue-navy _mr8">{{ _t('save') }}</button>
                            <button type="reset" class="btn _btn _btn-sm _btn-gray" data-hide-form>{{ _t('cancel') }}</button>
                            <input type="hidden" name="type" value="_EMAIL"/>
                        {!! Form::close() !!}
                    </div>
                </div>
            </section>
            <section>
                <div class="_fwfl settings-row">
                    <div class="_fl col-md-3 col-xs-12">
                        <b class="settings-row-title">{{ _t('setting.profile.url') }}</b>
                    </div>
                    <div class="_fl col-md-9 col-xs-12">
                        <div class="settings-show">
                            <div class="_fl col-no-padding col-md-11 col-xs-11 ">
                                <b class="_fwfl"><a href="{{ url($userProfile->slug) }}" class="_tg6 _fs13 _tdn current-slug">{{ preg_replace('/^http:\/\//', '', url($userProfile->slug)) }}</a></b>
                            </div>
                            <div class="_fr col-no-padding col-md-1 col-xs-1">
                                <button type="button" class="settings-expand-btn" data-show-form><i class="fa fa-pencil"></i></button>
                            </div>
                        </div>
                        {!! Form::open(['route' => 'front_settings_save_info', 'method' => 'POST', 'class' => 'settings-form', 'data-save-form' => '', 'data-requires' => 'slug']) !!}
                            <div class="settings-field-wrapper">
                                {!! Form::text('slug', $userProfile->slug, ['class' => 'settings-field', 'placeholder' => _t('setting.profile.slug')]) !!}
                            </div>
                            <span class="_fwfl settings-help-text _mb10">
                                {{ _t('setting.profile.currurl') }} <strong class="_tg7 current-slug">{{ preg_replace('/^http:\/\//', '', url($userProfile->slug)) }}</strong>
                                <p>{{ _t('setting.profile.slug_note') }}</p>
                            </span>
                            <button type=submit" class="btn _btn _btn-sm _btn-blue-navy _mr8">{{ _t('save') }}</button>
                            <button type="reset" class="btn _btn _btn-sm _btn-gray" data-hide-form>{{ _t('cancel') }}</button>
                            <input type="hidden" name="type" value="_SLUG"/>
                        {!! Form::close() !!}
                    </div>
                </div>
            </section>
            <section>
                <div class="_fwfl settings-row">
                    <div class="_fl col-md-3 col-xs-12">
                        <b class="settings-row-title">{{ _t('setting.profile.pass') }}</b>
                    </div>
                    <div class="_fl col-md-9 col-xs-12">
                        <div class="settings-show">
                            <span class="settings-help-text">{{ _t('setting.profile.pass_note') }}</span>
                            <span class="_fl btn _btn _btn-red _mt10" data-show-form>{{ _t('setting.profile.pass_btn') }}</span>
                        </div>
                        {!! Form::open(['route' => 'front_settings_save_info', 'method' => 'POST', 'class' => 'settings-form', 'data-save-form' => '', 'data-requires' => 'old_password|new_password|new_password_confirmation']) !!}
                            <div class="settings-field-wrapper">
                                {!! Form::password('old_password', ['class' => 'settings-field', 'placeholder' => _t('setting.profile.oldpass')]) !!}
                            </div>
                            <div class="settings-field-wrapper">
                                {!! Form::password('new_password', ['class' => 'settings-field', 'placeholder' => _t('setting.profile.newpass')]) !!}
                            </div>
                            <div class="settings-field-wrapper">
                                {!! Form::password('new_password_confirmation', ['class' => 'settings-field', 'placeholder' => _t('setting.profile.renewpass')]) !!}
                            </div>
                            <button type=submit" class="btn _btn _btn-sm _btn-blue-navy _mr8">{{ _t('save') }}</button>
                            <button type="reset" class="btn _btn _btn-sm _btn-gray" data-hide-form>{{ _t('cancel') }}</button>
                            <input type="hidden" name="type" value="_PASS"/>
                        {!! Form::close() !!}
                    </div>
                </div>
            </section>
            <section>
                <div class="_fwfl settings-row">
                    <div class="_fl col-md-3 col-xs-12">
                        <b class="settings-row-title">{{ _t('setting.profile.personal') }}</b>
                    </div>
                    <div class="_fl col-md-9 col-xs-12">
                        <div class="settings-show">
                            <div class="_fl col-no-padding col-md-11 col-xs-11">
                                <b class="_fl _tg7 _fs13">Bui Thanh Vuong, 24 years old, ...</b>
                            </div>
                            <div class="_fr col-no-padding col-md-1 col-xs-1">
                                <button type="button" class="settings-expand-btn" data-show-form><i class="fa fa-pencil"></i></button>
                            </div>
                        </div>
                        {!! Form::open(['route' => 'front_settings_save_info', 'method' => 'POST', 'class' => 'settings-form', 'data-save-form' => '', 'data-requires' => 'old_password|new_password|new_password_confirmation']) !!}
                            <div class="settings-field-wrapper">
                                <span class="_fl _w50 _pr3">
                                    {!! Form::text('first_name', $userProfile->first_name, ['class' => 'settings-field', 'placeholder' => _t('setting.profile.fname')]) !!}
                                </span>
                                <span class="_fl _w50  _pl3">
                                    {!! Form::text('last_name', $userProfile->last_name, ['class' => 'settings-field', 'placeholder' => _t('setting.profile.lname')]) !!}
                                </span>
                            </div>
                            <div class="settings-field-wrapper settings-birthday">
                                @set $birthdate = birthdate()
                                {!! Form::kingSelect('date', $birthdate['date'], null, ['id' => 'settings-birthdate', 'class' => 'settings-field'], _t('setting.profile.birthdate')) !!}
                                {!! Form::kingSelect('month', $birthdate['month'], null, ['id' => 'settings-birthmonth', 'class' => 'settings-field'], _t('setting.profile.birthmonth')) !!}
                                {!! Form::kingSelect('year', $birthdate['year'], null, ['id' => 'settings-birthyear', 'class' => 'settings-field'], _t('setting.profile.birthyear')) !!}
                            </div>
                            <div class="settings-field-wrapper">
                                {!! Form::kingSelect('gender', [
                                    0 => _t('setting.profile.sextell'), 
                                    1 => _t('setting.profile.male'), 
                                    2 => _t('setting.profile.female'), 
                                    3 => _t('setting.profile.other')
                                ], null, ['id' => 'settings-gender', 'class' => 'settings-field'], _t('setting.profile.sextell')) !!}
                            </div>
                            <button type=submit" class="btn _btn _btn-sm _btn-blue-navy _mr8">{{ _t('save') }}</button>
                            <button type="reset" class="btn _btn _btn-sm _btn-gray" data-hide-form>{{ _t('cancel') }}</button>
                            <input type="hidden" name="type" value="_PASS"/>
                        {!! Form::close() !!}
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
        </div>
    </div>
    <div class="_fr col-md-3 hidden-xs">
        @include('frontend::layouts.settings-vertical-navigation')
    </div>
</div>
@stop