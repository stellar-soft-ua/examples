<?php

use THEME\Theme\Repositories\EventRepository;
use THEME\Theme\Repositories\ProjectRepository;

$post  = get_queried_object();
$terms = wp_get_object_terms($post->ID, 'topic');
$term  = is_array($terms) && count($terms) >= 1 ? $terms[0] : null;

$posts = ProjectRepository::builder()
                          ->setIds(array_merge(
                              get_post_meta($post->ID, 'related_projects'),
                              get_post_meta($post->ID, 'related_events')
                          ))
                          ->withTopic()
                          ->withEvents()
                          ->orderByMetaKey('starts_at', 'desc')
                          ->get();

$sections = Carbon_Fields\Helper\Helper::get_post_meta($post->ID, 'sections') ?: null;
$footer   = Carbon_Fields\Helper\Helper::get_post_meta($post->ID, 'footer') ?: null;

return [
    'post'          => $post,
    'term'          => $term,
    'sections'      => $sections,
    'footer'        => $footer,
    'related_posts' => $posts
];
