<?php
add_shortcode('cmt_applications', 'cmt_applications_callback');

function cmt_applications_callback($atts)
{
    $atts = shortcode_atts([
        'title'           => '',
        'number_of_posts' => 2
    ], $atts);


    $title = $atts['title'];

    $number = (!empty($atts['number_of_posts'])) ? absint($atts['number_of_posts']) : 2;

    if (!$number) {
        $number = 2;
    }

    $query = new WP_Query([
        'post_type'      => 'application',
        'posts_per_page' => $number,
        'orderby'        => 'post_date',
        'order'          => 'DESC',
        'post_status'    => 'publish'
    ]);
    if (!$query->have_posts()) {
        return;
    }
    ob_start();
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
                            <div class="ellipsis">
                                <p>
                                    <?= $post->post_content ?>
                                </p>
                            </div>
                        </div>
                        <img src="<?= get_post_thumbnail($post) ?>" class="features__img"
                             alt="Main item">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
