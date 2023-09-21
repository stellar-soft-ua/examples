<?php
if (!class_exists('WP_Customize_Control')) {
    return null;
}

class Post_Dropdown_Custom_Control extends WP_Customize_Control
{
    private $posts = false;

    public function __construct($manager, $id, $args = [], $options = [])
    {
        $post_args = wp_parse_args($options, [
            'numberposts' => '-1',
            'post_status' => 'publish',
            'post_type'   => $args['post_type'],
            'exclude'     => [$args['post_main']]
        ]);
        $this->posts = get_posts($post_args);

        parent::__construct($manager, $id, $args);
    }

    public function render_content()
    {
        ?>
        <label>
            <span class="<?= $this->id; ?>-dropdown"><?= esc_html($this->label); ?></span>
            <select name="<?= $this->id; ?>" <?= $this->get_link(); ?>
                    id="<?= $this->id; ?>" <?php if (count($this->posts) == 0) {
                echo 'disabled="disabled"';
            } ?> >
                <?php
                foreach ($this->posts as $post) {
                    printf('<option value="%s" %s >%s</option>', $post->ID,
                        selected($this->value(), $post->ID, false), $post->post_title);
                }
                ?>
            </select>
        </label>
        <?php
    }

}