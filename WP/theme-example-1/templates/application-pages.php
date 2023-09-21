<?php
/**
 * Template Name: Application Pages
 */
get_header();
?>

<section class="copy-block-section">
    <h1><?= the_title() ?></h1>
    <div class="copy-block-text">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; endif; ?>
    </div>
</section>
<?= do_shortcode('[application-pages]') ?>
<?php get_footer(); ?>
