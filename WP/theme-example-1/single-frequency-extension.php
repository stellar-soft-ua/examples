<?php get_header(); ?>
<?php $post = get_post(); ?>

<section class="product">
    <?php get_product_info( $post ,FREQUENCY_EXTENSION_CATEGORY) ?>
</section>

<section class="related-block">
    <div class="container">
        <?php
        get_product_related( $post, FREQUENCY_EXTENSION_CATEGORY );
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
