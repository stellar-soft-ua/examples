<?php
function get_product_review($post)
{
    $post_type = get_post_type($post->ID);
    $app_note = @get_post_custom_values('app_note', $post->ID)[0];
    $app_notes = get_post($app_note);
    $review_software_title = @get_post_custom_values('_review_software_title', $post->ID)[0];
    $review_software_link = @get_post_custom_values('_review_software_link', $post->ID)[0];
    $review_software_image = @get_post_custom_values('_review_software_image', $post->ID)[0];
    $review_title = @get_post_custom_values('_review_title', $post->ID)[0];
    $review_link = @get_post_custom_values('_review_link', $post->ID)[0];
    $review_image = @get_post_custom_values('_review_image', $post->ID)[0];
    $video_title = @get_post_custom_values('_video_title', $post->ID)[0];
    $video_link = @get_post_custom_values('_video_link', $post->ID)[0];
    $video_image = @get_post_custom_values('_video_image', $post->ID)[0];
    $show_video = @get_post_custom_values('show_video', $post->ID)[0];
    ?>
    <?php if ($review_software_link): ?>
    <div class="review-container">
        <div class="review_image_container">
            <img src="<?= $review_software_image ?>"/>
        </div>
        <div class="review-card-titles">
            <div class="review-title">
                <div class="review-title-content">
                    <h3 class="software__title"><?= $review_software_title ?></h3>
                </div>
            </div>
        </div>
        <div class="software__button">
            <a href="<?= $review_software_link ?>"
               class="btn--transparent" data-manual="1"><?= @get_post_custom_values('_review_software_btn_name',
                    $post->ID)[0] ?></a>
        </div>
    </div>
    <?php endif; ?>
        <?php if ($review_link): ?>
        <div class="review-container">
            <div class="review_image_container">
                <img src="<?=$review_image?>"/>
            </div>
            <div class="review-card-titles">
                <div class="review-title">
                    <div class="review-title-content">
                        <h3 class="software__title"><?= $review_title ?></h3>
                    </div>
                </div>
            </div>
            <div class="software__button">
                <a href="<?= $review_link ?>"
                   class="btn--transparent" data-manual="1"><?= @get_post_custom_values('_review_btn_name',
                        $post->ID)[0] ?></a>
            </div>
        </div>
    <?php endif; ?>
        <?php if ($show_video): ?>
        <div class="reviews__video">
            <?php
            if (@get_post_custom_values('vimeo_video', $post->ID)[0]) {
                $vim_link = @get_post_custom_values('vimeo_video', $post->ID)[0];
                if (strpos($vim_link, 'youtu') !== false) {
                    ?>
                    <iframe
                            width="100%"
                            height="265"
                            src="https://www.youtube.com/embed/<?= get_youtube_video_id_from_url($vim_link) ?>"
                            allowfullscreen>

                    </iframe>
                    <?php
                } elseif (strpos($vim_link, 'vimeo') !== false) {
                    ?>
                    <iframe src="https://player.vimeo.com/video/<?= get_vimeo_video_id_from_url($vim_link) ?>"
                            width="380"
                            height="214"
                            frameborder="0"
                            webkitallowfullscreen
                            mozallowfullscreen
                            allowfullscreen
                    ></iframe>
                    <?php
                }
            }
            ?>
        </div>
    <?php else: ?>
    <?php if ($video_link): ?>
        <div class="review-container">
                <div class="review_image_container">
                    <img src="<?=$video_image?>"/>
                </div>
                <div class="review-card-titles">
                    <div class="review-title">
                        <div class="review-title-content">
                            <h3 class="software__title"><?= $video_title ?></h3>
                        </div>
                    </div>
                </div>
                <div class="software__button">
                    <a href="<?= $video_link ?>"
                       class="btn--transparent" data-manual="1"><?= @get_post_custom_values('_video_btn_name',
                            $post->ID)[0] ?></a>
                </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php
}
