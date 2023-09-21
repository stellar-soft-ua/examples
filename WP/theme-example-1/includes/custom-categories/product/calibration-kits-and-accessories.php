<?php
function calibration_kits_category()
{
    register_taxonomy(CALIBRATION_KITS_AND_ACCESSORIES_CATEGORY, CALIBRATION_KITS_POST_TYPE,
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
            'rewrite'           => ['slug' => 'calibration-kits-and-accessories-category'],
            'show_admin_column' => true
        ]
    );
}

function calibration_kits_tags()
{
    register_taxonomy(CALIBRATION_KITS_AND_ACCESSORIES_PORTS, CALIBRATION_KITS_POST_TYPE,
        [
            'labels'            => [
                'name'          => 'Number of Ports',
                'singular_name' => 'Number of Ports',
                'search_items'  => 'Search Ports',
                'all_items'     => 'All Ports',
                'edit_item'     => 'Edit Ports',
                'update_item'   => 'Update Port',
                'add_new_item'  => 'Add New Port',
                'new_item_name' => 'New Port',
                'menu_name'     => 'Number of Ports',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'calibration-kits-and-accessories-ports'],
            'show_admin_column' => true
        ]
    );
}

function calibration_kits_type()
{
    register_taxonomy(CALIBRATION_KITS_AND_ACCESSORIES_TYPES, CALIBRATION_KITS_POST_TYPE,
        [
            'labels'            => [
                'name'          => 'Type',
                'singular_name' => 'Type',
                'search_items'  => 'Search Types',
                'all_items'     => 'All Types',
                'edit_item'     => 'Edit Type',
                'update_item'   => 'Update Type',
                'add_new_item'  => 'Add New Type',
                'new_item_name' => 'New Type',
                'menu_name'     => 'Types',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'calibration-kits-and-accessories-type'],
            'show_admin_column' => true
        ]
    );
}

function calibration_kits_length()
{
    register_taxonomy(CALIBRATION_KITS_AND_ACCESSORIES_LENGTH, CALIBRATION_KITS_POST_TYPE,
        [
            'labels'            => [
                'name'          => 'Length',
                'singular_name' => 'Length',
                'search_items'  => 'Search Length',
                'all_items'     => 'All Length',
                'edit_item'     => 'Edit Length',
                'update_item'   => 'Update Length',
                'add_new_item'  => 'Add New Length',
                'new_item_name' => 'New Length',
                'menu_name'     => 'Lengths',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'calibration-kits-and-accessories-length'],
            'show_admin_column' => true
        ]
    );
}

function calibration_kits_products()
{
    register_taxonomy(CALIBRATION_KITS_AND_ACCESSORIES_PRODUCTS, CALIBRATION_KITS_POST_TYPE,
        [
            'labels'            => [
                'name'          => 'Compatible Product',
                'singular_name' => 'Compatible Product',
                'search_items'  => 'Search Compatible Products',
                'all_items'     => 'All Compatible Product',
                'edit_item'     => 'Edit Compatible Product',
                'update_item'   => 'Update Compatible Product',
                'add_new_item'  => 'Add New Compatible Product',
                'new_item_name' => 'New Compatible Product',
                'menu_name'     => 'Compatible Products',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'calibration-kits-and-accessories-comp-prod'],
            'show_admin_column' => true
        ]
    );
}

function calibration_kits_frequency()
{
    register_taxonomy(CALIBRATION_KITS_AND_ACCESSORIES_FREQUENCY, CALIBRATION_KITS_POST_TYPE,
        [
            'labels'            => [
                'name'          => 'Frequencies',
                'singular_name' => 'Frequencies',
                'search_items'  => 'Search Frequency',
                'all_items'     => 'All Frequency',
                'edit_item'     => 'Edit Frequency',
                'update_item'   => 'Update Frequency',
                'add_new_item'  => 'Add New Frequency',
                'new_item_name' => 'New Frequency',
                'menu_name'     => 'Frequencies',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'calibration-kits-and-accessories-frequency'],
            'show_admin_column' => true
        ]
    );
}

add_action('init', 'calibration_kits_tags');
add_action('init', 'calibration_kits_category');
add_action('init', 'calibration_kits_type');
add_action('init', 'calibration_kits_length');
add_action('init', 'calibration_kits_products');
add_action('init', 'calibration_kits_frequency');

