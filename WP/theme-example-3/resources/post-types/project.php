<?php

// Add columns for start and end dates

add_filter('manage_project_posts_columns', function ($columns) {
    // save date to the variable
    $date = $columns['date'];
    // unset the 'date' column
    unset($columns['date']);

    $columns['starts_at'] = __('Beginn', 'theme');
//    $columns['ends_at']   = __('Ende', 'theme');

    $columns['date'] = $date; // set the 'date' column again, after the custom column

    return $columns;
});

// Add the data to the custom columns for the event post type:
add_action('manage_project_posts_custom_column', function ($column, $post_id) {
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
add_filter('manage_edit-project_sortable_columns', function ($columns) {
    $columns['starts_at'] = 'starts_at';
//    $columns['ends_at']   = 'ends_at';

    return $columns;
});

// Order the posts depending on the selected column
add_action('pre_get_posts', function (WP_Query $query) {
    if ( ! is_admin()) {
        return;
    }

    if (array_get($query->query, 'post_type') === 'project') {
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

add_filter("rest_project_query", function (array $args, WP_REST_Request $request) {
    // WP is not adding the meta_key param on its own -.-
    if ($request->get_param('orderby') === 'meta_value_num') {
        $args['meta_key'] = $request->get_param('meta_key');
    }

    return $args;

}, 10, 2);


add_action('rest_api_init', function () {
    register_rest_field('project', 'topic', [
        'get_callback' => function ($post) {
            foreach (array_get($post, 'topic', []) as $index => $id) {
                $term = get_term($id);

                if ( ! $term instanceof WP_Term) {
                    continue;
                }

                $term->color_primary   = get_term_meta($id, '_theme_color_primary', true);
                $term->color_secondary = get_term_meta($id, '_theme_color_secondary', true);

                return $term;
            }

            return null;
        }
    ]);

    register_rest_field('project', 'starts_at', [
        'get_callback' => function ($post) {
            return intval(get_post_meta($post['id'], 'starts_at', true));
        }
    ]);
});


return [
    'arguments' => [
        'labels'       => generate_post_type_labels('Projekt', 'Projekte', 'das'),
        'public'       => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-media-document ',
        'supports'     => [
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'revisions'
        ],
        'has_archive'  => false,
        'rewrite'      => [
            'slug'         => 'project',
            'with_front'   => false,
            'hierarchical' => false,
        ]
    ]
];
