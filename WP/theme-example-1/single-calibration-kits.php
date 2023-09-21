<?php get_header(); ?>
<?php $post = get_post(); ?>

<section class="product calibration-kits-products">
    <?php get_product_info( $post,'calibration_kits_category' ) ?>
</section>

<section class="related-block">
    <div class="container">
        <?php
        get_product_related( $post, 'calibration_kits_category' );
        ?>
    </div>
</section>

<?php get_footer(); ?>
