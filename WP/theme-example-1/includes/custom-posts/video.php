<?php

add_action('init', 'cmt_video_post_type');

function cmt_video_post_type()
{
    register_post_type('video',
        [
            'labels'      => [
                'name'               => 'Videos',
                'singular_name'      => 'Video',
                'add_new'            => 'Add Video',
                'add_new_item'       => 'Add Video',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Video',
                'new_item'           => 'New Video',
                'view'               => 'View',
                'view_item'          => 'View Video',
                'search_items'       => 'Search Video',
                'not_found'          => 'No Video found',
                'not_found_in_trash' => 'No Video in Trash',
                'parent'             => 'Parent Video'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true

        ]
    );
}