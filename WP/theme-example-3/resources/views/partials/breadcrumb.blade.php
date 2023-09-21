@if(!is_front_page() && function_exists('bcn_display') && $breadcrumb = bcn_display(true))
    <div class="{{ $container }}">
        <div class="breadcrumb">
            <div class="breadcrumb-items">
                {!! $breadcrumb !!}
            </div>
        </div>
    </div>
@endif
