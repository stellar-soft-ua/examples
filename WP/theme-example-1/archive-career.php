<?php get_header(); ?>
<?php
$page_data = get_page_by_path('careers');
$page_id = $page_data->ID;
$img_url = wp_get_attachment_image_src(get_post_thumbnail_id($page_id), 'full')[0];
?>
    <section class="careers-text">
        <div class="container">
            <h1><?= $page_data->post_title ?></h1>
            <div class="careers-text__wrap">
                <?= $page_data->post_content ?>
                <div class="careers-text__image"></div>
            </div>

        </div>
    </section>

    <section class="positions">
        <div class="positions__image" style="background-image: url(<?= $img_url ? $img_url : '' ?>)!important;"></div>
        <div class="container">
            <div class="positions__wrap">
                <a href="<?= get_permalink(get_theme_mod('cmt_career_positions_url')) ?>" class="btn">View All Open Positions</a>
            </div>
        </div>
    </section>

    <section class="fields-activity">
        <div class="container">
            <div class="fields-activity__list">
                <?php
                $posts_per_page = 4;
                $args = [
                    'post_type'      => 'career',
                    'post_status'    => 'publish',
                    'posts_per_page' => $posts_per_page,
                    'orderby'        => 'rand',
                ];
                $query = new WP_Query;
                $posts = $query->query($args); ?>
                <?php foreach ($posts as $post): ?>
                    <div class="fields-activity__activity">
                        <?php $career_preview = get_the_post_thumbnail_url($post->ID, 'career-img'); ?>
                        <img src="<?= $career_preview ? $career_preview : 'http://placehold.it/285x205' ?>"/>
                        <a href="<?= get_permalink($post->ID); ?>"><?= @get_post_custom_values('short_title',
                                $post->ID)[0] ?></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php get_footer(); ?>