<?php

add_action('init', 'cmt_calibration_service_post_type');

function cmt_calibration_service_post_type()
{
    register_post_type(CALIBRATION_SERVICE,
        [
            'labels'      => [
                'name'               => 'Calibration Services',
                'singular_name'      => 'Calibration Service',
                'add_new'            => 'Add Calibration Service',
                'add_new_item'       => 'Add Calibration Service',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Calibration Service',
                'new_item'           => 'New Calibration Service',
                'view'               => 'View',
                'view_item'          => 'View Calibration Service',
                'search_items'       => 'Search Calibration Service',
                'not_found'          => 'No Calibration Service found',
                'not_found_in_trash' => 'No Calibration Service found in Trash',
                'parent'             => 'Parent Calibration Service'
            ],
            'supports'    => ['title'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'calibration-service'],
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/application-icon.svg",
        ]
    );
}
