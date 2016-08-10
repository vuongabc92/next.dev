<section>
    {!! Form::open(['route' => 'front_settings_save_info', 'method' => 'POST', 'class' => '_fwfl skills-form', 'data-add-skill' => '', 'data-required' => 'skill']) !!}
        <h3 class="skills-title">Your Skills</h3>
        <div class="settings-field-wrapper">
            <div class="skill-field">{!! Form::text('skill', null, ['class' => 'settings-field', 'placeholder' => _t('setting.skill.add'), 'autocomplete' => 'off']) !!}</div>
            <input type="hidden" name="type" value="_SKILL">
            <div class="skill-btn"><button type="submit" class="btn _btn skill-submit"><i class="fa fa-plus"></i></button></div>
        </div>
        <div class="_fwfl _mt12 skill-tags">
            <div class="tag">
                <div class="tag-container">
                    <div class="rating" data-rating="5">
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                        <input type="hidden" value="0" class="current-rating"/>
                    </div>
                    <div class="tag-name">PHP & MySQL</div>
                    <i class="fa fa-close"></i>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</section>