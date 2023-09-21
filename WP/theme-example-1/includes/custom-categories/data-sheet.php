<?php
function data_sheets_category()
{
    register_taxonomy(DATA_SHEET_CATEGORY,DATA_SHEET_POST_TYPE,
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
            'rewrite'           => ['slug' => 'data_sheet_category'],
            'show_admin_column' => true
        ]
    );
}

add_action('init', 'data_sheets_category');


