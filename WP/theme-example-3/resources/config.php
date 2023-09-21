<?php

use THEME\Theme\Admin;
use THEME\Theme\BladeDirectives;
use THEME\Theme\Commands\ZenodoPull;
use THEME\Theme\Controller\HubController;
use THEME\Theme\Controller\PostsController;
use THEME\Theme\Controller\ReadCounterController;
use THEME\Theme\Settings\ThemeSettings;
use THEME\Theme\Settings\ZenodoSettings;

return [
    /*
    |--------------------------------------------------------------------------
    | Disabled Post Types
    |--------------------------------------------------------------------------
    |
    | An array of post types that should be unregistered before registering the
    | post types of the theme. This is a good place to disable default post
    | types of the Divi builder.
    */
    'disable_post_types' => [
        'project'
    ],

    /*
    |--------------------------------------------------------------------------
    | Disabled Taxonomies
    |--------------------------------------------------------------------------
    |
    | An array of taxonomies that should be unregistered before registering the
    | taxonomies of the theme. This is a good place to disable default taxonomies
    | of the Divi builder.
    */
    'disable_taxonomies' => [
        'project_category',
        'project_tag'
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme Modules
    |--------------------------------------------------------------------------
    |
    | An array of simple classes that should be initialized along the theme.
    */
    'modules' => [
        Admin::class,
        BladeDirectives::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Backend Admin Pages
    |--------------------------------------------------------------------------
    |
    | An array of admin pages to be registered.
    | These classes must extend the SettingsPage class from the framework.
    */
    'admin_pages' => [
        ThemeSettings::class,
        ZenodoSettings::class
    ],

    /*
    |--------------------------------------------------------------------------
    | REST Controllers
    |--------------------------------------------------------------------------
    |
    | An array of controllers to provide rest functionality.
    | The controller must extend the WP_REST_Controller class.
    */
    'rest_controllers' => [
        ReadCounterController::class,
        HubController::class,
        PostsController::class
    ],

    /*
    |--------------------------------------------------------------------------
    | WP CLI Commands
    |--------------------------------------------------------------------------
    |
    | An array of commands that should be registered for the WP CLI.
    */
    'commands' => [
        ZenodoPull::class
    ]
];
