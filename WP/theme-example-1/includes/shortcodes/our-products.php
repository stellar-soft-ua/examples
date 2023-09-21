<?php
add_shortcode("our_products", "cmt_our_products_callback");

function cmt_our_products_callback($atts)
{

    $query = new WP_Query([
        'post_type' => PRODUCT_POST_TYPE,
        'posts_per_page' => 6,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'post_status' => 'publish'
    ]);

    if (!$query->have_posts()) {
        return;
    }

    ob_start();
    ?>
    <section class="our-products">
        <div class="container">
            <div class="top-block">
                <div class="our-products__items">
                    <?php foreach ($query->posts as $index => $post) : ?>
                        <div class="our-products__item" data-product-index="<?= $index + 1 ?>">
                            <div class="image-block our-products-image">
                                <img class="no-lazy" data-src="<?=get_post_thumbnail($post)?>"alt="Image"/>
                            </div>
                            <div>
                                <p><?= $post->post_title ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="our-products__info">
                <?php foreach ($query->posts as $index => $post): ?>
                <div class="our-products__item-info" data-product-index="<?= $index + 1 ?>">
                    <div class="our-products__wrap">
                        <div class="our-products__img">
                            <img class="no-lazy" data-src="<?= wp_get_attachment_image_src(get_post_meta($post->ID, 'image_upload_val', true), 'full')[0]?>"/>
                        </div>
                        <div class="our-products__description">
                            <?= apply_filters('the_content', $post->post_content) ?>
                            <div class="our-products__btns">
                                <a href="<?= get_post_meta($post->ID, 'cmt_see_btn_link', true)?>" class="btn">
                                    <?= get_post_meta($post->ID, 'cmt_see_btn_text', true) ?></a>
                                <a href="<?= get_post_meta($post->ID, 'cmt_download_btn_link', true)?>" class="btn">
                                    <?= get_post_meta($post->ID, 'cmt_download_btn_text', true) ?></a>
                                <a href="<?= get_post_meta($post->ID, 'cmt_demo_btn_link', true)?>" class="btn" target="_blank">
                                    <?= get_post_meta($post->ID, 'cmt_demo_btn_text', true) ?></a>
                                <a href="<?= get_post_meta($post->ID, 'cmt_contact_btn_link', true)?>" class="btn" target="_blank">
                                    <?= get_post_meta($post->ID, 'cmt_contact_btn_text', true) ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
