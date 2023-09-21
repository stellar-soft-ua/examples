<?php
add_shortcode("add_post", "add_post_to_page");

function add_post_to_page($atts)
{
    $atts = shortcode_atts([
        'id' => '',
    ], $atts);

    ob_start();
    $args = [
        'p' => $atts['id'],
        'post_type' => 'any',
    ];
    $query = new WP_Query;
    $posts = $query->query($args);
    ?>
        <?php foreach ($posts as $post): ?>
    <?php
    $price         = @get_post_custom_values('product_price', $post->ID)[0];
    $price_to      = @get_post_custom_values('product_price_to', $post->ID)[0];
    $post_type = get_post_type($post->ID);
    $taxonomy = get_object_taxonomies($post_type)[1];
    $terms         = get_the_terms($post->ID, $taxonomy);
    $t_id          = $terms[0]->term_id;
    $product_color = get_option("taxonomy_term_$t_id");
    ?>
    <div class="inserted-post product-preview <?= $product_color["tax_color"] ? $product_color["tax_color"] : 'border-green' ?>">
        <div class="image-block">
            <?php $product_preview = get_the_post_thumbnail_url($post->ID, 'product-preview'); ?>
            <a href="<?= get_the_permalink($post->ID) ?>"><img
                        src="<?= $product_preview ? $product_preview : get_template_directory_uri() . "/assets/img/placeholder.png" ?>"
                        alt="Image"></a>
        </div>
        <div class="product-preview__text inserted-product-preview__text">
            <div class="product-preview__wrap">
                <p class="product-preview__title"><?= $post->post_title ?></p>
                <?= @get_post_custom_values('freguency_min',
                    $post->ID)[0] ?>
                <p class="product-preview__description"><?= freguency_converter(@get_post_custom_values('frequency_min',
                        $post->ID)[0]); ?>
                    - <?= freguency_converter(@get_post_custom_values('frequency_max',
                        $post->ID)[0]); ?></p>
            </div>
        </div>
    </div>
        <?php endforeach; ?>
    <?php
    return ob_get_clean();
}
