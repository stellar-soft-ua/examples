<?php get_header(); ?>

<section class="products">
    <div class="container" id="products-lists">
        <div class="products__block">
            <?php get_product_filter(CALIBRATION_KITS_AND_ACCESSORIES_CATEGORY,CALIBRATION_KITS_POST_TYPE, false); ?>
            <?php get_product_list(CALIBRATION_KITS_POST_TYPE, 50); ?>
        </div>
    </div>
    <input type="hidden" value="50" id="impedance"/>
</section>
<?php get_footer(); ?>
