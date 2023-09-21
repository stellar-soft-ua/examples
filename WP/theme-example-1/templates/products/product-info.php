<?php
function get_product_info($post, $tax)
{
    $price    = @get_post_custom_values('product_price', $post->ID)[0];
    $price_to = @get_post_custom_values('product_price_to', $post->ID)[0];
    $in_stock = @get_post_custom_values('in_stock', $post->ID)[0];
    if ($in_stock == "on") {
        $in_stock = "Yes";
    } else {
        $in_stock = "No";
    }

    $post_type     = get_post_type();
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
    $btn_text      = $post_type === FREQUENCY_EXTENSION_POST_TYPE ? 'Build Your CobaltFx System' : 'Buy Now';
    $impedance = @get_post_custom_values( 'cholesterol', $post->ID )[0];
    ?>
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumbs__list">
                <li class="breadcrumbs__item"><a
                            href="<?= get_product_list_link($post_type,$impedance); ?>" class="breadcrumbs__link">Product
                        list</a></li>
                <span class="breadcrumbs__separator">></span>
                <li class="breadcrumbs__item"> <?= $post->post_title ?></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="product__block">
            <div class="gallery">
                <?php
                $buy_link    = @get_post_custom_values('buy_now', $post->ID)[0];
                $product_img = get_the_post_thumbnail_url( $post->ID, 'product-img' );
                $full_product_img_src = get_the_post_thumbnail_url($post->ID, 'large');

                $images_str  = @get_post_custom_values( '_multi_img_array', $post->ID )[0];
                $images      = [];
                if ( ! empty( $images_str ) ) {
                    $images = explode( ',', $images_str );
                }
                ?>
                <div class="gallery__photo photo-big"><img
                            src="<?= get_single_product_big_image( $product_img, $images ) ?>"
                            alt="Image slide"/></div>
                <?php
                if ( ( $product_img && count( $images ) >= 1 ) || count( $images ) > 1 ) :
                    ?>
                    <div class="gallery__title">Images</div>
                    <div class="gallery__small">
                        <?php if ( $product_img ): ?>
                            <div class="gallery__photo photo-small active-img">
                                <img src="<?= $product_img ?>" data-full-src="<?= $full_product_img_src; ?>"/>
                            </div>
                        <?php endif; ?>
                        <?php foreach ($images as $i => $image): ?>
                            <?php if ($i == 0 && !$product_img):
                                $img_class = "active-img";
                            endif;
                            $img_src = wp_get_attachment_image_src($image, 'product-img')[0];
                            $type = substr($img_src, -3, 3);
                            $full_img_src = wp_get_attachment_image_src($image, 'large', false )[0];
                            if ($type === 'gif') {
                                $full_img_src = wp_get_attachment_image_src($image, 'full', false )[0];;
                            }
                            if (!empty($img_src)): ?>
                                <div class="gallery__photo photo-small <?= $img_class ?>"><img
                                            src="<?= $img_src ?>"
                                            alt="Image slide"
                                            data-full-src="<?=$full_img_src?>"/>
                                </div>
                                <?php $img_class = "";
                            endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php
                    $product_videos = get_post_meta($post->ID, 'repeatable-fields-product-video')[0];
                    if ($product_videos && is_array($product_videos)) :
                        asort($product_videos);
                        $product_videos = array_values($product_videos);
                        $wistia_video_360 = [];
                        foreach ($product_videos as $key => $field) :
                            if ($field['video_types'] == 'd_sort_wistia_video_360') {
                                $wistia_video_360[] = $field['url'];
                                unset($product_videos[$key]);
                            }
                        endforeach;
                        if (!empty($product_videos)) : ?>
                            <div class="gallery__title">Videos</div>
                            <div class="gallery__small">
                                <?php foreach ($product_videos as $field) : ?>
                                    <?php if ($field['video_types'] == 'a_sort_internal_video') : ?>
                                        <div class="gallery__video photo-small">
                                            <!--TODO: Need set check for default image-->
                                            <img src="<?= $product_img ?>" data-full-src="<?= $field['url']; ?>" alt="Image slide" />
                                            <div class="label__video">
                                                <div class="label__video__inner">VIDEO</div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($field['video_types'] == 'b_sort_wistia_video') : ?>
                                        <?php wp_enqueue_script('wistia-external');
                                        $pattern = '/https:\/\/.+(wistia\.com)\/medias\/(\w+)/i';
                                        if (preg_match( $pattern, $field['url'], $matches)) :
                                            if (!empty($matches[1]) && $matches[1] == 'wistia.com') :
                                                if ($video_id = !empty($matches[2]) ? $matches[2] : '') : ?>
                                                    <div class="wistia_responsive_padding gallery__video photo-small">
                                                        <span class="wistia_embed wistia_async_<?=$video_id; ?> popover=true popoverAnimateThumbnail=true videoFoam=true" style="display:inline-block;height:100%;position:relative;width:100%">&nbsp;</span>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if ($field['video_types'] == 'c_sort_h5p_video') : ?>
                                        <?php
                                        $pattern = '/\[h5p(.*)\]/s';
                                        if (preg_match($pattern, $field['url'], $matches)) :
                                            if (!empty($matches[1])) :
                                                $array_shortcodes_attr = shortcode_parse_atts($matches[1]);
                                                if (!empty($array_shortcodes_attr['id'])) : ?>
                                                    <div class="gallery__h5p photo-small">
                                                        <!--TODO: Need set check for default image-->
                                                        <img src="<?=$product_img;?>"
                                                             data-ajaxurl="/wp-admin/admin-ajax.php"
                                                             data-action="load-h5p-content"
                                                             data-h5p_video_id="<?=$array_shortcodes_attr['id'];?>"
                                                             alt="Interactive video"
                                                             title="Interactive video"
                                                        />
                                                        <div class="label__video">
                                                            <div class="label__video__inner">Watch</div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($wistia_video_360)) : ?>
                            <div class="gallery__title">360 Content</div>
                            <div class="gallery__small">
                                <?php foreach ($wistia_video_360 as $url) : ?>
                                    <?php if (!empty($url)) : ?>
                                        <?php wp_enqueue_script('wistia-external');
                                        $pattern = '/https:\/\/.+(wistia\.com)\/medias\/(\w+)/i';
                                        if (preg_match( $pattern, $url, $matches)) :
                                            if (!empty($matches[1]) && $matches[1] == 'wistia.com') :
                                                if ($video_id = !empty($matches[2]) ? $matches[2] : '') : ?>
                                                    <div class="wistia_responsive_padding gallery__video photo-small">
                                                            <span class="wistia_embed wistia_async_<?=$video_id; ?> popover=true popoverAnimateThumbnail=true videoFoam=true" style="display:inline-block;height:100%;position:relative;width:100%">&nbsp;</span>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
            </div>

            <div class="product__wrap">
                <h2 class="product__title"><?= $post->post_title ?></h2>
                <div class="tabs">
                    <ul class="tab-links">
                        <li class="<?= get_tab_color( $product_color["tax_color"] ) ?> active"><a
                                    href="#tab1">Product</a></li>
                        <?php if ((check_specifications([
                                'frequency_min',
                                'frequency_max',
                                'measured_parameters',
                                'sweep_types',
                                'effective_directivity_dynamic',
                                'effective_directivity',
                                'measurement_speed',
                                'cholesterol',
                                'measurement_type'
                            ], $post->ID) || @get_post_custom_values( 'specifications', $post->ID )[0]) || @get_post_custom_values( 'vna_specifications', $post->ID )[0]): ?>
                            <li class="<?= get_tab_color($product_color["tax_color"]) ?>"><a
                                        href="#tab2">Specifications</a></li>
                        <?php endif; ?>
                        <?php if ( @get_post_custom_values( 'product_app', $post->ID )[0] ): ?>
                            <li class="<?= get_tab_color( $product_color["tax_color"] ) ?>"><a href="#tab3">Applications</a>
                            </li>
                        <?php endif; ?>

                        <?php if ( @get_post_custom_values( 'software', $post->ID )[0] ):?>
                            <li class="<?= get_tab_color( $product_color["tax_color"] ) ?>"><a href="#tab4">Software/Documentation</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div class="tab-content">
                        <div id="tab1" class="tab active">
                            <?php
                            $content = $post->post_content;
                            $content = apply_filters( 'the_content', $content );
                            $vna_specifications = @get_post_custom_values( 'vna_specifications', $post->ID )[0];
                            $specifications = @get_post_custom_values( 'specifications', $post->ID )[0]
                            ?>
                            <div class="product__text"><?= $content ?></div>
                        </div>
                        <div id="tab2" class="tab">
                            <?php if($vna_specifications):$vna_specifications = apply_filters( 'the_content', $vna_specifications );?>
                                <div class="product__text"><?= $vna_specifications ?></div>
                            <?php elseif($specifications):$specifications = apply_filters( 'the_content', $specifications );?>
                                <div class="product__text"><?= $specifications ?></div>
                            <?php else:?>
                                <ul class="product__list">
                                    <?php
                                    $has_characteristics = false;
                                    $freguency_min       = freguency_converter( @get_post_custom_values( 'frequency_min',
                                        $post->ID )[0] );
                                    $freguency_max       = freguency_converter( @get_post_custom_values( 'frequency_max',
                                        $post->ID )[0] );
                                    ?>
                                    <?php if ( $freguency_min || $freguency_max ) : $has_characteristics = true; ?>
                                        <li>- Frequency range:
                                            <?= $freguency_min ? $freguency_min : '-' ?>
                                            <?php if ( $freguency_max ): ?>
                                                to
                                                <?= $freguency_max ?>
                                            <?php endif; ?>
                                        </li>
                                    <?php endif; ?>
                                    <?php $measured_parameters = @get_post_custom_values( 'measured_parameters',
                                        $post->ID )[0];
                                    if ( $measured_parameters ): $has_characteristics = true; ?>
                                        <li>- Measured parameters: <?= $measured_parameters ?></li>
                                    <?php endif; ?>
                                    <?php $sweep_types = @get_post_custom_values( 'sweep_types', $post->ID )[0];
                                    if ( $sweep_types ): $has_characteristics = true; ?>
                                        <li>- Sweep types: <?= $sweep_types ?></li>
                                    <?php endif; ?>
                                    <?php $effective_directivity_dynamic = @get_post_custom_values( 'effective_directivity_dynamic',
                                        $post->ID )[0];
                                    if ( $effective_directivity_dynamic ): $has_characteristics = true; ?>
                                        <li>- Effective Directivity: <?= $effective_directivity_dynamic ?></li>
                                    <?php endif; ?>
                                    <?php $effective_directivity = @get_post_custom_values( 'effective_directivity',
                                        $post->ID )[0];
                                    if ( $effective_directivity ): $has_characteristics = true; ?>
                                        <li>- Dynamic range: <?= $effective_directivity . " dB" ?></li>
                                    <?php endif; ?>
                                    <?php $measurement_speed = @get_post_custom_values( 'measurement_speed', $post->ID )[0];
                                    if ( $measurement_speed ): $has_characteristics = true; ?>
                                        <li>- Measurement speed: <?= $measurement_speed . " µs"; ?></li>
                                    <?php endif; ?>
                                    <?php $impedance = @get_post_custom_values( 'cholesterol', $post->ID )[0];
                                    if ( $impedance ): $has_characteristics = true; ?>
                                        <li>- Impedance: <?= $impedance . ' Ohm' ?></li>
                                    <?php endif; ?>
                                    <?php $measurement_type = @get_post_custom_values( 'measurement_type', $post->ID )[0];
                                    if ( $measurement_type ): $has_characteristics = true; ?>
                                        <li>- Measurement type: <?= $measurement_type ?></li>
                                    <?php endif; ?>
                                    <?php if ( ! $has_characteristics ): ?>
                                        <li> Not provided</li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif;?>
                        </div>
                        <div id="tab3" class="tab">
                            <?php if ( @get_post_custom_values( 'product_app', $post->ID )[0] ): ?>
                                <?php $product_app = @get_post_custom_values( 'product_app',
                                    $post->ID )[0];
                                $product_app = apply_filters( 'the_content', $product_app );?>

                                <div class="product__text"><?= $product_app ?></div>
                            <?php else: ?>
                                <?= "No content"; ?>
                            <?php endif; ?>
                        </div>
                        <div id="tab4" class="tab">
                            <?php if ( @get_post_custom_values( 'software', $post->ID )[0] ): ?>
                                <?php $software = @get_post_custom_values( 'software',
                                    $post->ID )[0];
                                $software = apply_filters( 'the_content', $software );?>
                                <div class="product__text"><?= $software ?></div>
                            <?php else: ?>
                                <?= "No content"; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product__buttons">
                <?php if ($price || $price_to): ?>
                    <?php if ($price > 0 || $price_to > 0): ?>
                        <div class="product__price-block">
                            <?= check_price_range($price, $price_to, false) ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( $post_type === FREQUENCY_EXTENSION_POST_TYPE ): ?>
                        <?= $buy_link ? '<a class="product__link btn buy-button" href=' . $buy_link . ' target="_blank">' . $btn_text . '</a>' : '' ?>
                    <?php else: ?>
                        <?= $buy_link ? '<a class="product__link btn buy-button" href="#modal-buy-window" rel="modal:open">' . $btn_text . '</a>' : '' ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php
                    $edit_button_1_link = @get_post_custom_values('edit_button_1_link', $post->ID)[0];
                    $edit_button_1_name = @get_post_custom_values('edit_button_1_name', $post->ID)[0];
                    echo $edit_button_1_name &&
                        isset($_COOKIE['country_name']) &&
                        $_COOKIE['country_name'] === "United States" ?
                            '<a class="product__link btn new-button" href=' . ($edit_button_1_link ? $edit_button_1_link : '') . ' target="_blank">' . $edit_button_1_name . '</a>'
                            : '';
                ?>
                <?= @get_post_custom_values( 'find_rep',
                    $post->ID )[0] ? '<a class="product__link btn" href="' . @get_post_custom_values( 'find_rep',
                        $post->ID )[0] . '" target="_blank">Find a Representative</a>' : '' ?>
                <?= @get_post_custom_values( 'req_qoute',
                    $post->ID )[0] ? '<a class="product__link btn" href="' . @get_post_custom_values( 'req_qoute',
                        $post->ID )[0] . '" target="_blank">Request a Quote</a>' : '' ?>
                <?= @get_post_custom_values( 'btn_try',
                    $post->ID )[0] ? '<a class="product__link btn" href="' . @get_post_custom_values( 'btn_try',
                        $post->ID )[0] . '" target="_blank">Try the ' . explode( ' ',
                        trim( $post->post_title ) )[0] . '</a>' : '' ?>
                <?= @get_post_custom_values( 'btn_download',
                    $post->ID )[0] ? '<a class="product__link btn" href="' . @get_post_custom_values( 'btn_download',
                        $post->ID )[0] . '" target="_blank">Download Demo Software</a>' : '' ?>
                <?= @get_post_custom_values( 'btn_documentation',
                    $post->ID )[0] ? '<a class="product__link btn" href="' . @get_post_custom_values( 'btn_documentation',
                        $post->ID )[0] . '" target="_blank">Software/Documentation</a>' : '' ?>
                <?= @get_post_custom_values( '_refurbished__button_link',
                    $post->ID )[0] ? '<a class="product__link btn" href="' . @get_post_custom_values( '_refurbished__button_link',
                        $post->ID )[0] . '" target="_blank">'.@get_post_custom_values( '_refurbished__button_name',
                        $post->ID )[0].'</a>' : '' ?>
                <div id="modal-buy-window" class="modal">
                    <div class="modal__items">
                        <div class="modal__item" id="features-item">
                            <div class="product-preview__wrap" style="padding: 15px;">
                                <div class="application__content">
                                    <p class="buy-window-text">You are now being redirected to our online store</p>
                                    <ul class="helps__list">
                                        <li class="helps__item"><a href="#modal-buy-window" rel="modal:close" >Go Back</a></li>
                                        <li class="helps__item"><a href="<?= @get_post_custom_values( 'buy_now',$post->ID )[0]?>" target="_blank" class="continue-btn">Continue</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    wp_enqueue_script('cmt-remove-tabs',get_template_directory_uri().'/assets/js/remove-tabs.js',['cmt-jquery'],false,true);
//    wp_enqueue_script('h5p-content');
}
