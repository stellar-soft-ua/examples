<?php
function vna_category()
{
    register_taxonomy(VNA_CATEGORY, VNA_POST_TYPE,
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
            'rewrite'           => ['slug' => 'vna-category'],
            'show_admin_column' => true
        ]
    );
}

function vna_ports()
{
    register_taxonomy(VNA_PORTS, VNA_POST_TYPE,
        [
            'labels'            => [
                'name'          => 'Number of Ports',
                'singular_name' => 'Number of Ports',
                'search_items'  => 'Search Ports',
                'all_items'     => 'All Ports',
                'edit_item'     => 'Edit Ports',
                'update_item'   => 'Update Port',
                'add_new_item'  => 'Add New Port',
                'new_item_name' => 'New Port Name',
                'menu_name'     => 'Number of Ports',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'vna-ports'],
            'show_admin_column' => false
        ]
    );
}


function vna_frequency()
{
    register_taxonomy(VNA_FREQUENCY, VNA_POST_TYPE,
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
            'rewrite'           => ['slug' => 'vna-frequency'],
            'show_admin_column' => false
        ]
    );
}

function vna_upper_frequency()
{
    register_taxonomy(VNA_UPPER_FREQUENCY, VNA_POST_TYPE,
        [
            'labels'            => [
                'name'          => 'Upper Frequencies',
                'singular_name' => 'Upper Frequencies',
                'search_items'  => 'Search Upper Frequencies',
                'all_items'     => 'All Upper Frequencies',
                'edit_item'     => 'Edit Upper Frequency',
                'update_item'   => 'Update Upper Frequency',
                'add_new_item'  => 'Add New Upper Frequency',
                'new_item_name' => 'New Upper Frequency',
                'menu_name'     => 'Upper Frequencies',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'vna-upper-frequency'],
            'show_admin_column' => false
        ]
    );
}

function vna_solutions()
{
    register_taxonomy(VNA_APPLICATION_SOLUTIONS, VNA_POST_TYPE,
        [
            'labels'            => [
                'name'          => 'Application Solutions',
                'singular_name' => 'Application Solutions',
                'search_items'  => 'Search Application Solutions',
                'all_items'     => 'All Application Solutions',
                'edit_item'     => 'Edit Application Solution',
                'update_item'   => 'Update Application Solution',
                'add_new_item'  => 'Add New Application Solution',
                'new_item_name' => 'New Application Solution Name',
                'menu_name'     => 'Application Solutions',
            ],
            'hierarchical'      => true,
            'sort'              => true,
            'args'              => ['orderby' => 'term_order'],
            'rewrite'           => ['slug' => 'vna-application-solutions'],
            'show_admin_column' => true
        ]
    );
}

add_action('init', 'vna_ports');
add_action('init', 'vna_category');
add_action('init', 'vna_frequency');
add_action('init', 'vna_upper_frequency');
add_action('init', 'vna_solutions');