<?php
require_once(__DIR__ . '/includes/constants/constants.php');

// Block page by ip
require_once(__DIR__ . '/includes/block-page-by-ip/block-page-by-ip.php');

// Custom Post Types
require_once(__DIR__ . '/includes/custom-posts/application.php');
require_once(__DIR__ . '/includes/custom-posts/banner.php');
require_once(__DIR__ . '/includes/custom-posts/manual.php');
require_once(__DIR__ . '/includes/custom-posts/partner.php');
require_once(__DIR__ . '/includes/custom-posts/position.php');
require_once(__DIR__ . '/includes/custom-posts/testimonial.php');
require_once(__DIR__ . '/includes/custom-posts/frost-sullivan.php');
require_once(__DIR__ . '/includes/custom-posts/webinar.php');
require_once(__DIR__ . '/includes/custom-posts/video.php');
require_once(__DIR__ . '/includes/custom-posts/product/calibration-kits-and-accessories.php');
require_once(__DIR__ . '/includes/custom-posts/product/vnas.php');
require_once(__DIR__ . '/includes/custom-posts/product.php');
require_once(__DIR__ .'/includes/custom-posts/faq.php');
require_once(__DIR__ .'/includes/custom-posts/location.php');
require_once(__DIR__ . '/includes/custom-posts/where-vnas.php');
require_once(__DIR__ . '/includes/custom-posts/leadership.php');
//require_once(__DIR__ . '/includes/custom-posts/getting-started.php');
require_once(__DIR__ . '/includes/custom-posts/banner-galleries.php');
require_once(__DIR__ .'/includes/custom-posts/product/frequency-extension-system.php');
require_once(__DIR__ .'/includes/custom-posts/data-sheet.php');
require_once(__DIR__ .'/includes/custom-posts/calibration-service.php');
require_once(__DIR__ .'/includes/custom-posts/application-landing.php');
require_once(__DIR__ .'/includes/custom-posts/integrations.php');
require_once(__DIR__ .'/includes/custom-posts/latest-news.php');
require_once(__DIR__ .'/includes/custom-posts/documentation.php');

//Walkers
require_once(__DIR__ . '/includes/footer-menu-walker.php');

// Custom Categories
require_once(__DIR__ . '/includes/custom-categories/manual.php');
require_once(__DIR__ . '/includes/custom-categories/webinar.php');
require_once(__DIR__ . '/includes/custom-categories/video.php');
require_once(__DIR__ . '/includes/custom-categories/product/vna.php');
require_once(__DIR__ . '/includes/custom-categories/product/calibration-kits-and-accessories.php');
require_once(__DIR__ . '/includes/custom-categories/webinar.php');
require_once(__DIR__ . '/includes/custom-categories/location.php');
//require_once(__DIR__ . '/includes/custom-categories/getting-started.php');
require_once(__DIR__ . '/includes/custom-categories/product/frequency-extension.php');
require_once(__DIR__ . '/includes/custom-categories/data-sheet.php');
require_once(__DIR__ . '/includes/custom-categories/integrations.php');
require_once(__DIR__ . '/includes/custom-categories/documentation.php');

// Custom Fields
require_once(__DIR__ . '/includes/custom-fields/product/product-fields.php');
require_once(__DIR__ . '/includes/custom-fields/product/product-img.php');
require_once(__DIR__ . '/includes/custom-fields/product/related-post.php');
require_once(__DIR__ . '/includes/custom-fields/cmt-banner-fields.php');
require_once(__DIR__ . '/includes/custom-fields/cmt-position-fields.php');
require_once(__DIR__ . '/includes/custom-fields/cmt-manual-fields.php');
require_once(__DIR__ . '/includes/custom-fields/cmt-partner-fields.php');
require_once(__DIR__ . '/includes/custom-fields/cmt-testimonials-fields.php');
require_once(__DIR__ . '/includes/custom-fields/cmt-frost-sullivan-fields.php');
require_once (__DIR__.'/includes/custom-fields/cmt-application-fields.php');
require_once (__DIR__.'/includes/custom-fields/cmt-post-field.php');
require_once(__DIR__ . '/includes/custom-fields/cmt-webinars-fields.php');
require_once (__DIR__.'/includes/custom-fields/cmt-blog-fields.php');
require_once (__DIR__.'/includes/custom-fields/cmt-location-fields.php');
require_once (__DIR__.'/includes/custom-fields/cmt-category-fields.php');
require_once (__DIR__.'/includes/custom-fields/cmt-taxonomy-vna_ports-fields.php');
require_once (__DIR__.'/includes/custom-fields/product/cal-kits-fields.php');
require_once (__DIR__ . '/includes/custom-fields/cmt-our-products-fields.php');
require_once (__DIR__ . '/includes/custom-fields/cmt-leadership-fields.php');
require_once (__DIR__ . '/includes/custom-fields/cmt-getting-started-fields.php');
require_once (__DIR__ . '/includes/custom-fields/product/frequency-extension-fields.php');
require_once (__DIR__ . '/includes/custom-fields/where-vnas.php');
require_once (__DIR__ . '/includes/custom-fields/cmt-data-sheet-fields.php');
require_once (__DIR__ . '/includes/custom-fields/cmt-calibration-service-fields.php');
require_once (__DIR__ . '/includes/custom-fields/cmt-application-pages-fields.php');
require_once (__DIR__ . '/includes/custom-fields/cmt-integrations-fields.php');
require_once (__DIR__ . '/includes/custom-fields/cmt-pages-fields.php');
require_once (__DIR__ . '/includes/custom-fields/cmt-latest-news-fields.php');
require_once (__DIR__ . '/includes/custom-fields/cmt-documentation-field.php');
require_once (__DIR__ . '/includes/custom-fields/product/repeatable_fields_product_videos.php');
require_once (__DIR__ . '/includes/custom-fields/cmt-custom-pages-search.php');

// Shortcodes
require_once (__DIR__.'/includes/shortcodes/accordion.php');
require_once(__DIR__ . '/includes/shortcodes/manuals.php');
require_once (__DIR__.'/includes/shortcodes/testimonials.php');
require_once (__DIR__.'/includes/shortcodes/google-maps.php');
require_once (__DIR__ . '/includes/shortcodes/applications.php');
require_once (__DIR__ . '/includes/shortcodes/where_vnas.php');
require_once (__DIR__ . '/includes/shortcodes/banners.php');
require_once (__DIR__ . '/includes/shortcodes/our-products.php');
require_once (__DIR__ . '/includes/shortcodes/leadership.php');
require_once (__DIR__ . '/includes/shortcodes/partner.php');
require_once (__DIR__ . '/includes/shortcodes/data_sheet.php');
require_once (__DIR__ . '/includes/shortcodes/calibration-service.php');
require_once (__DIR__ . '/includes/shortcodes/application-pages.php');
require_once (__DIR__ . '/includes/shortcodes/add-post.php');
require_once (__DIR__ . '/includes/shortcodes/search-form-elementor-page.php');

// Widgets
require_once(__DIR__ . '/includes/widgets/cmt-applications-widget.php');
require_once(__DIR__ . '/includes/widgets/cmt-banners-widget.php');
require_once(__DIR__ . '/includes/widgets/cmt-customer-testimonials-widget.php');
require_once(__DIR__ . '/includes/widgets/cmt-our-products-widget.php');
require_once(__DIR__ . '/includes/widgets/cmt-partners-widget.php');
require_once(__DIR__ . '/includes/widgets/cmt-where-used-widget.php');


require_once(__DIR__ . '/includes/helpers.php');
require_once(__DIR__ . '/templates/products/product-related.php');
require_once(__DIR__ . '/templates/products/product-review.php');
require_once(__DIR__ . '/templates/products/product-info.php');
require_once(__DIR__ . '/templates/products/filter.php');
require_once(__DIR__ . '/templates/products/product-list.php');
require_once(__DIR__ . '/templates/products/upper-frequency-filter.php');
require_once(__DIR__ . '/templates/products/frequency-extension-filter.php');

require_once(__DIR__ . '/includes/comments-list.php');
require_once(__DIR__ . '/includes/load-h5p-content.php');

//Customize options
require_once(__DIR__ . '/includes/customize-options/cmt-career-options.php');

//Custom settings
require_once (__DIR__.'/includes/custom-settings/ip-address-list.php');
require_once (__DIR__.'/includes/custom-settings/languages-settings.php');
require_once(__DIR__ . '/includes/custom-categories/remove-unused-fields.php');
require_once(__DIR__ . '/includes/container-button.php');

//Allow to upload extra file types
require_once(__DIR__ . '/includes/extra-file-type.php');

//Ajax
require_once(__DIR__ . '/includes/ajax/ajax.php');

add_action('wp_enqueue_scripts', 'cmt_scripts');
add_action('after_setup_theme', 'cmt_theme_setup');
add_action('widgets_init', 'cmt_widgets');
add_action('admin_enqueue_scripts', 'cmt_admin_scripts');

add_action('admin_enqueue_scripts','admin_cmt_scripts');
function admin_cmt_scripts()
{
    wp_enqueue_style('admin-styles', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css');
    wp_enqueue_style('jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_script('admin-jquery-timepicker',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js',
        ['jquery'], false, true);
    wp_enqueue_script('admin-datepicker-panel', get_template_directory_uri() . '/assets/js/datepickerAdminPanel.js',
        ['jquery-ui-datepicker','admin-jquery-timepicker'], false, true);
    wp_enqueue_style('admin-select-style',  get_template_directory_uri() . '/assets/css/admin.css');
}



function cmt_scripts()
{
    // Theme description style
    wp_enqueue_style('style', get_stylesheet_uri(), [], STYLES_AND_SCRIPTS_VERSIONS, "all");

    wp_enqueue_style('cmt-source-code-pro', 'https://fonts.googleapis.com/css?family=Source+Code+Pro:200,300', [],
        null);
    wp_enqueue_style('cmt-jquery-ui',
        'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css', [], null);
    wp_enqueue_style('cmt-slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.0/slick.min.css', [],
        null);
    // Theme main style

    wp_enqueue_style('cmt-main', get_template_directory_uri() . '/assets/css/main.css', [], STYLES_AND_SCRIPTS_VERSIONS, "all");
    wp_enqueue_style('cmt-menu', get_template_directory_uri() . '/assets/css/slide-menu.css', [], STYLES_AND_SCRIPTS_VERSIONS, "all");
    wp_enqueue_style('cmt-main', get_template_directory_uri() . '/style.min.css', [], STYLES_AND_SCRIPTS_VERSIONS, "all");
    wp_enqueue_style('header-footer-style', get_template_directory_uri() . '/assets/css/header-footer.css', [], STYLES_AND_SCRIPTS_VERSIONS, "all");
    if (is_page_template('templates/post-archive-redesign.php')) {
        wp_enqueue_style('cmt-redesign-style', get_template_directory_uri() . '/assets/css/redesign-style.css', [], STYLES_AND_SCRIPTS_VERSIONS, "all");
        wp_enqueue_script('cmt-redesign-scripts',get_template_directory_uri().'/assets/js/redesign-scripts.js',['cmt-jquery'], STYLES_AND_SCRIPTS_VERSIONS, true);
    }

    // Custom javascript


    wp_enqueue_script('cmt-jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js', [], null, true);
//    wp_enqueue_script('cmt-typed', 'https://cdnjs.cloudflare.com/ajax/libs/typed.js/1.1.1/typed.min.js', null, true);
//    wp_enqueue_script('cmt-jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', ['cmt-jquery'],
//        null, true);
//    wp_enqueue_script('cmt-scroll-magic', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js', [], null,
//        true);
//    wp_enqueue_script('cmt-tween-lite', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenLite.min.js', [], null,
//        true);
//    wp_enqueue_script('cmt-tween-lite-css-plugin', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/CSSPlugin.min.js', [], null,
//        true);
    wp_enqueue_script('cmt-script-articles', get_template_directory_uri() . '/assets/js/main.js', [], STYLES_AND_SCRIPTS_VERSIONS, true);
    wp_enqueue_script('cmt-script-infinite', get_template_directory_uri() . '/assets/js/jquery-ias.min.js',
        ['cmt-jquery'], false, true);
    wp_enqueue_script('cmt-multi-level-menu',get_template_directory_uri().'/assets/js/slide-menu.js',['cmt-jquery'],false,true);
    //wp_enqueue_script('cmt-merquee-scripts',get_template_directory_uri().'/assets/js/merquee.js',['cmt-jquery'],false,true);
    wp_enqueue_script('cmt-bxslider-scripts',get_template_directory_uri().'/assets/js/vendor/jquery.bxslider.min.js',['cmt-jquery'],false,true);
    wp_enqueue_script('cmt-main-scripts',get_template_directory_uri().'/assets/js/scripts.js',['cmt-jquery', 'cmt-bxslider-scripts'], STYLES_AND_SCRIPTS_VERSIONS, true);

//    wp_enqueue_script('cmt-radio-btns', get_template_directory_uri() . '/assets/js/radio-buttons.js', [], null, true, ['cmt-jquery']);
//    wp_enqueue_script('cmt-script-infinite-more', get_template_directory_uri() . '/assets/js/load-more.js', ['cmt-script-infinite'], false, true);
//    wp_enqueue_script('cmt-script-webinar-date', get_template_directory_uri() . '/assets/js/webinarDate.js', ['jquery'], false, true);
//    wp_register_script('cmt-post-filter', get_template_directory_uri() . '/assets/js/post-filter.js', ['cmt-jquery'],
//        null,
//        false);
//    wp_enqueue_script('cmt-post-filter');
    wp_enqueue_script('cmt-shave',get_template_directory_uri().'/assets/js/shave.js',['cmt-jquery'],false,true);
    wp_enqueue_script('cmt-check-visitor',get_template_directory_uri().'/assets/js/check-visitor-country.js',['cmt-jquery'], STYLES_AND_SCRIPTS_VERSIONS, true);
//    wp_enqueue_script('cmt-read-more',get_template_directory_uri().'/assets/js/readMore.js',['cmt-jquery'],false,true);
//    wp_enqueue_script('cmt-scroll-to',get_template_directory_uri().'/assets/js/scrollToAnchor.js',['cmt-jquery'],false,true);


//    wp_enqueue_script('cmt-equal-height',get_template_directory_uri().'/assets/js/equal-height.js',['cmt-jquery'],false,true);


    $blocked_countries = get_option('countries_list') ? get_option('countries_list') : [];
    wp_localize_script( 'cmt-check-visitor', 'blocked_countries', $blocked_countries );
    wp_localize_script( 'cmt-post-filter', 'blocked_countries', $blocked_countries );

    wp_localize_script('cmt-post-filter', 'afp_vars', [
            'cmt_filter_nonce' => wp_create_nonce('cmt_filter_nonce'),
            'cmt_ajax_url'     => admin_url('admin-ajax.php'),
        ]
    );
    wp_register_script('cmt-position-filter', get_template_directory_uri() . '/assets/js/position-filter.js', ['cmt-jquery'],
        null,
        false);

    wp_localize_script('cmt-position-filter', 'cmt_pos', [
            'cmt_position_filter' => wp_create_nonce('cmt_position_filter'),
            'cmt_ajax_url'        => admin_url('admin-ajax.php'),
        ]
    );

    wp_localize_script('cmt-position-filter', 'cmt_pos', [
            'cmt_load_cookie' => wp_create_nonce('cmt_load_cookie'),
            'cmt_ajax_url'        => admin_url('admin-ajax.php'),
        ]
    );
    wp_register_script('wistia-external', 'https://fast.wistia.com/assets/external/E-v1.js', ['cmt-jquery'], null, true);
    wp_register_script('elementor-pages-search', get_template_directory_uri() . '/assets/js/elementor-pages-search.js', ['cmt-jquery'], STYLES_AND_SCRIPTS_VERSIONS, true);
}

function cmt_admin_scripts(){
    wp_enqueue_script('cmt-multiselect-box', get_template_directory_uri() . '/assets/js/multiselect.min.js');
    wp_enqueue_script('cmt-admin-scripts', get_template_directory_uri() . '/assets/js/admin-scripts.js');
    wp_enqueue_script('cmt-product-pages-selector', get_template_directory_uri() . '/assets/js/pages-product-selector.js');
}

function cmt_theme_setup()
{
    register_nav_menu('top', 'Header menu');
    register_nav_menu('bottom', 'Bottom');
    register_nav_menu('bottom-social', 'Bottom Social');

    add_theme_support('post-thumbnails');

    add_image_size('testimonials-img', 250, 70, true);
    add_image_size('banner-img', 900, 157, true);
    add_image_size('banner-thumbnail', 400, 76, ['center', 'center']);
    add_image_size('partner-img', 250, 76, true);
    add_image_size('product-img', 450, 350, true);
    add_image_size('frost-sullivan-img', 450, 416, true);

    add_image_size('product-preview', 335, 230, true);
    add_image_size('product-custom', 300, 200, true);
    add_image_size('product-thumbnail', 95, 65, true);


    add_image_size('career-img', 285, 205, true);
    add_image_size('application-img', 445, 295, true);
    add_image_size( 'full_hd', 1920, 1080 );
}

add_action( 'admin_print_footer_scripts', 'smackdown_add_quicktags' );

function cmt_widgets()
{
    register_sidebar([
        'name'          => 'Home Page Main Sidebar',
        'id'            => 'home-page-main-sidebar',
        'description'   => 'Home Page Main Sidebar',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ]);

    register_sidebar([
        'name'          => 'About Us Page Main Sidebar',
        'id'            => 'about-us-page-main-sidebar',
        'description'   => 'About Us Page Main Sidebar',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ]);

    register_widget('CMT_Applications_Widget', 'cmt-applications-widget');
    register_widget('CMT_Banners_Widget', 'cmt-banners-widget');
    register_widget('CMT_Customer_Testimonials_Widget', 'cmt-customer-testimonials-widget');
    register_widget('CMT_Our_Products_Widget', 'cmt-our-products-widget');
    register_widget('CMT_Partners_Widget', 'cmt-partners-widget');
    register_widget('CMT_Where_Used_Widget', 'cmt-where-used-widget');
}

if (function_exists('pll_register_string')) {
    pll_register_string('Home page title', 'Extend Your Reach�', false);
    pll_register_string('Home page typed text', 'Accessible, Portable, Metrology-Grade Instruments, Customizable',
        false);
    pll_register_string('Download button', 'Download Software page', false);
    pll_register_string('Our Product button', 'View our product',
        false);
}


add_action('wp_ajax_nopriv_load-filter2', 'load_products');
add_action('wp_ajax_load-filter2', 'load_products');

add_action('wp_ajax_nopriv_load-search-faq', 'search_faq');
add_action('wp_ajax_load-search-faq', 'search_faq');


add_action('wp_ajax_nopriv_load-search-blog-posts', 'search_blog_posts');
add_action('wp_ajax_load-search-blog-posts', 'search_blog_posts');

add_action('wp_ajax_nopriv_load-search-documentation-posts', 'search_documentation_posts');
add_action('wp_ajax_load-search-documentation-posts', 'search_documentation_posts');

add_action('wp_ajax_nopriv_load-search-webinars', 'search_webinars');
add_action('wp_ajax_load-search-webinars', 'search_webinars');

add_action('wp_ajax_nopriv_load-position-filter', 'load_position');
add_action('wp_ajax_load-position-filter', 'load_position');

add_action('wp_ajax_nopriv_load-search-map-locations', 'search_map_locations');
add_action('wp_ajax_load-search-map-locations', 'search_map_locations');

add_action('wp_ajax_nopriv_load-select-country', 'select_country');
add_action('wp_ajax_load-select-country', 'select_country');

add_action('wp_ajax_nopriv_load-select-chinese', 'select_chinese');
add_action('wp_ajax_load-select-chinese', 'select_chinese');

add_action('wp_ajax_nopriv_load-select-portuguese', 'select_portuguese');
add_action('wp_ajax_load-select-portuguese', 'select_portuguese');

add_action('wp_ajax_nopriv_load-select-spanish', 'select_spanish');
add_action('wp_ajax_load-select-spanish', 'select_spanish');

add_action('wp_ajax_nopriv_load-select-japanese', 'select_japanese');
add_action('wp_ajax_load-select-japanese', 'select_japanese');

add_action('wp_ajax_nopriv_load_cookie', 'load_cookie');
add_action('wp_ajax_load_cookie', 'load_cookie');

add_action('wp_ajax_nopriv_load-upperfilter', 'search_products_by_upper_frequency');
add_action('wp_ajax_load-upperfilter', 'search_products_by_upper_frequency');

add_action('wp_ajax_nopriv_search-integrations', 'get_integrations');
add_action('wp_ajax_search-integrations', 'get_integrations');

add_action('wp_ajax_nopriv_search-products-for-selector', 'get_products_for_selector');
add_action('wp_ajax_search-products-for-selector', 'get_products_for_selector');

add_action('wp_ajax_nopriv_load-h5p-content', 'load_h5p_content');
add_action('wp_ajax_load-h5p-content', 'load_h5p_content');

add_action('wp_ajax_nopriv_load-search-elementor-pages', 'search_elementor_pages');
add_action('wp_ajax_load-search-elementor-pages', 'search_elementor_pages');

add_action('init','check_visitor_country');

function new_excerpt_length($length)
{
    return 15;
}

add_filter('excerpt_length', 'new_excerpt_length');

add_filter('excerpt_more', function ($more) {
    return '...';
});

add_filter( 'wp_insert_post_data', 'my_add_ul_class_on_insert' );
function my_add_ul_class_on_insert( $postarr ) {
    $postarr['post_content'] = str_replace( '<ul>', '<ul class="list-text">', $postarr['post_content'] );
    $postarr['post_content'] = str_replace( '<ol>', '<ol class="list-text">', $postarr['post_content'] );

    return $postarr;
}

add_filter( 'post_row_actions', 'remove_row_actions', 10, 2 );
function remove_row_actions( $actions ) {
    unset( $actions['inline hide-if-no-js'] );

    return $actions;
}

add_theme_support( 'custom-logo' );

add_filter( 'manage_posts_columns', 'revealid_add_id_column', 5 );
add_action( 'manage_posts_custom_column', 'revealid_id_column_content', 5, 2 );

function revealid_add_id_column( $columns ) {
    global $post;
    if($post->post_type == 'banners_gallery'){
        $columns['revealid_id'] = 'Gallery ID';
    }
    if($post->post_type == 'application'){
        $columns['revealid_id'] = 'Application ID';
    }
    return $columns;
}

function revealid_id_column_content( $column, $id ) {
    if( 'revealid_id' == $column ) {
        echo $id;
    }
}

function limit_menu_depth( $hook ) {
    if ( $hook != 'nav-menus.php' ) return;
    wp_add_inline_script( 'nav-menu', 'wpNavMenu.options.globalMaxDepth = 2;', 'after' );
}
add_action( 'admin_enqueue_scripts', 'limit_menu_depth' );

add_action( 'init', 'remover_editor_support' );
function remover_editor_support() {
    remove_post_type_support(APP_PAGE_POST_TYPE,'editor');
    remove_post_type_support(INTEGRATIONS_POST_TYPE,'editor');
}

add_filter('wpseo_title', 'filter_wpseo_title');
function filter_wpseo_title($title) {
    if(is_archive()){
        $title = str_replace('Archive','',$title);
    }
    return $title;
}

// add async and defer attributes to enqueued scripts
add_filter('script_loader_tag', 'add_script_loader_tag', 10, 3);
function add_script_loader_tag($tag, $handle, $src) {

    if ($handle === 'wistia-external') {

        if (false === stripos($tag, 'async')) {

            $tag = str_replace(' src', ' async src', $tag);

        }

    }

    return $tag;

}

add_action('pre_get_posts', 'remove_my_cpt_from_search_results');

function remove_my_cpt_from_search_results($query) {

    if (is_admin() || !$query->is_main_query() || !$query->is_search()) {
        return $query;
    }

    $post_types_to_exclude = array(
        'application',
        'application-page',
        'calibration-service',
        'location',
        'data-sheet',
        'banner',
        'banners_gallery',
        'latest_news',
        'integrations',
        'frost-sullivan',
        'integrations',
        'leadership',
        'manual',
        'webinar',
        'video',
        'where_vnas',
        'product'
    );

    if ($query->get('post_type')) {
        $query_post_types = $query->get('post_type');

        if (is_string($query_post_types)) {
            $query_post_types = explode(',', $query_post_types);
        }
    } else {
        $query_post_types = get_post_types(array('exclude_from_search' => false));
    }

    if (sizeof(array_intersect($query_post_types, $post_types_to_exclude))) {
        $query->set('post_type', array_diff($query_post_types, $post_types_to_exclude));
    }

    return $query;
}

/*Theme Setting Option*/
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false,
    ));
}

// acf json
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
 
function my_acf_json_save_point( $path ) {
    
    // update path
    $path = get_stylesheet_directory() . '/acf-json';
    
    
    // return
    return $path;
    
}

//Get video timeline
add_action('save_post', 'save_post_video', 10, 3);

function save_post_video( $post_ID, $post, $update ) {
    if (isset($_POST) && !empty($_POST)) {
        $pattern = '~[a-z]+://\S+~';
        $postStr = implode(' ', $_POST);
        $num_found = preg_match_all($pattern, $postStr, $out);
        $linkArr = $out[0];
        $metaTags;
        $linkWistie;

        foreach ($linkArr as $link) {
            $url = parse_url($link);
            if($url['host'] == 'coppermountaintech.wistia.com') {
                $linkWistie = $link;
                break;
            };
        };

        if (!empty($linkWistie)) {
            $metaTags = get_meta_tags($linkWistie);
        };

        if (!empty($metaTags)) {
            $timeDescr = $metaTags['twitter:description'];
            $explDescr = explode(' ', $timeDescr);
            $metaArr = [];

                foreach ($explDescr as $exp) {
                    if ($exp !== 'min' && $exp !== 'sec' && $exp !== 'video') {
                        $metaArr[] = $exp;
                    };
                };

            $implDescr = implode(':', $metaArr);
            //wp_send_json($linkWistie); //check url after save
            if (!empty($implDescr)) {
                update_field('rd_vc_time_video', $implDescr);
            };
        };
        clean_post_cache( $post->post_id);
    };
};

/**
 * Use radio inputs instead of checkboxes for term checklists in specified taxonomies.
 *
 * @param   array   $args
 * @return  array
 */
function webinar_wpse_139269_term_radio_checklist($args) {
    if (! empty($args['taxonomy']) && $args['taxonomy'] === 'webinar_parent_category') {
        if (empty($args['walker']) || is_a($args['walker'], 'Walker')) { // Don't override 3rd party walkers.
            if ( ! class_exists('WPSE_139269_Walker_Category_Radio_Checklist')) {
                /**
                 * Custom walker for switching checkbox inputs to radio.
                 *
                 * @see Walker_Category_Checklist
                 */
                class WPSE_139269_Walker_Category_Radio_Checklist extends Walker_Category_Checklist {
                    function walk($elements, $max_depth, ...$args) {
                        $output = parent::walk($elements, $max_depth, ...$args);
                        $output = str_replace(
                            ['type="checkbox"', "type='checkbox'"],
                            ['type="radio"', "type='radio'"],
                            $output
                        );

                        return $output;
                    }
                }
            }

            $args['walker'] = new WPSE_139269_Walker_Category_Radio_Checklist;
        }
    }

    return $args;
}

add_filter( 'wp_terms_checklist_args', 'webinar_wpse_139269_term_radio_checklist' );

function video_wpse_139269_term_radio_checklist($args) {
    if (! empty($args['taxonomy']) && $args['taxonomy'] === 'video_parent_category') {
        if (empty($args['walker']) || is_a($args['walker'], 'Walker')) { // Don't override 3rd party walkers.
            if ( ! class_exists('WPSE_139269_Walker_Category_Radio_Checklist')) {
                /**
                 * Custom walker for switching checkbox inputs to radio.
                 *
                 * @see Walker_Category_Checklist
                 */
                class WPSE_139269_Walker_Category_Radio_Checklist extends Walker_Category_Checklist {
                    function walk($elements, $max_depth, ...$args) {
                        $output = parent::walk($elements, $max_depth, ...$args);
                        $output = str_replace(
                            ['type="checkbox"', "type='checkbox'"],
                            ['type="radio"', "type='radio'"],
                            $output
                        );

                        return $output;
                    }
                }
            }

            $args['walker'] = new WPSE_139269_Walker_Category_Radio_Checklist;
        }
    }

    return $args;
}

add_filter( 'wp_terms_checklist_args', 'video_wpse_139269_term_radio_checklist' );