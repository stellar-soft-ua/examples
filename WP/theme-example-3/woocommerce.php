<?php

/*
 * write woocommerce actions in src/WooCommerce.php and not in this file.
 */
if (is_singular('product')) {
    blade('woocommerce.single-product', [
        'productPost' => $post,
    ]);
} else {
    $category = false;
    $title = false;
    if (is_product_category()) {
        $queried_object = get_queried_object();
        $term_id = $queried_object->term_id;
        $category = get_term($term_id, 'product_cat');
        $title = single_term_title('', false);
    }

    $products = wc_get_products(array());

    blade('woocommerce.archive', [
        'products' => $products,
        'category' => $category,
        'title' => $title,
    ]);
}
