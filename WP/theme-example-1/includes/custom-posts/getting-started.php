<?php

add_action('init', 'cmt_getting_started_post_type');

function cmt_getting_started_post_type()
{
    register_post_type(GETTING_STARTED_POST_TYPE,
        [
            'labels'      => [
                'name'               => 'Product Page App Notes',
                'singular_name'      => 'Product Page App Notes',
                'add_new'            => 'Add Product Page App Notes',
                'add_new_item'       => 'Add Product Page App Notes',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Product Page App Notes',
                'new_item'           => 'New Product Page App Notes',
                'view'               => 'View',
                'view_item'          => 'View Product Page App Notes',
                'search_items'       => 'Search Product Page App Notes',
                'not_found'          => 'No Product Page App Notes found',
                'not_found_in_trash' => 'No Product Page App Notes found in Trash',
                'parent'             => 'Parent Product Page App Notes'
            ],
            'supports'    => ['title','thumbnail','editor'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'getting-started'],
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/application-icon.svg",
        ]
    );
}