<?php


add_filter('rwmb_meta_boxes', function ($meta_boxes) {
    $meta_boxes[] = [
        'title'      => __('Verknüpfte Inhalte'),
        'post_types' => ['project', 'event'],
        'context'    => 'side',
        'priority'   => 'default',

        'fields' => [
            [
                'name'       => __('Projekte'),
                'id'         => 'related_projects',
                'type'       => 'post',
                'post_type'  => 'project',
                'multiple'   => true,
                'ajax'       => true,
                'query_args' => [
                    'posts_per_page' => 10,
                ],
                'js_options' => [
                    'minimumInputLength' => 1, // THIS
                ],
            ],
            [
                'name'       => __('Veranstaltungen'),
                'id'         => 'related_events',
                'type'       => 'post',
                'post_type'  => 'event',
                'multiple'   => true,
                'ajax'       => true,
                'query_args' => [
                    'posts_per_page' => 10,
                ],
                'js_options' => [
                    'minimumInputLength' => 1, // THIS
                ],
            ]
        ]
    ];

    // Add more meta boxes if you want
    // $meta_boxes[] = ...

    return $meta_boxes;
});
