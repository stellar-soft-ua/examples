<?php
add_action('init', 'cmt_banner_galleries_post_type');
function cmt_banner_galleries_post_type()
{

    $labels = [
        'name'               => _x('Banners Galleries', 'post type general name'),
        'singular_name'      => _x('Banners Gallery', 'post type singular name'),
        'add_new'            => _x('Add New Banners Gallery', 'Banner'),
        'add_new_item'       => __('Add New Banners Gallery'),
        'edit_item'          => __('Edit Banners Gallery'),
        'new_item'           => __('New Banners Gallery'),
        'view_item'          => __('View Banners Gallery'),
        'search_items'       => __('Search Banners Gallery'),
        'not_found'          => __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon'  => ''
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => false,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor')
    ];

    register_post_type('banners_gallery', $args);
}