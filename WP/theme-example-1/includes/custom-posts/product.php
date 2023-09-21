<?php

add_action('init', 'cmt_product_post_type');

function cmt_product_post_type()
{
    register_post_type(PRODUCT_POST_TYPE,
        [
            'labels'      => [
                'name'               => 'Our Product',
                'singular_name'      => 'Product',
                'add_new'            => 'Add Product',
                'add_new_item'       => 'Add Product',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Product',
                'new_item'           => 'New Product',
                'view'               => 'View',
                'view_item'          => 'View Product',
                'search_items'       => 'Search Products',
                'not_found'          => 'No Products found',
                'not_found_in_trash' => 'No Products found in Trash',
                'parent'             => 'Parent Product'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'products'],
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/position-icon.svg",
        ]
    );
}
