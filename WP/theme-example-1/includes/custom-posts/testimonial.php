<?php

add_action('init', 'cmt_testimonial_post_type');

function cmt_testimonial_post_type()
{
    register_post_type('testimonial',
        [
            'labels'      => [
                'name'               => 'Testimonials',
                'singular_name'      => 'Testimonial',
                'add_new'            => 'Add Testimonial',
                'add_new_item'       => 'Add Testimonial',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Testimonial',
                'new_item'           => 'New Testimonial',
                'view'               => 'View',
                'view_item'          => 'View Testimonial',
                'search_items'       => 'Search Testimonials',
                'not_found'          => 'No testimonials found',
                'not_found_in_trash' => 'No testimonial found in Trash',
                'parent'             => 'Parent Testimonial'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'publicly_queryable' => false,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'testimonials'],
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/testimonial-icon.svg",
        ]
    );
}
