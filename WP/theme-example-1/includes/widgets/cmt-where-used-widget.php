<?php

class CMT_Where_Used_Widget extends WP_Widget //where-our-vnas-are-used
{
    private $fields;
    public function __construct()
    {
        $widget_ops = [
            'classname'                   => 'cmt-where-used-widget',
            'description'                 => 'CMT - Where Our Vnas Are Used',
            'customize_selective_refresh' => true,
        ];
        parent::__construct('cmt-where-used-widget', 'CMT - Where Our Vnas Are Used', $widget_ops);
        $this->alt_option_name = 'cmt_where_used_widget';

        $this->fields = [
            'title' => 'Title',
            'link'  => 'Link'
        ];
    }

    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
        $link = $instance['link'];
        ?>
        <section class="vnas">
            <div class="container">
                <?php if ($title) : ?>
                    <h2 class="vnas__title"><?= $title ?></h2>
                <?php endif; ?>

                <div class="vnas__items">
                    <div class="vnas__item"><img src="<?= get_template_directory_uri() ?>/assets/img/antenna.png"
                                                 alt="image"/>
                        <p class="vnas__text">Antennas</p>
                    </div>
                    <div class="vnas__item"><img src="<?= get_template_directory_uri() ?>/assets/img/filter-image.png"
                                                 alt="Image"/>
                        <p class="vnas__text">Filters</p>
                    </div>
                    <div class="vnas__item"><img src="<?= get_template_directory_uri() ?>/assets/img/radar-image.png"
                                                 alt="image"/>
                        <p class="vnas__text">Automotive radar</p>
                    </div>
                    <div class="vnas__item"><img src="<?= get_template_directory_uri() ?>/assets/img/mri-machines.png"
                                                 alt="image"/>
                        <p class="vnas__text">MRI machines</p>
                    </div>
                    <div class="vnas__item"><img src="<?= get_template_directory_uri() ?>/assets/img/humidity.png"
                                                 alt="image"/>
                        <p class="vnas__text">Humidity measurement</p>
                    </div>
                </div>
                <?php if ($link): ?>
                    <div class="vnas__btn"><a href="<?= $link ?>" class="btn">Tell Us About Your Application</a></div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }

    public function form($instance)
    {
        foreach($this->fields as $field =>$title) {
            $value = !empty($instance[$field]) ? $instance[$field] : '';
            ?>
            <p>
                <label for="<?= $this->get_field_id($field); ?>"><?php _e("$title:"); ?></label>
                <input class="widefat" id="<?= $this->get_field_id($field); ?>"
                       name="<?= $this->get_field_name($field); ?>" type="text" value="<?= esc_attr($value); ?>"/>
            </p>
            <?php
        }
    }

    public function update($new_instance, $old_instance)
    {
        $instance = [];

        foreach($this->fields as $field =>$title) {
            $instance[$field] = (!empty($new_instance[$field])) ? strip_tags($new_instance[$field]) : '';
        }

        return $instance;
    }
}