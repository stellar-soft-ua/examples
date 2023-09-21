<?php

class CMT_Banners_Widget extends WP_Widget
{
    public function __construct()
    {
        $widget_ops = [
            'classname' => 'cmt-banners-widget',
            'description' => 'CMT - Banners',
            'customize_selective_refresh' => true,
        ];
        parent::__construct('cmt-banners-widget', 'CMT - Banners', $widget_ops);
        $this->alt_option_name = 'cmt_banners_widget';
    }


    public function widget($args, $instance)
    {
        $title = (!empty($instance['title'])) ? $instance['title'] : '';


        $query = new WP_Query([
            'post_type' => 'banner',
            'posts_per_page' => -1,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_status' => 'publish'
        ]);
        if (!$query->have_posts()) {
            return;
        }
        ?>
        <section class="slider-big">
            <div class="container">
                <?php if (!empty($title)): ?>
                    <h2>
                        <?= $title ?>
                    </h2>
                <?php endif; ?>
                <div class="slider-big__wrap">

                    <?php foreach ($query->posts as $post) : ?>
                        <div class="slider-big__slide">
                            <?php $this->generate_banner_post($post->ID) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="slider-big__arrows">
                    <i class="slider-big__arrow arrow-left"></i>
                    <i class="slider-big__arrow arrow-right"></i>
                </div>
            </div>
        </section>

        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);

        return $instance;
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        ?>
        <p><label for="<?= $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?= $this->get_field_id('title'); ?>"
                   name="<?= $this->get_field_name('title'); ?>" type="text" value="<?= esc_attr($title); ?>"/>
        <?php
    }


    //Return placeholder if image does not exist
    private function get_post_image($post_id)
    {
        $post_img_url = get_the_post_thumbnail_url($post_id, 'banner-img');
        if (!empty($post_img_url)) {
            return $post_img_url;
        }
        return get_template_directory_uri() . "/assets/img/placeholder-450x157.png";
    }


    private function generate_banner_post($post_id)
    {
        $post_link = get_post_meta($post_id, 'cmt_banner_meta_url', true);

        if (!empty($post_link)) :
            ?>
            <a href="<?= $post_link ?>">
                <img src="<?= $this->get_post_image($post_id) ?>" alt="Images"/>
            </a>
        <?php
        else :
            ?>
            <img src="<?= $this->get_post_image($post_id) ?>" alt="Images"/>
        <?php

        endif;
    }

}
