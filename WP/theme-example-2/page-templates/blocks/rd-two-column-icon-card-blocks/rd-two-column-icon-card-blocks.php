<?php /**
 * Block Name: Rd Two Column Icon Card Blocks
*
* This is the template that displays the Rd Two Column Icon Card Blocks
*/ 
// Repeater
$difRepeater = 'dif_repeater';
$difRepTitleFs = get_field('dif_rep_title_fs');
$difRepTitleFc = get_field('dif_rep_title_fc');
$difRepTextFs = get_field('dif_rep_text_fs');
$difRepTextFc = get_field('dif_rep_text_fc');
$aligneCont = get_field('dif_aligne_cont');
$difIconCol = get_field('dif_icon_color');
// Suptitle fields
$difSuptitle = get_field('dif_sutitle');
$difSuptitleFs = get_field('dif_sutitle_fs');
$difSuptitleFc = get_field('dif_suptitle_fc');
// Title fields
$difTitle = get_field('dif_title');
$difTitleFs = get_field('dif_title_fs');
$difTitleFc = get_field('dif_title_fc');
// Text fields
$difText = get_field('dif_text');
$difTextFs = get_field('dif_text_fs');
$difTextFc = get_field('dif_text_fc');
// Section fields
$difBg = get_field('dif_bg');
$difBgImg = get_field('dif_bg_img');
$difLeftSideImg = get_field('dif_left_side_img');

if (!empty($difSuptitle) || !empty($difTitle) || !empty($difText) || have_rows($difRepeater)): ?>
    <section class="section-advanced d-4 about-pro-section-d-4<?php if (!empty($difBg)): echo ' '.$difBg; else: ?> bg-pro-white-smoke<?php endif; ?>"
        <?php if (!empty($difBgImg)):?>
            style="background-image: url('<?php echo esc_url($difBgImg['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
        <?php if (!empty($difLeftSideImg)): ?>
            <div class="decore-wrap d-none d-xl-block">
                <img class="decore" src="<?php echo esc_url($difLeftSideImg['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($difLeftSideImg['alt']); ?>">
            </div>
        <?php endif; ?>
        <div class="container">
            <div class="content row">
                <?php if (!empty($difSuptitle) || !empty($difTitle) || !empty($difText)): ?>
                    <div class="title-wrap col-12 col-xl-3">
                        <?php if (!empty($difSuptitle)): ?>
                            <h6 class="<?php if (!empty($difSuptitleFs)): echo $difSuptitleFs.' '; else: ?>h6 <?php endif; if (!empty($difSuptitleFc)): echo $difSuptitleFc.' '; else: ?>color-pro-red <?php endif; ?>suptitle text-uppercase mb-0"><?php echo $difSuptitle; ?></h6>
                        <?php endif;
                        if (!empty($difTitle)): ?>
                            <h2 class="<?php if (!empty($difTitleFs)): echo $difTitleFs.' '; else: ?>h3 small-static <?php endif; if (!empty($difTitleFc)): echo $difTitleFc.' '; else: ?>color-pro-black <?php endif; ?>u-pro-red text-uppercase mb-0"><?php echo $difTitle; ?></h2>
                        <?php endif;
                        if (!empty($difText)): ?>
                            <div class="<?php if (!empty($difTextFs)): echo $difTextFs.' '; else: ?>subtitle-large <?php endif; if (!empty($difTextFc)): echo $difTextFc.' '; else: ?>color-pro-black <?php endif; ?>mb-0 subtitle-custom"><?php echo $difText; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif;
                if (have_rows($difRepeater)): ?>
                    <div class="values-wrap row col-12 col-xl-9">
                        <?php while (have_rows($difRepeater)): 
                            the_row();
                            $difRepIcon = get_sub_field('dif_rep_icon');
                            $difRepTitle = get_sub_field('dif_rep_title');
                            $difRepText = get_sub_field('dif_rep_text'); ?>
                            <div class="values col-12 col-md-6 col-xl-5<?php if (!empty($aligneCont) && $aligneCont == 'center'): ?> text-center<?php endif; ?>">
                                <?php if (!empty($difRepIcon) || !empty($difRepTitle)): ?>
                                    <div class="values-head d-flex flex-column">
                                        <?php if (!empty($difRepIcon)): ?>
                                            <span class="values-head-icon<?php if (!empty($difIconCol)): echo ' '.$difIconCol; else: ?> icon-pro-black-simple<?php endif; ?>">
                                                <?php
                                                    $svg_markup = file_get_contents(get_attached_file($difRepIcon['ID']));
                                                    echo $svg_markup;
                                                ?>
                                            </span>
                                        <?php endif;
                                        if (!empty($difRepTitle)): ?>
                                            <span class="<?php if (!empty($difRepTitleFs)): echo $difRepTitleFs.' '; else: ?>h5 small-static <?php endif; if (!empty($difRepTitleFc)): echo $difRepTitleFc.' '; else: ?>color-pro-black <?php endif; ?>u-pro-red values-head-title mb-0"><?php echo $difRepTitle; ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif;
                                if (!empty($difRepText)): ?>
                                    <div class="values-body">
                                        <div class="<?php if (!empty($difRepTextFs)): echo $difRepTextFs.' '; else: ?>paragraph large <?php endif; if (!empty($difRepTextFc)): echo $difRepTextFc.' '; else: ?>color-pro-black <?php endif; ?>values-body-text m-0"><?php echo $difRepText; ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
