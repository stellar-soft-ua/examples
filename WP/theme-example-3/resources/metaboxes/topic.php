<?php


add_filter('rwmb_meta_boxes', function ($meta_boxes) {
    $meta_boxes[] = [
        'title'      => __('Thema'),
        'post_types' => ['project', 'event', 'zenodo_deposit'],
        'context'    => 'after_title',
        'priority'   => 'core',

        'fields' => [
            [
                'id'             => 'taxonomy',
                'type'           => 'taxonomy',
                'placeholder'    => __('Wählen Sie ein Thema aus...'),

                // Taxonomy slug.
                'taxonomy'       => 'topic',

                // How to show taxonomy.
                'field_type'     => 'select',
                'remove_default' => true,
                'desc'           => __('Projekte und Veranstaltungen können mit einem Thema verknüpft werden, unter dem sie 
                zusammengefasst werden. Das Thema definiert auch die Farbe der Überschrift oder Themen-Boxen.')
            ]
        ]
    ];

    // Add more meta boxes if you want
    // $meta_boxes[] = ...

    return $meta_boxes;
});
