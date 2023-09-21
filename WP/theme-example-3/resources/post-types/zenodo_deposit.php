<?php

//function set_project_hierarchical_depth($args)
//{
//    global $post_type_object;
//
//    if ($post_type_object->name == 'project') {
//        $args['depth'] = 1;
//    }
//
//    return $args;
//}
//
//add_filter('page_attributes_dropdown_pages_args', 'set_project_hierarchical_depth');
//add_filter('quick_edit_dropdown_pages_args', 'set_project_hierarchical_depth');
//
//add_action('carbon_fields_register_fields', function () {
//    /** @var Container\Post_Meta_Container $project */
//    $project = Container::make('post_meta', 'About The Project');
//    $project->where('post_type', '=', 'project');
//    $project->set_context('side');
//    $project->set_priority('core');
//    $project->add_fields([
//        Field::make('radio', 'project_type', __('Project Type'))
//             ->set_options([
//                 'study'    => __('Study'),
//                 'workshop' => __('Workshop')
//             ]),
//
//        Field::make('select', 'project_topic_id', __('Topic'))
//             ->set_options(function () {
//                 return array_merge([
//                     'null' => __('No topic')
//                 ], array_map_keys(get_terms([
//                     'taxonomy'   => 'project_topic',
//                     'hide_empty' => false
//                 ]), 'term_id', function ($term) {
//                     return $term->name;
//                 }));
//             })
//    ]);
//});
//

//add_filter('rwmb_meta_boxes', function ($meta_boxes) {
//    $meta_boxes[] = [
//        'title'      => __('About The Project'),
//        'post_types' => ['project'],
//        'context'    => 'side',
//        'priority'   => 'default',
//
//        'fields' => [
//            [
//                'name'    => __('Project Type'),
//                'id'      => 'project_type',
//                'type'    => 'radio',
//                // Array of 'value' => 'Label' pairs for radio options.
//                // Note: the 'value' is stored in meta field, not the 'Label'
//                'options' => [
//                    'study'    => __('Study'),
//                    'workshop' => __('Workshop')
//                ],
//                // Show choices in the same line?
//                'inline'  => false,
//            ]
//        ]
//    ];
//
//    // Add more meta boxes if you want
//    // $meta_boxes[] = ...
//
//    return $meta_boxes;
//});

// Add a custom rewrite tag to prevent 404 errors
//add_rewrite_tag('%project_topic%', '([^&]+)');
//add_rewrite_tag('%project_topic%', '(.+?)');

// Rewrite the post type link to include the topic in the url
//add_filter('post_type_link', function ($link, $id = 0) {
//    $post = get_post($id);
//
//    if ($post->post_type !== 'project') {
//        return $link;
//    }
//
//    if (is_object($post)) {
//        $terms = wp_get_object_terms($post->ID, 'topic');
//        $term  = is_array($terms) && count($terms) === 1 ? $terms[0] : null;
//
//        if ($term) {
//            $root = '';
//            //            $parentPages  = carbon_get_term_meta($term->term_id, 'theme_parent_page');
//            //            $parentPageId = is_array($parentPages) && count($parentPages) === 1 ? (int)$parentPages[0]['id'] : null;
//            //            $parentPage   = get_post($parentPageId);
//            //
//            //            if ($parentPage) {
//            //                $root = $parentPage->post_name . '-';
//            //            }
//
//            $link = str_replace('%project_topic%', $root . $terms[0]->slug, $link);
//        } else {
//            $link = str_replace('/%project_topic%', '', $link);
//        }
//    }
//
//    return $link;
//}, 10, 3);
add_action('rest_api_init', function () {
    register_rest_field('zenodo_deposit', 'colors', [
        'get_callback' => function ($post) {
            if (array_key_exists('topic', $post)) {
                foreach ($post['topic'] as $index => $id) {
                    return [
                        'color_primary'   => get_term_meta($id, '_theme_color_primary', true),
                        'color_secondary' => get_term_meta($id, '_theme_color_secondary', true)
                    ];
                }
            }

            return null;
        }
    ]);

    register_rest_field('zenodo_deposit', 'title', [
        'get_callback' => function ($post) {
            $post = get_post($post['id']);

            return $post->post_title;
        }
    ]);

    register_rest_field('zenodo_deposit', 'description', [
        'get_callback' => function ($post) {
            $post = get_post($post['id']);

            return $post->post_content;
        }
    ]);

    register_rest_field('zenodo_deposit', 'zenodo_meta', [
        'get_callback' => function ($post) {
            return unserialize(get_post_meta($post['id'], 'zenodo_response', true));
        }
    ]);

    register_rest_field('zenodo_deposit', 'featured_image', [
        'get_callback' => function ($post, $field_name, $request) {
            if ($post['featured_media']) {
                $img = wp_get_attachment_image_src($post['featured_media'], 'large');

                return $img[0];
            }

            return false;
        }
    ]);
});

return [
    'arguments' => [
        'labels'       => generate_post_type_labels('Deposit', 'Deposits', 'der'),
        //        'menu_icon'    => 'dashicons-calendar-alt',
        'public'       => false,
        'show_in_rest' => true,
        'show_ui' => true,
        'query_var'    => true,
        'rest_base'    => 'deposits',
        'supports'     => [
            'title',
            //            'editor',
            'thumbnail',
            'excerpt',
            //            'page-attributes'
        ],
        //        'rewrite'      => [
        //            'slug'         => 'veranstaltungen/%topic%',
        //            'with_front'   => false,
        //            'hierarchical' => false,
        //        ]
    ]
];
