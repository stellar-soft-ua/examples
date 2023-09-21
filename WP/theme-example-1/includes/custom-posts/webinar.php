<?php

add_action('init', 'cmt_webinar_post_type');

function cmt_webinar_post_type()
{
    register_post_type('webinar',
        [
            'labels'      => [
                'name'               => 'Webinars',
                'singular_name'      => 'Webinar',
                'add_new'            => 'Add Webinar',
                'add_new_item'       => 'Add Webinar',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Webinar',
                'new_item'           => 'New Webinar',
                'view'               => 'View',
                'view_item'          => 'View Webinar',
                'search_items'       => 'Search Webinar',
                'not_found'          => 'No Webinar found',
                'not_found_in_trash' => 'No Webinar in Trash',
                'parent'             => 'Parent Webinar'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true

        ]
    );
}
