<div class="{{ $module_class }}">
    @foreach((array)$posts as $post)
        <a class="h4"
           href="{{ get_permalink($post) }}"
           style="color: {{ carbon_get_term_meta($post->topic->term_id ?? 0, 'theme_color_primary') }};">{{ $post->post_title }}</a>
    @endforeach
</div>
