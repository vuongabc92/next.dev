<link rel="stylesheet" href="/packages/king/frontend/css/lordoftherings.css">
<div class="lordoftherings">
    <ul>
        <li>
            <a href="{{ route('front_index') }}" title="{{ _t('theme.download.home') }}"><i class="fa fa-home"></i></a>
        </li>
        <li>
            <a href="{{ route('front_settings') }}" title="{{ _t('theme.download.settings') }}"><i class="fa fa-cog"></i></a>
        </li>
        <li>
            <a href="{{ route('front_theme_download', ['slug' => $slug]) }}" title="{{ _t('theme.download.downpdf') }}"><i class="fa fa-download"></i></a>
        </li>
    </ul>
</div>