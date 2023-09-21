<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
    /** @var Container\Term_Meta_Container $appearance */
    $appearance = Container::make('term_meta', __('Darstellung', 'theme'));
    $appearance->where('term_taxonomy', '=', 'topic');
    $appearance->add_fields([
        Field::make('association', 'theme_topic_page', __('Themen-Seite', 'theme'))
             ->set_help_text(__('Die Themen-Seite, die den Filter für die Themen beinhaltet', 'theme'))
             ->set_types([
                 [
                     'type'      => 'post',
                     'post_type' => 'page'
                 ]
             ])
             ->set_min(1)
             ->set_max(1),
        Field::make('color', 'theme_color_primary', __('Primärfarbe', 'theme')),
        Field::make('color', 'theme_color_secondary', __('Sekundärfarbe', 'theme')),
        Field::make('checkbox', 'theme_is_hidden', __('Verstecktes Thema', 'theme')),
    ]);
});

//add_rewrite_tag('%topic%', '([^&]+)');

// Rewrite the post type link to include the topic in the url
add_filter('term_link', function ($link, $id = 0) {
    $term = get_term($id);

    if ($term->taxonomy !== 'topic') {
        return $link;
    }

    if (strpos($link, '%topic_root%') !== false) {
        $root = carbon_get_term_meta($term->term_id, 'theme_topic_page');
        $pageId = array_get($root, '0.id');

        if ($pageId) {
            $page = get_the_permalink($pageId);
            return $page . "#" . $term->slug;
        }
    }

    return "/";
}, 10, 3);

return [
    'object_type' => ['project', 'event', 'zenodo_deposit'],
    'arguments'   => [
        'labels'             => generate_taxonomy_labels('Thema', 'Themen', 'das'),
        'public'             => true,
        'show_in_rest'       => true,
        'show_ui'            => true,
        'show_in_quick_edit' => false,
        'capability_type'    => 'taxonomy',
        'meta_box_cb'        => false, // Hide the metabox in the post edit page
        'rewrite'            => [
            'slug' => '%topic_root%'
        ],
        'hierarchical'       => false,
        'show_admin_column'  => true,
    ]
];
