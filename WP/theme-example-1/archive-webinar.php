<?php get_header(); ?>

<div class="webinars-page">
    <?php
    $webinar_page = get_page_by_path('webinar');
    $category = get_terms([
        'taxonomy'   => 'webinar_category',
        'hide_empty' => true,
    ]);
    if ($webinar_page): ?>
        <?= apply_filters('the_content', $webinar_page->post_content) ?>
    <?php endif; ?>
    <section class="webinars">
        <div class="container">
            <div class="form-wrap">
                <div class="input-search__wrap">
                    <input type="text" placeholder="Search" id="webinarSearch"/>
                    <span class="clear-icon"></span>
                    <span class="search-icon"></span>
                </div>
                <select id="webinarSelect" class="tech-category-filter">
                    <option value="all">All</option>
                    <?php foreach ($category as $cat): ?>
                        <option value="<?= $cat->term_id ?>"><?= $cat->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="webinars__cards">
                <?php
                $query = new WP_Query([
                    'post_type'      => 'webinar',
                    'posts_per_page' => -1,
                    'orderby'        => 'post_date',
                    'order'          => 'DESC',
                    'post_status'    => 'publish'
                ]);
                foreach ($query->posts as $post) : $post_category = get_webinar_categories_by_post_id($post->ID);?>
                    <div class="product-preview product-preview--posts"
                        data-category="<?= get_webinar_categories_by_post_id($post->ID) ?>">
                        <div class="image-block">
                            <img src="<?= get_post_thumbnail($post) ?>"/>
                        </div>
                        <div class="product-preview__text">
                            <div class="product-preview__wrap">
                                <div>
                                    <p class="product-preview__title">
                                        <?= $post->post_title ?>
                                    </p>
                                </div>
                                <?php if(str_replace(' ','',$post_category)!=='recorded'):?>
                                    <p class="product-preview__description webinar-date"><?= get_webinar_date_by_id($post->ID) ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="hover-block hover-block--posts">
                                <div class="hover-block__text">
                                    <div>
                                        <div class="blog-short-description">
                                            <?= apply_filters('the_content', $post->post_content); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= get_post_permalink($post) ?>" class="hover-block__link btn">Read More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <i class="testimonials__arrow arrow-left"></i>
            <i class="testimonials__arrow arrow-right"></i>
        </div>
    </section>
</div>

<?php
wp_enqueue_script('cmt-script-webinar-date', get_template_directory_uri() . '/assets/js/webinarDate.js', ['jquery'], false, true);
wp_enqueue_script('cmt-search-webinars', get_template_directory_uri() . '/assets/js/search-webinars.js', ['jquery'], false, true);
wp_enqueue_script('cmt-slick', get_template_directory_uri() . '/assets/js/slick-slider.js', ['jquery'], false, true);
get_footer();
?>
