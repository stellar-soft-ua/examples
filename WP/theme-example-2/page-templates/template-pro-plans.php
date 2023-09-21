<?php
/**
 * Template Name: Pro Plans Page
 */

get_header('section');?>
<main class="main pro-plans">
    <?php get_template_part('parts/pro-plans/pro-plans', 'section-1');
get_template_part('parts/pro-plans/pro-plans', 'section-2');
get_template_part('parts/pro-plans/pro-plans', 'section-3');?>
</main>
<?php get_footer('section');?>