@if (\Illuminate\Support\Arr::has($_GET, 'et_fb'))
    @extends('layouts.master')

    @section('content')
        {!! the_content() !!}
    @endsection
@else
@endif
@php
    header('Content-Type: application/json');

    $postId = apply_filters('wpml_object_id', get_queried_object_id(), 'modal', true, $_GET['lang'] ?? 'de');
    $post = get_post($postId);

    echo json_encode([
        'title' => $post->post_title,
        'content' => apply_filters('the_content', $post->post_content)
    ]);

    exit;
@endphp