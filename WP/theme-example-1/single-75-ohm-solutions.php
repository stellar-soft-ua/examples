<?php get_header(); ?>
<?php $post = get_post(); ?>

<section class="product">
    <?php get_product_info( $post,'calibration_kits_category' ) ?>
</section>

<section class="related-block">
    <div class="container">
        <?php
        get_product_related( $post );
        ?>
    </div>
</section>

<section class="reviews">

    <div class="container">
        <div class="reviews__block">
            <?php get_product_review( $post ) ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
