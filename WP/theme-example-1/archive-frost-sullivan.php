<?php get_header(); ?>

<section class="frost-sulivan">
    <div class="container">
        <h1>Frost & Sullivan</h1>
        <?php
        $frost_page = get_page_by_path('frost-sullivan');
        if (!empty($frost_page->post_content)):
            ?>
            <div class="frost-sulivan__main-text">
                <?= apply_filters('the_content', $frost_page->post_content); ?>
            </div>
        <?php endif; ?>
        <div class="frost-sulivan__items">
            <?php
            $query = new WP_Query([
                'post_type'      => 'frost-sullivan',
                'posts_per_page' => -1,
                'orderby'        => 'post_date',
                'order'          => 'DESC',
                'post_status'    => 'publish'
            ]);
            if (!$query->have_posts()) {
                echo '<h3>No Posts found</h3>';
            }
            ?>
            <?php foreach ($posts as $post): ?>
                <?php
                $application_preview = get_the_post_thumbnail_url($post->ID);
                $reward_date = @get_post_custom_values('cmt_frost_sullivan_year', $post->ID)[0];
                ?>
                <div class="frost-sulivan__item">
                    <div class="frost-sulivan__text">
                        <p class="reward-title"><?= $post->post_title ?></p>
                        <div>
                            <p><?= apply_filters('the_content', $post->post_content) ?></p>
                        </div>
                        <p class="reward-date"><?= date('F j, Y', strtotime($reward_date)) ?></p>
                    </div>
                    <a class="frost-sullivan-link" href="<?=@get_post_custom_values('cmt_frost_sullivan_url', $post->ID)[0]?>" target="_blank">
                        <div class="img-container">
                                <img src="<?=get_post_thumbnail($post)?>"/>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<?php get_footer(); ?>
