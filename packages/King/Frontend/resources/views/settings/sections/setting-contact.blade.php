<section>
    <div class="_fwfl settings-row settings-last-row">
        <div class="_fl col-md-3 col-xs-12">
            <b class="settings-row-title">{{ _t('setting.profile.contact') }}</b>
        </div>
        <div class="_fl col-md-9 col-xs-12">
            <div class="settings-show">
                <div class="_fl col-no-padding col-md-11 col-xs-11">
                    <span class="settings-help-text">
                        {{ _t('setting.contact.default_txt') }}
                    </span>
                </div>
                <div class="_fr col-no-padding col-md-1 col-xs-1">
                    <button class="settings-expand-btn" data-show-form><i class="fa fa-pencil"></i></button>
                </div>
            </div>
            {!! Form::open(['route' => 'front_settings_save_info', 'method' => 'POST', 'class' => 'settings-form', 'data-save-form' => '', 'data-requires' => '']) !!}
            <div class="settings-field-wrapper">
                {!! Form::text('street_name', $userProfile->street_name, ['class' => 'settings-field', 'placeholder' => _t('setting.profile.street')]) !!}
            </div>
            <div class="settings-field-wrapper">
                {!! Form::kingSelect('country', $countries, $userProfile->country_id, ['id' => 'settings-country', 'class' => 'settings-field', 'data-select-place' => '', 'data-target' => 'city']) !!}
            </div>
            <div class="settings-field-wrapper">
                {!! Form::kingSelect('city', $cities, $userProfile->city_id, ['id' => 'settings-city', 'class' => 'settings-field', 'data-select-place' => '', 'data-target' => 'district']) !!}
            </div>
            <div class="settings-field-wrapper">
                <span class="_fl _w50 _pr3">
                    {!! Form::kingSelect('district', $districts, $userProfile->district_id, ['id' => 'settings-district', 'class' => 'settings-field', 'data-select-place' => '', 'data-target' => 'ward']) !!}
                </span>
                <span class="_fl _w50 _pl3">
                    {!! Form::kingSelect('ward', $wards, $userProfile->ward_id, ['id' => 'settings-ward', 'class' => 'settings-field']) !!}
                </span>
            </div>
            <div class="settings-field-wrapper">
                {!! Form::text('phone_number', $userProfile->phone_number, ['class' => 'settings-field', 'placeholder' => _t('setting.profile.phone')]) !!}
            </div>
            <div class="settings-field-wrapper">
                {!! Form::text('website', $userProfile->website, ['class' => 'settings-field', 'placeholder' => _t('setting.profile.website')]) !!}
            </div>
            <div class="settings-field-wrapper">
                <div class="social-added-list">
                    <ul data-kill-social data-delete-msg="Delete this social profile?">
                        @set $socialList = social_profile_list()
                        
                        @if(count($socialList))
                            @foreach($socialList as $id => $one)
                            <li>
                                <a href="{{ $one['link'] }}" target="_blank"><i class="{{ (isset($one['icon'])) ? $one['icon'] : '' }}"></i></a>
                                <span class="kill-social" data-kill-id="{{ $id }}" >&times;</span>
                            </li>
                            @endforeach
                            <li><a href="#" onclick="$('#social-modal').modal('show');"><i class="fa fa-plus"></i></a></li>
                        @else
                        <li><a href="#" class="social-empty-msg" onclick="$('#social-modal').modal('show');"><strong>{{ _t('setting.profile.add_social_add') }}</strong></a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <button type="submit" class="btn _btn _btn-sm _btn-blue-navy _mr8">{{ _t('save') }}</button>
            <button type="reset" class="btn _btn _btn-sm _btn-gray" data-hide-form>{{ _t('cancel') }}</button>
            <input type="hidden" name="type" value="_CONTACT"/>
            {!! Form::close() !!}
        </div>
    </div>
    
    <div class="modal modal-social fade" id="social-modal" tabindex="-1" role="dialog" aria-labelledby="socialModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="_fl modal-content">
                <div class="_fwfl modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="socialModalLabel">{{ _t('setting.profile.add_social_title') }}</h4>
                </div>
                {!! Form::open(['route' => 'front_settings_save_info', 'method' => 'POST', 'class' => 'settings-form full', 'data-save-form' => '', 'data-requires' => 'social_type|social_profile']) !!}
                <div class="_fwfl modal-body">
                    <div class="settings-field-wrapper">
                        {!! Form::kingSelect('social_type', $availableSocial, null, ['id' => 'settings-available-social', 'class' => 'settings-field']) !!}
                    </div>
                    <div class="settings-field-wrapper">
                        {!! Form::text('social_profile', '', ['class' => 'settings-field', 'placeholder' => _t('setting.profile.social_profile')]) !!}
                    </div>
                    <input type="hidden" name="type" value="_CONTACT"/>
                    <input type="hidden" name="contact_social" value="true"/>
                </div>
                <div class="_fwfl modal-footer">
                    <button type="button" class="btn _btn _btn-sm _btn-gray" data-dismiss="modal">{{ _t('cancel') }}</button>
                    <button type="submit" class="btn _btn _btn-sm _btn-blue-navy">{{ _t('save') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>