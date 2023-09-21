<?php /**
  * Block Name: Rd Two Column CTA & Stats Counter Block
  *
  * This is the template that displays the Rd Two Column CTA & Stats Counter Block
  */
  // Suptitle fields
  $fcbSupTitle = get_field('fcb_suptitle');
  $fcbSupTitleFs = get_field('fcb_suptitle_fs');
  // Title fields
  $fcbTitle = get_field('fcb_title');
  $fcbTitleFs = get_field('fcb_title_fs');
  // Section fields
  $fcbBg = get_field('fcb_bg');
  $fcbBgSectionImg = get_field('fcb_bg_section_img');
  $fcbBgImg1 = get_field('fcb_bg_img_1');
  $fcbBgImg2 = get_field('fcb_bg_img_2');
  $fcbCountBg = get_field('fcb_count_bg');
  $index = 0;
  $emptyCol;
  // Button fields
  $fcbBtn = get_field('fcb_btn');
  $fcbBtnVideo = get_field('fcb_btn_video');
  $fcbBtnCheck = get_field('fcb_btn_check');
  $fypbBtnSize = get_field('fcb_btn_size');
  $linkTarget = $fcbBtn['target'] ? $fcbBtn['target'] : '_self';
  // Counter fields
  $fcbCounterRepeat = 'fcb_counter_repeat';
  // Text fields
  $fcbText = get_field('fcb_text');
  ?>
  <section class="home-section section-advanced d-3<?php if (!empty($fcbBg)): echo ' '.$fcbBg; else: ?> bg-pro-white-smoke<?php endif; ?> first-section-counter" data-counter="section-counter-1"
    <?php if (!empty($fcbBgSectionImg)):?>
        style="background-image: url('<?php echo esc_url($fcbBgSectionImg['sizes']['full_hd']); ?>')"
    <?php endif; ?>>
    <div class="container">
        <div class="row justify-content-center">
            <?php if (!empty($fcbSupTitle) || !empty($fcbTitle) || !empty($fcbText) || !empty($fcbBtnVideo) || !empty($fcbBtn)): ?>
                <div class="col-md-5 order-1 order-md-0 d-flex align-items-center">
                    <div class="text-block">
                        <?php if (!empty($fcbSupTitle)): ?>
                            <h6 class="<?php if (!empty($fcbSupTitleFs)): echo $fcbSupTitleFs.' '; else: ?>h6 <?php endif; ?>color-pro-red text-block__suptitle text-uppercase letter-spacing-4-61"><?php echo $fcbSupTitle; ?></h6>
                        <?php endif;
                        if (!empty($fcbTitle)): ?>
                        <h2 class="<?php if (!empty($fcbTitleFs)): echo $fcbTitleFs.' '; else: ?>h3 <?php endif; ?>color-pro-black u-pro-red text-block__title text-uppercase"><?php echo $fcbTitle; ?></h2>
                        <?php endif;
                        if (!empty($fcbText)): ?>
                            <div class="large color-pro-black text-block__descr"><?php echo $fcbText; ?></div>
                        <?php endif;
                        if (!empty($fcbBtn) || !empty($fcbBtnVideo)): ?>
                            <div class="btn-wrap mt-5 w-100 d-flex">
                                <?php if (!empty($fcbBtnCheck) && $fcbBtnCheck == 'link'):
                                    if (!empty($fcbBtn)): ?>
                                        <a class="<?php if (!empty($fypbBtnSize)): echo $fypbBtnSize.' '; endif; ?>btn-rounded btn-rounded-red btn bg-pro-red btn-link-custom" target="<?php echo esc_attr($linkTarget); ?>" href="<?php echo esc_url($fcbBtn['url']); ?>" aria-label="<?php echo esc_html( $fcbBtn['title'] ); ?>">
                                            <span class="color-pro-white"><?php echo esc_html( $fcbBtn['title'] ); ?></span>
                                        </a>
                                    <?php endif;
                                elseif (!empty($fcbBtnCheck) && $fcbBtnCheck == 'video'):
                                    if (!empty($fcbBtnVideo)): ?>
                                        <button class="<?php if (!empty($fypbBtnSize)): echo $fypbBtnSize.' '; endif; ?>btn-rounded btn-rounded-red btn video-btn video-gtnp bg-pro-red btn-type-custom" type="button" aria-label="<?php echo $fcbBtnVideo; ?>">
                                            <span class="color-pro-white"><?php echo $fcbBtnVideo; ?></span>
                                        </button>
                                    <?php endif;
                                endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else:
                $emptyCol = ' left: 0;';
            endif; ?>
            <?php if(have_rows($fcbCounterRepeat)): ?>
                <div class="col-md-6 order-0 order-md-1 <?php if (empty($emptyCol)): ?>offset-md-1<?php else: ?>justify-content-center<?php endif; ?> d-flex align-items-center">
                    <div class="counter__wrap row">
                        <?php while(have_rows($fcbCounterRepeat)) :
                            the_row();
                            $index++;
                            $fcbCounter = get_sub_field('fcb_counter');
                            $fcbCounterText = get_sub_field('fcb_counter_text');
                            $fcbCounterInit = get_sub_field('fcb_counter_init_num');
                            $fcbCounterPlus = get_sub_field('fcb_counter_plus'); ?>
                            <div class="col-md-6 col-lg-5 offset-lg-1">
                                <div class="counter">
                                    <?php if (!empty($fcbCounter)): ?>
                                        <span class="color-pro-red counter-num">
                                            <span class="counter-content" id="count-<?php echo $index; ?>" data-count="<?php echo $fcbCounter; ?>" data-init="<?php echo $fcbCounterInit; ?>"><?php echo $fcbCounterInit; ?></span><?php if (!empty($fcbCounterPlus) && $fcbCounterPlus == 'plus'): ?><span>+</span><?php elseif (!empty($fcbCounterPlus) && $fcbCounterPlus == 'kplus'): ?><span>k+</span><?php endif; ?>
                                        </span>
                                    <?php endif;
                                    if (!empty($fcbCounterText)): ?>
                                        <span class="color-pro-black counter-text"><?php echo $fcbCounterText; ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <?php if (!empty($fcbBgImg1) || !empty($fcbBgImg2)):?>
                        <div class="counter-bg__wrapper<?php if (!empty($fcbCountBg)): echo ' '.$fcbCountBg; else: ?> bg-pro-lt-gray<?php endif; ?>"
                            style="<?php if (!empty($fcbBgImg1)):?>background-image: url('<?php echo esc_url($fcbBgImg1['sizes']['full_hd']); ?>');<?php endif; if (!empty($emptyCol)): echo $emptyCol; endif; ?>">
                            <?php if (!empty($fcbBgImg2)):?>
                                <img class="counter-bg__img" src="<?php echo esc_url($fcbBgImg2['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($fcbBgImg2['alt']); ?>"/>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>