<?php

class CMT_Partners_Widget extends WP_Widget
{
    public function __construct()
    {
        $widget_ops = [
            'classname' => 'cmt-partners-widget',
            'description' => 'CMT - Partners',
            'customize_selective_refresh' => true,
        ];
        parent::__construct('cmt-partners-widget', 'CMT - Partners', $widget_ops);
        $this->alt_option_name = 'cmt_partners_widget';
    }


    public function widget($args, $instance)
    {
        $title = (!empty($instance['title'])) ? $instance['title'] : '';


        $query = new WP_Query([
            'post_type' => 'partner',
            'posts_per_page' => -1,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_status' => 'publish'
        ]);
        if (!$query->have_posts()) {
            return;
        }
        ?>
        <section class="testimonials">
            <div class="container">
                <?php if (!empty($title)): ?>
                    <h2>
                        <?= $title ?>
                    </h2>
                <?php endif; ?>
                <ul class="testimonials__items">

                    <?php foreach ($query->posts as $post) : ?>
                        <li class="testimonials__item">
                            <img src="<?= $this->get_post_image($post->ID) ?>" alt="Image"/>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <i class="testimonials__arrow arrow-left arrow--about"></i>
                <i class="testimonials__arrow arrow-right arrow--about"></i>
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
        $post_img_url = get_the_post_thumbnail_url($post_id, 'partner-img');
        if (!empty($post_img_url)) {
            return $post_img_url;
        }
        return get_template_directory_uri() . "/assets/img/placeholder-250x76.png";
    }
}
