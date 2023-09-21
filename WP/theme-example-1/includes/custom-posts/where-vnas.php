<?php

add_action('init', 'cmt_where_vnas_post_type');

function cmt_where_vnas_post_type()
{
    register_post_type('where_vnas',
        [
            'labels'      => [
                'name'               => 'Where our VNAs are used',
                'singular_name'      => 'Where our VNAs are used',
                'add_new'            => 'Add Where our VNAs are used',
                'add_new_item'       => 'Add Where our VNAs are used',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Where our VNAs are used',
                'new_item'           => 'New Where our VNAs are used',
                'view'               => 'View',
                'view_item'          => 'View Where our VNAs are used',
                'search_items'       => 'Search Where our VNAs are used',
                'not_found'          => 'No Where our VNAs are used found',
                'not_found_in_trash' => 'No Where our VNAs are used found in Trash',
                'parent'             => 'Parent Where our VNAs are used'
            ],
            'supports'    => ['title', 'thumbnail'],
            'public'      => true,
            'rewrite'     => ['slug' => 'where-vnas']
        ]
    );
}
