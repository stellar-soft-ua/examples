<?php


add_filter('rwmb_meta_boxes', function ($meta_boxes) {
    $meta_boxes[] = [
        'title'      => __('Oft Gelesen'),
        'post_types' => ['project', 'event'],
        'context'    => 'side',
        'priority'   => 'core',

        'fields' => [
            [
                'id'         => \THEME\Theme\Helper\ReadCounter::COUNTER_META_KEY,
                'name'       => __('Aufrufe'),
                'type'       => 'text',
                'attributes' => [
                    'readonly' => true
                ]
            ],
            [
                'name' => __('Featured'),
                'id'   => 'is_featured',
                'type' => 'checkbox',
                'std'  => 1, // 0 or 1,
                'desc' => __('Lässt den Post in "Oft Gelesen" zu Beginn erscheinen.')
            ],

        ]
    ];

    // Add more meta boxes if you want
    // $meta_boxes[] = ...

    return $meta_boxes;
});
