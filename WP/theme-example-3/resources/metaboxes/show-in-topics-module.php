<?php


add_filter('rwmb_meta_boxes', function ($meta_boxes) {
    $meta_boxes[] = [
        'title'      => __('Themenseite'),
        'post_types' => ['event'],
        'context'    => 'side',
        'priority'   => 'core',

        'fields' => [
            [
                'name' => __('Auf Themenseite anzeigen'),
                'id'   => 'show_on_topic_page',
                'type' => 'checkbox',
                'std'  => 0, // 0 or 1,
                'desc' => __('Zeigt die Veranstaltung auch auf der Themen-Seite an. Normalerweise sind dort nur Projekte zu sehen.')
            ],

        ]
    ];

    // Add more meta boxes if you want
    // $meta_boxes[] = ...

    return $meta_boxes;
});
