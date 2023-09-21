<?php

//add_action('carbon_fields_register_fields', function () {
//    Container::make('post_meta', __('Veranstaltungsdetails', 'theme'))
//             ->where('post_type', 'IN', ['event'])
//             ->set_context('side')
//             ->add_fields([
//                 Field::make('date_time', 'starts_at', __('Beginn', 'theme'))
//                      ->set_input_format('d.m.Y H:s', 'd.m.yy HH:MM')
//             ]);
//});


add_filter('rwmb_meta_boxes', function ($meta_boxes) {
    $dateTimeOptions = [
        'dateFormat'      => 'dd.mm.yy',
        'stepMinute'      => 5,
        'showTimepicker'  => true,
        //                    'controlType'     => 'select',
        'showButtonPanel' => false,
        'oneLine'         => false,
    ];

    $meta_boxes[] = [
        'title'      => __('Details', 'theme'),
        'post_types' => ['project', 'event'],
        'context'    => 'after_title',
        'priority'   => 'low',

        'fields' => [
            [
                'name'       => __('Beginn', 'theme'),
                'id'         => 'starts_at',
                'type'       => 'datetime',
                'desc'       => __('Einträge werden nach diesem Wert sortiert.'),

                // Datetime picker options.
                // For date options, see here http://api.jqueryui.com/datepicker
                // For time options, see here http://trentrichardson.com/examples/timepicker/
                'js_options' => $dateTimeOptions,

                // Display inline?
                'inline'     => false,

                // Save value as timestamp?
                'timestamp'  => true,
            ],
            [
                'name'       => __('Ende', 'theme'),
                'id'         => 'ends_at',
                'type'       => 'datetime',
                'desc'       => __('Dieser Wert wird für die Schnittstelle zu a+ benötigt.'),

                // Datetime picker options.
                // For date options, see here http://api.jqueryui.com/datepicker
                // For time options, see here http://trentrichardson.com/examples/timepicker/
                'js_options' => $dateTimeOptions,

                // Display inline?
                'inline'     => false,

                // Save value as timestamp?
                'timestamp'  => true,
            ],
            [
                'name'       => __('Ort', 'theme'),
                'id'         => 'place',
                'type'       => 'text',
                'desc'       => __('Der Veranstaltungsort z.B. <b>Brunngasse 36, 3011 Bern</b>. Wird für die Schnittstelle zu a+ benötigt.')
            ],
        ]
    ];

    return $meta_boxes;
});
