<?php
function get_product_related($post, $tax)
{
    $product_id = get_post_meta($post->ID, 'product_id')[0];
    $is_auto = @get_post_custom_values('auto_related_content', $post->ID)[0];
    if ($is_auto == "on") {
        $related_product_content = get_related_posts($product_id);
    } else {
        $related_product_content = get_post_meta($post->ID, 'related-product-post')[0];
    }
    $related_args = [
        'ID'        => $related_product_content,
        'post_type' => [CALIBRATION_KITS_POST_TYPE, VNA_POST_TYPE],
        'post__in'  => $related_product_content
    ];
    $related_items = get_posts($related_args);
    $post_type = get_post_type($post);
    $title = $post_type == CALIBRATION_KITS_POST_TYPE ? "Related Products" : "Recommended Accessories and Calibration Kits";

    if ($related_items && $related_product_content):?>
        <h2 class="related-block__title"><?= $title ?></h2>
        <div class="related-block__items">
            <?php foreach ($related_items as $item): ?>
                <?php
                $post_type = get_post_type($item->ID);
                $taxonomy = get_object_taxonomies($post_type)[1];
                $solutions_taxonomy = get_object_taxonomies($post_type)[4];
                $terms = get_the_terms($item->ID, $taxonomy);
                $solutions_terms = false;
                if($solutions_taxonomy == 'vna_application_solutions'){
                    $solutions_terms = get_the_terms($item->ID, $solutions_taxonomy);
                }
                if ($solutions_terms) {
                    $t_id          = $solutions_terms[0]->term_id;
                    $product_color = get_option("taxonomy_term_$t_id");
                } else {
                    $t_id          = $terms[0]->term_id;
                    $product_color = get_option("taxonomy_term_$t_id");
                }
                ?>
                <div class="product-preview <?= $product_color["tax_color"] ? $product_color["tax_color"] : 'border-green' ?>  product-preview--related">
                    <a href="<?= the_permalink($item->ID) ?>" target="_blank">
                        <div class="image-block">
                            <img src="<?= get_the_post_thumbnail_url($item->ID) ? get_the_post_thumbnail_url($item->ID) : get_template_directory_uri() . "/assets/img/placeholder.png" ?>"
                                 alt="Image"
                                 class="item__image"/></div>
                        <div class="product-preview__text">
                            <p class="product-preview__title"><?= $item->post_title ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <i class="testimonials__arrow arrow-left slick-arrow" style="display: block;"></i>
        <i class="testimonials__arrow arrow-right slick-arrow" style="display: block;"></i>
    <?php endif;
}
