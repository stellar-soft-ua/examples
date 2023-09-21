<?php


add_filter('rwmb_meta_boxes', function ($meta_boxes) {
    $meta_boxes[] = [
        'title'      => __('Synchronisation'),
        'post_types' => ['zenodo_deposit'],
        'context'    => 'side',
        'priority'   => 'core',

        'fields' => [
            [
                'name' => __('Einfrieren'),
                'id'   => 'is_locked',
                'type' => 'checkbox',
                'std'  => 0, // 0 or 1,
                'desc' => __('Lässt den Post einfrieren und verhindert, dass Änderungen durch einen Synchronisierung überschrieben werden.')
            ]
        ]
    ];

    // Add more meta boxes if you want
    // $meta_boxes[] = ...

    return $meta_boxes;
});
