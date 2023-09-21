<?php
add_shortcode('where_vnas', 'cmt_where_vnas_callback');

function cmt_where_vnas_callback($atts)
{
    $atts = shortcode_atts([
        'number_of_posts' => '',
        'title'           => '',
        'btn_text'        => '',
        'btn_link'        => '',
        'is_anchored'     => false
    ], $atts);

    $title = $atts['title'];
    $btn_text = $atts['btn_text'];
    $btn_link = $atts['btn_link'];
    $is_anchored = $atts['is_anchored'];

    $number_of_posts = (!empty($atts['number_of_posts'])) ? absint($atts['number_of_posts']) : -1;
    if (!$number_of_posts) {
        $number_of_posts = -1;
    }

    $query = new WP_Query([
        'post_type'      => 'where_vnas',
        'posts_per_page' => $number_of_posts,
        'orderby'        => 'post_date',
        'order'          => 'DESC',
        'post_status'    => 'publish'
    ]);
    if (!$query->have_posts()) {
        return;
    }
    ob_start();
    ?>
    <section class="vnas">
        <div class="container">
            <?php if (!empty($title)) : ?>
                <h2 class="vnas__title"><?= $title ?></h2>
            <?php endif; ?>
            <div class="vnas__items">
                <?php foreach ($query->posts as $post): $link = get_post_custom_values('application_id',
                    $post->ID)[0] ?>
                    <div class="vnas__item">
                        <?php if ($is_anchored && $link): ?>
                            <a href="#" class="anchor-vnas" data-anchor="<?= $link ? $link : '' ?>">
                                <img src="<?= get_post_thumbnail($post) ?>" alt="Image"/>
                                <p class="vnas__text"><?= $post->post_title ?></p>
                            </a>
                        <?php else: ?>
                            <img src="<?= get_post_thumbnail($post) ?>" alt="Image"/>
                            <p class="vnas__text"><?= $post->post_title ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($btn_text)) : ?>
                <div class="vnas__btn">
                    <a href="<?= $btn_link ?>" class="btn" target="_blank"><?= $btn_text ?></a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
