<?php
function manual_category()
{
    register_taxonomy('manual_category', 'manual',
        [
            'labels'            => [
                'name'          => 'Category',
                'singular_name' => 'Category',
                'search_items'  => 'Search Category',
                'all_items'     => 'All Category',
                'edit_item'     => 'Edit Category',
                'update_item'   => 'Update Category',
                'add_new_item'  => 'Add New Category',
                'new_item_name' => 'New Category Name',
                'menu_name'     => 'Category',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'manual-category'],
            'show_admin_column' => true
        ]
    );
}

add_action('init', 'manual_category');
