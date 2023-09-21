<?php
/**
 * Template Name: Pro Reporting Page
 */

get_header('section');?>
<main class="main pro-reporting">
    <?php get_template_part('parts/pro-reporting/pro-reporting', 'section-1');
    get_template_part('parts/pro-reporting/pro-reporting', 'section-2');
    get_template_part('parts/pro-reporting/pro-reporting', 'section-3');
    get_template_part('parts/pro-reporting/pro-reporting', 'section-4');
    get_template_part('parts/pro-reporting/pro-reporting', 'section-5'); ?>
</main>
<?php get_footer('section');?>
