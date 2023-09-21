<?php

// Bootstrap the theme
require_once('vendor/autoload.php');
require_once('vendor/wpmetabox/meta-box/meta-box.php');

// Rewrite the post type link to include the topic in the url
add_filter('post_type_link', function ($link, $id = 0) {
    $post = get_post($id);

    if (strpos($link, '%topic%') === false) {
        return $link;
    }

    if (is_object($post)) {
        $terms = wp_get_object_terms($post->ID, 'topic');
        $term = is_array($terms) && count($terms) === 1 ? $terms[0] : null;

        if ($term) {
            $link = str_replace('%topic%', $terms[0]->slug, $link);
        } else {
            $link = str_replace('/%topic%', '', $link);
        }
    }

    return $link;
}, 10, 3);

// Theme Supports
add_theme_support('custom-logo');
add_post_type_support('page', 'excerpt');

// Do not apply an p-tag to the excerpt.
remove_filter('the_excerpt', 'wpautop');

// Don't generate an excerpt from the content because it might have shortcodes in it
remove_filter('get_the_excerpt', 'wp_trim_excerpt');

// add custom fields query to WP REST API v2
// https://1fix.io/blog/2015/07/20/query-vars-wp-api/
add_filter('rest_query_vars', function ($valid_vars) {
    return array_merge($valid_vars, ['meta_key', 'meta_value']);
});

add_filter('rest_endpoints', function ($routes) {
    foreach (['project', 'deposit', 'multiple-post-type'] as $type) {
        $route = '/wp/v2/'.$type;

        if (!array_key_exists($route, $routes)) {
            continue;
        }

        // Allow ordering by meta values
        $routes[$route][0]['args']['orderby']['enum'][] = 'meta_value_num';

        // Allow only specific meta keys
        $routes[$route][0]['args']['meta_key'] = [
            'description' => 'The meta key to query.',
            'type' => 'string',
            'enum' => ['starts_at', 'ends_at'],
            'validate_callback' => 'rest_validate_request_arg',
        ];
    }

    return $routes;
});

/**
 * Get the URL of an attachment or returns the same value if it is not numeric.
 *
 * @param  int|string  $attachment_id
 *
 * @return false|int|mixed|string
 */
function get_attachment_url($attachment_id = 0)
{
    if (is_numeric($attachment_id)) {
        return wp_get_attachment_url($attachment_id);
    }

    return $attachment_id;
}

if (class_exists(\THEME\Framework\Theme::class)) {
    // Init the theme
    $theme = new ThemeBootstrapTheme();
    $theme->init();
}