<?php

add_action('init', 'cmt_vna_post_type');

function cmt_vna_post_type()
{
    register_post_type(VNA_POST_TYPE,
        [
            'labels'      => [
                'name'               => 'VNAs',
                'singular_name'      => 'VNA',
                'add_new'            => 'Add VNA',
                'add_new_item'       => 'Add VNA',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit VNA',
                'new_item'           => 'New VNA',
                'view'               => 'View',
                'view_item'          => 'View VNA',
                'search_items'       => 'Search VNAs',
                'not_found'          => 'No VNAs found',
                'not_found_in_trash' => 'No VNA found in Trash',
                'parent'             => 'Parent VNA'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => VNA_POST_TYPE],
        ]
    );
}