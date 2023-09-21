<?php

add_action('init', 'cmt_manual_post_type');

function cmt_manual_post_type()
{
    register_post_type('manual',
        [
            'labels'      => [
                'name'               => 'Manuals',
                'singular_name'      => 'Manual',
                'add_new'            => 'Add Manual',
                'add_new_item'       => 'Add Manual',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Manual',
                'new_item'           => 'New Manual',
                'view'               => 'View',
                'view_item'          => 'View Manual',
                'search_items'       => 'Search Manuals',
                'not_found'          => 'No manuals found',
                'not_found_in_trash' => 'No manual found in Trash',
                'parent'             => 'Parent Manual'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'publicly_queryable' => false,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'manuals'],
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/manual-icon.svg",
        ]
    );
}
