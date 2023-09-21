<?php get_header(); ?>
<?php
$page_data = get_page_by_path('applications');
$page_id = $page_data->ID;
$img_url = wp_get_attachment_image_src(get_post_thumbnail_id($page_id), 'full')[0];
?>
    <section class="careers-text">
        <div class="container">
            <h1><?= $page_data->post_title ?></h1>
            <div class="careers-text__wrap">
                <?= apply_filters('the_content',$page_data->post_content) ?>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="features__items">
                <?php
                $args = [
                    'post_type'      => 'application',
                    'post_status'    => 'publish',
                    'posts_per_page' => $posts_per_page,
                ];
                $query = new WP_Query;
                $posts = $query->query($args); ?>
                <?php foreach ($posts as $post): ?>
                    <?php $application_preview = get_the_post_thumbnail_url($post->ID, 'application-img'); ?>
                    <div class="features__item" id="features-item <?=$post->ID?>">
                        <div class="application-image-wrap">
                            <img class="features__img"
                                 src="<?= $application_preview ? $application_preview : 'http://placehold.it/445x295' ?>"/>
                        </div>
                        <div class="application__text" id="application-text">
                            <h3 class="application__title"><?= $post->post_title ?></h3>
                            <div class="text-readmore">
                                <div class="application__content" id="application-content"><?=apply_filters('the_content', $post->post_content) ?></div>
                            </div>
                            <div class="read-buttons">
                                <a href='#' class='more'> read more...</a>
                                <a href='#' class='less'> less</a>
                            </div>
                            <div class="application__buttons">
                            <div class="app-action-buttons">
                                <?php $app_link = @get_post_custom_values( 'cmt_app_btn_link', $post->ID )[0];
                                if ( $app_link ):?>
                                    <a class="application__btn btn"
                                       href="<?= $app_link ?>"
                                       target="_blank"><?= @get_post_custom_values('cmt_app_btn_text', $post->ID)[0]; ?></a>
                                <?php endif; ?>
                                <?php $testimonal_btn = @get_post_custom_values('cmt_testimonial_btn_text', $post->ID)[0];
                                if ( $testimonal_btn ):?>
                                    <a class="application__btn btn"
                                       href="#detail_<?= $post->ID ?>"
                                       rel="modal:open"><?= $testimonal_btn ?></a>
                                <?php endif; ?>
                            </div>
                            </div>
                        </div>
                        <div id="detail_<?= $post->ID ?>" class="modal">
                            <?php
                            $testimonial_id = @get_post_custom_values('testimonial', $post->ID)[0];
                            $testimonal = get_post($testimonial_id);
                            ?>
                            <div class="modal__items">
                                <div class="modal__item" id="features-item">
                                    <div class="modal-image-container">
                                        <img class="modal-application-img modal-testimonials-img"
                                             src="<?= get_post_img($testimonial_id) ?>" alt="Images"/>
                                    </div>
                                    <div class="product-preview__wrap" style="padding: 15px;">
                                        <div class="application__content">
                                            <p class="leadership-name"><?= $testimonal->post_title ?></p>
                                            <p class="leadership-description" id="leadership-description">
                                                <?= $testimonal->post_content?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php get_footer(); ?>