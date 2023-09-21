<?php
/**
 * Template Name: Elementor Videos Archive
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php the_content(); ?>
<?php endwhile; endif; ?>
<div class="search-results-wrapper" id="search-results-wrapper-id">
    <h4 class="search-results">Search results</h4>
    <div class="container" role="main" id="search-results-content-wrapper-id"></div>
</div>
<?php
wp_enqueue_script('elementor-pages-search');
wp_localize_script(
    'elementor-pages-search', 'cmt_elementor_pages_cpm_php_var',
    array(
        "ajaxurl" => admin_url('admin-ajax.php'),
        "cpm_key" => CPM_SHOW_IN_SEARCH_RESULTS_VIDEOS,
    )
);
get_footer(); ?>
