<?php

add_action('init', 'cmt_store_documentation_post_type');

function cmt_store_documentation_post_type()
{
    register_post_type(DOCUMENTATION_POST_TYPE,
        [
            'labels'      => [
                'name'               => 'Documentation',
                'singular_name'      => 'Documentation',
                'add_new'            => 'Add Item',
                'add_new_item'       => 'Add Item',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Item',
                'new_item'           => 'New Item',
                'view'               => 'View',
                'view_item'          => 'View Item',
                'search_items'       => 'Search Item',
                'not_found'          => 'No item found',
                'not_found_in_trash' => 'No item found in Trash',
                'parent'             => 'Parent Item'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'documentation'],
            'menu_position' => 20
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/application-icon.svg",
        ]
    );
}
