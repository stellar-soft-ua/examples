<div class="social children-gutter-x-small">
    <div><?php echo __('Diese Seite teilen', 'theme'); ?>:</div>

    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ $permalink }}">
        {!! include_asset('images/icons/facebook.svg') !!}
    </a>

    <a target="_blank" href="https://twitter.com/intent/tweet?url={{ $permalink }}">
        {!! include_asset('images/icons/twitter.svg') !!}
    </a>
</div>
