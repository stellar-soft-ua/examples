<?php


add_filter('rwmb_meta_boxes', function ($meta_boxes) {
    $meta_boxes[] = [
        'title'      => __('Seitentitel'),
        'post_types' => ['page', 'project', 'event'],
        'context'    => 'after_title',
        'priority'   => 'core',

        'fields' => [
            /**
            [
                'id'      => 'hide_title',
                'name'    => __('Sichtbarkeit'),
                'type'    => 'select',
                'options' => [
                    0 => __('Titel anzeigen'),
                    1 => __('Titel verstecken')
                ],
                'desc'    => __('Gibt an, ob der Seitentitel im Template ausgegeben werden soll.')
            ],
             */
            [
                'id'    => '_tagline',
                'name'  => __('Tagline'),
                'type'  => 'text',
                'class' => 'tagline',
                'desc'  => __('Der Untertitel wird unterhalb es Titels angezeigt.')
            ]
        ]
    ];

    // Add more meta boxes if you want
    // $meta_boxes[] = ...

    return $meta_boxes;
});
