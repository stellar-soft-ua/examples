<?php
add_shortcode("cmt_banners", "cmt_banners_callback");

function cmt_banners_callback($atts)
{
    $atts = shortcode_atts([
        'title'     => '',
        'post_id'   => '',
        'post_type' => BANNER_POST_TYPE,
        'height'    => 0
    ], $atts);
    $title = $atts['title'];
    $post_id = intval($atts['post_id']);
    $post_type = $atts['post_type'];
    $height = intval($atts['height']);
    $height = $height > 0 ? $height : 157;
    $wp_query = new WP_Query;

    if ($post_id > 0) {
        $post_type = BANNER_GALLERIES_POST_TYPE;
    }

    switch ($post_type) {
        case 'banner':
            $posts = $wp_query->query([
                'post_type'      => BANNER_POST_TYPE,
                'posts_per_page' => -1,
                'orderby'        => 'post_date',
                'order'          => 'DESC',
                'post_status'    => 'publish'
            ]);
            break;
        case 'banners_gallery':
            $posts = $wp_query->query([
                'post_type' => BANNER_GALLERIES_POST_TYPE,
                'p'         => $post_id
            ]);
            break;
        default:
            return;
    }

    if (empty($posts)) {
        return;
    }
    ob_start();
    ?>
    <section class="slider-big">
        <div class="container">
            <?php if (!empty($title)): ?>
                <h2>
                    <?= $title ?>
                </h2>
            <?php endif; ?>
            <div class="slider-big__wrap">
                <?php if ($post_type == BANNER_POST_TYPE) {
                    generate_banner_posts($posts);
                } else {
                    generate_banner_galleries_posts($posts, $height);
                } ?>
            </div>
            <div class="slider-big__arrows">
                <i class="slider-big__arrow arrow-left"></i>
                <i class="slider-big__arrow arrow-right"></i>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

function generate_banner_posts($posts)
{
    foreach ($posts as $post) : ?>
        <div class="slider-big__slide">
            <?php $post_link = get_post_meta($post->ID, 'cmt_banner_meta_url', true);
            if (!empty($post_link)) : ?>
                <a href="<?= $post_link ?>" target="_blank">
                    <img src="<?= get_banner_img($post->ID) ?>" alt="Banner image"/>
                </a>
            <?php else : ?>
                <img src="<?= get_banner_img($post->ID) ?>" alt="Banner image"/>
            <?php endif; ?>
        </div>
    <?php endforeach;
}

function generate_banner_galleries_posts($posts, $height)
{
    $post = $posts[0];
    $gallery = get_post_gallery($post->ID, false);
    $gallery_attach_ids = explode(',', $gallery['ids']);

    if (!(empty($gallery_attach_ids))) {
        foreach ($gallery_attach_ids as $id) {
            ?>
            <div class="slider-big__slide">
                <img src="<?= wp_get_attachment_image_src($id,"full")[0] ?>" style="max-height: <?=$height?>px"/>
            </div>
            <?php
        }
    }
}