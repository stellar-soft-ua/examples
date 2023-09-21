<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */
if (!defined('CHILD_THEME_VERSION')) {
    define('CHILD_THEME_VERSION', '1.0.3');
}
// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

// clean up missing wp parts
require_once get_stylesheet_directory() . '/lib/menu/description.php';

add_action('after_setup_theme', 'genesis_sample_localization_setup');
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup()
{

    load_child_theme_textdomain(genesis_get_theme_handle(), get_stylesheet_directory() . '/languages');

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

// Add Timezone
require_once get_stylesheet_directory() . '/lib/datetime.php';

// Walker modification
require_once get_stylesheet_directory() . '/lib/BootstrapNavigation.php';
require_once get_stylesheet_directory() . '/lib/BootstrapNavigationMobile.php';

add_action('after_setup_theme', 'genesis_child_gutenberg_support');
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support()
{ // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
    require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

// Registers the responsive menus.
if (function_exists('genesis_register_responsive_menus')) {
    genesis_register_responsive_menus(genesis_get_config('responsive-menus'));
}

add_action('wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles');
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles()
{

    $appearance = genesis_get_config('appearance');

    wp_enqueue_style(
        genesis_get_theme_handle() . '-fonts',
        $appearance['fonts-url'],
        [],
        genesis_get_theme_version()
    );

    wp_enqueue_style('dashicons');

    if (genesis_is_amp()) {
        wp_enqueue_style(
            genesis_get_theme_handle() . '-amp',
            get_stylesheet_directory_uri() . '/lib/amp/amp.css',
            [genesis_get_theme_handle()],
            genesis_get_theme_version()
        );
    }

    //assetEnqueue('politicopro-child-theme', '/style.css', true, false);

    if (!is_page_template([
        'page-templates/template-home.php',
        'page-templates/template-home-gutenberg.php',
        'page-templates/template-features.php',
        'page-templates/template-pro-reporting.php',
        'page-templates/template-demo.php',
        'page-templates/template-pro-plans.php',
        'page-templates/template-about-pro.php',
        'page-templates/template-pro-features-gutenberg.php',
        'page-templates/template-pro-reporting-gutenberg.php',
        'page-templates/template-home-advanced.php',
        'page-templates/template-pro-features-advanced.php',
        'page-templates/template-pro-reporting-advanced.php',
        'page-templates/template-pro-plans-advanced.php',
        'page-templates/template-about-pro-advanced.php',
    ]) &&
        !is_page(['html-markup'])
    ) {
        assetEnqueue('boostrap-scripts', '/assets/css/bootstrap/css/bootstrap.min.css', true, false);
        assetEnqueue('child-custom-font-style', 'https://use.typekit.net/pqu4ubu.css', false, false);
        assetEnqueue('variables-style', '/assets/css/variables.css', true, false);
        assetEnqueue('child-custom-style-2', '/assets/css/custom.css', true, false);
        assetEnqueue('childt-popper-jquery', '/assets/js/popper.js', true, true);
        assetEnqueue('childt-bootstrap-jquery', '/assets/css/bootstrap/js/bootstrap.min.js', true, true);
        assetEnqueue('equal-height', '/assets/js/grids.js', true, true);
        assetEnqueue('childt-custom-jquery', '/assets/js/custom.js', true, true);
    }
    assetEnqueue('sage/main.css', '/dist/styles/main.css', true, false);

    if (!is_page_template('page-templates/campaign-landing.php')) {
        assetEnqueue('sage/main.js', '/dist/scripts/main.js', true, true);
    }
}

/**
 * @return void
 */
function assetEnqueue($handle, $asset, $usePath = true, $footer = true): void
{
    $ftime = null;

    // default to css
    $command = 'wp_enqueue_style';
    if (strpos($asset, '.js') !== false) {
        $command = 'wp_enqueue_script';
    }

    if ($usePath) {
        $asset1 = sprintf('%s%s', get_stylesheet_directory_uri(), $asset);
        $file = sprintf('%s%s', get_stylesheet_directory(), $asset);

        /*get the version*/
        if (file_exists($file)) {
            $ftime = filemtime($file);
        }
    } else {
        $asset1 = $asset;
    }

    $command($handle, $asset1, [], $ftime, $footer);
}

add_action('after_setup_theme', 'genesis_sample_theme_support', 9);
/**
 * Add desired theme supports.
 *
 * See config file at `config/theme-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_theme_support()
{

    $theme_supports = genesis_get_config('theme-supports');

    foreach ($theme_supports as $feature => $args) {
        add_theme_support($feature, $args);
    }

}

add_action('after_setup_theme', 'genesis_sample_post_type_support', 9);
/**
 * Add desired post type supports.
 *
 * See config file at `config/post-type-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_post_type_support()
{

    $post_type_supports = genesis_get_config('post-type-supports');

    foreach ($post_type_supports as $post_type => $args) {
        add_post_type_support($post_type, $args);
    }

}

// Adds image sizes.
add_image_size('sidebar-featured', 75, 75, true);
add_image_size('genesis-singular-images', 702, 526, true);

// Removes header right widget area.
unregister_sidebar('header-right');

// Removes secondary sidebar.
unregister_sidebar('sidebar-alt');

// Removes site layouts.
genesis_unregister_layout('content-sidebar-sidebar');
genesis_unregister_layout('sidebar-content-sidebar');
genesis_unregister_layout('sidebar-sidebar-content');

// Repositions primary navigation menu.
remove_action('genesis_after_header', 'genesis_do_nav');
//add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action('genesis_after_header', 'genesis_do_subnav');
add_action('genesis_footer', 'genesis_do_subnav', 10);

add_filter('wp_nav_menu_args', 'genesis_sample_secondary_menu_args');
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 * @since 2.2.3
 *
 */
function genesis_sample_secondary_menu_args($args)
{

    if ('secondary' === $args['theme_location']) {
        $args['depth'] = 1;
    }

    return $args;

}

add_filter('genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar');
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 * @since 2.2.3
 *
 */
function genesis_sample_author_box_gravatar($size)
{

    return 90;

}

add_filter('genesis_comment_list_args', 'genesis_sample_comments_gravatar');
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 * @since 2.2.3
 *
 */
function genesis_sample_comments_gravatar($args)
{

    $args['avatar_size'] = 60;
    return $args;

}

/* Remove the site Header */
remove_action('genesis_header', 'genesis_do_header');
remove_action('genesis_header', 'genesis_header_markup_open', 5);
remove_action('genesis_header', 'genesis_header_markup_close', 15);
remove_action('genesis_header', 'genesis_do_nav');

remove_action('genesis_after_header', 'genesis_do_nav');
remove_action('genesis_entry_header', 'genesis_do_post_title');
remove_action('genesis_entry_header', 'genesis_entry_header_markup_open', 5);
remove_action('genesis_entry_header', 'genesis_entry_header_markup_close', 15);
/* Add Custom Site Header in Genesis Child Theme */
function customize_genesis_header()
{
    include get_stylesheet_directory() . '/main-header.php';
}

add_action('genesis_header', 'customize_genesis_header');

/*Child theme*/
/**
 *
 */
/* Remove site site Footer */
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);
remove_action('genesis_footer', 'genesis_do_subnav', 10);

/* Add Custom Site Footer in Genesis Child Theme */
function customize_genesis_footer()
{
    include get_stylesheet_directory() . '/main-footer.php';
}

add_action('genesis_footer', 'customize_genesis_footer');
remove_action('genesis_before_footer', 'genesis_footer_widget_areas');

/* Create Footer Setting options
 */
function footer_theme_settings($wp_customize)
{

    $wp_customize->add_section('genesis_footer', array(
        'title' => 'Footer',
        'priority' => 160,
    ));
    /* add a setting for the footer logo */
    $wp_customize->add_setting('footer_theme_logo');
    /* Add a control to upload the logo */
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_theme_logo',
        array(
            'label' => 'Footer Logo',
            'section' => 'genesis_footer',
            'settings' => 'footer_theme_logo',
        )
    ));

    /* add a setting for the Copyright Text */
    $wp_customize->add_setting('copyright_text');
    /* Add a control to add Copyright title */
    $wp_customize->add_control('copyright_text',
        array(
            'type' => 'text',
            'label' => 'Copyright Text',
            'section' => 'genesis_footer',
            'settings' => 'copyright_text',
        )
    );
    /*Add a setting for the Twitter URl */
    $wp_customize->add_setting('twitter_url');
    /* Add a control to add Twitter title */
    $wp_customize->add_control('twitter_url',
        array(
            'type' => 'text',
            'label' => 'Twitter Url',
            'section' => 'genesis_footer',
            'settings' => 'twitter_url',
        )
    );
    /*Add a setting for the Linkedin URl*/
    $wp_customize->add_setting('linkedin_url');
    /* Add a control to add Linkedin title */
    $wp_customize->add_control('linkedin_url',
        array(
            'type' => 'text',
            'label' => 'Linkedin Url',
            'section' => 'genesis_footer',
            'settings' => 'linkedin_url',
        )
    );
    /*Add a setting for the Instagram URl*/
    $wp_customize->add_setting('instagram_url');
    /* Add a control to add Instagram title */
    $wp_customize->add_control('instagram_url',
        array(
            'type' => 'text',
            'label' => 'Instagram Url',
            'section' => 'genesis_footer',
            'settings' => 'instagram_url',
        )
    );

    $wp_customize->add_section('genesis_header', array(
        'title' => 'Header',
        'priority' => 160,
    ));
    /* add a setting for the footer logo */
    $wp_customize->add_setting('header_theme_logo');
    /* Add a control to upload the logo */
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_theme_logo',
        array(
            'label' => 'Archive Header Logo',
            'section' => 'genesis_header',
            'settings' => 'header_theme_logo',
        )
    ));

}

add_action('customize_register', 'footer_theme_settings');

add_action('genesis_before_content_sidebar_wrap', 'beforcontent_callback');
add_action('genesis_after_content_sidebar_wrap', 'aftecontent_callback');

function beforcontent_callback()
{
    echo '<div class="container">';
}

function aftecontent_callback()
{
    echo "</div>";
}

add_action('after_setup_theme', 'eenews_setup', 11);
function eenews_setup()
{
    $GLOBALS['content_width'] = 1110;
}

function mytheme_custom_excerpt_length($length)
{
    return 20;
}

add_filter('excerpt_length', 'mytheme_custom_excerpt_length', 999);

add_filter('walker_nav_menu_start_el', 'add_arrow', 10, 4);
function add_arrow($output, $item, $depth, $args)
{

//Only add class to 'top level' items on the 'primary' menu.
    if ('primary' == $args->theme_location && $depth === 0) {
        if (in_array("menu-item-has-children", $item->classes)) {
            $output .= '<span class="sub-menu-icon"></span>';
        }
    }
    return $output;
}

// Move Yoast to bottom
function wpcover_move_yoast()
{
    return 'low';
}

add_filter('wpseo_metabox_prio', 'wpcover_move_yoast');

/*This function used for removed the edit button link on the fronted*/
function custom_remove_edit_post_link($link)
{
    return '';
}

add_filter('edit_post_link', 'custom_remove_edit_post_link');
/*End*/

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

/*Add function menu Active*/
add_filter('nav_menu_css_class', 'aiq_nav_class', 10, 2);
function aiq_nav_class($classes, $item)
{
    if (in_array('current-menu-item', $classes)) {
        $classes[] = 'active ';
    }
    return $classes;
}

/*politicopro site start code */
add_filter('wp_nav_menu_items', 'pol_add_search_toggle', 10, 2);

/* Filter in Search Toggle to end of primary menu */
function pol_add_search_toggle($items, $args)
{
    if ($args->theme_location == 'primary' || $args->theme_location == 'top-menu') { //Swap to your location
        $items .= '<li class="search search-wpb"><a class="search-icon" href="javascript:void(0);">Search</a><a class="search-close-icon" href="javascript:void(0);">Search-close</a></li>';
    }
    return $items;
}

/**
 * define ACF blocks
 */
require_once get_stylesheet_directory() . '/page-templates/extra-functions.php';

/* Register nav Menu */
add_action('init', function () {
    register_nav_menus([
        'top-menu' => __('Top Menu'),
        'main-menu' => __('Main Menu'),
        'main-menu-mobile' => __('Main Menu mobile'),
    ]);
});

/** Add filter for the FacetWP plugin */
add_filter('facetwp_sort_options', function ($options, $params) {
    $options['default']['label'] = 'Most Recent';
    unset($options['title_asc']);
    unset($options['title_desc']);
    unset($options['date_desc']);
    unset($options['date_asc']);
    $options['popular'] = [
        'label' => 'Popular',
        'query_args' => [
            'orderby' => 'meta_value_num',
            'meta_key' => 'post_view_count',
            'order' => 'DESC',
        ],
    ];
    return $options;
}, 10, 2);

add_filter('facetwp_facet_dropdown_show_counts', '__return_false');

/**
 * filter html for sort to output radio buttons
 */
/*add_filter( 'facetwp_sort_html', function( $output, $params ) {
$output = '<div class="facetwp-sort-radio facetwp-sort-custom-radio">';
foreach ( $params['sort_options'] as $key => $atts ) {
$output .= '<label class="custom-sort-'.$key.'"><input type="radio" name="sort" value="' . $key . '"> ' . $atts['label'] . '</label>';
}
$output .= '</div>';
return $output;
}, 10, 2 );*/

//* Remove Genesis in-post SEO Settings
remove_action('genesis_meta', 'genesis_seo_meta_description');
remove_action('admin_menu', 'genesis_add_inpost_seo_box');

/* Change categories link */

add_filter('term_link', function ($termlink, $term, $taxonomy) {
    if ('category' == $taxonomy) {
        $termlink = trailingslashit(get_permalink(get_page_by_path('blog'))) . '?_categories=' . $term->slug;
    }
    return $termlink;
}, 10, 3);

/** Include blog placeholder image */
/** replace the featured image with placeholder if empty **/
add_filter('facetwp_builder_item_value', function ($value, $item) {
    if ('featured_image' == $item['source'] && empty($value)) {
        //$value = wc_placeholder_img( $item['settings']['image_size'] );
        $value = '<img src="' . get_stylesheet_directory_uri() . '/images/blog-placeholder.png" alt="Placeholder Image"/>';
    }
    return $value;
}, 10, 2);

/** Change permalink for blog deatils posts */

function _blog_generate_rewrite_rules($wp_rewrite)
{
    $new_rules = array(
        '(([^/]+/)*blog)/page/?([0-9]{1,})/?$' => 'index.php?pagename=$matches[1]&paged=$matches[3]',
        'blog/([^/]+)/?$' => 'index.php?post_type=post&name=$matches[1]',
    );
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}

add_action('generate_rewrite_rules', '_blog_generate_rewrite_rules');
function _blog_update_post_link($post_link, $id = 0)
{
    $post = get_post($id);
    if (is_object($post) && $post->post_type == 'post') {
        return home_url('/blog/' . $post->post_name);
    }
    return $post_link;
}

add_filter('post_link', '_blog_update_post_link', 1, 3);

/**
 * Add Page Slug as Body Class.
 */
function wps_add_slug_body_class($classes)
{
    global $post;
    if (isset($post)) {
        $classes[] = $post->post_name;
    }
    return $classes;
}

add_filter('body_class', 'wps_add_slug_body_class');

// Add Google Tag Manager code in <head>
//add_action( 'wp_head', 'sk_google_tag_manager1' );
function sk_google_tag_manager1()
{?>
<!-- Google Tag Manager -->
<script>
(function(w, d, s, l, i) {
    w[l] = w[l] || [];
    w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
    });
    var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
    j.async = true;
    j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
    f.parentNode.insertBefore(j, f);
})(window, document, 'script', 'dataLayer', 'GTM-TSG2KMX');
</script>
<!-- End Google Tag Manager -->
<?php }

// Add Google Tag Manager code immediately below opening <body> tag
add_action('wp_body_open', function() {
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TSG2KMX"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}, 1);


add_action( 'wp_footer', 'sk_google_tag_manager2' );
function sk_google_tag_manager2()
{?>
<script>
(function(a, b, c, d) {
    a='//tags.tiqcdn.com/utag/politico/pro/prod/utag.js';
    b=document;
    c='script';
    d=b.createElement(c);
    d.src=a;
    d.type='text/java'+c;
    d.async=true;
    a=b.getElementsByTagName(c)[0];
    a.parentNode.insertBefore(d,a)
})();
var utag_data = {
    "free_paid_content":"free",
    "site_section":"pro b2b site",
    "ad_unit_section":"pro-b2b-site",
    "page_type":"pro b2b site",
    "site_domain":"www.politicopro.com",
    "internal_site_id":"politicopro",
    "page_name":"pro b2b site - " + document.location.pathname,
    "distribution_channel":"politico",
};
</script>
<?php }

function upload_dir_new($data)
{
    $data['baseurl'] = str_replace("/wp-content/uploads/sites/2", "/media", $data['baseurl']);
    $data['basedir'] = str_replace("/wp-content/uploads/sites/2", "/media", $data['basedir']);
    return $data;
}

function my_acf_format_value($value, $post_id, $field)
{
    if (strpos($value, '.pdf') !== false) {
        $value = str_replace("/wp-content/uploads/sites/2/", "/", $value);
    }
    return $value;
}

add_filter('acf/format_value/type=file', 'my_acf_format_value', 99, 3);

/* Disable the gutenburg and unused blocks from admin */
add_filter('allowed_block_types', 'custom_allowed_block_types');
function custom_allowed_block_types($allowed_blocks)
{
    return array(
        'core/image',
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/html',
        'acf/secondary-pricing-table-block',
        'acf/dark-cta-block',
        'acf/resource-banner-block',
        'acf/three-column-cta-block',
        'acf/two-column-content-block',
        'acf/two-column-success-grid-block',
        'acf/success-banner-block',
        'acf/banner-with-download-links',
        'acf/download-block',
        'acf/inner-banner',
        'acf/three-column-icon-grid-block',
        'acf/cta-with-icon',
        'acf/resource-cta-block',
        'acf/pricing-table-block',
        'acf/two-column-image-center-block',
        'acf/two-column-request-grid-block',
        'acf/explore-grid-block',
        'acf/testimonial-block',
        'acf/faqs-block',
        'acf/left-content-with-form-block',
        'acf/faq-three-column-block',
        'acf/top-accordion-block',
        'acf/values-block',
        'acf/leadership-block',
        'acf/plans-grid-block',
        'acf/full-width-banner-block',
        'acf/content-block',
        'acf/quote-block',
        'acf/three-column-image-block',
        'acf/left-accordion-block',
        'acf/fact-sheet',
        'acf/stats-block',
        'acf/four-column-icon-grid-block',
        'acf/four-column-image-grid-block',
        'acf/learn-more-cta-block',
        'acf/two-column-image-content-block',
        'acf/client-block',
        'acf/home-hero-block',
        'acf/secondary-banner',
        'acf/rd-text-block',
        'acf/rd-first-counter-block',
        'acf/rd-title-block',
        'acf/rd-find-your-place',
        'acf/rd-gold-standart-block',
        'acf/rd-platform-features-block',
        'acf/rd-glimpse-block',
        'acf/rd-300-experts-block',
        'acf/rd-features-hero-block',
        'acf/rd-1000-topics-block',
        'acf/rd-police-news-block',
        'acf/rd-additional-features-block',
        'acf/rd-single-stats-pattern',
        'acf/rd-two-column-cta-and-rotating-text-pattern',
        'acf/rd-text-and-image-pattern',
        'acf/rd-cards-scroller',
        'acf/rd-vertical-timeline-accordion',
        'acf/rd-two-column-icon-card-blocks'
    );
}

function filter_the_author($name, $first, $last)
{
    $name = "Politico Author";
    return $name;
}

;

add_filter('wds-model-user-full_name', 'filter_the_author', 99, 3);

/* Define view count */

function pp_get_post_view()
{
    $count = get_field('post_view_count', get_the_ID());
    return "$count views";
}

function pp_set_post_view()
{
    $key = 'post_view_count';
    $post_id = get_the_ID();
    $count = (int) get_field($key, $post_id);
    $count++;
    update_field($key, $count, $post_id);
}

/* Hide sync media button */
add_action('admin_head', 'my_custom_admin_css');
function my_custom_admin_css()
{
    echo '<style>
    a#sync-media.gray-blue-link {
      display: none;
    }
    body .attachments-browser .uploader-inline {
      top: auto !important;
    }
  </style>';
}

add_filter('facetwp_indexer_query_args', function ($args) {
    $args['post_status'] = ['publish', 'inherit'];

    return $args;
});

add_filter('facetwp_query_args', function ($query_args, $class) {
    if ('resources' == $class->ajax_params['template']) {

        $query_args['meta_query']['relation'] = 'OR';
        $query_args['meta_query'][] = [
            'key' => '_wds_meta-robots-noindex',
            'value' => 1,
            'type' => 'NUMERIC',
            'compare' => '!=',
        ];
        $query_args['meta_query'][] = [
            'key' => '_wds_meta-robots-noindex',
            'compare' => 'NOT EXISTS',
        ];

    }

    // echo "<pre>"; print_r($query_args); exit;
    return $query_args;
}, 10, 2);

// image sizes
add_image_size('square-mid', 300, 300);
add_image_size('square-small', 150, 150);

/* Added the end slash */
function append_query_string($url, $post, $leavename = false)
{
    return $url . '/';
}

add_filter('post_link', 'append_query_string', 10, 3);

// filters rss feed based on query string
add_action('rss_tag_pre', function ($tag) {
    $summary = filter_input(INPUT_GET, '_summary', FILTER_SANITIZE_STRING);
    if ('yes' === $summary) {
        add_filter('option_rss_use_excerpt', '__return_true');
    } elseif ('no' === $summary) {
        add_filter('option_rss_use_excerpt', '__return_false');
    }

    // default to what's in settings > reading > For each post in a feed, include
});

// attachment triggers
require_once 'lib/facet-wp-media-update.php';

/**
 * Copyright field functionality
 *
 * @param array $field ACF Field settings
 *
 * @return array
 */

add_action('acf/load_field/name=copyright', function ($field) {
    $field['instructions'] = 'Input <code>@year</code> to replace static year with dynamic, so it will always shows current year.';

    return $field;
});

if (!is_admin()) {
    // Replace @year with current year
    add_filter('acf/load_value/name=copyright', function ($value) {
        return str_replace('@year', date('Y'), $value);
    });
}

add_action('get_header', 'remove_primary_sidebar_single_pages');
function remove_primary_sidebar_single_pages()
{
    if (is_singular('page')) {
        remove_action('genesis_sidebar', 'genesis_do_sidebar');
    }
}

// gutenberg begin
add_action('init', function () {
    $blocks = glob(get_theme_file_path() . '/resources/assets/gutenberg/blocks/**/index.php');

    foreach ($blocks as $filename) {
        (function () use ($filename) {
            require $filename;
            $blockDir      = dirname($filename);
            $template      = $blockDir . '/index.blade.php';
            $hasTemplate   = file_exists($template);
            $blockJson     = $blockDir . '/block.json';
            $hasBlockJson  = file_exists($blockJson);
            $hasRender     = isset($render);
            $hasController = isset($controller);

            if (!$hasBlockJson) {
                user_error(
                    "error registering dynamic block: {$filename}. Metadata file not found at {$blockJson}."
                    . " see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/"
                    . " for details on block metadata files.",
                    E_USER_ERROR
                );
                return;
            }

            if ($hasRender && $hasTemplate) {
                user_error(
                    "error registering dynamic block: {$filename} declares a \$render callback
 even though there is an index.blade.php template. Please use either one or the other!",
                    E_USER_ERROR
                );
            }

            if ($hasController && !$hasTemplate) {
                user_error(
                    "error registering dynamic block: {$filename} declares a \$controller function
 but does not provide an index.blade.php template. Please add a template for the block to function properly!",
                    E_USER_ERROR
                );
            }

            if ($hasController && $hasRender) {
                user_error(
                    "error registering dynamic block: {$filename} declares a \$controller function
 and \$render callback. Either use a \$controller with an index.blade.php template or a \$render callback!",
                    E_USER_ERROR
                );
            }

            if (! $hasTemplate && !$hasRender) {
                user_error(
                    "error registering dynamic block: {$filename} does provide neither a \$render callback
 nor is there an index.blade.php template next to it!",
                    E_USER_ERROR
                );
            }

            if (isset($render)) {
                register_block_type($blockJson, [
                    'render_callback' => $render,
                ]);
            } elseif ($hasTemplate && ! $hasController) {
                register_block_type($blockJson, [
                    'render_callback' => function ($block_attributes, $content) use ($template) {
                        $atts = array_merge($block_attributes, [
                            'content' => $content,
                        ]);

                        return template($template, $atts);
                    },
                ]);
            } elseif ($hasTemplate && $hasController) {
                register_block_type($blockJson, [
                    'render_callback' => function ($block_attributes, $content) use ($template, $controller) {
                        $atts = $controller($block_attributes, $content);

                        return template($template, $atts);
                    },
                ]);
            }//end if
        })();
    }//end foreach
});
// gutenberg end

add_filter( 'facetwp_is_main_query', function( $is_main_query, $query ) {
    if ( $query->is_archive() && $query->is_main_query() ) {
        $is_main_query = false;
    }
    return $is_main_query;
}, 10, 2 );

add_theme_support( 'post-thumbnails' );
add_image_size( 'full_hd', 1920, 1080 );


// reorder basic text editor toolbar in acf
add_filter( 'acf/fields/wysiwyg/toolbars' , 'new_toolbar'  );
function new_toolbar( $toolbars ) {
    $toolbars['Basic Light' ] = array();
    $toolbars['Basic Light' ][1] = array('bold' , 'italic' , 'underline' );

    if( ($key = array_search('code' , $toolbars['Full' ][2])) !== false) {
        unset( $toolbars['Full' ][2][$key] );
    };

    unset( $toolbars['Basic' ] );

    return $toolbars;
};

