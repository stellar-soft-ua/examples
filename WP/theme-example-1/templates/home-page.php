<?php
/**
 * Template Name: Home Page
 */
?>
<?php
load_translation_home_page();
get_header();
$content = get_the_content();
$content = apply_filters('the_content', $content); ?>
<section class="top">
    <div class="container">
        <h2 class="top__title">
            <span class="top__span"><?= pll_e("Extend Your Reach™"); ?></span>
            <span class="top__span animate-strings"
                  data-text="<?= pll_e("Accessible, Portable, Metrology-Grade Instruments, Customizable"); ?>"></span>
        </h2>
        <div class="top__block">
            <div class="top__image">
                <?php $post_img = get_the_post_thumbnail_url(get_the_ID(), "full") ?>
                <img src="<?= $post_img ? $post_img : get_template_directory_uri() . "/assets/img/main-image.png" ?>" alt="Main image"
                     usemap="#Map"/>
                <img src="<?= get_template_directory_uri() ?>/assets/img/animation.gif" usemap="#Map"
                     class="animation-bg"/>

                <map name="Map" id="Map">
                    <area alt="" id="view-product-map" title="" href="#" shape="poly"
                          coords="247,135,336,82,411,124,425,126,425,156,321,215,248,162"/>
                    <area alt="" id="download-software-map" title="" href="#" shape="poly"
                          coords="471,234,600,160,607,159,602,151,604,8,614,3,820,124,820,279,814,278,815,294,691,369,684,370,471,247"/>
                </map>
                <div class="product-btn">
                    <a href="/50-ohm-vnas" class="img_link">
                        <span class="tooltiptext-left"><?= pll_e("View our product")?></span>
                        <div class="tooltiptext-left-arrow"></div>
                    </a>
                </div>
                <div class="download-btn">
                    <a href="/demo-the-software" class="img_link">
                        <span class="tooltiptext-right"><?= pll_e("Download Software page")?></span>
                        <div class="tooltiptext-left-arrow"></div>

                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="arrow-bottom"></div>
</section>
<?php
wp_reset_query();
while (have_posts()) : the_post();
    the_content();
endwhile;
wp_enqueue_script('cmt-delete-cookies', get_template_directory_uri() . '/assets/js/delete-cookies.js', ['cmt-jquery'], null, true);
wp_enqueue_script('cmt-delay',get_template_directory_uri().'/assets/js/delay-picture-loading.js',[],false,true);
?>
<?php get_footer(); ?>

