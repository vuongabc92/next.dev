<!-- Theme details modal -->
<div class="modal fade modal-theme-details" id="themeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="themeDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="_fwfl theme-details-header" id="themeDetailsHeader">
                    <a href="#" id="themeAuthorAvatar">
                        <img class="_r50" src="" />
                    </a>
                    <h1><span id="themeName"></span> <span class="theme-details-version badge badge-secondary" id="themeVersion"></span></h1>
                    <h2>
                        <span class="theme-by">{{ _t('theme.details_by') }} <a href="#"></a></span>
                        <span class="theme-date">{{ _t('theme.details_on') }} <span class="_tgb"></span></span>
                    </h2>
                </div>
                <div class="_fwfl theme-details-content">
                    <div class="theme-details-screenshot" id="themeScreenshot">
                        <img src="" />
                    </div>
                    @if(auth()->check())
                    <div class="theme-details-meta">
                        <div class="_fwfl theme-details-actions" id="themeAction">
                            <form action="{{ route('front_theme_install') }}" method="post" data-install-theme>
                                {{ csrf_field() }}
                                <input type="hidden" name="theme_id" />
                                <input type="hidden" name="cv_url" value="{{ user()->userProfile->cvUrl() }}"/>
                                <button type="submit" class="btn _btn _btn-blue-navy" data-finished-text="{{ _t('theme.installed') }}">
                                    {{ _t('theme.install') }}
                                </button>
                            </form>
                            <a href="#" class="btn _btn _btn-gray" target="_blank" id="themePreviewBtn">{{ _t('theme.preview') }}</a>
                        </div>
                    </div>
                    @endif
                    <div class="theme-details-desc" id="themeDesc"></div>
                </div>
            </div>
        </div>
    </div>
</div>