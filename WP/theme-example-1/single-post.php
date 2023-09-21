<?php get_header(); ?>
<?php $post       = get_post();
$single_thumbnail = get_the_post_thumbnail_url($post->ID);
$related_content  = get_post_meta($post->ID, 'related-post')[0];

$related_args  = [
    'post__in' => $related_content
];
$content       = apply_filters('the_content', $post->post_content);
$related_posts = get_posts($related_args);
$prev          = get_permalink(get_adjacent_post(false, '', false));
$next          = get_permalink(get_adjacent_post(false, '', true)); ?>
    <section class="post">
        <div class="container">
            <div class="post__wrap">
                <div class="post__description">
                    <div class="post__nav">
                        <?php if ($prev != get_permalink()): ?>
                            <a href="<?= $prev ?>" class="btn--transparent">Back</a>
                        <?php endif; ?>
                        <?php if ($next != get_permalink()): ?>
                            <a href="<?= $next ?>" class="btn--transparent">Next</a>
                        <?php endif; ?>
                    </div>
                    <img class="tech-library-image" src="<?= $single_thumbnail ? $single_thumbnail : get_template_directory_uri() . "/assets/img/placeholder.png" ?>"
                         alt="Images"/>
                    <div class="post__title">
                        <h3><?= $post->post_title ?></h3>
                        <span><?= get_the_date('F j, Y', $post->ID) ?></span>
                    </div>
                    <div class="post__text">
                        <?= $content ?>
                        <?php if ( $button_link = get_post_meta( $post->ID, 'post_button_link' )[0] ):
                            $button_text = get_post_meta( $post->ID, 'post_button_text' )[0] ?>
                            <div class="btn-container">
                                <a class="btn btn--transparent button-clear" href="<?= $button_link ?>"
                                   download> <?= $button_text ? $button_text : 'Downoad PDF version' ?> </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($related_content): ?>
                    <div class="related-posts">
                        <h3>Related Post</h3>
                        <div class="related-posts__list">
                        <?php foreach ($related_posts as $related): ?>
                            <?php $blog_description = get_post_meta($related->ID, 'blog_description')[0]; ?>

                                <div class="product-preview product-preview--posts">
                                    <div class="image-block">
                                        <img src="<?= get_the_post_thumbnail_url($related->ID) ? get_the_post_thumbnail_url($related->ID) : get_template_directory_uri() . "/assets/img/placeholder.png" ?>"
                                             alt="Images"/>
                                    </div>
                                    <div class="product-preview__text">
                                        <div class="product-preview__wrap">
                                            <p class="product-preview__title"><?= $related->post_title ?></p>
                                            <p class="product-preview__description"><?= get_the_date('F j, Y',
                                                    $related->ID) ?></p>
                                        </div>
                                        <div class="hover-block hover-block--posts">
                                            <div class="hover-block__text">
                                                <?php if ($blog_description): ?>
                                                    <div class="ellipsis">
                                                        <p>
                                                            <?= wp_strip_all_tags($blog_description) ?>
                                                        </p>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="ellipsis">
                                                        <p>
                                                            <?= wp_strip_all_tags($related->post_content) ?>
                                                        </p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <a href="<?= get_permalink($related->ID) ?>" class="hover-block__link btn">Read
                                                More</a>
                                        </div>
                                    </div>
                                </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php get_footer(); ?>