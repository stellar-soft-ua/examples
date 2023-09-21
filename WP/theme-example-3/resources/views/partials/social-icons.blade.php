<div class="social children-gutter-x-small">
    @if($facebook = get_option('theme_theme_social_facebook'))
        <a href="{{ $facebook }}" target="_blank" class="facebook">{!! include_asset('images/icons/facebook.svg') !!}</a>
    @endif

    @if($twitter = get_option('theme_theme_social_twitter'))
        <a href="{{ $twitter }}" target="_blank" class="twitter">{!! include_asset('images/icons/twitter.svg') !!}</a>
    @endif

    @if($linkedin = get_option('theme_theme_social_linkedin'))
        <a href="{{ $linkedin }}" target="_blank" class="linkedin">{!! include_asset('images/icons/linkedin.svg') !!}</a>
    @endif
</div>
