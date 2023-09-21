<?php /**
 * Block Name: Rd Features Icons Version
*
* This is the template that displays the Rd Features Icons Version
*/ 
// Repeater
$afRepeater = 'af_repeater';
$afRepTitleFs = get_field('af_rep_title_fs');
$afRepTitleFc = get_field('af_rep_title_fc');
$afRepTextFs = get_field('af_rep_text_fs');
$afRepTextFc = get_field('af_rep_text_fc');
$aligneCont = get_field('af_aligne_cont');
$afPreRowXl = get_field('af_per_row_xl');
$afPreRowMd = get_field('af_per_row_md');
$afIconCol = get_field('af_icon_color');
// Suptitle fields
$afSuptitle = get_field('af_sutitle');
$afSuptitleFs = get_field('af_sutitle_fs');
$afSuptitleFc = get_field('af_suptitle_fc');
// Title fields
$afTitle = get_field('af_title');
$afTitleFs = get_field('af_title_fs');
$afTitleFc = get_field('af_title_fc');
// Text fields
$afText = get_field('af_text');
$afTextFs = get_field('af_text_fs');
$afTextFc = get_field('af_text_fc');
// Section fields
$afBg = get_field('af_bg');
$afBgImg = get_field('af_bg_img');
$sectionSelect = get_field('af_section_select');

if (have_rows($afRepeater) || !empty($afSuptitle) || !empty($afTitle) || !empty($afText)): ?>
    <section class="section-advanced<?php if(!empty($sectionSelect) && $sectionSelect == 'features'): ?> d-5 features-section-d-5<?php elseif (!empty($sectionSelect) && $sectionSelect == 'reporting'): ?> d-5 pro-reporting-section-d-5<?php elseif (!empty($sectionSelect) && $sectionSelect == 'plans'): ?> d-3 pro-plans-section-d-3<?php else: ?> features-section-d-5<?php endif; if (!empty($afBg)): echo ' '.$afBg; else: ?> bg-pro-white-smoke<?php endif; ?>"
        <?php if (!empty($afBgImg)):?>
            style="background-image: url('<?php echo esc_url($afBgImg['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
        <div class="container">
            <div class="content<?php if (!empty($sectionSelect) && $sectionSelect == 'reporting'): ?> d-flex align-items-center justify-content-center flex-column<?php elseif (!empty($sectionSelect) && $sectionSelect == 'plans'): ?> d-flex flex-column  align-items-center justify-content-xl-center w-100<?php endif; ?>">
                <?php if (!empty($afSuptitle) || !empty($afTitle) || !empty($afText)): ?>
                    <div class="title-wrap row d-flex align-items-xl-center justify-content-xl-center flex-column">
                        <?php if (!empty($afSuptitle)): ?>
                            <h6 class="<?php if (!empty($afSuptitleFs)): echo $afSuptitleFs.' '; else: ?>h6 <?php endif; if (!empty($afSuptitleFc)): echo $afSuptitleFc.' '; else: ?>color-pro-red <?php endif; ?>text-uppercase suptitle text-xl-center mb-0"><?php echo $afSuptitle; ?></h6>
                        <?php endif;
                        if (!empty($afTitle)): ?>
                            <h2 class="<?php if (!empty($afTitleFs)): echo $afTitleFs.' '; else: ?>h3 <?php endif; if (!empty($afTitleFc)): echo $afTitleFc.' '; else: ?>color-pro-black <?php endif; ?>u-pro-red text-uppercase text-xl-center mb-0"><?php echo $afTitle; ?></h2>
                        <?php endif;
                        if (!empty($afText)): ?>
                            <div class="<?php if (!empty($afTextFs)): echo $afTextFs.' '; else: ?>subtitle subtitle-trust <?php endif; if (!empty($afTextFc)): echo $afTextFc.' '; else: ?>color-pro-black <?php endif; ?>text-xl-center custom-subtitle mb-0"><?php echo $afText; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif;
                if (have_rows($afRepeater)): ?>
                    <div class="row<?php if(!empty($sectionSelect) && $sectionSelect == 'features'): ?> additional-features<?php elseif (!empty($sectionSelect) && $sectionSelect == 'reporting'): ?> trust<?php elseif (!empty($sectionSelect) && $sectionSelect == 'plans'): ?> faqs<?php else: ?> additional-features<?php endif; ?>">
                        <?php while (have_rows($afRepeater)):
                            the_row();
                            $afRepIcon = get_sub_field('af_rep_icon');
                            $afRepTitle = get_sub_field('af_rep_title');
                            $afRepText = get_sub_field('af_rep_text');
                            $afRepLink = get_sub_field('af_rep_link');
                            $afRepLinkTarget = $afRepLink['target'] ? $afRepLink['target'] : '_self'; ?>
                            <div class="d-flex flex-column justify-content-md-between<?php if(!empty($sectionSelect) && $sectionSelect == 'features'): ?> additional-features-block<?php elseif (!empty($sectionSelect) && $sectionSelect == 'reporting'): ?> trust-block align-items-xl-center<?php elseif (!empty($sectionSelect) && $sectionSelect == 'plans'): ?> faqs-block<?php else: ?> additional-features-block<?php endif; ?> col-12 col-md-<?php if (!empty($afPreRowMd)): echo $afPreRowMd; else: ?>6<?php endif; ?> col-xl-<?php if (!empty($afPreRowXl)): echo $afPreRowXl; else: ?>4<?php endif; if (!empty($aligneCont) && $aligneCont == 'center'): ?> text-center<?php endif; ?>">
                                <div class="column-block-wrap<?php if (!empty($aligneCont) && $aligneCont == 'center'): ?> d-flex flex-column align-items-center<?php endif; ?>">
                                    <?php if (!empty($afRepIcon) || !empty($afRepTitle)): ?>
                                        <div class="d-flex flex-column<?php if(!empty($sectionSelect) && $sectionSelect == 'features'): ?> additional-features-block-header<?php elseif (!empty($sectionSelect) && $sectionSelect == 'reporting'): ?> trust-block-head align-items-xl-center justify-content-xl-center<?php elseif (!empty($sectionSelect) && $sectionSelect == 'plans'): ?> faqs-block-head<?php else: ?> additional-features-block-header<?php endif; if (!empty($aligneCont) && $aligneCont == 'center'): ?> align-items-center<?php endif; ?>">
                                            <?php if (!empty($afRepIcon)): ?>
                                                <div class="<?php if(!empty($sectionSelect) && $sectionSelect == 'features'): ?>additional-features-icon-wrap<?php elseif (!empty($sectionSelect) && $sectionSelect == 'reporting'): ?>trust-block-head-icon<?php elseif (!empty($sectionSelect) && $sectionSelect == 'plans'): ?>faqs-icon-wrap<?php else: ?>additional-features-icon-wrap<?php endif; if (!empty($afIconCol)): echo ' '.$afIconCol; else: ?> icon-pro-black-simple<?php endif; ?>">
                                                    <?php
                                                        $svg_markup = file_get_contents(get_attached_file( $afRepIcon['ID'] ));
                                                        echo $svg_markup;
                                                    ?>
                                                </div>
                                            <?php endif;
                                            if (!empty($afRepTitle)): ?>
                                                <div class="<?php if (!empty($afRepTitleFs)): echo $afRepTitleFs.' '; else: ?>h5 small <?php endif; if (!empty($afRepTitleFc)): echo $afRepTitleFc.' '; else: ?>color-pro-black <?php endif; ?>u-pro-red mb-0<?php if(!empty($sectionSelect) && $sectionSelect == 'features'): ?> additional-features-title<?php elseif (!empty($sectionSelect) && $sectionSelect == 'reporting'): ?> trust-block-body-title text-xl-center<?php elseif (!empty($sectionSelect) && $sectionSelect == 'plans'): ?> faqs-block-title<?php else: ?> additional-features-title<?php endif; ?>"><?php echo $afRepTitle; ?></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif;
                                    if (!empty($afRepText)): ?>
                                        <div class="<?php if (!empty($afRepTextFs)): echo $afRepTextFs.' '; else: ?>default <?php endif; if (!empty($afRepTextFc)): echo $afRepTextFc.' '; else: ?>color-pro-black <?php endif; if(!empty($sectionSelect) && $sectionSelect == 'features'): ?>additional-features-block-body<?php elseif (!empty($sectionSelect) && $sectionSelect == 'reporting'): ?>trust-block-body-text text-xl-center<?php endif; if(!empty($sectionSelect) && $sectionSelect == 'plans'): ?>faqs-block-body<?php else: ?>additional-features-block-body<?php endif; ?>"><?php echo $afRepText; ?></div>
                                    <?php endif; ?>
                                </div>
                                <?php if(!empty($afRepLink)): ?>
                                    <div class="faqs-block-footer<?php if (!empty($aligneCont) && $aligneCont == 'center'): ?> d-flex flex-column align-items-center<?php endif; ?>">
                                        <a class="faqs-block-link d-flex flex-row align-items-center" href="<?php echo esc_url($afRepLink['url']); ?>" target="<?php echo esc_attr($afRepLinkTarget); ?>" aria-label="<?php echo esc_html($afRepLink['title']); ?>">
                                            <span class="faqs-block-link-text"><?php echo esc_html($afRepLink['title']); ?></span>
                                            <span class="faqs-block-link-arrow"></span>
                                        </a>
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