<?php /**
 * Block Name: Rd Single Stats Pattern
*
* This is the template that displays the Rd Single Stats Pattern
*/
// Subtitle fields
$prcSubtitle = get_field('prc_subtitle');
$prcSubtitleFs = get_field('prc_subtitle_fs');
// Title fields
$prcTitle = get_field('prc_title');
$prcTitleFs = get_field('prc_title_fs');
// Paragraph fields
$prcText = get_field('prc_text');
// Section fields
$prcBgImg = get_field('prc_bg_img');
$prcTheme = get_field('prc_theme');
//Counter fields
$prcRepeater = 'prc_repeater';
$index = 0;

if (!empty($prcSubtitle) || !empty($prcTitle) || !empty($prcText) || have_rows($prcRepeater)): ?>
    <section class="section-advanced d-2 pro-reporting-section-d-2 bg-transparent second-section-counter<?php if (!empty($prcTheme)): echo ' '.$prcTheme; else: ?> default-theme<?php endif; ?>" data-counter="section-counter-2"
        <?php if (!empty($prcBgImg)):?>
            style="background-image: url('<?php echo esc_url($prcBgImg['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
        <div class="container">
            <div class="content">
                <?php if (!empty($prcSubtitle) || !empty($prcTitle) || !empty($prcText)): ?>
                    <div class="title-wrap row">
                        <?php if (!empty($prcSubtitle)): ?>
                            <h6 class="<?php if (!empty($prcSubtitleFs)): echo $prcSubtitleFs.' '; else: ?>h6 <?php endif; ?>color-pro-red suptitle text-xl-center text-uppercase mb-0"><?php echo $prcSubtitle; ?></h6>
                        <?php endif;
                        if (!empty($prcTitle)): ?>
                            <h2 class="<?php if (!empty($prcTitleFs)): echo $prcTitleFs.' '; else: ?>h3 <?php endif; ?>u-pro-red color-pro-white text-xl-center text-uppercase mb-0 title-custom-counter"><?php echo $prcTitle; ?></h2>
                        <?php endif;
                        if (!empty($prcText)): ?>
                            <div class="color-pro-white subtitle-secondary text-xl-center subtitle-custom-counter"><?php echo $prcText; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif;
                if (have_rows($prcRepeater)): ?>
                    <div class="text-wrap row">
                        <?php while(have_rows($prcRepeater)):
                            the_row();
                            $index++;
                            $countNum = get_sub_field('prc_rep_num');
                            $countNumSub = get_sub_field('prc_rep_num_sub');
                            $countNumInit = get_sub_field('prc_counter_init_num');
                            $countNumPlus = get_sub_field('prc_counter_plus');
                            if (!empty($countNum) || !empty($countNumSub)): ?>
                                <div class="info-col col-12 col-md-6 col-xl-4 d-flex flex-column align-items-center justify-content-center">
                                    <?php if (!empty($countNum)): ?>
                                        <span class="color-pro-red counter-num">
                                            <span class="counter-content" id="count-<?php echo $index; ?>" data-count="<?php echo $countNum; ?>" data-init="<?php echo $countNumInit; ?>"><?php echo $countNumInit; ?></span><?php if (!empty($countNumPlus) && $countNumPlus == 'plus'): ?><span>+</span><?php elseif (!empty($countNumPlus) && $countNumPlus == 'kplus'): ?><span>k+</span><?php endif; ?>
                                        </span>
                                    <?php endif;
                                    if (!empty($countNumSub)): ?>
                                        <span class="counter-text text-center color-pro-white"><?php echo $countNumSub; ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>