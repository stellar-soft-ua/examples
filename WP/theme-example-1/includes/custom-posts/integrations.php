<?php

add_action('init', 'cmt_integrations_post_type');

function cmt_integrations_post_type()
{
    register_post_type(INTEGRATIONS_POST_TYPE,
        [
            'labels'      => [
                'name'               => 'Integrations',
                'singular_name'      => 'Integrations',
                'add_new'            => 'Add Integrations',
                'add_new_item'       => 'Add Integrations',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Integrations',
                'new_item'           => 'New Integrations',
                'view'               => 'View',
                'view_item'          => 'View Integrations',
                'search_items'       => 'Search Integrations',
                'not_found'          => 'No Integrations found',
                'not_found_in_trash' => 'No Integrations found in Trash',
                'parent'             => 'Parent Integrations'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'integrations'],
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/application-icon.svg",
        ]
    );
}
