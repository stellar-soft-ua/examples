<?php

add_shortcode('cmt_leaderships', 'cmt_leadership_callback');

function cmt_leadership_callback($atts)
{
    $query = new WP_Query([
        'post_type'      => LEADERSHIP_POST_TYPE,
        'posts_per_page' => -1,
        'orderby'        => 'post_date',
        'order'          => 'DESC',
        'post_status'    => 'publish'
    ]);
    $atts = shortcode_atts([
        'title' => ''
    ], $atts);

    $title = $atts['title'];
    ob_start();
    ?>
    <section class="leadership">
        <div class="container">
            <?php if (!empty($title)): ?>
                <h2>
                    <?= $title ?>
                </h2>
            <?php endif; ?>
            <div class="products__list">
                <?php foreach ($query->posts as $post) : ?>
                    <div class="leadership-item">
                        <a href="#detail_<?= $post->ID ?>" rel="modal:open">
                            <div class="image-block">
                                <img src="<?= get_post_thumbnail($post) ?>"
                                     alt="Image">
                            </div>
                            <div class="product-preview__text">
                                <div class="leadership-block">
                                    <p class="product-preview__title"> <?= @get_post_custom_values('leadership_name',
                                            $post->ID)[0]; ?></p>
                                    <p class="product-preview__description"><?= $post->post_title ?></p>
                                </div>
                            </div>
                        </a>
                        <div id="detail_<?= $post->ID ?>" class="modal">
                            <div class="modal__items">
                                <div class="modal__item" id="features-item">
                                    <div class="modal-image-container">
                                        <img class="modal-application-img"
                                             src="<?= get_post_img($post->ID, 'application-img') ?>" alt="Images"/>
                                    </div>
                                    <div class="product-preview__wrap" style="padding: 15px;">
                                        <div class="application__content">
                                            <p class="leadership-name"><?= @get_post_custom_values('leadership_name',
                                                    $post->ID)[0]; ?></p>
                                            <p class="leadership-title"><?= $post->post_title ?></p>
                                            <div class="leadership-description" id="leadership-description">
                                                <?= apply_filters('the_content',  @get_post_custom_values('leadership_description',
                                                    $post->ID)[0])
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <i class="testimonials__arrow arrow-left arrow--about slick-arrow"></i>
            <i class="testimonials__arrow arrow-right arrow--about slick-arrow"></i>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
