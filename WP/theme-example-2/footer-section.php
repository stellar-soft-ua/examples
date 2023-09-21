<?php $footerBg;

if (is_page_template(['page-templates/template-home.php', 'page-templates/template-home-gutenberg.php'])):
    $footerBg;

elseif (is_page_template(['page-templates/template-pro-reporting.php', 'page-templates/template-pro-plans.php'])):
    $footerBg = wp_is_mobile() ? '#030E28' : 'pro-reporting-bg-bottom.jpg';
endif; ?>
    <footer class="footer" <?php if (!empty($footerBg)):
        if (is_page_template('page-templates/template-pro-reporting.php') && wp_is_mobile()
            || is_page_template('page-templates/template-pro-plans.php') && wp_is_mobile()): ?>
            style="background: <?php echo $footerBg; ?>"
        <?php else: ?>
            style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/resources/assets/images/<?php echo $footerBg; ?>'); background-size: cover; background-repeat: no-repeat;"
        <?php endif;
    endif; ?>>

        <?php if (is_page_template(['page-templates/template-home.php', 'page-templates/template-home-gutenberg.php', 'page-templates/template-pro-features.php', 'page-templates/template-pro-features-gutenberg.php', 'page-templates/template-features.php'])): ?>
            <div class="footer__top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 order-md-1">
                            <div class="footer__top-content text-center text-md-start">
                                <h2 class="h3 footer__header text-uppercase text-white">Live a day as a <span
                                        class="underline">pro.</span></h2>
                                <p class="footer__descr text-white extra-large">
                                    Whether you’re a lobbyist, consultant, researcher, or analyst, POLITICO Pro can help
                                    you
                                    stay
                                    informed and craft winning policy.
                                </p>
                                <a class="btn btn-primary btn-lg" href="/demo/"><span>Start Your Free Trial</span></a>
                            </div>
                        </div>
                        <div class="col-md-6 order-md-0 text-center text-md-start">
                            <img class="footer__top-image d-none d-md-inline-block"
                                 src="<?php echo get_stylesheet_directory_uri() ?>/resources/assets/images/home-section-10-image.png"
                                 alt="alt">
                            <img class="footer__top-image d-inline-block d-md-none"
                                 src="<?php echo get_stylesheet_directory_uri() ?>/resources/assets/images/footer-bg-mobile.png"
                                 alt="alt">
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif (is_page_template(['page-templates/template-pro-reporting.php', 'page-templates/template-pro-reporting-gutenberg.php'])):
            get_template_part('parts/pro-reporting/pro-reporting', 'section-7');

        elseif (is_page_template('page-templates/template-pro-plans.php')):
            get_template_part('parts/pro-plans/pro-plans', 'section-4');

        elseif (is_page_template('page-templates/template-demo.php')
            || is_page_template('page-templates/template-form.php')):
            get_template_part('parts/demo/demo', 'section-2');

        elseif (is_page_template('page-templates/template-about-pro.php')):
            get_template_part('parts/about-pro/about-pro', 'section-6');
        elseif (is_page_template('page-templates/template-faq.php')):
            get_template_part('parts/faq/footer', 'section-4');
        endif; ?>
        <div class="footer__middle">
            <div class="container">
                <div class="row">

                    <div class="col-md col-lg-4 col-xl-5 text-center text-md-start">

                        <?php if ($footer_logo = get_field('footer_logo', 'options')): ?>
                            <div class="footer__logo">
                                <img
                                    src="<?php echo $footer_logo['url'] ?>"
                                    alt="politico pro">
                            </div>
                        <?php endif; ?>

                        <?php if ($first_column_lists = get_field('first_column_lists', 'options')): ?>
                            <ul class="footer-list footer-list__large d-none d-md-block">
                                <?php foreach ($first_column_lists as $link): ?>
                                    <?php if ($link['link']): ?>
                                        <?php $link_target = $link['link']['target'] ?: '_self'; ?>
                                        <li class="footer-list__item">
                                            <a href="<?php echo $link['link']['url'] ?>"
                                               class="footer-list__link"
                                               target="<?php echo esc_attr($link_target); ?>"><?php echo $link['link']['title'] ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                    </div>

                    <div class="col-12 col-md text-center text-md-start">
                        <div class="footer__column footer__column-first">

                            <?php if ($second_column_title = get_field('second_column_title', 'options')): ?>
                                <h6 class="footer__title">
                                    <?php if ($second_column_title['url'] != '#'): ?>
                                    <a class="footer__title--link" href="<?php echo $second_column_title['url']; ?>">
                                        <?php endif; ?>

                                        <?php echo $second_column_title['title']; ?>

                                        <?php if ($second_column_title['url']): ?>
                                    </a>
                                <?php endif; ?>
                                </h6>
                            <?php endif; ?>

                            <?php if ($second_column_lists = get_field('second_column_lists', 'options')): ?>
                                <ul class="footer-list">
                                    <?php foreach ($second_column_lists as $link): ?>
                                        <?php if ($link['link']): ?>
                                            <?php $link_target = $link['link']['target'] ?: '_self'; ?>
                                            <li class="footer-list__item">
                                                <a href="<?php echo $link['link']['url'] ?>"
                                                   class="footer-list__link"
                                                   target="<?php echo esc_attr($link_target); ?>"><?php echo $link['link']['title'] ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="col-12 col-md text-center text-md-start">
                        <div class="footer__column footer__column-second">
                            <?php if ($third_column_title = get_field('third_column_title', 'options')): ?>
                                <h6 class="footer__title">
                                    <?php if ($third_column_title['url'] != '#'): ?>
                                        <a class="footer__title--link" href="<?php echo $third_column_title['url']; ?>">
                                    <?php endif; ?>

                                        <?php echo $third_column_title['title']; ?>

                                <?php if ($third_column_title['url']): ?>
                                    </a>
                                <?php endif; ?>
                                </h6>
                            <?php endif; ?>

                            <?php if ($third_column_lists = get_field('third_column_lists', 'options')): ?>
                                <ul class="footer-list">
                                    <?php foreach ($third_column_lists as $link): ?>
                                        <?php if ($link['link']): ?>
                                            <?php $link_target = $link['link']['target'] ?: '_self'; ?>
                                            <li class="footer-list__item">
                                                <a href="<?php echo $link['link']['url'] ?>"
                                                   class="footer-list__link"
                                                   target="<?php echo esc_attr($link_target); ?>"><?php echo $link['link']['title'] ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="col-12 col-md text-center text-md-start">
                        <div class="footer__column footer__column-third">
                            <?php if ($fourth_column_title = get_field('fourth_column_title', 'options')): ?>
                                <h6 class="footer__title">
                                    <?php if ($fourth_column_title['url'] != '#'): ?>
                                    <a class="footer__title--link" href="<?php echo $fourth_column_title['url']; ?>">
                                        <?php endif; ?>

                                        <?php echo $fourth_column_title['title']; ?>

                                        <?php if ($fourth_column_title['url']): ?>
                                    </a>
                                <?php endif; ?>
                                </h6>
                            <?php endif; ?>

                            <?php if ($fourth_column_lists = get_field('fourth_column_lists', 'options')): ?>
                                <ul class="footer-list">
                                    <?php foreach ($fourth_column_lists as $link): ?>
                                        <?php if ($link['link']): ?>
                                            <?php $link_target = $link['link']['target'] ?: '_self'; ?>
                                            <li class="footer-list__item">
                                                <a href="<?php echo $link['link']['url'] ?>"
                                                   class="footer-list__link"
                                                   target="<?php echo esc_attr($link_target); ?>"><?php echo $link['link']['title'] ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="col-12 col-md text-center text-md-end">
                        <div class="footer__column footer__column-fourth d-inline-block text-center text-md-start">

                            <?php if ($fifth_column_title = get_field('fifth_column_title', 'options')): ?>
                                <h6 class="footer__title">
                                    <?php if ($fifth_column_title['url'] != '#'): ?>
                                    <a class="footer__title--link" href="<?php echo $fifth_column_title['url']; ?>">
                                        <?php endif; ?>

                                        <?php echo $fifth_column_title['title']; ?>

                                        <?php if ($fifth_column_title['url']): ?>
                                    </a>
                                <?php endif; ?>
                                </h6>
                            <?php endif; ?>

                            <?php if ($fifth_column_lists = get_field('fifth_column_lists', 'options')): ?>
                                <ul class="footer-list">
                                    <?php foreach ($fifth_column_lists as $link): ?>
                                        <?php if ($link['link']): ?>
                                            <?php $link_target = $link['link']['target'] ?: '_self'; ?>
                                            <li class="footer-list__item">
                                                <a href="<?php echo $link['link']['url'] ?>"
                                                   class="footer-list__link"
                                                   target="<?php echo esc_attr($link_target); ?>"><?php echo $link['link']['title'] ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <?php if ($first_column_lists = get_field('first_column_lists', 'options')): ?>
                                <ul class="footer-list d-block d-md-none">
                                    <?php foreach ($first_column_lists as $link): ?>
                                        <?php if ($link['link']): ?>
                                            <?php $link_target = $link['link']['target'] ?: '_self'; ?>
                                            <li class="footer-list__item">
                                                <a href="<?php echo $link['link']['url'] ?>"
                                                   class="footer-list__link"
                                                   target="<?php echo esc_attr($link_target); ?>"><?php echo $link['link']['title'] ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="container">
            <div class="footer__bottom">
                <div class="row">
                    <div class="col-md-6">

                        <?php if (have_rows('socials', 'options')): ?>
                            <ul class="footer-socials justify-content-center justify-content-md-start">
                                <?php while (have_rows('socials', 'options')): the_row(); ?>
                                    <?php $social_network = get_sub_field('social_network'); ?>
                                    <li class="footer-socials__item">
                                        <a class="footer-socials__link <?php echo $social_network['value']; ?>"
                                           href="<?php the_sub_field('social_profile'); ?>"
                                           target="_blank"
                                           aria-label="<?php echo $social_network['label']; ?>"
                                           rel="noopener">
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>

                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <?php if ($copyright = get_field('copyright', 'options')): ?>
                            <span class="footer__copyright">
                                <?php echo $copyright; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </footer>

<?php
wp_footer(); // We need this for plugins.
