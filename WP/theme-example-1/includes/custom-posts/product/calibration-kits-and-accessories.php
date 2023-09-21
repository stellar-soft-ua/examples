<?php

add_action('init', 'cmt_calibration_kits_and_accessories_post_type');

function cmt_calibration_kits_and_accessories_post_type()
{
    register_post_type(CALIBRATION_KITS_POST_TYPE,
        [
            'labels'      => [
                'name'               => '50 Ohm Calibration Kits and Accessories',
                'singular_name'      => '50 Ohm Calibration Kits and Accessories',
                'add_new'            => 'Add 50 Ohm Calibration Kits and Accessories',
                'add_new_item'       => 'Add 50 Ohm Calibration Kits and Accessories',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit 50 Ohm Calibration Kits and Accessories',
                'new_item'           => 'New 50 Ohm Calibration Kits and Accessories',
                'view'               => 'View',
                'view_item'          => 'View 50 Ohm Calibration Kits and Accessories',
                'search_items'       => 'Search 50 Ohm Calibration Kits and Accessories',
                'not_found'          => 'No 50 Ohm Calibration Kits and Accessories found',
                'not_found_in_trash' => 'No 50 Ohm Calibration Kits and Accessories found in Trash',
                'parent'             => 'Parent 50 Ohm Calibration Kits and Accessories'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => CALIBRATION_KITS_POST_TYPE],
        ]
    );
}