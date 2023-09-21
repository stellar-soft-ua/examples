<?php
/**
 * Template Name: 50 Ohm VNA
 */

get_header(); ?>
    <?php get_upper_frequency_filter(VNA_POST_TYPE,50,VNA_PORTS,VNA_UPPER_FREQUENCY) ?>
    <section class="products">
        <div class="container">
            <div class="products__block">
                <?php get_upper_categories([VNA_CATEGORY,VNA_APPLICATION_SOLUTIONS], VNA_POST_TYPE); ?>
                <?php get_product_list(VNA_POST_TYPE, 50); ?>
            </div>
        </div>
        <input type="hidden" value="50" id="impedance"/>
    </section>

<?php get_footer(); ?>