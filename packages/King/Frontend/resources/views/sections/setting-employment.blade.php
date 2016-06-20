<section class="employment">
    
    <div class="_fwfl timeline-container">
        <div class="timeline" data-update-employment>
            @if (count($employmentHistories))
                @foreach($employmentHistories as $employment)
                    <div class="_fwfl timeline-section" id="timeline-section-{{ $employment->id }}">
                        <div class="timeline-point"></div>
                        <div class="timeline-content">
                            <h4>{{ $employment->company_name }}</h4>
                            <span class="position">{{ $employment->position }}</span>
                            <span class="time">{{ Carbon\Carbon::parse($employment->start_date)->format('m/Y') }} - {{ ($employment->is_current) ? _t('setting.employment.current') : Carbon\Carbon::parse($employment->end_date)->format('m/Y') }}</span>
                            <a href="{{ $employment->company_website }}" target="_blank">{{ (str_contains($employment->company_website, 'https')) ? str_replace('https://', '', $employment->company_website) : str_replace('http://', '', $employment->company_website) }}</a>
                            <button class="btn _btn timeline-edit" data-update-employment-id="{{ $employment->id }}"><i class="fa fa-pencil"></i></button>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="_fwfl timeline-section default-timeline">
                <div class="timeline-point"></div>
                <div class="timeline-content">
                    <div class="settings-show">
                        <h4>{{ _t('setting.employment.hi') }}</h4>
                        @if ( ! count($employmentHistories))
                            <p>{{ _t('setting.employment.noemployment') }}</p>
                        @endif
                        <button class="btn _btn _btn-sm _btn-blue" data-show-form><i class="fa fa-plus"></i> {{ _t('setting.employment.addemploy') }}</button>
                    </div>
                    {!! Form::open(['route' => 'front_settings_save_info', 'method' => 'POST', 'class' => 'settings-form', 'id' => 'settings-add-new-employment', 'data-save-form' => '', 'data-requires' => 'company_name|position|start_month|start_year|end_month|end_year']) !!}
                        <div class="settings-field-wrapper">
                            {!! Form::text('company_name', '', ['class' => 'settings-field', 'placeholder' => _t('setting.employment.companyname')]) !!}
                        </div>
                        <div class="settings-field-wrapper">
                            {!! Form::text('position', '', ['class' => 'settings-field', 'placeholder' => _t('setting.employment.position')]) !!}
                        </div>
                        @set $start_date = employment_date();
                        @set $end_date   = employment_date('end');
                        <div class="settings-field-wrapper">
                            <div class="_fl _w50 _pr3">{!! Form::kingSelect('start_month', $start_date['m'], null, ['id' => 'start-month', 'class' => 'settings-field']) !!}</div>
                            <div class="_fl _w50 _pl3">{!! Form::kingSelect('start_year', $start_date['y'], null, ['id' => 'start-year', 'class' => 'settings-field']) !!}</div>
                        </div>
                        <div class="settings-field-wrapper">
                            <div class="_fl _w50 _pr3">{!! Form::kingSelect('end_month', $end_date['m'], null, ['id' => 'end-month', 'class' => 'settings-field']) !!}</div>
                            <div class="_fl _w50 _pl3">{!! Form::kingSelect('end_year', $end_date['y'], null, ['id' => 'end-year', 'class' => 'settings-field']) !!}</div>
                        </div>
                        <div class="settings-field-wrapper">
                            {!! Form::text('website', '', ['class' => 'settings-field', 'placeholder' => 'Company website']) !!}
                        </div>
                        <div class="settings-field-wrapper">
                            {!! Form::checkbox('current_company', 1, 0, ['class' => '_fl _mr5', 'id' => 'current-company']) !!} <label class="_fwn _fl _ml5 settings-label" for="current-company">{{ _t('setting.employment.curcompany') }}</label>
                        </div>
                        
                        <button type=submit" class="btn _btn _btn-sm _btn-blue-navy _mr8">{{ _t('save') }}</button>
                        <button type="reset" class="btn _btn _btn-sm _btn-gray" data-hide-form>{{ _t('cancel') }}</button>
                        <input type="hidden" name="type" value="_EMPLOYMENT"/>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>