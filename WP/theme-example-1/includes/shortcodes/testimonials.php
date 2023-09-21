<?php

add_shortcode("testimonials", "testimonials");

function testimonials($atts)
{
    $atts = shortcode_atts([
        'title' => 'title',
    ], $atts);
    $args = [
        'post_type'      => 'testimonial',
        'post_status'    => 'publish',
        'posts_per_page' => '-1',
    ];
    $posts = get_posts($args);

    ob_start();
    ?>
    <section class="testimonials">
        <div class="container">
            <h2><?= $atts['title'] ?></h2>
            <ul class="testimonials__items">
                <?php foreach ($posts as $post): ?>
                    <li class="testimonials__item">
                        <div class="testimonials__wrap">
                            <div class="testimonials__text"><?= apply_filters('the_content',$post->post_content) ?></div>
                            <div class="read-buttons">
                                <a class='more'> read more...</a>
                                <a class='less'> less</a>
                            </div>
                            <p class="testimonials__author"><?= @get_post_meta($post->ID, 'cmt_customer')[0] ?></p>
                            <p class="testimonials__position"><?= @get_post_meta($post->ID, 'cmt_company')[0] ?></p>
                        </div>
                        <a href="<?= @get_post_meta($post->ID, 'cmt_customer_website')[0] ?>" target="_blank"><img src="<?= get_the_post_thumbnail_url($post->ID) ?>" alt="Image"/></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <i class="testimonials__arrow arrow-left"></i>
            <i class="testimonials__arrow arrow-right"></i>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
