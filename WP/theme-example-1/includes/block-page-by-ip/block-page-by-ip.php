<?php

add_action('wp', 'block_page_by_ip');
function block_page_by_ip()
{
    if (is_page()) {
        global $post;
        $blocked_page_by_country = get_post_meta($post->ID, 'blocked_page_by_country', true);
        if ($blocked_page_by_country) {
            $country_name = get_country_by_ip();
            $blocked_countries = get_option('countries_list');
            if (check_country($country_name, $blocked_countries)) {
                header("Location: ".get_bloginfo("url"));
                exit();
            }
        }
    }
}
