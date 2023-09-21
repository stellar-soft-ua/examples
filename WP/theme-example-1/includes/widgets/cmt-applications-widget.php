<?php

class CMT_Applications_Widget extends WP_Widget
{
    public function __construct()
    {
        $widget_ops = [
            'classname' => 'cmt-applications-widget',
            'description' => 'CMT - Applications',
            'customize_selective_refresh' => true,
        ];
        parent::__construct('cmt-applications-widget', 'CMT - Applications', $widget_ops);
        $this->alt_option_name = 'cmt_applications_widget';
    }


    public function widget($args, $instance)
    {
        $title = (!empty($instance['title'])) ? $instance['title'] : '';

        $number = (!empty($instance['number'])) ? absint($instance['number']) : 2;
        if (!$number) {
            $number = 2;
        }

        $query = new WP_Query([
            'post_type' => 'application',
            'posts_per_page' => $number,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_status' => 'publish'
        ]);
        if (!$query->have_posts()) {
            return;
        }
        ?>
        <section class="features">
            <div class="container">
                <?php if (!empty($title)): ?>
                    <h2 class="features__title">
                        <?= $title ?>
                    </h2>
                <?php endif; ?>
                <div class="features__items">
                    <?php foreach ($query->posts as $key => $post) : ?>
                        <div class="features__item">
                            <div class="features__text">
                                <p>
                                    <?= $post->post_content ?>
                                </p>
                            </div>
                            <img src="<?= $this->get_post_image($post->ID); ?>" class="features__img"
                                 alt="Main item">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['number'] = (int)$new_instance['number'];

        return $instance;
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 2;
        ?>
        <p><label for="<?= $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <textarea id="<?= $this->get_field_id('title'); ?>"
                      name="<?= $this->get_field_name('title'); ?>" rows="5" cols="55"><?= $title; ?></textarea></p>

        <p><label for="<?= $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
            <input id="<?= $this->get_field_id('number'); ?>"
                   name="<?= $this->get_field_name('number'); ?>" type="number" step="1" min="1"
                   value="<?= $number; ?>" size="3"/></p>
        <?php
    }


    //Return placeholder if image does not exist
    private function get_post_image($postId)
    {
        $postImgUrl = get_the_post_thumbnail_url($postId);
        if (!empty($postImgUrl)) {
            return $postImgUrl;
        }
        return get_template_directory_uri() . "/assets/img/placeholder.png";
    }
}
