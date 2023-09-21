<?php

add_action('init', 'cmt_position_post_type');

function cmt_position_post_type()
{
    register_post_type(POSITION_POST_TYPE,
        [
            'labels'      => [
                'name'               => 'Positions',
                'singular_name'      => 'Position',
                'add_new'            => 'Add Position',
                'add_new_item'       => 'Add Position',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Position',
                'new_item'           => 'New Position',
                'view'               => 'View',
                'view_item'          => 'View Position',
                'search_items'       => 'Search Positions',
                'not_found'          => 'No positions found',
                'not_found_in_trash' => 'No position found in Trash',
                'parent'             => 'Parent Position'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'positions'],
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/position-icon.svg",
        ]
    );
}
