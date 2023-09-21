<?php
/**
 * Template Name: 75 Ohm Solutions
 */

get_header(); ?>

    <section class="products">
        <div class="container" id="products-lists">
            <div class="products__block">
                <?php get_product_filter(VNA_CATEGORY,[VNA_POST_TYPE,CALIBRATION_KITS_POST_TYPE], true); ?>
                <?php get_product_list([VNA_POST_TYPE,CALIBRATION_KITS_POST_TYPE], 75); ?>
            </div>
        </div>
        <input type="hidden" value="75" id="impedance"/>
    </section>

<?php get_footer(); ?>