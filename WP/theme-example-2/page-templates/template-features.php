<?php
/**
 * Template Name: Features Page
 */

get_header('section');?>
<main class="main features">
    <?php get_template_part('parts/features/features', 'section-1');
get_template_part('parts/features/features', 'section-3');
get_template_part('parts/features/features', 'section-4');
get_template_part('parts/features/features', 'section-5'); ?>
</main>
<?php get_footer('section');?>