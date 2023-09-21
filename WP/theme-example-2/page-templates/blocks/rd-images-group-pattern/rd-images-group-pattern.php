<?php /**
 * Block Name: Rd Images Group Pattern
*
* This is the template that displays the Rd Images Group Pattern
*/
// Suptitle fields
$expSuptitle = get_field('exp_suptitle');
$expSuptitleFs = get_field('exp_suptitle_fs');
// Title fields
$expTitle = get_field('exp_title');
$expTitleFc = get_field('exp_title_fc');
$expTitleFs = get_field('exp_title_fs');
// Paragraph fields
$expText = get_field('exp_text');
$expTextFc = get_field('exp_text_fc');
$expTextFs = get_field('exp_text_fs');
// Repeater fields
$expRep = 'exp_acc_repeater';
$expRepTitleFc = get_field('exp_acc_title_fc');
$expRepTextFc = get_field('exp_acc_text_fc');
$expblockRowNumMd = get_field('ex_block_row_num_md');
$expblockRowNumXl = get_field('ex_block_row_num_xl');
// Section fields
$expbg = get_field('exp_bg');
$expbgImg = get_field('exp_bg_img');
$seeMoreBtn = get_field('exp_see_more_btn');
$linkTarget = $seeMoreBtn['target'] ? $seeMoreBtn['target'] : '_self';
$expRepSelect = get_field('exp_select_tmpl');

if (have_rows($expRep) || !empty($expSuptitle) || !empty($expTitle) || !empty($expText)): ?>
    <section class="<?php if (!empty($expRepSelect) && $expRepSelect == 'home'): ?>experts-list-advanced<?php elseif (!empty($expRepSelect) && $expRepSelect == 'about'): ?>about-pro-section-d-5 section-advanced d-5<?php else: ?>experts-list-advanced<?php endif; if (!empty($expbg)): echo ' '.$expbg; else: ?> bg-transparent<?php endif; ?>"
        <?php if (!empty($expbgImg)):?>
            style="background-image: url('<?php echo esc_url($expbgImg['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
        <div class="container">
            <?php if (!empty($expSuptitle) || !empty($expTitle)): ?>
                <div class="row justify-content-center">
                    <div class="col-lg-2 col-xxl-1 p-0"></div>
                    <div class="col-lg-8 col-xxl-10 p-0 text-center d-flex justify-content-center">
                        <div class="title-wrap">
                            <?php if (!empty($expSuptitle)): ?>
                                <h6 class="<?php if (!empty($expSuptitleFs)): echo $expSuptitleFs.' '; else: ?>h6 <?php endif; ?>color-pro-red suptitle text-uppercase letter-spacing-4-61"><?php echo $expSuptitle; ?></h6>
                            <?php endif;
                            if (!empty($expTitle)): ?>
                                <h2 class="<?php if (!empty($expTitleFs)): echo $expTitleFs.' '; else: ?>h3 <?php endif; if (!empty($expTitleFc)): echo $expTitleFc.' '; else: ?>color-pro-black <?php endif; ?>u-pro-red title text-uppercase"><?php echo $expTitle; ?></h2>
                            <?php endif;
                            if ($expText): ?>
                                <div class="<?php if (!empty($expTextFs)): echo $expTextFs.' '; else: ?>paragraph paragraph-demo <?php endif; if (!empty($expTextFc)): echo $expTextFc.' '; else: ?>color-pro-black <?php endif; ?>text-center mb-0 paragraph-custom"><?php echo $expText; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-2 col-xxl-1 text-end see-more-wrap">
                        <?php if (!empty($seeMoreBtn)): ?>
                            <a target="<?php echo esc_attr($linkTarget); ?>" href="<?php echo esc_url($seeMoreBtn['url']); ?>" class="btn btn-link" aria-label="<?php echo esc_html($seeMoreBtn['title']); ?>"><?php echo esc_attr($seeMoreBtn['title']); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif;
            if (have_rows($expRep)): ?>
                <div class="experts-list-wrapper">
                    <div class="row justify-content-center">
                        <?php while(have_rows($expRep)):
                            the_row();
                            $expImg = get_sub_field('exp_rep_img');
                            $expTitle = get_sub_field('exp_rep_title');
                            $expText = get_sub_field('exp_rep_text');
                            $expDescrip = get_sub_field('exp_rep_descrip'); ?>
                            <div class="expert col-6 col-md-<?php if (!empty($expblockRowNumMd)): echo $expblockRowNumMd; else: ?>4<?php endif; ?> col-xl-<?php if (!empty($expblockRowNumXl)): echo $expblockRowNumXl; else: ?>3<?php endif; ?> text-center">
                                <?php if (!empty($expImg)): ?>
                                    <div class="expert-head d-flex align-items-center justify-content-center">
                                        <div class="expert-head-photo" style="background-image: url('<?php echo esc_url($expImg['sizes']['full_hd']); ?>')">
                                        </div>
                                    </div>
                                <?php endif;
                                if (!empty($expTitle) || !empty($expText) || !empty($expDescrip)): ?>
                                    <div class="expert-body d-flex align-items-center justify-content-center flex-column">
                                        <?php  if (!empty($expTitle)): ?>
                                            <span class="<?php if (!empty($expRepTitleFc)): echo $expRepTitleFc.' '; else: ?>color-pro-black <?php endif; ?>expert-body-title"><?php echo $expTitle; ?></span>
                                        <?php endif;
                                         if (!empty($expText) || !empty($expDescrip)): ?>
                                            <p class="<?php if (!empty($expRepTextFc)): echo $expRepTextFc.' '; else: ?>color-pro-gray <?php endif; ?>expert-body-text d-none d-xl-inline">
                                                <?php if (!empty($expRepSelect) && $expRepSelect == 'home'):
                                                    if (!empty($expDescrip)):
                                                        echo $expDescrip.'<br/>';
                                                    endif;
                                                    if (!empty($expText)): ?>
                                                        <span class="exp-txt font-weight-bold"><?php echo $expText; ?></span>
                                                    <?php endif;
                                                elseif (!empty($expRepSelect) && $expRepSelect == 'about'):
                                                    if (!empty($expText)): ?>
                                                        <span><?php echo $expText; ?></span><br/>
                                                    <?php endif;
                                                    if (!empty($expDescrip)):
                                                        echo $expDescrip;
                                                    endif;
                                                endif; ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>