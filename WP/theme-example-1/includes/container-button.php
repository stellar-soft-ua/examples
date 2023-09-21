<?php
add_action( 'after_setup_theme', 'mythemeslug_theme_setup' );

if ( ! function_exists( 'mythemeslug_theme_setup' ) ) {
    function mythemeslug_theme_setup() {
        add_action( 'admin_init', 'mythemeslug_theme_add_editor_styles' );
        add_action( 'init', 'mythemeslug_buttons' );
    }
}
if ( ! function_exists( 'mythemeslug_theme_add_editor_styles' ) ) {
    function mythemeslug_theme_add_editor_styles() {
        add_editor_style( 'custom-editor-style.css' );
    }
}

if ( ! function_exists( 'mythemeslug_buttons' ) ) {
    function mythemeslug_buttons() {
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
            return;
        }

        if ( get_user_option( 'rich_editing' ) !== 'true' ) {
            return;
        }

        add_filter( 'mce_external_plugins', 'mythemeslug_add_buttons' );
        add_filter( 'mce_buttons', 'mythemeslug_register_buttons' );
    }
}

if ( ! function_exists( 'mythemeslug_add_buttons' ) ) {
    function mythemeslug_add_buttons( $plugin_array ) {
        $plugin_array['columns'] = get_template_directory_uri() . '/assets/js/tinymce-plugin.js';

        return $plugin_array;
    }
}

if ( ! function_exists( 'mythemeslug_register_buttons' ) ) {
    function mythemeslug_register_buttons( $buttons ) {
        array_push( $buttons, 'columns' );

        return $buttons;
    }
}