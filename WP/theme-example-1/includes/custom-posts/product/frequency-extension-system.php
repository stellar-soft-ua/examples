<?php

add_action('init', 'cmt_extension_system_post_type');

function cmt_extension_system_post_type()
{
    register_post_type(FREQUENCY_EXTENSION_POST_TYPE,
        [
            'labels'      => [
                'name'               => '50 Ohm Frequency Extension System',
                'singular_name'      => '50 Ohm Frequency Extension System',
                'add_new'            => 'Add 50 Ohm Frequency Extension System',
                'add_new_item'       => 'Add 50 Ohm Frequency Extension System',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit 50 Ohm Frequency Extension System',
                'new_item'           => 'New 50 Ohm Frequency Extension System',
                'view'               => 'View',
                'view_item'          => 'View 50 Ohm Frequency Extension System',
                'search_items'       => 'Search 50 Ohm Frequency Extension System',
                'not_found'          => 'No 50 Ohm Frequency Extension System found',
                'not_found_in_trash' => 'No 50 Ohm Frequency Extension System found in Trash',
                'parent'             => 'Parent 50 Ohm Frequency Extension System'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => FREQUENCY_EXTENSION_POST_TYPE],
        ]
    );
}