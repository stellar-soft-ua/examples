<?php

add_shortcode("google-maps", "show_map");

function show_map($atts)
{
    $atts = shortcode_atts([
        'category' => '',
    ], $atts);
    ob_start();
    $regions = array_keys(unserialize (REGIONS));
    ?>
    <?php if ($atts['category'] == 'find-a-representative'): ?>
    <div class="location-selector">
       <div class="location-selector_wrap">
           <p class="location-selector_title-region">Select a Region</p>
           <div class="location-selector_region" size="7">
              <?php get_regions($regions)?>
           </div>
       </div>
        <div class="location-selector_arrow-wrap"></div>
        <div class="location-selector_wrap">
            <p class="location-selector_title-state">Select a Country or State</p>
            <div class="location-selector_state" id="state-selector" size="7">
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="map-container contact-map">
        <div class="map-container__wrap">
            <div class="input-search__wrap location-search-wrap" id="locations-search">
                <input type="text" placeholder="Search" id="search-locations"/>
                <span class="clear-icon"></span>
                <span class="search-icon"></span>
            </div>
            <div class="map-container__description">
                <div class="map-items-block">
                    <?php
                    $args = [
                        'post_type'      => LOCATION_POST_TYPE,
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                        'orderby' => array(
                            'meta_value_num' => 'ASC',
                            'title' => 'ASC'
                        ),
                        'meta_key'        => 'order_location',
                        'tax_query'      => [
                            [
                                'taxonomy' => 'location',
                                'field'    => 'slug',
                                'terms'    => $atts['category']
                            ]
                        ]
                    ];
                    $query = new WP_Query;
                    $marker_id = 1;
                    $posts = $query->query($args); ?>
                    <?php foreach ($posts as $post): ?>
                        <?php
                            $post_category = wp_get_post_terms($post->ID, 'location')[0]->slug;
                            $location_link = get_post_custom_values('location_account_link', $post->ID)[0]
                        ?>
                        <div class="map-container__item" onclick="onItemClick(this)" id="<?=$marker_id?>">
                            <?php if($location_link):?>
                                <p class="map-container__item-title"><a href="<?= $location_link ?>" target="_blank"><?= $post->post_title ?></a></p>
                            <?php else:?>
                                <p class="map-container__item-title"><?= $post->post_title ?></p>
                            <?php endif;?>
                            <?php $name = get_post_custom_values('name', $post->ID)[0];
                            if ($name):?>
                                <p class="map-container__item-name"><?= $name ?></p>
                            <?php endif; ?>
                            <?php $address = get_post_custom_values('location_address', $post->ID)[0];
                            if ($address):?>
                                <p class="map-container__item-email">Address:
                                    <a><?= $address ?></a>
                                </p>
                            <?php endif; ?>
                            <?php $email = get_post_custom_values('email', $post->ID)[0];
                            if ($email && $post_category === 'third-party-laboratories'):?>
                                <p class="map-container__item-email">Email:
                                    <a href="mailto:<?= $email ?>"><?= $email ?></a>
                                </p>
                            <?php endif ?>
                            <?php $phone = get_post_custom_values('phone', $post->ID)[0];
                            if ($phone):?>
                                <p class="map-container__item-phone">Phone:
                                    <a href="tel:<?= $phone ?>"><?= $phone ?></a>
                                </p>
                            <?php endif; ?>
                            <?php $website = get_post_custom_values('website_url', $post->ID)[0];
                            if ($website):?>
                                <p class="map-container__item-site">Website:
                                    <a href="<?= $website ?>"><?= $website ?></a>
                                </p>
                            <?php endif; ?>
                            <?php if ($email && $post_category === 'find-a-representative'): ?>
                                <div class="email-btn-wrap"><a class="btn email-representative-btn" href="<?= $email ?>"
                                                               target="_blank">Email Representative</a></div>
                            <?php endif ?>
                            <?php if ($email && ($post_category === 'contact-us' || $post_category === 'repair-services')): ?>
                                <div class="email-btn-wrap"><a class="btn email-representative-btn" href="<?= $email ?>"
                                                               target="_blank">Email Us</a></div>
                            <?php endif ?>
                            <input type="hidden" class="latitude" value="<?= get_post_custom_values('latitude',
                                $post->ID)[0] ? get_post_custom_values('latitude', $post->ID)[0] : '' ?>"/>
                            <input type="hidden" class="longitude" value="<?= get_post_custom_values('longitude',
                                $post->ID)[0] ? get_post_custom_values('longitude', $post->ID)[0] : '' ?>"/>
                            <input type="hidden" class="key_words" value="<?= get_post_custom_values('location_key_words',
                                $post->ID)[0] ? get_post_custom_values('location_key_words', $post->ID)[0] : '' ?>"/>
                            <input type="hidden" class="marker_id" value="<?= $marker_id++ ?>"/>
                        </div>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" class="posts-category" value="<?= $atts['category'] ?>"/>
            </div>
        </div>
        <div class="map-container__map" id="map"></div>
    </div>
    <?php
    wp_enqueue_script('cmt-google-maps',
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyA-ZUyvJ-o75dBZPVWP8cpXwXpsw90hDd8', ['cmt-jquery'],
        "1.001", true);
    wp_enqueue_script('cmt-maps', get_template_directory_uri() . '/assets/js/google-maps.js',
        ['cmt-jquery', 'cmt-google-maps'], null, true);
    wp_localize_script( 'cmt-maps', 'regions', unserialize (REGIONS) );
    return ob_get_clean();
}
