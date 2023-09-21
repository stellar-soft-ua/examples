<?php
/**
 * Template Name: Home Page
 */

get_header('section'); ?>
<main class="main home">
    <?php get_template_part('parts/home/home', 'section-1');  ?>
    <?php get_template_part('parts/home/home', 'section-2');  ?>
    <?php get_template_part('parts/home/home', 'section-3');  ?>
    <?php get_template_part('parts/home/home', 'section-4');  ?>
    <?php get_template_part('parts/home/home', 'section-5');  ?>
    <?php get_template_part('parts/home/home', 'section-6');  ?>
    <?php get_template_part('parts/home/home', 'section-7');  ?>
    <?php get_template_part('parts/home/home', 'section-8');  ?>
    <?php get_template_part('parts/home/home', 'section-9');  ?>
</main>
<?php get_footer('section'); ?>

