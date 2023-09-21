<?php /**
 * Block Name: Rd Floating Image
*
* This is the template that displays the Rd Floating Image
*/ 
// Repeater
$pnRepeater = 'pn_repeater';
// Title fields
$pnTitleFs = get_field('pn_title_fs');
$pnTitleFc = get_field('pn_title_fc');
// Text fields
$pnTextFs = get_field('pn_text_fs');
$pnTextFc = get_field('pn_text_fc');
// Section fields
$pnBg = get_field('pn_bg');
$pnBgImg = get_field('pn_bg_img');
// Single bg/img fields
$pnSingleBg = get_field('pn_single_bg');
$pnSingleBgImg = get_field('pn_single_bg_img');

if (have_rows($pnRepeater)):?>
    <section class="section-advanced d-4 features-section-d-4<?php if (!empty($pnBg)): echo ' '.$pnBg; else: ?> bg-transparent<?php endif; ?>"
        <?php if (!empty($pnBgImg)):?>
            style="background-image: url('<?php echo esc_url($pnBgImg['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
        <div class="container">
            <div class="content d-flex align-items-center justify-content-center flex-column">
                <?php while (have_rows($pnRepeater)):
                    the_row();
                    $pnSingleTitle = get_sub_field('np_rep_title');
                    $pnSingleText = get_sub_field('np_rep_text');
                    $pnSingleImg = get_sub_field('np_rep_img');
                    $pnSingleIcon = get_sub_field('np_rep_icon'); ?>
                    <article class="accordion-news d-flex align-items-center align-items-xl-stretch justify-content-center">
                        <div class="accordion-news-text-wrap">
                            <?php if (!empty($pnSingleTitle) || !empty($pnSingleText) || !empty($pnSingleIcon)): ?>
                                <div class="accordion-news-text">
                                    <div class="title-wrap">
                                        <?php if (!empty($pnSingleIcon)): ?>
                                            <span class="accordion-news-icon">
                                                <img src="<?php echo esc_url($pnSingleIcon['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($pnSingleIcon['alt']); ?>"/>
                                            </span>
                                        <?php endif;
                                        if (!empty($pnSingleTitle)): ?>
                                            <h3 class="<?php if (!empty($pnTitleFs)): echo $pnTitleFs.' '; else: ?>h3 small <?php endif; if (!empty($pnTitleFc)): echo $pnTitleFc.' '; else: ?>color-pro-black <?php endif; ?>u-pro-red accordion-news-title underline text-xl-center text-uppercase">
                                                <div class="u-pro-red accordion-news-title-wrap"><?php echo $pnSingleTitle; ?></div>
                                                <div class="cross-wrap cross-wrap-red d-xl-none"><?php get_template_part('page-templates/blocks/cross-block/cross'); ?></div>
                                            </h3>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($pnSingleText)): ?>
                                        <div class="accordion-news-text-body">
                                            <div class="<?php if (!empty($pnTextFs)): echo $pnTextFs.' '; else: ?>paragraph <?php endif; if (!empty($pnTextFc)): echo $pnTextFc.' '; else: ?>color-pro-black <?php endif; ?>text-xl-center"><?php echo $pnSingleText; ?></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($pnSingleImg)): ?>
                            <div class="accordion-news-img-wrap<?php if (!empty($pnSingleBg)): echo ' '.$pnSingleBg; else: ?> bg-transparent<?php endif; ?>"
                                <?php if (!empty($pnSingleBgImg)):?>
                                    style="background-image: url('<?php echo esc_url($pnSingleBgImg['sizes']['full_hd']); ?>')"
                                <?php endif; ?>>
                                <img class="accordion-news-img" src="<?php echo esc_url($pnSingleImg['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($pnSingleImg['alt']); ?>"/>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php endif; ?>