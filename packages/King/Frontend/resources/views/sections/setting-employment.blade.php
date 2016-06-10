<section class="employment">
    
    <div class="_fwfl timeline-container">
        <div class="timeline">
            <div class="_fwfl timeline-section">
                <div class="timeline-point"></div>
                <div class="timeline-content">
                    <div class="settings-show">
                        <h4>Hi there!</h4>
                        <p>You have not created any employment history yet.</p>
                        <button class="btn _btn _btn-sm _btn-blue" data-show-form><i class="fa fa-plus"></i> Add Employment</button>
                    </div>
                    {!! Form::open(['route' => 'front_settings_save_info', 'method' => 'POST', 'class' => 'settings-form', 'data-save-form' => '', 'data-requires' => '']) !!}
                        <div class="settings-field-wrapper">
                            {!! Form::text('company_name', '', ['class' => 'settings-field', 'placeholder' => 'Company name']) !!}
                        </div>
                        <div class="settings-field-wrapper">
                            {!! Form::text('position', '', ['class' => 'settings-field', 'placeholder' => 'Position']) !!}
                        </div>
                        @set $start_date = employment_date();
                        @set $end_date   = employment_date('end');
                        <div class="settings-field-wrapper">
                            <div class="_fl _w50 _pr3">{!! Form::kingSelect('start_month', $start_date['m'], null, ['id' => 'settings-city', 'class' => 'settings-field']) !!}</div>
                            <div class="_fl _w50 _pl3">{!! Form::kingSelect('start_year', $start_date['y'], null, ['id' => 'settings-city', 'class' => 'settings-field']) !!}</div>
                        </div>
                        <div class="settings-field-wrapper">
                            <div class="_fl _w50 _pr3">{!! Form::kingSelect('end_month', $end_date['m'], null, ['id' => 'settings-city', 'class' => 'settings-field']) !!}</div>
                            <div class="_fl _w50 _pl3">{!! Form::kingSelect('end_year', $end_date['y'], null, ['id' => 'settings-city', 'class' => 'settings-field']) !!}</div>
                        </div>
                        <div class="settings-field-wrapper">
                            {!! Form::text('website', '', ['class' => 'settings-field', 'placeholder' => 'Company website']) !!}
                        </div>
                        <div class="settings-field-wrapper">
                            {!! Form::checkbox('current', 1, 0, ['class' => '_fl _mr5', 'id' => 'employment-current']) !!} <label class="_fwn _fl _ml5" for="employment-current">Current company</label>
                        </div>
                        <button type=submit" class="btn _btn _btn-sm _btn-blue-navy _mr8">{{ _t('save') }}</button>
                        <button type="reset" class="btn _btn _btn-sm _btn-gray" data-hide-form>{{ _t('cancel') }}</button>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="_fwfl timeline-section">
                <div class="timeline-point"></div>
                <div class="timeline-content">
                    <h4>Studio 60</h4>
                    <span>PHP developer</span>
                    <span>May 2016 - Present</span>
                    <a href="http://s60.co" target="_blank">s60.co</a>
                </div>
            </div>
            
            <div class="_fwfl timeline-section">
                <div class="timeline-point"></div>
                <div class="timeline-content">
                    <h4>Sutrix Group</h4>
                    <span>Senior PHP developer</span>
                    <span>July 2015 - June 2016</span>
                    <a href="http://sutrixgroup.com/" target="_blank">sutrixgroup.com</a>
                </div>
            </div>
            
            <div class="_fwfl timeline-section">
                <div class="timeline-point"></div>
                <div class="timeline-content">
                    <h4>PTIT</h4>
                    <span>Full Stack developer</span>
                    <span>July 2013 - June 2015</span>
                </div>
            </div>
            
            <div class="_fwfl timeline-section">
                <div class="timeline-point"></div>
                <div class="timeline-content">
                    A tool created for the THINKLab with the purpose of giving people running client engagements all the resources and information they needed to do so. It needed to be flexible in the way that we could distribute to all global labs.
                </div>
            </div>
            
            <div class="_fwfl timeline-section">
                <div class="timeline-point"></div>
                <div class="timeline-content">
                    A tool created for the THINKLab with the purpose of giving people running client engagements all the resources and information they needed to do so. It needed to be flexible in the way that we could distribute to all global labs.
                </div>
            </div>
            
            <div class="_fwfl timeline-section">
                <div class="timeline-point"></div>
                <div class="timeline-content">
                    A tool created for the THINKLab with the purpose of giving people running client engagements all the resources and information they needed to do so. It needed to be flexible in the way that we could distribute to all global labs.
                </div>
            </div>
        </div>
    </div>
</section>