<?php get_header(); ?>

<?php the_post(); ?>
<section class="webinar">
    <div class="container">
        <div class="webinar__item">
            <img src="<?= get_post_thumbnail($post) ?>" alt="Partner Image" class="center-image" id="partner-image"/>
            <div class="webinar__wrap">
                <h3 class="webinar-title"><?= get_post_meta(get_the_ID(), 'partner_short_description', true) ?></h3>
                <p class="webinar-description">
                    <?= get_the_content() ?>
                </p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
