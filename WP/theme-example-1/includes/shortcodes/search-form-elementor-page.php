<?php
add_shortcode( 'addsearchform', 'add_search_form_elementor_page');

function add_search_form_elementor_page() {
    ob_start();

    get_template_part('templates/shortcode/search-form-elementor-page');

    return ob_get_clean();
}
