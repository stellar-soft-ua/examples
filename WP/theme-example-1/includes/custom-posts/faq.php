<?php

add_action('init', 'cmt_faq_post_type');

function cmt_faq_post_type()
{
    register_post_type(FAQ_POST_TYPE,
        [
            'labels'      => [
                'name'               => 'FAQ',
                'singular_name'      => 'FAQ',
                'add_new'            => 'Add FAQ',
                'add_new_item'       => 'Add FAQ',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit FAQ',
                'new_item'           => 'New FAQ',
                'view'               => 'View',
                'view_item'          => 'View FAQ',
                'search_items'       => 'Search FAQ',
                'not_found'          => 'No FAQ found',
                'not_found_in_trash' => 'No FAQ found in Trash',
                'parent'             => 'Parent FAQ'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => FAQ_POST_TYPE],
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/application-icon.svg",
        ]
    );
}
