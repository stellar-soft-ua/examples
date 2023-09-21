<?php

add_action('init', 'cmt_store_leadership_post_type');

function cmt_store_leadership_post_type()
{
    register_post_type(LEADERSHIP_POST_TYPE,
        [
            'labels'      => [
                'name'               => 'Leadership',
                'singular_name'      => 'Leadership',
                'add_new'            => 'Add Leadership',
                'add_new_item'       => 'Add Leadership',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Leadership',
                'new_item'           => 'New Leadership',
                'view'               => 'View',
                'view_item'          => 'View Leadership',
                'search_items'       => 'Search Leadership',
                'not_found'          => 'No Leadership found',
                'not_found_in_trash' => 'No Leadership found in Trash',
                'parent'             => 'Parent Leadership'
            ],
            'supports'    => ['title','thumbnail'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'leadership'],
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/application-icon.svg",
        ]
    );
}