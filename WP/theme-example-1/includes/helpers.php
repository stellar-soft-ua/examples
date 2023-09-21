<?php
function freguency_converter($value)
{
    if (strtolower($value) == 'dc') {
        return 'DC';
    }
    if ( ! is_numeric($value)) {
        return '';
    }

    $number = intval($value);
    if ($number < 1000) {
        return $number . " kHz";
    }
    if ($number >= 1000 && $number < 1000000) {
        return ($number / 1000) . " MHz";
    }
    if ($number >= 1000000) {
        return $number / 1000000 . " GHz";
    }
}

function get_vimeo_video_id_from_url($url = '')
{

    $regs = array();

    $id = '';

    if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im',
        $url, $regs)) {
        $id = $regs[3];
    }

    return $id;

}

function get_youtube_video_id_from_url($url = '')
{
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
        $url, $match);
    $youtube_id = $match[1];

    return $youtube_id;
}

function product_change_posts_per_page($query)
{
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }

    if (is_post_type_archive([CALIBRATION_KITS_POST_TYPE, VNA_POST_TYPE])) {
        $query->set('posts_per_page', 50);
    }
}

function get_frost_sullivan_image($post_id)
{
    $post_img_url = get_the_post_thumbnail_url($post_id, 'frost-sullivan-img');
    if ( ! empty($post_img_url)) {
        return $post_img_url;
    }

    return get_template_directory_uri() . "/assets/img/placeholder-450x280.png";
}

add_filter('pre_get_posts', 'product_change_posts_per_page');

function load_products()
{
    $paged            = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $posts_per_page   = -1;
    $terms            = $_POST['term'];
    $post_type        = $_POST['term']['post_type'];
    $product_category = $_POST['term']['product_category_name'];
    $args             = [
        'posts_per_page' => $posts_per_page,
        'post_type'      => $post_type,
        'offset'         => $posts_per_page * ($paged - 1)

    ];


    if (isset($terms['category'])) {
        $tax_query[] = [
            'taxonomy' => $product_category,
            'field'    => 'slug',
            'terms'    => $terms['category']
        ];
    }

    if (isset($terms)) {
        if ($terms['impedance']) {
            $meta_query[] = [
                'key'   => 'cholesterol',
                'value' => $terms['impedance']
            ];
        }
        $args = [
            'posts_per_page' => $posts_per_page,
            'post_type'      => $post_type,
            'offset'         => $posts_per_page * ($paged - 1),
            'order'          => 'DESC',
            'tax_query'      => $tax_query,
            'meta_query'     => $meta_query
        ];
    }


    $query = new WP_Query;
    $posts = $query->query($args);
    if ($posts):?>

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
            $product_img   = get_the_post_thumbnail_url($post->ID,
                'product-preview') ? get_the_post_thumbnail_url($post->ID,
                'product-preview') : get_template_directory_uri() . "/assets/img/placeholder.png";
            $images_str    = @get_post_custom_values('_multi_img_array', $post->ID)[0];
            $images        = [];
            if ( ! empty($images_str)) {
                $images = explode(',', $images_str);
            }
            $hover_image = wp_get_attachment_image_src($images[0], 'product-preview')[0];
            $product_tag = @get_post_custom_values('product_tag',$post->ID)[0];
            ?>
            <div class="product-preview product-preview--single <?= $product_color["tax_color"] ? $product_color["tax_color"] : 'border-green' ?> load-more"
                 onmouseover="hover(this);" onmouseout="unhover(this);" onclick="redirect(this)" data-new-location="<?=get_the_permalink($post->ID);?>">
                <?php if($product_tag): ?>
                    <div class="ribbon <?=$product_tag?>"><span><?=check_tag_name($product_tag)?></span></div>
                <?php endif;?>
                <div class="image-block">
                    <input type="hidden" value="<?= $product_img ?>" class="product-main-image">
                    <input type="hidden" value="<?= $hover_image ?>" class="product-second-image">
                    <a href="<?= get_the_permalink($post->ID) ?>">
                        <img class="product-card-image" src="<?= $product_img ?>"
                             data-second-image="<?= $hover_image ?>" data-main-image="<?= $product_img ?>" alt="Image">
                    </a>
                </div>
                <?php
                $has_characteristics = false;
                $frequency_min       = freguency_converter(@get_post_custom_values('frequency_min', $post->ID)[0]);
                $frequency_max       = freguency_converter(@get_post_custom_values('frequency_max', $post->ID)[0]);
                $price               = @get_post_custom_values('product_price', $post->ID)[0];
                $price_to            = @get_post_custom_values('product_price_to', $post->ID)[0];
                ?>
                <div class="product-preview__text">
                    <div class="product-preview__wrap">
                        <p class="product-preview__title"><?= $post->post_title ?></p>
                        <p class="product-preview__price">
                            <?= check_price_range($price, $price_to, true) ?>
                        </p>
                        <p class="product-preview__description"> <?= $frequency_min ? $frequency_min : '' ?>
                            <?php if ($frequency_max): ?>
                                to
                                <?= $frequency_max ?>
                            <?php endif; ?></p>
                    </div>
                    <div class="hover-block">
                        <ul class="hover-block__list">
                            <?php if ($frequency_min || $frequency_max) : $has_characteristics = true; ?>
                                <li class="hover-block__item">- Frequency range:
                                    <?= $frequency_min ? $frequency_min : '-' ?>
                                    <?php if ($frequency_max): ?>
                                        to
                                        <?= $frequency_max ?>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                            <?php $measured_parameters = @get_post_custom_values('measured_parameters',
                                $post->ID)[0];
                            if ($measured_parameters): $has_characteristics = true; ?>
                                <li class="hover-block__item">- Measured
                                    parameters: <?= $measured_parameters ?></li>
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
                            <?php if ( ! $has_characteristics): ?>
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
    else:
        echo 'No products found';
    endif;
    die();

}

function get_position_by_department($department) {
    $meta_query[] =
        [
            'key'   => 'department',
            'value' => $department
        ];
    $args = [
        'post_type'   => 'position',
        'post_status' => 'publish',
        'meta_query'  => $meta_query
    ];
    $query      = new WP_Query;
    $data = $query->query($args);
    return $data;
}

function load_position()
{
    $unique       = [];
    $meta_query[] = [
        'key'   => 'available-position',
        'value' => 'on'
    ];
    $position     = $_POST['term'];
    if ($position != 'All') {
        $meta_query[] =
            [
                'key'   => 'department',
                'value' => $position
            ];
        $pos_class    = 'position';
    } else {
        $pos_class = 'position__all';
    }
    ?>
    <?php $department_args = [
    'post_type'   => 'position',
    'post_status' => 'publish',
    'meta_query'  => $meta_query
];
    $query_department      = new WP_Query;
    $posts_department      = $query_department->query($department_args);
    foreach ($posts_department as $dep_post) {
        if ( ! in_array(@get_post_custom_values('department', $dep_post->ID)[0], $unique)) {
            array_push($unique, @get_post_custom_values('department', $dep_post->ID)[0]);
        }
    }
    foreach ($unique as $department) {
        $data = get_position_by_department($department);
        ?>
        <div class="<?= $pos_class ?> active-position"
         data-position="<?= $department ?>">
            <div class="position__title">
                <h4><?= $department ?></h4>
            </div>
        <?php
        foreach ($data as $position_unit) {
            $is_available = @get_post_custom_values('available-position', $position_unit->ID)[0];
            if($is_available) {
                ?>
                <div class="position__unit">
                    <div class="position__detail">
                        <p class="position__name"><?= @get_post_custom_values('short_title', $position_unit->ID)[0] ?></p>
                        <p class="position__adress"><?= @get_post_custom_values('location', $position_unit->ID)[0] ?></p>
                        <p class="position__time"><?= @get_post_custom_values('type-of-engagement', $position_unit->ID)[0] ?></p>
                    </div>
                    <div class="position__button">
                        <a href="<?= get_permalink($position_unit->ID) ?>" class="btn" target="_blank">Read
                            Full Job Description</a>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        </div>
        <?php
    }
    die();
}

function get_faq_list($post_type)
{
    $args  = [
        'posts_per_page' => '-1',
        'post_type'      => $post_type,
    ];
    $query = new WP_Query;
    $posts = $query->query($args); ?>
    <?php foreach ($posts as $post) : ?>
    <h3><p class="faq-title"><?= $post->post_title ?></p></h3>
    <div class="accardion-collapse__inside">
        <?= wpautop($post->post_content) ?>
    </div>
<?php endforeach; ?>
    <?php
}

function search_faq()
{
    $expression = $_POST['search'];
    $post_type  = FAQ_POST_TYPE;
    global $wpdb;
    $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type='{$post_type}' AND (post_content LIKE '%{$expression}%' OR post_title LIKE '%{$expression}%') ORDER by post_date DESC",
        OBJECT);
    if ($results) {
        ?>
        <?php foreach ($results as $result) : ?>
            <h3 class="faq-title-wrap"><p class="faq-title"><?= $result->post_title ?></p></h3>
            <div class="accardion-collapse__inside">
                <?= $result->post_content ?>
            </div>
        <?php endforeach; ?>
        <?php
    }
    die();
}


function search_blog_posts()
{
    $expression = $_POST['search'];
    $cat_filter = $_POST['cat_filter'];
    $posts_per_page = -1;
    $tax_query[] = [
        'taxonomy' => 'category',
        'field'    => 'slug',
        'terms'    => $cat_filter
    ];
    $args = [
        'posts_per_page' => $posts_per_page,
        'post_type' => BLOG_POST_TYPE,
        's' => $expression ? $expression : '',
        'tax_query' => $cat_filter ? $tax_query : ''
    ];
    $query = new WP_Query;
    $posts = $query->query($args);
    ?>
    <?php if (!empty($posts)) :
        foreach ($posts as $post): ?>
            <div class="product-preview product-preview--posts" id="product-preview">
                <div class="image-block">
                    <?php $product_preview = get_the_post_thumbnail_url($post->ID, 'product-preview'); ?>
                    <img src="<?= $product_preview ? $product_preview : get_template_directory_uri() . "/assets/img/placeholder.png" ?>"
                         alt="Image">
                </div>
                <div class="product-preview__text">
                    <div class="product-preview__wrap">
                        <p class="product-preview__title"><?= $post->post_title ?></p>
                        <p class="product-preview__description"><?= get_the_date('F j, Y', $post->ID) ?></p>
                    </div>
                    <div class="hover-block hover-block--posts">
                        <div class="hover-block__text">
                            <div class="ellipsis">
                                <p class="blog-short-description"><?= get_post_custom_values('blog_description',
                                        $post->ID)[0] ?></p>
                            </div>
                        </div>
                        <a href="<?= get_permalink($post->ID) ?>" class="hover-block__link btn">Read More</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <input type="hidden" value="<?= $published_posts = wp_count_posts('post')->publish; ?>" class="posts-count"/>
    <?php else : ?>
    <h3 style="margin: 20px auto">
        We could not find any existing technical articles matching your search. However, our expert engineers are available and happy to help you with any questions you may have. Contact them by using the button below.' +
    </h3>
    <a style="margin: 0" class="application__btn btn" href="http://usb-vna.coppermountaintech.com/acton/media/24246/askanengineer" target="_blank">Ask an Engineer</a>
    <?php endif; ?>
    <?php
    die();
}

function search_documentation_posts()
{
    $expression = $_POST['search'];
    $cat_filter = $_POST['cat_filter'];
    $posts_per_page = -1;
    $tax_query[] = [
        'taxonomy' => 'documentation-category',
        'field'    => 'slug',
        'terms'    => $cat_filter
    ];
    $args = [
        'posts_per_page' => $posts_per_page,
        'post_type' => DOCUMENTATION_POST_TYPE,
        's' => $expression ? $expression : '',
        'tax_query' => $cat_filter ? $tax_query : ''
    ];
    $query = new WP_Query;
    $posts = $query->query($args);
    ?>
    <?php if (!empty($posts)) : ?>
        <?php foreach ($posts as $post): ?>
            <div class="product-preview product-preview--posts" id="product-preview">
                <div class="image-block">
                    <?php $product_preview = get_the_post_thumbnail_url($post->ID, 'product-preview'); ?>
                    <img src="<?= $product_preview ? $product_preview : get_template_directory_uri() . "/assets/img/placeholder.png" ?>"
                         alt="Image">
                </div>
                <div class="product-preview__text">
                    <div class="product-preview__wrap">
                        <p class="product-preview__title"><?= $post->post_title ?></p>
                        <p class="product-preview__description"><?= get_the_date('F j, Y', $post->ID) ?></p>
                    </div>
                    <div class="hover-block hover-block--posts">
                        <div class="hover-block__text">
                            <div class="ellipsis">
                                <p class="blog-short-description"><?= get_post_custom_values('documentation_description',
                                        $post->ID)[0] ?></p>
                            </div>
                        </div>
                        <a href="<?= get_permalink($post->ID) ?>" class="hover-block__link btn">Read More</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <input type="hidden" value="<?= $published_posts = wp_count_posts('post')->publish; ?>" class="posts-count"/>
    <?php else : ?>
    <h3 style="margin: 0 auto">No matches found</h3>
    <?php endif; ?>

    <?php
    die();
}

function search_elementor_pages()
{
    $search_value = $_POST['s'];
    $search_meta_post_key = $_POST['cmp_key'];

    $query = get_posts([
        "s" => $search_value,
        "post_type" => ["page"],
        "posts_per_page" => -1,
        "meta_query" => [
            "relation" => "AND",
            [
                "key" => $search_meta_post_key,
                "value" => 1,
                "compare" => "=",
                "type"  => "NUMERIC"
            ]
        ],
    ]);
    ?>
    <?php if (!empty($query)) : ?>
        <?php foreach ($query as $post): ?>
            <div class="search-item">
                <h4 class="search-page-title">
                    <a href="<?= get_permalink($post->ID); ?>">
                        <?= get_the_title($post->ID); ?>
                    </a>
                </h4>
                <p class="short-search-text"><?= get_the_excerpt($post->ID); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
    <h3 style="margin: 0 auto">No matches found</h3>
    <?php endif; ?>

    <?php
    die();
}

function search_webinars()
{
    global $wpdb;
    $expression = $_POST['search'];

    $cat_filter = $_POST['cat_filter'];
    $id         = $cat_filter;
    $post_type  = 'webinar';
    $query      = "SELECT * FROM wp_posts AS posts
             WHERE  post_type='{$post_type}' AND post_status='publish'
             AND (post_title LIKE '%{$expression}%' OR post_content LIKE '%{$expression}%')
             ORDER BY post_date DESC";
    $cat_query  = "SELECT * FROM wp_posts AS posts
             INNER JOIN wp_term_relationships as relation
             ON posts.ID=relation.object_id
             WHERE  post_type='{$post_type}' AND post_status='publish'
             AND (post_title LIKE '%{$expression}%' OR post_content LIKE '%{$expression}%')
             AND (term_taxonomy_id='{$id}')
             ORDER BY post_date DESC";
    if ($cat_filter === 'all') {
        $cat_filter = null;
    }
    if ($cat_filter) {
        $posts = $wpdb->get_results($cat_query, OBJECT);
    } else {
        $posts = $wpdb->get_results($query, OBJECT);
    }
    ?>
    <?php foreach ($posts as $post): $post_category = get_webinar_categories_by_post_id($post->ID); ?>
    <div>
        <div>
            <div class="product-preview webinar-preview"
                 data-category="<?= get_webinar_categories_by_post_id($post->ID) ?>">
                <div class="image-block">
                    <img class="webinar-image" src="<?= get_post_thumbnail($post) ?>"/>
                </div>
                <div class="product-preview__text">
                    <div class="product-preview__wrap">
                        <div class="ellipsis">
                            <p class="product-preview__title">
                                <?= $post->post_title ?>
                            </p>
                        </div>
                        <?php if (str_replace(' ', '', $post_category) !== 'recorded'): ?>
                            <p class="product-preview__description webinar-date"><?= get_webinar_date_by_id($post->ID) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="hover-block hover-block--posts">
                        <div class="hover-block__text">
                            <div>
                                <div class="blog-short-description">
                                    <?= apply_filters('the_content', $post->post_content); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= get_post_permalink($post) ?>" class="hover-block__link btn">Read More</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
    <?php
    die();
}

function get_frequencies_array($_frequency)
{
    $frequencies = get_terms([
        'taxonomy'   => $_frequency,
        'hide_empty' => false
    ]);
    $array       = [];
    foreach ($frequencies as $frequency) {
        array_push($array, $frequency->name);
    }
    $lower_array = array_map('strtolower', $array);
    $min         = in_array('dc', $lower_array) ? 'DC' : min($array);
    unset($lower_array[array_search('dc', $lower_array)]);
    $max = max($lower_array);
    $arr = [$min, $max];

    return $arr;
}

function get_min_and_max($post_type, $min, $max)
{
    global $wpdb;
    $result = $wpdb->get_results("SELECT  MAX(CAST(max_meta.meta_value AS UNSIGNED)), MIN(CAST(min_meta.meta_value AS UNSIGNED)) FROM wp_posts as posts
join wp_postmeta as max_meta ON posts.ID = max_meta.post_id AND max_meta.meta_key = '$max'
join wp_postmeta as min_meta ON posts.ID = min_meta.post_id AND min_meta.meta_key = '$min'
where posts.post_type = '$post_type' AND min_meta.meta_value REGEXP '^[0-9]+$' AND max_meta.meta_value REGEXP '^[0-9]+$'");
    $array  = json_decode(json_encode($result[0]), true);
    $array  = array_values($array);
    $max    = $array[0];
    $min    = $array[1];
    if ($max < $min) {
        $min = $array[0];
        $max = $array[1];
    }
    $array = [$min, $max];

    return $array;
}

function search_map_locations()
{
    global $wpdb;
    $expression = $_POST['search'];
    $category   = $_POST['category'];
    $term_id    = get_term_by('slug', $category, 'location')->term_id;
    $post_type  = LOCATION_POST_TYPE;
    if($expression == "india" || $expression == "India" || $expression == "mexico" || $expression == "Mexico"){
        $expression = ucfirst($expression);
        $query      = "SELECT p.ID id, p.post_title title, name.meta_value name, email.meta_value email, phone.meta_value phone,  order_location.meta_value order_location, website_url.meta_value website_url, latitude.meta_value latitude, longitude.meta_value longitude, location_address.meta_value location_address, location_key.meta_value location_key
        FROM wp_posts AS p
        JOIN wp_postmeta AS name
        ON p.ID = name.post_id AND name.meta_key = 'name'
        JOIN wp_postmeta AS email
        ON p.ID = email.post_id AND email.meta_key = 'email'
        JOIN wp_postmeta AS phone
        ON p.ID = phone.post_id AND phone.meta_key = 'phone'
        JOIN wp_postmeta AS website_url
        ON p.ID = website_url.post_id AND website_url.meta_key = 'website_url'
        JOIN wp_postmeta AS order_location
        ON p.ID = order_location.post_id AND order_location.meta_key = 'order_location'
        JOIN wp_postmeta AS latitude
        ON p.ID = latitude.post_id AND latitude.meta_key = 'latitude'
        JOIN wp_postmeta AS longitude
        ON p.ID = longitude.post_id AND longitude.meta_key = 'longitude'
        JOIN wp_postmeta AS location_address
        ON p.ID = location_address.post_id AND location_address.meta_key = 'location_address'
        JOIN wp_postmeta AS location_key
        ON p.ID = location_key.post_id AND location_key.meta_key = 'location_key_words'
        JOIN wp_term_relationships AS r
        ON r.object_id = p.ID
        WHERE
        p.post_status = 'publish'
        AND p.post_type = '{$post_type}' AND r.term_taxonomy_id = '${term_id}'
        AND((p.post_title = '%{$expression}%' OR phone.meta_value LIKE '%{$expression}%') OR ((name.meta_value LIKE '%{$expression}%' OR email.meta_value LIKE '%{$expression}%') OR location_key.meta_value = '{$expression}'))
        ORDER BY order_location.meta_value ASC , p.post_title ASC
                 ";
    }else{
        $query      = "SELECT p.ID id, p.post_title title, name.meta_value name, email.meta_value email, phone.meta_value phone,  order_location.meta_value order_location, website_url.meta_value website_url, latitude.meta_value latitude, longitude.meta_value longitude, location_address.meta_value location_address, location_key.meta_value location_key
        FROM wp_posts AS p
        JOIN wp_postmeta AS name
        ON p.ID = name.post_id AND name.meta_key = 'name'
        JOIN wp_postmeta AS email
        ON p.ID = email.post_id AND email.meta_key = 'email'
        JOIN wp_postmeta AS phone
        ON p.ID = phone.post_id AND phone.meta_key = 'phone'
        JOIN wp_postmeta AS website_url
        ON p.ID = website_url.post_id AND website_url.meta_key = 'website_url'
        JOIN wp_postmeta AS order_location
        ON p.ID = order_location.post_id AND order_location.meta_key = 'order_location'
        JOIN wp_postmeta AS latitude
        ON p.ID = latitude.post_id AND latitude.meta_key = 'latitude'
        JOIN wp_postmeta AS longitude
        ON p.ID = longitude.post_id AND longitude.meta_key = 'longitude'
        JOIN wp_postmeta AS location_address
        ON p.ID = location_address.post_id AND location_address.meta_key = 'location_address'
        JOIN wp_postmeta AS location_key
        ON p.ID = location_key.post_id AND location_key.meta_key = 'location_key_words'
        JOIN wp_term_relationships AS r
        ON r.object_id = p.ID
        WHERE 
        p.post_status = 'publish'
        AND p.post_type = '{$post_type}' AND r.term_taxonomy_id = '${term_id}'
        AND((p.post_title LIKE '%{$expression}%' OR phone.meta_value LIKE '%{$expression}%') OR ((name.meta_value LIKE '%{$expression}%' OR email.meta_value LIKE '%{$expression}%') OR location_key.meta_value LIKE '%{$expression}%'))
        ORDER BY order_location.meta_value ASC , p.post_title ASC
                 ";
    }
    $posts      = $wpdb->get_results($query, OBJECT);
    if($expression == 'Virginia' || $expression == 'virginia'){
        $post_to_array = json_decode(json_encode($posts),true);
        $posts = [];
        foreach ($post_to_array as $item){
            $str_arr = array_map('trim', explode(',', $item['location_key']));
            if(array_search('Virginia',$str_arr)){
                $posts[] = $item;
            }
        }
        $posts = json_decode(json_encode($posts), FALSE);
    }
    $marker_id  = 1;
    ?>
    <?php foreach ($posts as $post): ?>
    <div class="map-container__item" onclick="onItemClick(this)">
        <p class="map-container__item-title"><?= $post->title ?></p>
        <?php if ($post->name): ?>
            <p class="map-container__item-name"><?= $post->name ?></p>
        <?php endif; ?>
        <?php if ($post->location_address): ?>
            <p class="map-container__item-email">Address:
                <a><?= $post->location_address ?></a>
            </p>
        <?php endif; ?>
        <?php if ($post->email && $category === 'third-party-laboratories'): ?>
            <p class="map-container__item-email">Email:
                <a href="mailto:<?= $post->email ?>"><?= $post->email ?></a>
            </p>
        <?php endif; ?>
        <?php if ($post->phone): ?>
            <p class="map-container__item-phone">Phone:
                <a href="tel:<?= $post->phone ?>"><?= $post->phone ?></a>
            </p>
        <?php endif; ?>
        <?php if ($post->website_url): ?>
            <p class="map-container__item-site">Website:
                <a href="<?= $post->website_url ?>" target="_blank"><?= $post->website_url ?></a>
            </p>
        <?php endif; ?>
        <?php if ($post->email && $category === 'find-a-representative'): ?>
            <div class="email-btn-wrap"><a class="btn email-representative-btn" href="<?= $post->email ?>"
                                           target="_blank">Email Representative</a></div>
        <?php endif ?>
        <?php if ($post->email && $category === 'contact-us'): ?>
            <div class="email-btn-wrap"><a class="btn email-representative-btn" href="<?= $post->email ?>"
                                           target="_blank">Email Us</a></div>
        <?php endif ?>
        <input type="hidden" class="latitude" value="<?= $post->latitude ?>"/>
        <input type="hidden" class="longitude" value="<?= $post->longitude ?>"/>
        <input type="hidden" class="marker_id" value="<?= $marker_id++ ?>"/>
        <input type="hidden" class="key_words" value="<?= $post->location_key ?>"/>
    </div>
<?php endforeach; ?>
    <?php
    die();
}

function get_post_img($post_id, $size = 'full')
{
    $post_img_url = get_the_post_thumbnail_url($post_id, $size);
    if ( ! empty($post_img_url)) {
        return $post_img_url;
    }

    return get_template_directory_uri() . "/assets/img/placeholder-450x280.png";
}

function get_related_posts($key)
{
    global $wpdb;
    $post_ids = [];
    $results  = [];
    $matrix   = [
        "TR1300"              => ["TR5048", "R54", "ACM6000T", "S911T", "N1.1"],
        "TR5048"              => ["TR1300", "S5048", "ACM6000T", "N611", "S911T", " N612"],
        "TR7530"              => ["S7530", "TR5048", "ACM4000T", "F7511"],
        "S5048"               => ["TR5048", "S5065", "ACM6000T", "N611", "N612", "S911T"],
        "S7530"               => ["TR7530", "S5048", "ACM4000T", "F7511"],
        "S5065"               => ["S5048", "S5085", "ACM2509", "N911", "N912", "S911T"],
        "S5085"               => ["S5065", "Planar 804", "C1209", "ACM2509", "N911", "N912", "S911T"],
        "804/1"               => ["Planar 814/1", "S5085", "C1209", "ACM2509", "N911", "N912", "S911T"],
        "304/1"               => ["S5048", "C1209", "ACM6000T", "N611", "N612", "S911T"],
        "814/1"               => ["Planar 804/1", "C2209", "ACM2509", "N911", "N912", "S911T"],
        "808/1"               => ["Planar 804/1", "C1409", "ACM8400T", "N911", "N912", "S911T"],
        "C1209"               => ["C2209", "C1409", "S5085", "ACM2509", "N911", "N912", "S911T"],
        "C1220"               => ["C2220", "C1420", "ACM2520", "S2611", "N1801"],
        "C2209"               => ["C1209", "C2220", "ACM2509", "N911", "N912", "S911T"],
        "C2220"               => ["C2209", "C1220", "ACM2520", "S2611", "N1801"],
        "C4209"               => ["C1209", "C4220", "ACM2509", "N911", "N912", "S911T"],
        "C4220"               => ["C1220", "C4209", "ACM2520", "S2611", "N1801"],
        "C1409"               => ["C1209", "C1420", "ACM2509", "N911", "N912", "S911T"],
        "C1420"               => ["C1409", "C1220", "ACM2520", "S2611", "N1801"],
        "C2409"               => ["C2420", "C2209", "ACM2509", "N911", "N912", "S911T"],
        "C2420"               => ["C2409", "C2220", "ACM2520", "S2611", "N1801"],
        "C4409"               => ["C4209", "C1409", "ACM2509", "N911", "N912", "S911T"],
        "C4420"               => ["C4220", "C1420", "ACM2520", "S2611", "N1801"],
        "R54"                 => ["R60", "TR5048", "ACM6000T", "N611", "N612", "S911T"],
        "R60"                 => ["R54", "R140", "S5065", "ACM6000T", "N611", "N612", "S911T"],
        "R140"                => ["R60", "R180", "ACM2520", "S2611", "N1801"],
        "R180 (-02, default)" => ["R140", "R60", "ACM2520", "S2611", "N1801"]
    ];
    $result   = isset($matrix[$key]) ? $matrix[$key] : null;
    if ($result) {
        foreach ($result as $item) {
            $query = $wpdb->get_results("SELECT post_id FROM wp_postmeta where meta_key = 'product_id' and meta_value = '$item' and meta_value != ''",
                ARRAY_N);
            $query = json_decode(json_encode($query[0]), true);
            array_push($post_ids, $query);
        }
        $post_ids = array_values($post_ids);
        foreach ($post_ids as $id) {
            array_push($results, $id[0]);
        }
    } else {
        $results = false;
    }

    return $results;
}

function select_country()
{
    update_option('countries_list', $_POST['country']);
    die();
}

function get_single_product_big_image($post_img, $preview_imgs)
{
    if ($post_img) {
        return $post_img;
    }
    if ( ! empty($preview_imgs[0])) {
        return wp_get_attachment_image_src($preview_imgs[0], 'product-img')[0];
    }

    return get_template_directory_uri() . "/assets/img/placeholder.png";
}

function get_post_thumbnail($post)
{
    $post_img = get_the_post_thumbnail_url($post->ID);
    $post_img = $post_img ? $post_img : get_template_directory_uri() . "/assets/img/placeholder.png";

    return $post_img;
}

function smackdown_add_quicktags()
{

    if (wp_script_is('quicktags')) { ?>
        <script type="text/javascript">
            QTags.addButton('accordion_tag', 'accordion', '[accordion][/accordion]', '', '', '', 1);
            QTags.addButton('accordion_title_tag', 'accordion-title', '[accordion-title order=""] title [/accordion-title]', '', '', '', 1);
            QTags.addButton('accordion_description_tag', 'accordion-description', '[accordion-description order=""] description [/accordion-description]', '', '', '', 1);
            QTags.addButton('banners_tag', 'banners', '[cmt_banners title="" post_type="" post_id="" height=""][/cmt_banners]', '', '', '', 1);
            QTags.addButton('applications_tag', 'applications', '[cmt_applications  title=""][/cmt_applications]', '', '', '', 1);
            QTags.addButton('testimonials_tag', 'testimonials', '[testimonials  title=""][/testimonials]', '', '', '', 1);
            QTags.addButton('where_vnas_tag', 'where vnas', '[where_vnas number_of_posts="" title="" btn_text="" btn_link="#"][/where_vnas]', '', '', '', 1);
            QTags.addButton('add_post_tag', 'Add product', '[add_post id=""][/add_post]', '', '', '', 1);
            QTags.addButton('add_section', 'Add section', '<section></section>', '', '', '', 1);
            QTags.addButton('add_container', 'Add container', "<div class='container'></div>", '', '', '', 1);
        </script>
    <?php }

}

function get_banner_img($post_id)
{
    $post_img_url = get_the_post_thumbnail_url($post_id, 'banner-img');
    if ( ! empty($post_img_url)) {
        return $post_img_url;
    }

    return get_template_directory_uri() . "/assets/img/placeholder-450x157.png";
}

function select_chinese()
{
    update_option('chinese_countries', $_POST['country']);
    die();
}

function select_portuguese()
{
    update_option('portuguese_countries', $_POST['country']);
    die();
}

function select_spanish()
{
    update_option('spanish_countries', $_POST['country']);
    die();
}

function select_japanese()
{
    update_option('japanese_countries', $_POST['country']);
    die();
}

function check_country($country_name, $list)
{
    if ( ! empty($list)) {
        if (in_array($country_name, $list)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function check_visitor_country()
{
    $ip = get_visitor_ip();
    if ( ! isset($_COOKIE['country_name'])) {
        $details = json_decode(curl_get_file_contents('http://api.ipstack.com/' . $ip . '?access_key=' . API_KEY));
        setcookie("country_name", $details->country_name);
    }
}

function get_country_by_ip()
{
    $ip = get_visitor_ip();
    if ( !isset($_COOKIE['country_name'])) {
        $details = json_decode(curl_get_file_contents('http://api.ipstack.com/' . $ip . '?access_key=' . API_KEY));
        setcookie("country_name", $details->country_name);
        return $details->country_name;
    } else {
        return  $_COOKIE['country_name'];
    }
}

function load_translation_home_page()
{
    $ip      = get_visitor_ip();
    $details = new stdClass();
    if ( ! isset($_COOKIE['country_name'])) {
        $details = json_decode(curl_get_file_contents('http://api.ipstack.com/' . $ip . '?access_key=' . API_KEY));
        setcookie("country_name", $details->country_name);
        redirect_to_page($details);
    } else {
        $details->country_name = $_COOKIE['country_name'];
        redirect_to_page($details);
    }
}

function get_visitor_ip()
{
    if ( ! empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

function redirect_to_page($details)
{
    $country_name         = $details->country_name;
    $chinese_countries    = get_option('chinese_countries');
    $portuguese_countries = get_option('portuguese_countries');
    $spanish_countries    = get_option('spanish_countries');
    $japanese_countries   = get_option('japanese_countries');
    if (is_front_page()) {
        if ( ! isset($_COOKIE['firsttime'])) {
            setcookie("firsttime", "no");
            if (check_country($country_name, $spanish_countries)) {
                wp_redirect(pll_home_url('es'));
                exit;
            } elseif (check_country($country_name, $portuguese_countries)) {
                wp_redirect(pll_home_url('pt'));
                exit;
            } elseif (check_country($country_name, $chinese_countries)) {
                wp_redirect(pll_home_url('zh'));
                exit;
            } elseif (check_country($country_name, $japanese_countries)) {
                wp_redirect(pll_home_url('ja'));
                exit;
            }
			/*else {
                wp_redirect(pll_home_url('es'));
                exit;
            }*/
        }
    }
}

function check_page()
{
    if (is_archive()) {
        return post_type_archive_title();
    }

    return the_title();
}

function chech_post_single_page($post_type)
{
    $no_single = ['faq', 'application', 'testimonial'];
    if (in_array($post_type, $no_single)) {
        return get_post_type_archive_link($post_type);
    }

    return the_permalink();
}

function get_webinar_date_by_id($post_id)
{
    $webinarDate = get_post_meta($post_id, 'cmt_webinar_date', true);
    $dateTimeUtc = "";
    if ( ! empty($webinarDate)) {
        $dateTime    = date_create_from_format('M d, Y h:i A e', $webinarDate);
        $dateTimeUtc = gmdate('Y M d h:i A e', $dateTime->getTimestamp());
    }

    return $dateTimeUtc;
}

function get_webinars_categories()
{
    global $wpdb;
    $result     = [];
    $categories = $wpdb->get_results("SELECT t.name, t.slug FROM `wp_terms` AS t INNER JOIN `wp_term_taxonomy` as tax ON t.term_id = tax.term_id AND tax.taxonomy = 'webinar_category'",
        ARRAY_N);
    if (is_array($categories) && count($categories) > 0) {
        $result = array_map(function ($category) {
            return [
                'name' => $category[0],
                'slug' => $category[1]
            ];
        }, $categories);
    }

    return $result;
}

function get_webinar_categories_by_post_id($post_id)
{
    $args       = [
        "fields" => "all"
    ];
    $categories = wp_get_post_terms($post_id, 'webinar_category', $args);

    return array_reduce($categories, function ($result, $item) {
        $result .= $item->slug . " ";

        return $result;
    });
}

function get_tab_color($border_color)
{
    $color = 'green';
    switch ($border_color) {
        case 'border-blue':
            $color = 'blue';
            break;
        case 'border-green':
            $color = 'green';
            break;
        case 'border-yellow':
            $color = 'yellow';
            break;
        case 'border-red':
            $color = 'red';
            break;
        case 'border-grey':
            $color = 'grey';
            break;
        case 'border-pink':
            $color = 'pink';
            break;
        case 'sc-blue':
            $color = 'scblue';
            break;
        case 'sc-grey':
            $color = 'scgrey';
            break;
        case 'sc-green':
            $color = 'scgreen';
            break;
    }

    return $color;
}

function load_cookie()
{
    $cookie = $_POST['rand_arr'];

    return $cookie;
}

function get_impedance($impedance_50, $impedance_75)
{
    if ($impedance_50 && $impedance_75) {
        return '50 Ohm, 75 Ohm';
    }
    if ($impedance_50) {
        return '50 Ohm';
    }
    if ($impedance_75) {
        return '75 Ohm';
    }
}

function check_specifications($fields, $id)
{
    foreach ($fields as $field) {
        if (@get_post_custom_values($field, $id)[0]) {
            return true;
        }
    }

    return false;
}

function get_all_posts($post_type, $impedance)
{
    global $wpdb;
    $query   = "SELECT DISTINCT posts.ID,upper_frequency.meta_value upper_frequency, impedance.meta_value impedance, number_of_ports.meta_value number_of_ports, product_type.meta_value product_type  FROM wp_posts as posts
    INNER JOIN wp_postmeta AS upper_frequency
    ON posts.ID=upper_frequency.post_id AND upper_frequency.meta_key = 'upper_frequency'
    INNER JOIN wp_postmeta AS impedance
    ON posts.ID=impedance.post_id AND impedance.meta_key = 'cholesterol'
    INNER JOIN wp_postmeta AS number_of_ports
    ON posts.ID=number_of_ports.post_id AND number_of_ports.meta_key = 'number_of_ports'
    INNER JOIN wp_postmeta AS product_type
    ON posts.ID=product_type.post_id AND product_type.meta_key = 'product_type'
    where post_type='{$post_type}' and impedance.meta_value='{$impedance}'";
    $results = $wpdb->get_results($query, OBJECT);

    return $results;
}

function get_all_extensions()
{
    global $wpdb;
    $query   = "SELECT DISTINCT posts.ID,freq_ext_variation.meta_value freq_ext_variation, freq_ext_type.meta_value freq_ext_type  FROM wp_posts as posts
    INNER JOIN wp_postmeta AS freq_ext_variation
    ON posts.ID=freq_ext_variation.post_id AND freq_ext_variation.meta_key = 'freq_ext_variation'
    INNER JOIN wp_postmeta AS freq_ext_type
    ON posts.ID=freq_ext_type.post_id AND freq_ext_type.meta_key = 'freq_ext_type'
    where post_type='frequency-extension'";
    $results = $wpdb->get_results($query, OBJECT);

    return $results;
}

function check_product($posts, $frequency, $product_type, $number_of_ports)
{
    foreach ($posts as $post) {
        $up_freq         = str_replace(" ", "", $post->upper_frequency);
        $frequency       = str_replace(" ", "", $frequency);
        $number_of_ports = str_replace(" ", "", $number_of_ports);
        $post_num_ports  = str_replace(" ", "", $post->number_of_ports);
        $product_type    = strtolower($product_type);
        $post_prod_type  = strtolower($post->product_type);

        if ($frequency && $product_type == null) {
            if ($up_freq == $frequency && $post_num_ports == $number_of_ports) {
                return true;
            }
        }
        if ($frequency && $product_type != null) {
            if (($up_freq == $frequency && $post_num_ports == $number_of_ports) && $post_prod_type == $product_type) {
                return true;
            }
        }
    }
}

function check_extensions($posts,$type,$variation)
{
    foreach ($posts as $post) {
        $ext_type = str_replace(" ", "", $type);
        $post_ext_type = str_replace(" ", "", $post->freq_ext_type);
        $post_ext_type = maybe_unserialize($post_ext_type);
        $ext_variation = str_replace(" ", "", $variation);
        $post_ext_variation = str_replace(" ", "", $post->freq_ext_variation);
        if(is_array($post_ext_type) && $post_ext_variation == $ext_variation && in_array($ext_type,$post_ext_type)){
            return true;
        }
    }
}

function search_products_by_upper_frequency()
{
    $paged            = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $posts_per_page   = 50;
    $terms            = $_POST['term'];
    $id               = $terms['itemId'];
    $post_type        = $_POST['term']['post_type'];
    $product_category = $_POST['term']['product_category_name'];
    $taxonomy         = get_object_taxonomies($post_type)[1];
    $show_id          = $terms['showIds'];
    $solutions_taxonomy = get_object_taxonomies($post_type)[4];
    $args             = [
        'posts_per_page' => $posts_per_page,
        'post_type'      => $post_type,
        'offset'         => $posts_per_page * ($paged - 1)

    ];

    if (isset($terms['category'])) {
        $tax_query[] = [
            'taxonomy' => $product_category,
            'field'    => 'slug',
            'terms'    => $terms['category']
        ];
    }

    if (isset($terms['number_of_ports'])) {
        $meta_query[] =
            [
                'key'     => 'number_of_ports',
                'value'   => $terms['number_of_ports'],
                'compare' => '='
            ];
    }

    if (isset($terms['impedance'])) {
        $meta_query[] = [
            'key'   => 'cholesterol',
            'value' => $terms['impedance']
        ];
    }

    if (isset($terms['product_type']) && $terms['product_type'] !== "") {
        $meta_query[] = [
            'key'     => 'product_type',
            'value'   => $terms['product_type'],
            'compare' => '='
        ];
    }

    if (isset($terms['upper_frequency'])) {
        $meta_query[] =
            [
                'key'     => 'upper_frequency',
                'value'   => $terms['upper_frequency'],
                'compare' => '='
            ];
    }

    if (isset($terms['ext_type'])&&!empty($terms['ext_type'])) {
        $meta_query[] =
            [
                'key'     => 'freq_ext_type',
                'value'   => $terms['ext_type'],
                'compare' => 'LIKE'
            ];
    }

    if (isset($terms['ext_variation'])&&!empty($terms['ext_variation'])) {
        $meta_query[] =
            [
                'key'     => 'freq_ext_variation',
                'value'   => $terms['ext_variation'],
                'compare' => '='
            ];
    }

    $args = [
        'posts_per_page' => $posts_per_page,
        'post_type'      => $post_type,
        'offset'         => $posts_per_page * ($paged - 1),
        'order'          => 'DESC',
        'tax_query'      => $tax_query,
        'meta_query'     => $meta_query
    ];

    $query = new WP_Query;
    $posts = $query->query($args);
    if ($posts):?>
        <?php foreach ($posts as $post): ?>
            <?php
            $taxonomies = '';
            $terms         = get_the_terms($post->ID, $taxonomy);
            $solutions_terms = get_the_terms($post->ID, $solutions_taxonomy);
            foreach ($terms as $term) {
                $taxonomies .= $term->slug . ',';
            }
            foreach ($solutions_terms as $solution_term) {
                $taxonomies .= $solution_term->slug . ',';
            }
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
            $product_img   = get_the_post_thumbnail_url($post->ID,
                'product-preview') ? get_the_post_thumbnail_url($post->ID,
                'product-preview') : get_template_directory_uri() . "/assets/img/placeholder.png";
            $images_str    = @get_post_custom_values('_multi_img_array', $post->ID)[0];
            $images        = [];
            if ( ! empty($images_str)) {
                $images = explode(',', $images_str);
            }
            $hover_image = wp_get_attachment_image_src($images[0], 'product-preview')[0];
            $product_tag = @get_post_custom_values('product_tag',$post->ID)[0];
            ?>
            <div id="<?= $show_id ? $id : '' ?>"
                 class="product-preview product-preview--single <?= $product_color["tax_color"] ? $product_color["tax_color"] : 'border-green' ?> load-more <?=$post->ID?>"
                 data-taxonomy="<?= $taxonomies ?>" onmouseover="hover(this);" onmouseout="unhover(this);" onclick="redirect(this)" data-new-location="<?=get_the_permalink($post->ID);?>">
                <?php if($product_tag): ?>
                    <div class="ribbon <?=$product_tag?>"><span><?=check_tag_name($product_tag)?></span></div>
                <?php endif;?>
                <div class="image-block">
                    <a href="<?= get_the_permalink($post->ID) ?>"><img src="<?= get_the_post_thumbnail_url($post->ID,
                            'product-preview') ? get_the_post_thumbnail_url($post->ID,
                            'product-preview') : get_template_directory_uri() . "/assets/img/placeholder.png" ?>"
                                                                       alt="Image" class="product-card-image"
                                                                       data-second-image="<?= $hover_image ?>"
                                                                       data-main-image="<?= $product_img ?>"></a>
                </div>
                <?php
                $has_characteristics = false;
                $frequency_min       = freguency_converter(@get_post_custom_values('frequency_min', $post->ID)[0]);
                $frequency_max       = freguency_converter(@get_post_custom_values('frequency_max', $post->ID)[0]);
                $price               = @get_post_custom_values('product_price', $post->ID)[0];
                $price_to            = @get_post_custom_values('product_price_to', $post->ID)[0];
                ?>
                <div class="product-preview__text">
                    <div class="product-preview__wrap">
                        <p class="product-preview__title"><?= $post->post_title ?></p>
                        <p class="product-preview__price">
                            <?= check_price_range($price, $price_to, true) ?>
                        </p>
                        <p class="product-preview__description"> <?= $frequency_min ? $frequency_min : '' ?>
                            <?php if ($frequency_max): ?>
                                to
                                <?= $frequency_max ?>
                            <?php endif; ?></p>
                    </div>
                    <div class="hover-block">
                        <ul class="hover-block__list">
                            <?php if ($frequency_min || $frequency_max) : $has_characteristics = true; ?>
                                <li class="hover-block__item">- Frequency range:
                                    <?= $frequency_min ? $frequency_min : '-' ?>
                                    <?php if ($frequency_max): ?>
                                        to
                                        <?= $frequency_max ?>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                            <?php $measured_parameters = @get_post_custom_values('measured_parameters',
                                $post->ID)[0];
                            if ($measured_parameters): $has_characteristics = true; ?>
                                <li class="hover-block__item">- Measured
                                    parameters: <?= $measured_parameters ?></li>
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
                            <?php if ($post_type == CALIBRATION_KITS_POST_TYPE): ?>
                                <?php
                                $impedance_50 = @get_post_custom_values('impedance_50', $post->ID)[0];
                                $impedance_75 = @get_post_custom_values('impedance_75', $post->ID)[0];
                                if ($impedance_50 == 'on' || $impedance_75 == 'on'):?>
                                    <li class="hover-block__item">- Impedance: <?= get_impedance($impedance_50,
                                            $impedance_75); ?></li>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php $impedance = @get_post_custom_values('cholesterol', $post->ID)[0];
                                if ($impedance): $has_characteristics = true; ?>
                                    <li class="hover-block__item">- Impedance: <?= $impedance . ' Ohm' ?></li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php $measurement_type = @get_post_custom_values('measurement_type', $post->ID)[0];
                            if ($measurement_type): $has_characteristics = true; ?>
                                <li class="hover-block__item">- Measurement type: <?= $measurement_type ?></li>
                            <?php endif; ?>
                            <?php if ( ! $has_characteristics): ?>
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
    else:
        echo 'No products found';
    endif;
    die();
}

function check_tag_name($tag)
{
    switch ($tag){
        case 'new':
            return 'NEW';
            break;
        case 'end-of-sale':
            return 'End of Sale';
            break;
        case 'discontinued':
            return 'Discontinued';
            break;
    }
}

function get_upper_categories($category, $post_type)
{
    $terms = get_terms([
        'taxonomy' => $category[0],
        'hide_empty' => true,
    ]);
    $terms_solutions = get_terms([
        'taxonomy' => $category[1],
        'hide_empty' => true,
    ]);
    ?>
    <div class="filters">
        <h2 class="filters__title"><?= check_page() ?>
            <i></i>
        </h2>
        <div class="filters__wrap">
            <input type="hidden" id="product_category_name" value="<?= $category[0] ?>"/>
            <?php if (!empty($terms)): ?>
                <div class="categories block">
                    <?php foreach ($terms as $term): ?>
                        <div class="categories__item">
                            <input type="checkbox" name="<?= $term->slug ?>" value="<?= $term->name ?>"
                                   id="<?= $term->term_id ?>" class="upper-tax-filter">
                            <label for=<?= $term->term_id ?>></label>
                            <span class="categories__text title-checkbox"><?= $term->name ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (!empty($terms_solutions)): ?>
                    <h2>Application Solutions</h2>
                    <input type="hidden" id="product_category_name" value="<?= $category[1] ?>"/>
                    <div class="categories block">
                        <?php foreach ($terms_solutions as $term_solution): ?>
                            <div class="categories__item">
                                <input type="checkbox" name="<?= $term_solution->slug ?>"
                                       value="<?= $term_solution->name ?>"
                                       id="<?= $term_solution->term_id ?>" class="upper-tax-filter">
                                <label for=<?= $term_solution->term_id ?>></label>
                                <span class="categories__text title-checkbox"><?= $term_solution->name ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

function check_price_range($from, $to, $is_list)
{
    $price_class = $is_list ? 'product-card-price' : '';
    $price_tag   = $is_list ? 'span' : 'strong';
    if ($from > 0 || $to > 0) {
        if ($from && $to) {
            return '<' . $price_tag . ' class=' . $price_class . '>$ ' . number_format($from,
                    0) . ' - $ ' . number_format($to, 0) . ' USD</' . $price_tag . '>';
        }
        if ($from) {
            return '<' . $price_tag . ' class=' . $price_class . '>$ ' . number_format($from,
                    2) . ' USD</' . $price_tag . '>';
        }
        if ($to) {
            return '<' . $price_tag . ' class=' . $price_class . '>$ ' . number_format($to,
                    2) . ' USD</' . $price_tag . '>';
        }
    }
}

function get_regions($regions)
{
    ?>
    <div class="location-selector_first-column">
        <?php for ($i = 0; $i <= 3; $i++): ?>
            <div class="location-selector_region-item" onclick="regionClick(this)"><?= $regions[$i] ?></div>
        <?php endfor; ?>
    </div>
    <div class="location-selector_second-column">
        <?php for ($i = 4; $i <= 6; $i++): ?>
            <div class="location-selector_region-item" onclick="regionClick(this)"><?= $regions[$i] ?></div>
        <?php endfor; ?>
    </div>
    <?php
}


function import_services()
{
    $file = fopen(get_template_directory_uri() . '/assets/services.csv', 'r');
    while (($line = fgetcsv($file)) !== false) {
        $post_data = array(
            'post_title'  => wp_strip_all_tags($line[0]),
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type'   => CALIBRATION_SERVICE
        );

        $post_id = wp_insert_post($post_data);
        add_post_meta($post_id, 'instrument', $line[0]);
        add_post_meta($post_id, 'calibration_type', $line[1]);
        add_post_meta($post_id, 'cal_price', $line[2]);
        add_post_meta($post_id, 'cal_url', $line[3]);
    }
    fclose($file);
}

function get_integrations()
{
    $expression = $_POST['search'];
    $cat_filter = $_POST['cat_filter'];
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $posts_per_page = -1;
    $tax_query[] = [
        'taxonomy' => 'integration_category',
        'field'    => 'slug',
        'terms'    => $cat_filter
    ];
    $args = [
        'posts_per_page' => $posts_per_page,
        'post_type' => INTEGRATIONS_POST_TYPE,
        'offset' => $posts_per_page * ($paged - 1),
        's' => $expression ? $expression : '',
        'tax_query' => $cat_filter ? $tax_query : ''
    ];
    $query = new WP_Query;
    $posts = $query->query($args);
    ?>
        <div class="application-pages-list">
            <?php foreach ($posts as $post): ?>
                <a class="app-card" href="<?= @get_post_custom_values('cmt_integrations_btn_link', $post->ID)[0] ?>"
                   target="_blank">
                    <div class="app-image-container" style="background: url('<?=get_the_post_thumbnail_url($post->ID)?>')">
                    </div>
                    <div class="app-title">
                        <p><?= $post->post_title ?></p>
                    </div>
                    <div class="app-btn-container">
                        <?php $btn_text = @get_post_custom_values('cmt_integrations_btn_text', $post->ID)[0];
                        if ($btn_text !== ''): ?>
                            <div class="btn"><?= $btn_text ?></div>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
            <?php
            $published_posts = wp_count_posts(INTEGRATIONS_POST_TYPE)->publish;
            $page_number_max = ceil($published_posts / $posts_per_page);
            ?>
            <p class="pagination" style="display:  none;">
                <a class="pagination__next" href=<?= get_next_posts_page_link($page_number_max); ?>></a>
            </p>
        </div>
    <?php
}

function get_products_for_selector()
{
    $post_type = $_POST['selected_post_type'];
    $args = [
        'posts_per_page' => -1,
        'post_type' => $post_type,
    ];
    $query = new WP_Query;
    $posts = $query->query($args);
    ?>
        <?php foreach ($posts as $post): ?>
            <li data-post-id="<?=$post->ID?>" class="list-item"><?=$post->post_title?></li>
        <?php endforeach; ?>
    <?php
    die();
}

function get_product_list_link($post_type, $impedance)
{
    $url = get_post_type_archive_link( $post_type );
    if($post_type === VNA_POST_TYPE && $impedance === '50'){
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'templates/50-ohm-vna.php'
        ));
        $url = get_page_link($pages[0]->ID);
    }

    if($post_type === VNA_POST_TYPE && $impedance === '75'){
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'templates/75-ohm-vna.php'
        ));
        $url = get_page_link($pages[0]->ID);
    }
    return $url;
}

function curl_get_file_contents($URL)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) return $contents;
    else return FALSE;
}
