<li>
    <div class="theme-leaf">
        <a href="{{ route('front_theme_details', ['theme_id' => $theme->id]) }}" data-theme-details>
            <img src="{{ asset('uploads/themes/' . $theme->slug . '/screenshot.png') }}" />
            <div class="theme-dataOverlay">
                <div class="_fwfl view-mode-wrap">
                    @if(count($theme->devices()))
                    <ul class="_fr _lsn _m0 _p0 view-mode-list">
                        @foreach($theme->devices() as $device)
                        <li><i class="fa fa-{{ $device }}"></i></li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                <h3>{{ $theme->name }}</h3>
                <span>{{ str_limit($theme->description, 100) }}</span>
            </div>
        </a>
    </div>
</li>