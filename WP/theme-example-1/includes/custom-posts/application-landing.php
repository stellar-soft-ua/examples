<?php

add_action('init', 'cmt_application_pages_post_type');

function cmt_application_pages_post_type()
{
    register_post_type(APP_PAGE_POST_TYPE,
        [
            'labels'      => [
                'name'               => 'Application Pages',
                'singular_name'      => 'Application Page',
                'add_new'            => 'Add Application Page',
                'add_new_item'       => 'Add Application Page',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Application Page',
                'new_item'           => 'New Application Page',
                'view'               => 'View',
                'view_item'          => 'View Application Page',
                'search_items'       => 'Search Application Page',
                'not_found'          => 'No application page found',
                'not_found_in_trash' => 'No application page found in Trash',
                'parent'             => 'Parent Application Page'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'application-page'],
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/application-icon.svg",
        ]
    );
}
