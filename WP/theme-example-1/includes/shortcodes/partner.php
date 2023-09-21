<?php

add_shortcode('cmt_partners', 'cmt_partner_callback');

function cmt_partner_callback($atts)
{
    $query = new WP_Query([
        'post_type'      => PARTNER_POST_TYPE,
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
    <section class="testimonials">
        <div class="container">
            <?php if (!empty($title)): ?>
                <h2>
                    <?= $title ?>
                </h2>
            <?php endif; ?>
            <ul class="testimonials__items">
                <?php foreach ($query->posts as $post) : ?>
                    <li class="testimonials__item partner-item">
                        <a href="#detail_<?= $post->ID ?>" rel="modal:open" id="partner-modal-open">
                            <p class="partner-bottom-text">
                                <?= get_post_custom_values('partner_short_description', $post->ID)[0] ?>
                            </p>
                        </a>
                        <a href=" <?= get_post_custom_values('partner_website_url', $post->ID)[0] ?>" target="_blank">
                            <img src=<?= get_post_thumbnail($post) ?> alt="Image"/>
                        </a>
                            <div class="truncate partner-text" ><?= apply_filters('the_content', $post->post_content) ?></div>
                            <p class="overflow-dots">...</p>

                        <div id="detail_<?= $post->ID ?>" class="modal">
                            <div class="modal__items">
                                <div class="modal__item" id="features-item">
                                    <div class="modal-image-container partners-image">
                                        <a href=" <?= get_post_custom_values('partner_website_url', $post->ID)[0] ?>" target="_blank">
                                            <img class="modal-application-img"
                                                 src="<?= get_post_img($post->ID) ?>" alt="Images"/>
                                        </a>
                                    </div>
                                    <div class="product-preview__wrap" style="padding: 15px;">
                                        <div class="application__content">
                                            <p class="leadership-name"><?= $post->post_title ?></p>
                                            <div class="leadership-description" id="leadership-description">
                                                <?= apply_filters('the_content',$post->post_content)?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <i class="testimonials__arrow arrow-left arrow--about"></i>
            <i class="testimonials__arrow arrow-right arrow--about"></i>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
