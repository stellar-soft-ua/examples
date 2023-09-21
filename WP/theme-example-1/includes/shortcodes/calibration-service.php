<?php

add_shortcode("calibration_service", "calibration_service");

function calibration_service($atts)
{
    $services = [];
    $args = [
        'post_type' => CALIBRATION_SERVICE,
        'post_status' => 'publish',
        'posts_per_page' => '-1',
        'order' => 'ASC',
        'orderby' => 'meta_value',
        'meta_key' => 'instrument',
    ];
    $posts = get_posts($args);
    $title_arr = [];
    foreach ($posts as $post_t) {
        array_push($title_arr, $post_t->post_title);
    }
    $type = [];
    $price = [];
    $url = [];
    $arr_id = [];
    $title_arr = array_unique($title_arr);
    foreach ($title_arr as $item_title) {
        $args = ["post_type" => CALIBRATION_SERVICE, "s" => $item_title];
        $query = get_posts($args);
        foreach ($query as $key => $item) {
            $instrument = @get_post_custom_values('instrument', $item->ID)[0];
            array_push($type, @get_post_custom_values('calibration_type', $item->ID)[0]);
            array_push($price, @get_post_custom_values('cal_price', $item->ID)[0]);
            array_push($url, @get_post_custom_values('cal_url', $item->ID)[0]);
            array_push($arr_id, $item->ID);
            if ($key >= 1 || count($query) < 2) {
                array_push($services,
                    ['instrument' => $instrument, 'type' => $type, 'price' => $price, 'url' => $url, 'ID' => $arr_id]);
                $type = [];
                $price = [];
                $url = [];
                $arr_id = [];
            }

        }
    }

    ob_start();
    ?>

    <section class="services-selector">
        <div class="container">
            <div class="location-selector">
                <div class="location-selector_wrap">
                <p class="column-title"> Chose Your VNA or Calibration Kit </p>
                    <input type="search" id="calibration-search" placeholder="Search">
                    <span class="clear-icon"></span>
                    <span class="search-icon"></span>
                    <div id="left-column" class="calibration-picker">
                        <p class="notfound" style="display: none"> No matches found </p>
                        <?php foreach ($services as $item): ?>
                            <div class="location-selector_region-item left-col"
                                 id="<?=implode(",", $item['ID'])?>"
                                 onclick="productClick(this)"><?=$item['instrument']?></div>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="location-selector_arrow-wrap"></div>
                <div class="location-selector_wrap">
                <p class="column-title"> Accredited or Unaccredited  </p>
                    <div id="right-column" class="calibration-picker">

                    </div>
                </div>
            </div>
            <hr class="green-line">

            <div class="button-block">
                <p class="service-price"></p>
                <a class="product__link btn" target="_blank">Request
                    a Quote </a>
            </div>
        </div>
    </section>

    <?php
$count_posts = wp_count_posts(CALIBRATION_SERVICE);
    $total_posts = $count_posts->publish;
    if ($total_posts === 0) {
        import_services();
    }

    wp_enqueue_script('cmt-service', get_template_directory_uri() . '/assets/js/service-search.js',
        ['cmt-jquery'], null, true);
    wp_localize_script('cmt-service', 'services', $services);
    wp_enqueue_script('cmt-block', get_template_directory_uri() . '/assets/js/check-visitor-country.js',
        ['cmt-jquery'], null, true);

    return ob_get_clean();
}