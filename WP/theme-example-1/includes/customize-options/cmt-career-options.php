<?php

require_once (__DIR__.'/custom-controls/post-dropdown.php');

add_action('customize_register', 'cmt_page_custom_options');

function cmt_page_custom_options($wp_customize)
{

    $wp_customize->add_section(
        'cmt_page_section',
        [
            'title'    => 'View all position URL',
            'priority' => 1
        ]
    );

    $wp_customize->add_setting('cmt_career_positions_url', ['default' => 0]);
    $wp_customize->add_control(new Post_Dropdown_Custom_Control($wp_customize, 'cmt_career_positions_url',
        [
            'label'     => 'Select page',
            'section'   => 'cmt_page_section',
            'settings'  => 'cmt_career_positions_url',
            'post_type' => 'page',
            'post_main' => get_theme_mod('cmt_career_positions_url', 0)
        ]
    ));
}