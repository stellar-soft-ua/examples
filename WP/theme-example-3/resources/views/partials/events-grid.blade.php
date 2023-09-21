<div class="row">
    @foreach($events as $event)
        <div class="col-xl-4 col-lg-6 isotope-item">
            @include('partials.advanced-link', [
                'title' => $event->post_title,
                'description' => wp_trim_words($event->post_excerpt, 20),
                'href' => get_permalink($event)
            ])
        </div>
    @endforeach
</div>
