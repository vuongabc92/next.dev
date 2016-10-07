<section>
    {!! Form::open(['route' => 'front_settings_save_info', 'method' => 'POST', 'class' => '_fwfl skills-form', 'data-add-skill' => '', 'data-required' => 'skill']) !!}
        <h3 class="skills-title">Your Skills</h3>
        <div class="settings-field-wrapper">
            <div class="skill-field">{!! Form::text('skill', null, ['class' => 'settings-field', 'placeholder' => _t('setting.skill.add'), 'autocomplete' => 'off', 'data-autocomplete-skill']) !!}</div>
            <input type="hidden" name="type" value="_SKILL">
            <div class="skill-btn"><button type="submit" class="btn _btn skill-submit"><i class="fa fa-plus"></i></button></div>
            <div class="skill-suggestion"></div>
        </div>
        <div class="_fwfl _mt12 skill-tags" data-rating="5" data-kill-tag>
            @if(user()->skills->count())
                @foreach(user()->skills as $user_skill)
                <div class="tag" id="{{ $user_skill->id }}">
                    <div class="tag-container">
                        <div class="rating">
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <input type="hidden" value="{{ (is_null($user_skill->votes)) ? 0 : $user_skill->votes }}" class="current-rating"/>
                        </div>
                        <div class="tag-name">{{ $user_skill->skill->name }}</div>
                        <i class="fa fa-close"></i>
                    </div>
                </div>
                @endforeach
            @else
                <span class="_fs13 _fwb _tg7 no-skills">{{ _t('setting.skill.empty') }}</span>
            @endif
        </div>
    {!! Form::close() !!}
</section>