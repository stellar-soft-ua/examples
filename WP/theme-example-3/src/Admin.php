<?php

namespace THEME\Theme;

use Leafo\ScssPhp\Compiler;
use THEME\Framework\Enqueues\EnqueueStyle;
use THEME\Framework\Enqueues\Style;

class Admin
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        add_action('admin_head', [$this, 'add_favicon']);

        EnqueueStyle::backend(new Style('theme-admin-style', get_template_directory_uri() . '/style-admin.css'));
        EnqueueStyle::backend(new Style('theme-divi', get_template_directory_uri() . '/divi-builder.css'));

        if (is_admin()) {
            EnqueueStyle::backend(new Style('admin_css', get_template_directory_uri() . '/admin-style.css'));
            add_action('admin_menu', [$this, 'ThemeTheme_setup_menu']);
            if (defined('DOING_AJAX') && DOING_AJAX) {

                if (isset($_POST['createflydir'])) {
                    $return = array(
                        'success' => true
                    );
                    mkdir(get_home_path() . 'app/uploads/fly');
                    wp_send_json($return);
                }
            }
        }

        $this->modifyCapapabilities();
        if (get_option('allow_svg') == 1) {
            add_filter('tiny_mce_before_init', [$this, 'allow_svg_in_tinymce']);
        }

        if (get_option('enable_wpautop') == 1) {
            remove_filter('the_content', 'wpautop');
            remove_filter('the_excerpt', 'wpautop');
        }
        add_action('wp_dashboard_setup', [$this, 'add_dashboard_widget']);
        add_action('wp_ajax_rendermaterializecss_action', [$this, 'rendermaterializecss_action_callback']);
        add_filter('site_transient_update_plugins', [$this, 'disableDiviUpdateNotifications']);

//        add_action('admin_init', function () {
//            if (is_admin()) {
//                remove_menu_page('edit-comments.php');
//            }
//        });
    }


    function admin_theme_theme_init()
    {
        blade('admin');
    }

    function ThemeTheme_setup_menu()
    {
        add_menu_page('WeLoveYou', 'WeLoveYou', 'manage_options', 'themetheme', [$this, 'admin_theme_theme_init'], theme_resource_url() . "assets/dist/images/admin/theme_icon.png");

        add_action('admin_enqueue_scripts', [$this, 'register_admin_script']);
        add_action('admin_init', [$this, 'register_admin_settings']);
    }


    function register_admin_settings()
    {
        register_setting('theme_option_group', 'google_tag_manager_head');
        register_setting('theme_option_group', 'google_tag_manager_body');
        register_setting('theme_option_group', 'recaptcha_secret');
        register_setting('theme_option_group', 'recaptcha_sitekey');
        register_setting('theme_option_group', 'google_maps_api_key');
        register_setting('theme_option_group', 'menu_frontend_framework');
        register_setting('theme_option_group', 'enable_admin_menu');
        register_setting('theme_option_group', 'allow_svg');
        register_setting('theme_option_group', 'enable_wpautop');
        register_setting('theme_option_group', 'love_form_framework');
    }

    function register_admin_script($hook)
    {
        if ($hook != 'toplevel_page_themetheme') {
            return;
        }
        wp_enqueue_script('themethemeadmin', theme_resource_url() . 'assets/dist/js/admin.js', null, 'e8e09f526c438fd9409c7c1457cb60ef');
        wp_localize_script('themethemeadmin', 'theme', array(
            'nonce' => wp_create_nonce("theme_render_materializecss"),
            'nonceb' => wp_create_nonce("theme_render_bootstrap"),
        ));
    }

    function add_favicon()
    {
        $favicon_url = theme_resource_url() . 'assets/dist/images/admin/favicon-admin.png';
        echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
    }

    function allow_svg_in_tinymce($init)
    {
        $svgElemList = array(
            'a',
            'altGlyph',
            'altGlyphDef',
            'altGlyphItem',
            'animate',
            'animateColor',
            'animateMotion',
            'animateTransform',
            'circle',
            'clipPath',
            'color-profile',
            'cursor',
            'defs',
            'desc',
            'ellipse',
            'feBlend',
            'feColorMatrix',
            'feComponentTransfer',
            'feComposite',
            'feConvolveMatrix',
            'feDiffuseLighting',
            'feDisplacementMap',
            'deDistantLight',
            'feFlood',
            'feFuncA',
            'feFuncB',
            'feFuncG',
            'feFuncR',
            'feGaussianBlur',
            'feImage',
            'feMerge',
            'feMergeNode',
            'feMorphology',
            'feOffset',
            'fePointLight',
            'feSpecularLighting',
            'feSpotLight',
            'feTile',
            'feTurbulance',
            'filter',
            'font',
            'font-face',
            'font-face-format',
            'font-face-name',
            'font-face-src',
            'font-face-url',
            'foreignObject',
            'g',
            'glyph',
            'glyphRef',
            'hkern',
            'image',
            'line',
            'lineGradient',
            'marker',
            'mask',
            'metadata',
            'missing-glyph',
            'pmath',
            'path',
            'pattern',
            'polygon',
            'polyline',
            'radialGradient',
            'rect',
            'script',
            'set',
            'stop',
            'style',
            'svg',
            'switch',
            'symbol',
            'text',
            'textPath',
            'title',
            'tref',
            'tspan',
            'use',
            'view',
            'vkern'
        );

        // extended_valid_elements is the list of elements that TinyMCE allows. This checks
        // to make sure it exists, and then implodes the SVG element list and adds it. The
        // format of each element is 'element[attributes]'. The array is imploded, and turns
        // into something like '...svg[*],path[*]...'

        if (isset($init['extended_valid_elements'])) {
            $init['extended_valid_elements'] .= ',' . implode('[*],', $svgElemList) . '[*]';
        } else {
            $init['extended_valid_elements'] = implode('[*],', $svgElemList) . '[*]';
        }

        // return value
        return $init;
    }


    public function modifyCapapabilities()
    {
        $editorRole = get_role('editor');
        $editorRole->add_cap('edit_theme_options');
    }

    /**
     * Add a widget to the dashboard.
     *
     * This function is hooked into the 'wp_dashboard_setup' action below.
     */
    function add_dashboard_widget()
    {
        wp_add_dashboard_widget(
            'theme_dashboard_widget',
            'WeLoveYou',
            [$this, 'theme_dashboard_widget_function']
        );

        global $wp_meta_boxes;
        $normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
        $example_widget_backup = array('theme_dashboard_widget' => $normal_dashboard['theme_dashboard_widget']);
        unset($normal_dashboard['theme_dashboard_widget']);
        $sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);
        $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
    }

    /**
     * Create the function to output the contents of our Dashboard Widget.
     */
    function theme_dashboard_widget_function()
    {
        blade('themedashboardwidget');
    }

    function rendermaterializecss_action_callback()
    {
        check_ajax_referer('theme_render_materializecss', 'security');
        $scss = new Compiler();

        $scss->setEncoding("UTF-8");
        $scss->setImportPaths(get_template_directory() . "/bower_components/materialize/sass/");
        $scss->setFormatter("Leafo\ScssPhp\Formatter\Compressed");

        $sass = '@charset "UTF-8";
        
        @charset "UTF-8";
        
        // Color
        @import "components/color-variables";
        @import "components/color-classes";
        
        // Variables;
        @import "components/variables";
        
        // Reset
        @import "components/normalize";
        
        // components
        @import "components/global";
        @import "components/badges";
        @import "components/icons-material-design";';
        //$sass .= '@import "components/grid";';
        if (get_option('menu_frontend_framework') == 'materialize') { // Slider in den Theme Einstellungen aktivieren
            $sass .= '@import "components/navbar";';
        }
        $sass .= '
        @import "components/transitions";
        //@import "components/cards";
        //@import "components/toast";
        //@import "components/tabs";
        //@import "components/tooltip";
        //@import "components/buttons";
        @import "components/dropdown";
        //@import "components/waves";
        //@import "components/modal";
        //@import "components/collapsible";
        //@import "components/chips";
        //@import "components/materialbox";
        @import "components/forms/forms";
        //@import "components/table_of_contents";
        //@import "components/sidenav";
        //@import "components/preloader";
        //@import "components/slider";
        //@import "components/carousel";
        @import "components/tapTarget";
        @import "components/pulse";
        @import "components/datepicker";
        @import "components/timepicker";';


        $materializecssOut = $scss->compile($sass);

        $materializecssfile = get_template_directory() . '/materialize.css';
        file_put_contents($materializecssfile, $materializecssOut);


        $return = array(
            'success' => true,
        );
        wp_send_json($return);
    }

    function disableDiviUpdateNotifications($value)
    {
        if (isset($value) && is_object($value)) {
            unset($value->response['divi-builder/divi-builder.php']);
        }
        return $value;
    }
}
