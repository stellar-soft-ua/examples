<?php
/**
 * Template Name: Integrations
 */
get_header(); ?>
<section class="copy-block-section">
    <h1><?= the_title() ?></h1>
    <div class="copy-block-text">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; endif; ?>
    </div>
</section>
<?php
$category = get_terms([
    'taxonomy'   => 'integration_category',
    'hide_empty' => false,
]);
?>
<section class="application-pages-section integrations">
    <div class="integrations-filter">
        <div class="form-wrap">
            <div class="input-search__wrap integrations-search">
                <input type="text" placeholder="Search" id="webinarSearch"/>
                <span class="clear-icon"></span>
                <span class="search-icon"></span>
            </div>
            <select id="webinarSelect" class="tech-category-filter integrations-filter">
                <option value="">All</option>
                <?php foreach ($category as $cat): ?>
                    <option value="<?= $cat->slug ?>"><?= $cat->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
<?=get_integrations()?>
</section>
<?php
wp_enqueue_script('search-integrations',get_template_directory_uri().'/assets/js/search-integrations.js',['cmt-jquery'],false,true);
get_footer();?>
