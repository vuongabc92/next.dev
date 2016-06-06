<section>
    <div class="_fwfl settings-row">
        <div class="_fl col-md-3 col-xs-12">
            <b class="settings-row-title">{{ _t('setting.profile.contact') }}</b>
        </div>
        <div class="_fl col-md-9 col-xs-12">
            <div class="settings-show">
                <div class="_fl col-no-padding col-md-11 col-xs-11">
                    <b class="_fl _tg8 _fs13">12 Le Van Khuong, ..., Ho Chi Minh city</b>
                </div>
                <div class="_fr col-no-padding col-md-1 col-xs-1">
                    <button class="settings-expand-btn" data-show-form><i class="fa fa-pencil"></i></button>
                </div>
            </div>
            {!! Form::open(['route' => 'front_settings_save_info', 'method' => 'POST', 'class' => 'settings-form', 'data-save-form' => '', 'data-requires' => '']) !!}
            <div class="settings-field-wrapper">
                {!! Form::text('street', '', ['class' => 'settings-field', 'placeholder' => _t('setting.profile.street')]) !!}
            </div>
            <div class="settings-field-wrapper">
                {!! Form::kingSelect('country', countries(), null, ['id' => 'settings-country', 'class' => 'settings-field', 'data-select-place' => '', 'data-target' => 'city']) !!}
            </div>
            <div class="settings-field-wrapper">
                {!! Form::kingSelect('city', ['' => _t('setting.profile.city')], null, ['id' => 'settings-city', 'class' => 'settings-field', 'data-select-place' => '', 'data-target' => 'district']) !!}
            </div>
            <div class="settings-field-wrapper">
                 <span class="_fl _w50 _pr3">
                    {!! Form::kingSelect('district', ['' => _t('setting.profile.district')], null, ['id' => 'settings-district', 'class' => 'settings-field', 'data-select-place' => '', 'data-target' => 'ward']) !!}
                </span>
                <span class="_fl _w50 _pl3">
                    {!! Form::kingSelect('ward', ['' => _t('setting.profile.ward')], null, ['id' => 'settings-ward', 'class' => 'settings-field']) !!}
                </span>
            </div>
            <div class="settings-field-wrapper">
                {!! Form::text('phone', '', ['class' => 'settings-field', 'placeholder' => 'Phone number']) !!}
            </div>
            <div class="settings-field-wrapper">
                {!! Form::textarea('social', '', ['class' => 'settings-field settings-textarea', 'placeholder' => 'Social network', 'rows' => 3]) !!}
                <span class="_mt5 settings-help-text">
                    Put your social network links line by line, such as:<br />
                    &nbsp;facebook.com/abc <br />
                    &nbsp;twitter.com/abc <br />
                    &nbsp;instagram.com/abc
                </span>
            </div>
            <button type=submit" class="btn _btn _btn-sm _btn-blue-navy _mr8">{{ _t('save') }}</button>
            <button type="reset" class="btn _btn _btn-sm _btn-gray" data-hide-form>{{ _t('cancel') }}</button>
            <input type="hidden" name="type" value="_CONTACT"/>
            {!! Form::close() !!}
        </div>
    </div>
</section>