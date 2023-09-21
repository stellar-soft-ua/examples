<?php
/**
 * Template Name: About Pro Page
 */

get_header();?>
<main class="main about-pro">
    <?php get_template_part('parts/about-pro/about-pro', 'section-1');
get_template_part('parts/about-pro/about-pro', 'section-2');
get_template_part('parts/about-pro/about-pro', 'section-3');
get_template_part('parts/about-pro/about-pro', 'section-4');
get_template_part('parts/about-pro/about-pro', 'section-5');?>
</main>
<?php get_footer();?>
