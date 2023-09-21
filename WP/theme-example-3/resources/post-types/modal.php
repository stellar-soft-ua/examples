<?php

use THEME\Framework\Cache\Transient;

add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
    if ($item->object === 'modal') {
        $atts['class'] = 'pointer';
        $atts['href'] = '#';
        $atts['data-show-modal'] = '#modal-'.$item->object_id;
    }

    return $atts;
}, 10, 3);

function get_custom_modal_by_id(WP_Query $query)
{
    if ($query->is_main_query() && $query->get('post_type') === 'modal') {
        $id = $query->get('name');

        if (is_numeric($id)) {
            $query->query_vars = [
                'post_type' => 'modal',
                'p' => intval($query->get('name')),
                'suppress_filters' => true,
            ];

            $query->query = $query->query_vars;
        }
    }

    return $query;
}

add_action('pre_get_posts', 'get_custom_modal_by_id');

return [
    'arguments' => [
        'labels' => generate_post_type_labels('Modal', 'Modals', 'das'),
        'public' => true,
        'publicly_queryable' => true,
        'show_in_rest' => false,
        'menu_icon' => 'dashicons-text-page',
        'supports' => [
            'title',
            'editor',
        ],
        'has_archive' => false,
        'rewrite' => [
            'slug' => 'modals',
            'with_front' => false,
            'hierarchical' => false,
        ],
    ],
];
