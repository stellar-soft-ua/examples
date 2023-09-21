<?php
function get_product_list($post_type, $impedance = '')
{
    $taxonomy = get_object_taxonomies($post_type)[1];
    $solutions_taxonomy = get_object_taxonomies($post_type)[4];
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $posts_per_page = -1;
    $meta_query[] =
        [
            'key'   => 'cholesterol',
            'value' => $impedance
        ];
    $args = [
        'posts_per_page' => $posts_per_page,
        'post_type'      => $post_type,
        'offset'         => $posts_per_page * ($paged - 1),
        'meta_query'     => $meta_query
    ];
    $query = new WP_Query;
    $posts = $query->query($args);
    ?>
    <div class="products__list load-more">
        <?php foreach ($posts as $post): ?>
            <?php
            $post_type = get_post_type($post->ID);
            $taxonomy = get_object_taxonomies($post_type)[1];
            $solutions_taxonomy = get_object_taxonomies($post_type)[4];
            $terms = get_the_terms($post->ID, $taxonomy);
            $solutions_terms = get_the_terms($post->ID, $solutions_taxonomy);
            if ($solutions_terms) {
                $t_id          = $solutions_terms[0]->term_id;
                $product_color = get_option("taxonomy_term_$t_id");
            } else {
                $t_id          = $terms[0]->term_id;
                $product_color = get_option("taxonomy_term_$t_id");
            }
            $price         = @get_post_custom_values('product_price', $post->ID)[0];
            $price_to      = @get_post_custom_values('product_price_to', $post->ID)[0];
            ?>
            <div class="product-preview product-preview--single <?= $product_color["tax_color"] ? $product_color["tax_color"] : 'border-green' ?> load-more"
                 data-taxonomy="<?= $terms[0]->slug ?>">
                <div class="image-block">
                    <?php $product_preview = get_the_post_thumbnail_url($post->ID, 'product-preview'); ?>
                    <a href="<?= get_the_permalink($post->ID) ?>"><img
                                src="<?= $product_preview ? $product_preview : get_template_directory_uri() . "/assets/img/placeholder.png" ?>"
                                alt="Image"></a>
                </div>
                <div class="product-preview__text">
                    <div class="product-preview__wrap">
                        <p class="product-preview__title"><?= $post->post_title ?></p>
                        <p class="product-preview__price">
                            <?= check_price_range($price, $price_to, true) ?>
                        </p>
                        <?= @get_post_custom_values('freguency_min',
                            $post->ID)[0] ?>
                        <p class="product-preview__description"><?= freguency_converter(@get_post_custom_values('frequency_min',
                                $post->ID)[0]); ?>
                            - <?= freguency_converter(@get_post_custom_values('frequency_max',
                                $post->ID)[0]); ?></p>
                    </div>
                    <div class="hover-block">
                        <ul class="hover-block__list">
                            <?php
                            $has_characteristics = false;
                            $freguency_min = freguency_converter(@get_post_custom_values('frequency_min',
                                $post->ID)[0]);
                            $freguency_max = freguency_converter(@get_post_custom_values('frequency_max',
                                $post->ID)[0]);

                            ?>
                            <?php if ($freguency_min || $freguency_max) : $has_characteristics = true; ?>
                                <li class="hover-block__item">- Frequency range:
                                    <?= $freguency_min ? $freguency_min : '-' ?>
                                    <?php if ($freguency_max): ?>
                                        to
                                        <?= $freguency_max ?>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                            <?php $measured_parameters = @get_post_custom_values('measured_parameters', $post->ID)[0];
                            if ($measured_parameters): $has_characteristics = true; ?>
                                <li class="hover-block__item">- Measured parameters: <?= $measured_parameters ?></li>
                            <?php endif; ?>
                            <?php $sweep_types = @get_post_custom_values('sweep_types', $post->ID)[0];
                            if ($sweep_types): $has_characteristics = true; ?>
                                <li class="hover-block__item">- Sweep types: <?= $sweep_types ?></li>
                            <?php endif; ?>
                            <?php $effective_directivity_dynamic = @get_post_custom_values('effective_directivity_dynamic',
                                $post->ID)[0];
                            if ($effective_directivity_dynamic): $has_characteristics = true; ?>
                                <li class="hover-block__item">- Effective
                                    Directivity: <?= $effective_directivity_dynamic ?></li>
                            <?php endif; ?>
                            <?php $effective_directivity = @get_post_custom_values('effective_directivity',
                                $post->ID)[0];
                            if ($effective_directivity): $has_characteristics = true; ?>
                                <li class="hover-block__item">- Dynamic
                                    range: <?= $effective_directivity . " dB" ?></li>
                            <?php endif; ?>
                            <?php $measurement_speed = @get_post_custom_values('measurement_speed', $post->ID)[0];
                            if ($measurement_speed): $has_characteristics = true; ?>
                                <li class="hover-block__item">- Measurement
                                    speed: <?= $measurement_speed . " µs"; ?></li>
                            <?php endif; ?>
                            <?php $impedance = @get_post_custom_values('cholesterol', $post->ID)[0];
                            if ($impedance): $has_characteristics = true; ?>
                                <li class="hover-block__item">- Impedance: <?= $impedance . ' Ohm' ?></li>
                            <?php endif; ?>
                            <?php $measurement_type = @get_post_custom_values('measurement_type', $post->ID)[0];
                            if ($measurement_type): $has_characteristics = true; ?>
                                <li class="hover-block__item">- Measurement type: <?= $measurement_type ?></li>
                            <?php endif; ?>
                            <?php if (!$has_characteristics): ?>
                                <li class="hover-block__item"> Not provided</li>
                            <?php endif; ?>
                        </ul>
                        <div class="hover-block__wrap">
                            <a href="<?= get_permalink($post->ID); ?>" class="hover-block__link btn">More</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php
        $published_posts = wp_count_posts('product')->publish;
        $page_number_max = ceil($published_posts / $posts_per_page);
        ?>
        <p class="navigation">
            <a class="pagination__next" href=<?= get_next_posts_page_link($page_number_max); ?>></a>
        </p>
    </div>
    <?php
}