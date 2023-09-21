<?php

add_action('init', 'cmt_latest_news_post_type');

function cmt_latest_news_post_type()
{
    register_post_type(LATEST_NEWS,
        [
            'labels'      => [
                'name'               => 'Latest News',
                'singular_name'      => 'Latest News',
                'add_new'            => 'Add Item',
                'add_new_item'       => 'Add Item',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Item',
                'new_item'           => 'New Item',
                'view'               => 'View',
                'view_item'          => 'View Item',
                'search_items'       => 'Search News',
                'not_found'          => 'No news found',
                'not_found_in_trash' => 'No news found in Trash',
                'parent'             => 'Parent News'
            ],
            'supports'    => ['title'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => LATEST_NEWS],
            'menu_icon'   => get_template_directory_uri() . "/assets/img/newspaper.png",
        ]
    );
}