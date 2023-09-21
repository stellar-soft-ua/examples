<?php

add_action('init', 'cmt_frost_sullivan_post_type');

function cmt_frost_sullivan_post_type()
{
    register_post_type('frost-sullivan',
        [
            'labels'      => [
                'name'               => 'Frost & Sullivan',
                'singular_name'      => 'Frost & Sullivan',
                'add_new'            => 'Add Frost & Sullivan',
                'add_new_item'       => 'Add Frost & Sullivan',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Frost & Sullivan',
                'new_item'           => 'New Frost & Sullivan',
                'view'               => 'View',
                'view_item'          => 'View Frost & Sullivan',
                'search_items'       => 'Search Frost & Sullivan',
                'not_found'          => 'No Frost & Sullivan found',
                'not_found_in_trash' => 'No Frost & Sullivan in Trash',
                'parent'             => 'Parent Frost & Sullivan'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true

        ]
    );
}
