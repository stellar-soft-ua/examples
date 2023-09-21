<?php
add_action('init', 'cmt_partner_post_type');
function cmt_partner_post_type()
{

    register_post_type(PARTNER_POST_TYPE,
        [
            'labels'      => [
                'name'               => 'Partners',
                'singular_name'      => 'Partners',
                'add_new'            => 'Add Partner',
                'add_new_item'       => 'Add Partner',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Partner',
                'new_item'           => 'New Partner',
                'view'               => 'View',
                'view_item'          => 'View Partner',
                'search_items'       => 'Search Partners',
                'not_found'          => 'No Partners found',
                'not_found_in_trash' => 'No Partners found in Trash',
                'parent'             => 'Parent Partner'
            ],
            'supports'    => ['title', 'editor', 'thumbnail'],
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => ['slug' => 'partner'],
            //'menu_icon'   => get_template_directory_uri() . "/assets/icons/position-icon.svg",
        ]
    );
}

?>
