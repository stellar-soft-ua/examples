<?php

namespace THEME\Theme;


class WooCommerce
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        // Add WooCommerce settings like default_columns with this tutorial:
        // https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
        add_action('after_setup_theme', [$this, 'theme_add_woocommerce_support']);
        // add_action('woocommerce_before_single_product_summary', [$this, 'theme_back_to_store']);

        // WooCommerce Styles/CSS deaktivieren
        add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    }

    function theme_add_woocommerce_support()
    {
        add_theme_support('woocommerce');
    }

    function theme_back_to_store()
    {
        ?>
        <div><a class="green-link wc-backward"
                href="<?php echo get_permalink(wc_get_page_id('shop')); ?>"><?php _e('Return to Store', 'theme') ?></a>
        </div>
        <?php
    }

}
