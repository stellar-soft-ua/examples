<?php
add_action('init', 'cmt_banner_post_type');
function cmt_banner_post_type() {

    $labels = array(
        'name' => _x('Banners', 'post type general name'),
        'singular_name' => _x('Banner', 'post type singular name'),
        'add_new' => _x('Add New Banner', 'Banner'),
        'add_new_item' => __('Add New Banner'),
        'edit_item' => __('Edit Banner'),
        'new_item' => __('New Banner'),
        'view_item' => __('View Banner'),
        'search_items' => __('Search Banner'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title', 'thumbnail' )
    );

    register_post_type( 'banner' , $args );
}
?>