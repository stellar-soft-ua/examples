<?php
$id = get_the_ID();
$footerBg;
$footerBgColor;
$fotterSelect = get_field('selecting_footer', $id);

if ($fotterSelect == 'footer-template'):
    if (is_page_template(['page-templates/template-pro-features.php',
                        'page-templates/template-pro-features-gutenberg.php',
                        'page-templates/template-pro-features-advanced.php'])):
        $footerBg = get_field('sf_bg_img', $id);
        $footerBgColor = get_field('sf_bg_color', $id);
    elseif (is_page_template(['page-templates/template-pro-reporting.php',
                            'page-templates/template-pro-reporting-gutenberg.php',
                            'page-templates/template-pro-reporting-advanced.php',
                            'page-templates/template-pro-plans.php',
                            'page-templates/template-pro-plans-advanced.php'])):
        $footerBgColor = get_field('prf_bg_color', $id);
        $footerBg = wp_is_mobile() ? '' : get_field('prf_bg_img', $id);
    elseif (is_page_template(['page-templates/template-about-pro.php',
                            'page-templates/template-about-pro-advanced.php'])):
        $footerBgColor = get_field('about_bg_color', $id);
        $footerBg = get_field('about_bg_img', $id);
    endif;
else:
    $footerBg = get_field('ff_bg_img', 'options');
    $footerBgColor = get_field('ff_bg_color', 'options');
endif; ?>
    <footer class="footer-advanced<?php if (!empty($footerBgColor)): echo ' '.$footerBgColor; else: ?> bg-pro-dk-blue<?php endif; ?>" <?php if (!empty($footerBg)):
        if ($fotterSelect == 'footer-template' && is_page_template(['page-templates/template-pro-reporting.php',
                                                                    'page-templates/template-pro-reporting-gutenberg.php',
                                                                    'page-templates/template-pro-reporting-advanced.php',
                                                                    'page-templates/template-pro-plans.php',
                                                                    'page-templates/template-pro-plans.php',
                                                                    'page-templates/template-pro-plans-advanced.php']) && wp_is_mobile()): ?>
            style="background: <?php echo $footerBg; ?>"
        <?php else: ?>
            style="background-image: url('<?php echo esc_url($footerBg['sizes']['full_hd']); ?>'); background-size: cover; background-repeat: no-repeat;"
        <?php endif;
        endif; ?>>

        <?php if ($fotterSelect == 'footer-template'):
            if (is_page_template(['page-templates/template-pro-reporting-advanced.php'])):
                get_template_part('parts/pro-reporting/rd-pro-reporting', 'section-7');
            elseif (is_page_template(['page-templates/template-features.php',
                                    'page-templates/template-pro-features-gutenberg.php',
                                    'page-templates/template-pro-features-advanced.php'])):
                get_template_part('parts/features/features', 'section-6');
            elseif (is_page_template(['page-templates/template-pro-plans.php',
                                    'page-templates/template-pro-plans-advanced.php'])):
                get_template_part('parts/pro-reporting/rd-pro-reporting', 'section-7');
            elseif (is_page_template(['page-templates/template-demo.php',
                                    'page-templates/template-form.php'])):
                get_template_part('parts/demo/demo', 'section-2');
            elseif (is_page_template(['page-templates/template-about-pro.php',
                                    'page-templates/template-about-pro-advanced.php'])):
                get_template_part('parts/about-pro/rd-about-pro', 'section-6');
            elseif (is_page_template('page-templates/template-faq.php')):
                get_template_part('parts/faq/footer', 'section-4');
            endif;
        else:
            get_template_part('parts/home/home', 'section-10');
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
