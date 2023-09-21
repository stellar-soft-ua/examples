<?php
/**
 * Template Name: Careers
 */

get_header();
global $post;

$img_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full')[0];
$args    = [
    'post_type'   => 'position',
    'post_status' => 'publish'
];

$query   = new WP_Query;
$_posts  = $query->query($args); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php the_content(); ?>
<?php endwhile; endif; ?>

    <section class="careers">
        <div class="container">
            <div class="careers__wrap">
                <a href="<?= get_permalink(get_theme_mod('cmt_career_positions_url')) ?>" class="btn" target="_blank">View All Open
                    Positions</a>
            </div>
        </div>
        <div class="careers__image" style="background-image: url(<?= $img_url ? $img_url : '' ?>) !important;"></div>
    </section>
<?php get_footer() ?>
