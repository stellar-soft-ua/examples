<?php get_header(); ?>

<?php
the_post();
$post_category = get_webinar_categories_by_post_id(get_the_ID());
$register_link = get_post_meta(get_the_ID(), 'cmt_webinar_register_url', true);
$webinar_date = get_webinar_date_by_id(get_the_ID());
?>
<section class="webinar">
    <div class="container">
        <div class="webinar-btn">
            <a href="/rd-webinars/"
               class="btn btn--transparent">Back</a>
        </div>
        <div class="webinar__item">
            <div class="webinar-image-wrap">
                <img src="<?= get_post_thumbnail($post) ?>" alt="Webinar Image"/>
            </div>
            <div class="webinar__wrap">
                <h2 class="webinar-title"><?= get_the_title() ?></h2>
                <?php if (str_replace(' ', '', $post_category) !== 'recorded' && $webinar_date): ?>
                    <strong class="webinar-date"><?= $webinar_date ?></strong>
                <?php endif; ?>
                <div class="webinar-description">
                    <?= the_content() ?>
                </div>
                <?php if ($register_link): ?>
                    <div class="webinar-btn">
                        <a href="<?= $register_link ?>"
                           class="btn btn--transparent" target="_blank">Register Now</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="webinar-video">
            <?php
            $video_link = get_post_meta(get_the_ID(), 'cmt_webinar_video_url', true);
            if ($video_link) {
                if (strpos($video_link, 'youtu') !== false) {
                    ?>
                    <iframe
                            src="https://www.youtube.com/embed/<?= get_youtube_video_id_from_url($video_link) ?>"
                            allowfullscreen>
                    </iframe>
                    <?php
                } elseif (strpos($video_link, 'vimeo') !== false) {
                    ?>
                    <iframe src="https://player.vimeo.com/video/<?= get_vimeo_video_id_from_url($video_link) ?>"
                            webkitallowfullscreen
                            mozallowfullscreen
                            allowfullscreen
                    ></iframe>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
