<?php

add_action('init', 'cmt_store_location_post_type');

function cmt_store_location_post_type()
{
    register_post_type(LOCATION_POST_TYPE,
        [
            'labels'      => [
                'name'               => 'Locations',
                'singular_name'      => 'Locations',
                'add_new'            => 'Add Location',
                'add_new_item'       => 'Add Location',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Location',
                'new_item'           => 'New Location',
                'view'               => 'View',
                'view_item'          => 'View Location',
                'search_items'       => 'Search Location',
                'not_found'          => 'No location found',
                'not_found_in_trash' => 'No location found in Trash',
                'parent'             => 'Parent Location'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'location'],
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/application-icon.svg",
        ]
    );
}