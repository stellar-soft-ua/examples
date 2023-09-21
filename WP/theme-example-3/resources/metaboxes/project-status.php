<?php


add_filter('rwmb_meta_boxes', function ($meta_boxes) {
    $meta_boxes[] = [
        'title'      => __('Projektstatus', 'theme'),
        'post_types' => ['project'],
        'context'    => 'after_title',
        'priority'   => 'core',

        'fields' => [
            [
                'id'          => 'project_status',
                'desc'        => __('Der Status vom Projekt gibt an, in welchen Kontexten das Projekt angezeigt wird.
                Projekt in "Ausschreibung" oder "Durchführung" werden im Modul "Aktuelle Projekte" angezeigt. Abgeschlossene
                Projekt werden als "Studien" gelistet.'),
                'type'        => 'select',
                // Array of 'value' => 'Label' pairs
                'options'     => [
                    'tender'  => __('Ausschreibung', 'theme'),
                    'ongoing' => __('Durchführung', 'theme'),
                    'done'    => __('Abgeschlossen', 'theme')
                ],
                // Placeholder text
                'placeholder' => __('Status auswählen...'),
            ]
        ]
    ];

    // Add more meta boxes if you want
    // $meta_boxes[] = ...

    return $meta_boxes;
});
