<?php get_header(); ?>
<?php get_frequency_filter(FREQUENCY_EXTENSION_POST_TYPE,FREQUENCY_EXTENSION_TYPE,FREQUENCY_EXTENSION_VARIATIONS);?>

<section class="products">
    <div class="container" id="frequency-extension-product-list">
        <div class="products__block">
            <?php get_product_filter(FREQUENCY_EXTENSION_CATEGORY,FREQUENCY_EXTENSION_POST_TYPE, false); ?>
            <?php get_product_list(FREQUENCY_EXTENSION_POST_TYPE); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
