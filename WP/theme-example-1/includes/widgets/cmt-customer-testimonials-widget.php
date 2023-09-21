<?php

class CMT_Customer_Testimonials_Widget extends WP_Widget
{
    public function __construct()
    {
        $widget_ops = [
            'classname'                   => 'cmt-customer-testimonials-widget',
            'description'                 => 'CMT - Customer Testimonials',
            'customize_selective_refresh' => true,
        ];
        parent::__construct('cmt-customer-testimonials-widget', 'CMT - Customer Testimonials', $widget_ops);
        $this->alt_option_name = 'cmt-customer-testimonials-widget';
    }

    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title',
            empty($instance['title']) ? '' : $instance['title']);
        ?>
        <section class="testimonials">
            <div class="container">
                <?php if ($title) : ?>
                    <h2>
                        <?= $title ?>
                    </h2>
                <?php endif; ?>
                <ul class="testimonials__items">
                    <?php
                    $query = new WP_Query(['post_type' => 'testimonial']);
                    $posts = $query->posts;
                    foreach ($posts as $post) {
                        ?>
                        <li class="testimonials__item">
                            <div class="testimonials__wrap">
                                <p class="testimonials__text">
                                    <?= $post->post_content ?>
                                </p>
                                <p class="testimonials__author">
                                    <?= @get_post_meta($post->ID, 'cmt_customer')[0] ?>
                                </p>
                                <p class="testimonials__position">
                                    <?= @get_post_meta($post->ID, 'cmt_company')[0] ?>
                                </p>
                            </div>
                            <div>
                                <img class="testimonials_image"
                                     src=<?= get_the_post_thumbnail_url($post->ID) ?> alt="Image">
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <i class="testimonials__arrow arrow-left"></i>
                <i class="testimonials__arrow arrow-right"></i>
            </div>
        </section>
        <?php
    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?= $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?= $this->get_field_id('title'); ?>"
                   name="<?= $this->get_field_name('title'); ?>" type="text" value="<?= esc_attr($title); ?>"/>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
}