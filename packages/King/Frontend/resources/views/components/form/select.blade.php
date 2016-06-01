<div class="selecter" data-selecter>
    {!! Form::select($name, $value, $default, $attributes) !!}
    <label for="{{ $attributes['id'] }}">{{ $present }}</label>
    <i class="fa fa-angle-down"></i>
</div>