<?php
function webinar_category()
{
    register_taxonomy('webinar_category', 'webinar',
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
            'rewrite'           => ['slug' => 'webinar-category'],
            'show_admin_column' => true
        ]
    );
}

add_action('init', 'webinar_category');

function webinar_parent_category()
{
    register_taxonomy('webinar_parent_category', 'webinar',
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
            'rewrite'           => ['slug' => 'webinar-parent-category'],
            'show_admin_column' => true
        ]
    );
}

add_action('init', 'webinar_parent_category');


