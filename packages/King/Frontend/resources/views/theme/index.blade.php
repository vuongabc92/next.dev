@extends('frontend::layouts._settings')

@section('body')
<div class="row">
    <ol class="_fwfl _lsn _p0 theme-tree">
        <li>
            <div>
                <a href="#">
                    <img src="{{ asset('themes/twenty_sixteen/screenshoot.png') }}" />
                    <h3>Twenty Sixteen</h3>
                </a>
                <form>
                    <input type="hidden" name="theme_id" value="1" />
                    <button>Install</button>
                </form>
            </div>
        </li>
        <li>
            <div>
                2
            </div>
        </li>
        <li>
            <div>
                3
            </div>
        </li>
        <li>
            <div>
                4
            </div>
        </li>
        <li>
            <div>
                5
            </div>
        </li>
        <li>
            <div>
                6
            </div>
        </li>
    </ol>
</div>
@stop