<?php
function video_category()
{
    register_taxonomy('video_category', 'video',
        [
            'labels'            => [
                'name'          => 'Categories',
                'singular_name' => 'Categories',
                'search_items'  => 'Search Categories',
                'all_items'     => 'All Categories',
                'edit_item'     => 'Edit Categories',
                'update_item'   => 'Update Category',
                'add_new_item'  => 'Add New Category',
                'new_item_name' => 'New Category Name',
                'menu_name'     => 'Categories',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'video-category'],
            'show_admin_column' => true
        ]
    );
}

add_action('init', 'video_category');

function video_parent_category()
{
    register_taxonomy('video_parent_category', 'video',
        [
            'labels'            => [
                'name'          => 'Parent Categories',
                'singular_name' => 'Parent Categories',
                'search_items'  => 'Search Parent Categories',
                'all_items'     => 'All Parent Categories',
                'edit_item'     => 'Edit Parent Categories',
                'update_item'   => 'Update Parent Category',
                'add_new_item'  => 'Add New Parent Category',
                'new_item_name' => 'New Parent Category Name',
                'menu_name'     => 'Parent Categories',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'video-parent-category'],
            'show_admin_column' => true
        ]
    );
}

add_action('init', 'video_parent_category');


