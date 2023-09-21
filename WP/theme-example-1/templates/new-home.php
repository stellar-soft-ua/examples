<?php
/**
 * Template Name: New Home
 */
?>
<?php
get_header();
$content = get_the_content();
$content = apply_filters('the_content', $content); ?>
<?php
wp_reset_query();
while (have_posts()) : the_post();
    the_content();
endwhile;
wp_enqueue_script('cmt-delete-cookies', get_template_directory_uri() . '/assets/js/delete-cookies.js', ['cmt-jquery'], null, true);
wp_enqueue_script('cmt-delay',get_template_directory_uri().'/assets/js/delay-picture-loading.js',[],false,true);
?>
<?php get_footer(); ?>

