<?php

add_action('init', 'cmt_application_post_type');

function cmt_application_post_type()
{
    register_post_type('application',
        [
            'labels'      => [
                'name'               => 'Applications',
                'singular_name'      => 'Application',
                'add_new'            => 'Add Application',
                'add_new_item'       => 'Add Application',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Application',
                'new_item'           => 'New Application',
                'view'               => 'View',
                'view_item'          => 'View Application',
                'search_items'       => 'Search Applications',
                'not_found'          => 'No applications found',
                'not_found_in_trash' => 'No application found in Trash',
                'parent'             => 'Parent Application'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'applications'],
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/application-icon.svg",
        ]
    );
}
