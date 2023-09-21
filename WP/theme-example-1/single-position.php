<?php get_header(); ?>
<?php $post = get_post();
add_filter('not_available_text', 'wptexturize');
add_filter('not_available_text', 'convert_smilies');
add_filter('not_available_text', 'convert_chars');
add_filter('not_available_text', 'wpautop');
add_filter('not_available_text', 'shortcode_unautop');
add_filter('not_available_text', 'prepend_attachment');
$text = apply_filters( 'the_content',  $post->post_content );
$unformatted_content = @get_post_custom_values('not_available_text', $post->ID)[0];
$formatted_content = apply_filters('not_available_text', $unformatted_content);
?>
<section>
    <div class="container" id="single-position-container">
        <div class="features__items">
            <div class="features__item single-position-item">
                <?php if(@get_post_custom_values('available-position', $post->ID)[0] == 'on'):?>
                <div><img class="features__img single-position-img"
                     src="<?= get_post_img($post->ID, 'application-img') ?>" alt="Images"/></div>
                <div class="application__text" style="padding: 0 72px;">
                    <h3 class="application__title"><?= $post->post_title ?></h3>
                    <div class="application__content">
                        <?php if (@get_post_custom_values('department', $post->ID)[0]): ?>
                            <p>
                                <span style="font-weight: 600">Department: </span><?= @get_post_custom_values('department',
                                    $post->ID)[0] ?></p>
                        <?php endif; ?>
                        <?php if (@get_post_custom_values('reports-to', $post->ID)[0]): ?>
                            <p>
                                <span style="font-weight: 600">Reports to: </span><?= @get_post_custom_values('reports-to',
                                    $post->ID)[0] ?></p>
                        <?php endif; ?>
                        <?php if (@get_post_custom_values('location', $post->ID)[0]): ?>
                            <p><span style="font-weight: 600">Location: </span><?= @get_post_custom_values('location',
                                    $post->ID)[0] ?></p>
                        <?php endif; ?>
                        </br>
                        <p>
                            <?php if ($post->post_content): ?>
                                <?= $text ?>
                            <?php endif; ?>
                        </p>
                        </br>
                        <?php if (@get_post_custom_values('pdf-job-description-link', $post->ID)[0]): ?>
                            <p>View full job description <a href="<?=@get_post_custom_values('pdf-job-description-link', $post->ID)[0]?>" target="_blank">here</a>.</p>
                        <?php endif; ?>
                    </div>
                    <?php if (@get_post_custom_values('apply-for-job-form-link', $post->ID)[0]): ?>
                        <a class="application__btn btn"
                           href="<?= @get_post_custom_values('apply-for-job-form-link', $post->ID)[0] ?>"
                           target="_blank">APPLY HERE</a>
                    <?php endif; ?>
                </div>
                <?php else:?>
                    <div><img class="features__img single-position-img"
                         src="<?= get_post_img($post->ID, 'application-img') ?>" alt="Images"/></div>
                    <div class="application__text">
                        <div class="application__content">
                            <?=$formatted_content?>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>
