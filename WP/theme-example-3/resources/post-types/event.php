<?php


// Add columns for start and end dates

add_filter('manage_event_posts_columns', function ($columns) {
    // save date to the variable
    $date = $columns['date'];
    // unset the 'date' column
    unset($columns['date']);

    $columns['starts_at'] = __('Beginn', 'theme');
    $columns['ends_at']   = __('Ende', 'theme');

    $columns['date'] = $date; // set the 'date' column again, after the custom column

    return $columns;
});

// Add the data to the custom columns for the event post type:
add_action('manage_event_posts_custom_column', function ($column, $post_id) {
    switch ($column) {

        case 'starts_at' :
            $startsAt = intval(get_post_meta($post_id, 'starts_at', true));

            if ($startsAt) {
                $startsAtDate = new DateTime('@' . $startsAt);
                echo $startsAtDate->format('d.m.Y \u\m H:s');
            }

            break;
        case 'ends_at' :
            $endsAt = intval(get_post_meta($post_id, 'ends_at', true));
            if ($endsAt === 0) {
                echo '-';
            } else {
                $endsAtDate = new DateTime('@' . $endsAt);
                echo $endsAtDate->format('d.m.Y \u\m H:s');
            }

            break;
    }
}, 10, 2);

// Set the sortable columns
add_filter('manage_edit-event_sortable_columns', function ($columns) {
    $columns['starts_at'] = 'starts_at';
    $columns['ends_at']   = 'ends_at';

    return $columns;
});

// Order the posts depending on the selected column
add_action('pre_get_posts', function (WP_Query $query) {
    if ( ! is_admin()) {
        return;
    }

    if (array_get($query->query, 'post_type') === 'event') {
        $orderby = $query->get('orderby');

        if ($orderby === 'starts_at') {
            $query->set('meta_key', 'starts_at');
            $query->set('orderby', 'meta_value_num');
        } elseif ($orderby === 'ends_at') {
            $query->set('meta_key', 'ends_at');
            $query->set('orderby', 'meta_value_num');
        }
    }
});

add_filter("rest_event_query", function (array $args, WP_REST_Request $request) {
    // WP is not adding the meta_key param on its own -.-
    if ($request->get_param('orderby') === 'meta_value_num') {
        $args['meta_key'] = $request->get_param('meta_key');
    }

    return $args;

}, 10, 2);


return [
    'arguments' => [
        'labels'       => generate_post_type_labels('Veranstaltung', 'Veranstaltungen', 'die'),
        'menu_icon'    => 'dashicons-calendar-alt',
        'public'       => true,
        'show_in_rest' => true,
        'supports'     => [
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'revisions'
            //            'page-attributes'
        ],
        'rewrite'      => [
            'slug'         => 'veranstaltungen',
            'with_front'   => false,
            'hierarchical' => false,
        ],
        //        'metaboxes' => [
        //            $eventMetabox
        //        ]
    ]
];
