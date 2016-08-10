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
            <button type="submit" class="btn _btn _btn-sm _btn-blue-navy _mr8">{{ _t('save') }}</button>
            <button type="reset" class="btn _btn _btn-sm _btn-gray" data-hide-form>{{ _t('cancel') }}</button>
            <input type="hidden" name="type" value="_SLUG"/>
            {!! Form::close() !!}
        </div>
    </div>
</section>