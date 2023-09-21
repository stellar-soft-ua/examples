<?php

add_shortcode( 'cmt_data_sheet', 'cmt_data_sheet_callback' );

function cmt_data_sheet_callback( $atts ) {
    $taxonomy = DATA_SHEET_CATEGORY;
    $terms    = get_terms( $taxonomy, [ 'orderby' => 'slug', 'order' => 'ASC' ] );

    ob_start();
    ?>
    <section class="accardion">
        <div class="container">
            <div class="accardion__block">
                <div class="accardion__titles">
                    <?php foreach ( $terms as $key => $term ): ?>
                        <div class="accardion__title <?= $key === 0 ? 'accardion-active' : '' ?>"
                             data-manual='<?= $key ?>'

                        ><?= $term->name ?></div>
                    <?php endforeach; ?>
                </div>
                <div class="accardion__description">
                    <?php foreach ( $terms as $key => $term ):
                        wp_reset_query();
                        $args = array(
                            'post_type' => DATA_SHEET_POST_TYPE,
                            'tax_query' => [
                                [
                                    'taxonomy' => $taxonomy,
                                    'field'    => 'slug',
                                    'terms'    => $term->slug,
                                ],
                            ],
                        );

                        $loop = new WP_Query( $args );
                        ?>
                        <div class="accardion__item <?= $key !== 0 ? 'toggle-accardion' : '' ?>"
                             data-manual='<?= $key ?>'>
                            <?php
                            while ( $loop->have_posts() ) : $loop->the_post();
                                $manual_url = @get_post_meta( get_the_ID(), 'data_sheet_url', true );
                                if ( ! $manual_url ) {
                                    return;
                                }
                                ?>

                                <div class="accardion__unit">
                                    <p><?= get_the_title() ?></p> <a href="<?= $manual_url ?>" target="_blank">
                                        <img src="<?= get_template_directory_uri() ?>/assets/img/download.png""
                                        alt="Image"/>
                                    </a></div>

                            <?php endwhile; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
