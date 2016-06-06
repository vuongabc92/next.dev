<div class="selecter" data-selecter>
    {!! Form::select($name, $value, $default, $attributes) !!}
    <label for="{{ $attributes['id'] }}">{{ (null === $default) ? array_first($value) : $value[$default] }}</label>
    <i class="fa fa-angle-down"></i>
    <img src="{{ asset('packages/king/frontend/images/loading_bgwhite_gray_24x24.gif') }}" />
</div>