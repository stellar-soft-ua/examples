<?php /**
 * Block Name: Rd Find Your Place
*
* This is the template that displays the Rd Find Your Place
*/
// Accorion fields
$fypAccRepeater = 'fyp_acc_repeater';
$fypAccBg = get_field('fyp_acc_bg');
// Section fields
$index = 0;
$fypbg = get_field('fyp_bg_color');
$fypbgImg = get_field('fyp_bg_img');

if(have_rows($fypAccRepeater)): ?>
    <section class="section-advanced d-4-home section-find-your-place bg-transparent<?php if (!empty($fypbg)): echo ' '.$fypbg; else: ?> bg-transparent<?php endif; ?>"
        <?php if (!empty($fypbgImg)):?>
            style="background-image: url('<?php echo esc_url($fypbgImg['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="ft-accordion-container ft-fade-in">
                        <?php while(have_rows($fypAccRepeater)):
                            the_row();
                            $fypAccTitle = get_sub_field('fyp_acc_title');
                            $fypAccTextTitle = get_sub_field('fyp_acc_text_title');
                            $fypAccText = get_sub_field('fyp_acc_text');
                            $fypAccPortraitMob = get_sub_field('fyp_acc_portrait_mob');
                            $fypBtn = get_sub_field('fyp_btn');
                            $fypBtnClass = get_sub_field('fyp_btn_class');
                            $fypBtnVideo = get_sub_field('fyp_btn_video');
                            $fypBtnCheck = get_sub_field('fyp_btn_check');
                            $linkTarget = $fypBtn['target'] ? $fypBtn['target'] : '_self';
                            $index++; ?>
                            <div class="ft-panel closed <?php if ($index == 1): ?> active<?php endif; ?>">
                                <div class="ft-flex-container">
                                    <div class="mobile-close"></div>
                                    <button class="panel-button">
                                        <div class="background portrait-aspect">
                                            <div class="content">
                                                <div class="rel-wrap rel-wrap-desk">
                                                    <?php if (!empty($fypAccBg)): ?>
                                                        <div class="lined-bg"
                                                            style="background-image: url('<?php echo esc_url($fypAccBg['sizes']['full_hd']); ?>');">
                                                            <div class="line-bg-inner"></div>
                                                        </div>
                                                    <?php endif;
                                                    if (!empty($fypAccPortraitMob)): ?>
                                                        <img class="ft-portrait" src="<?php echo esc_url($fypAccPortraitMob['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($fypAccPortraitMob['alt']); ?>">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if (!empty($fypAccTitle)): ?>
                                            <h2 class="h5 large"><?php echo $fypAccTitle; ?></h2>
                                        <?php endif; ?>
                                    </button>
                                    <div class="panel-content">
                                        <div class="panel-wrap">
                                            <?php if (!empty($fypAccTextTitle)): ?>
                                                <h2 class="split-title<?php if ($index == 1): ?> active<?php endif; ?>"><?php echo $fypAccTextTitle; ?></h2>
                                            <?php endif;
                                            if (!empty($fypAccText)): ?>
                                                <div class="split-content"><?php echo $fypAccText; ?></div>
                                            <?php endif;
                                            if (!empty($fypAccPortraitMob)): ?>
                                                <div class="rel-wrap">
                                                    <?php if (!empty($fypAccBg)): ?>
                                                        <div class="lined-bg"
                                                            style="background-image: url('<?php echo esc_url($fypAccBg['sizes']['full_hd']); ?>');">
                                                            <div class="line-bg-inner"></div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <img class="mobile-portrait" src="<?php echo esc_url($fypAccPortraitMob['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($fypAccPortraitMob['alt']); ?>">
                                                </div>
                                            <?php endif;
                                            if (!empty($fypBtn) || !empty($fypBtnVideo)): ?>
                                                <div class="btn-wrap mt-3 mb-2 w-100 d-flex justify-content-center justify-content-lg-start">
                                                    <?php if (!empty($fypBtnCheck) && $fypBtnCheck == 'link'):
                                                        if (!empty($fypBtn)): ?>
                                                            <a class="<?php if (!empty($fypBtnClass)): echo $fypBtnClass.' '; endif; ?>btn btn-primary bg-pro-red btn-link-custom" target="<?php echo esc_attr($linkTarget); ?>" href="<?php echo esc_url($fypBtn['url']); ?>" aria-label="<?php echo esc_html( $fypBtn['title'] ); ?>">
                                                                <span class="color-pro-white"><?php echo esc_html( $fypBtn['title'] ); ?></span>
                                                            </a>
                                                        <?php endif;
                                                    elseif (!empty($fypBtnCheck) && $fypBtnCheck == 'video'):
                                                        if (!empty($fypBtnVideo)): ?>
                                                            <button class="<?php if (!empty($fypBtnClass)): echo $fypBtnClass.' '; endif; ?>btn btn-primary video-btn video-gtnp bg-pro-red btn-type-custom" type="button" aria-label="<?php echo $fypBtnVideo; ?>">
                                                                <span class="color-pro-white"><?php echo $fypBtnVideo; ?></span>
                                                            </button>
                                                        <?php endif;
                                                    endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>