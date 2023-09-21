<?php

add_action('init', 'cmt_data_sheet_post_type');

function cmt_data_sheet_post_type()
{
    register_post_type(DATA_SHEET_POST_TYPE,
        [
            'labels'      => [
                'name'               => 'Data Sheets',
                'singular_name'      => 'Data Sheets',
                'add_new'            => 'Add Data Sheet',
                'add_new_item'       => 'Add Data Sheet',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Data Sheet',
                'new_item'           => 'New Data Sheet',
                'view'               => 'View',
                'view_item'          => 'View Data Sheet',
                'search_items'       => 'Search Data Sheets',
                'not_found'          => 'No Data Sheets found',
                'not_found_in_trash' => 'No Data Sheets found in Trash',
                'parent'             => 'Parent Data Sheet'
            ],
            'supports'    => ['title'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'data-sheet'],
        ]
    );
}
