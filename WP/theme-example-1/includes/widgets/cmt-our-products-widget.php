<?php

class CMT_Our_Products_Widget extends WP_Widget
{
    private static $fields = [
        'title' => 'Title',
        'link'  => 'Link'
    ];

    public function __construct()
    {
        $widget_ops = [
            'classname'                   => 'cmt-our-products-widget',
            'description'                 => 'CMT - Our Products',
            'customize_selective_refresh' => true,
        ];
        parent::__construct('cmt-our-products-widget', 'CMT - Our Products', $widget_ops);
        $this->alt_option_name = 'cmt_our_products_widget';
    }

    public function widget($args, $instance)
    {
        $title                 = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
        $link                  = $instance['link'];

        $products = get_posts([
            'numberposts' => 6,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => PRODUCT_POST_TYPE,
            'post_status' => 'publish',
        ]);

        ?>
        <section class="goods">
            <div class="container">
                <?php if ($title): ?>
                    <h2><?= $title ?></h2>
                <?php endif; ?>
                <div class="goods__items">
                    <?php foreach ($products as $product): ?>
                        <div class="product-preview product-preview--small border-green">
                            <div class="image-block">
                                <?php $product_preview = get_the_post_thumbnail_url($product->ID, 'product-custom'); ?>
                                <img src="<?= $product_preview ? $product_preview : get_template_directory_uri() . "/assets/img/placeholder.png" ?>" alt="Image"
                                     class="item__image">
                            </div>
                            <div class="product-preview__text">
                                <p class="product-preview__title"><?= $product->post_title ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ($link): ?>
                    <div class="goods__buttons">
                        <a href="<?= $link ?>" class="goods__btn btn">Test Drive a VNA</a>
                        <div class="goods__line line"></div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }

    public function form($instance)
    {
        $instance['selected_products'] = isset($instance['selected_products']) ? $instance['selected_products'] : '';

        $products = get_posts([
            'post_type'      => PRODUCT_POST_TYPE,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'posts_per_page' => -1
        ]);

        foreach (self::$fields as $field => $title) {
            $value = ! empty($instance[$field]) ? $instance[$field] : ''; ?>
            <p>
                <label for="<?= $this->get_field_id($field); ?>"><?php _e("$title:"); ?></label>
                <input class="widefat" id="<?= $this->get_field_id($field); ?>"
                       name="<?= $this->get_field_name($field); ?>" type="text" value="<?= esc_attr($value); ?>"/>
            </p>
            <?php
        }

        ?> <p> <?php
        if ( ! $products) {
            echo 'No posts found';
        }
        ?> </p> <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = [];

        foreach (self::$fields as $field => $title) {
            $instance[$field] = ( ! empty($new_instance[$field])) ? strip_tags($new_instance[$field]) : '';
        }

        return $instance;
    }
}
