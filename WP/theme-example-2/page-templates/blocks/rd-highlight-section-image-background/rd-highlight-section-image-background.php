<?php /**
 * Block Name: Rd Highlight Section Image Background
*
* This is the template that displays the Rd Highlight Section Image Background
*/
// Text fields
$textCont = get_field('rd_text_block_cont');
$textParFS = get_field('rd_text_block_par_fs');
$textParFC = get_field('rd_text_block_par_fc');
// Title fields
$textHeader = get_field('rd_text_block_header');
$textTitleFS = get_field('rd_text_block_title_fs');
$textTitleFC = get_field('rd_text_block_title_fc');
// Section fields
$textBg = get_field('rd_text_block_bg');
$textBlockMod = get_field('text_block_mod');
$textBgColor = get_field('rd_text_block_bg_color');
// Button fields
$textBtn = get_field('rd_text_block_btn');
$textBtnSize = get_field('rd_text_block_btn_size');
$textBlockVideoBtn = get_field('text_block_video_btn');
$textBlockVBtnCheck = get_field('text_block_btn_check');
$linkTarget = $textBtn['target'] ? $textBtn['target'] : '_self';
?>
<section class="section-advanced d-2 about-pro-section-d-2<?php if (!empty($textBlockMod)): echo ' '.$textBlockMod; else: ?> default-theme<?php endif; if (!empty($textBgColor)): echo ' '.$textBgColor; else: ?> bg-transparent<?php endif; ?>"
        <?php if (!empty($textBg)):?>
            style="background-image: url('<?php echo esc_url($textBg['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
    <div class="container d-flex justify-content-center align-atems-center">
        <div class="content">
            <?php if (!empty($textHeader)): ?>
                <div class="title-wrap d-flex justify-content-center align-atems-center mb-4">
                    <h2 class="<?php if (!empty($textTitleFS)): echo $textTitleFS.' '; else: ?>h3 <?php endif; ?><?php if (!empty($textTitleFC)): echo $textTitleFC.' '; else: ?>color-pro-white <?php endif; ?>u-pro-red text-uppercase text-center mb-0"><?php echo $textHeader; ?></h2>
                </div>
            <?php endif;
            if (!empty($textCont)): ?>
                <div class="<?php if (!empty($textParFS)): echo $textParFS.' '; else: ?>subtitle <?php endif; ?><?php if (!empty($textParFC)): echo $textParFC.' '; else: ?>color-pro-white <?php endif; ?>m-0 text-center"><?php echo $textCont; ?></div>
            <?php endif;
            if (!empty($textBtn) || !empty($textBlockVideoBtn)): ?>
                <div class="btn-wrap mt-5 w-100 d-flex justify-content-center align-atems-center">
                    <?php if (!empty($textBlockVBtnCheck) && $textBlockVBtnCheck == 'link'):
                        if (!empty($textBtn)): ?>
                            <a class="<?php if (!empty($textBtnSize)): echo $textBtnSize.' '; endif; ?>btn-rounded btn-rounded-red btn bg-pro-red btn-link-custom" target="<?php echo esc_attr($linkTarget); ?>" href="<?php echo esc_url($textBtn['url']); ?>" aria-label="<?php echo esc_html( $textBtn['title'] ); ?>">
                                <span class="color-pro-white"><?php echo esc_html( $textBtn['title'] ); ?></span>
                            </a>
                        <?php endif;
                    elseif (!empty($textBlockVBtnCheck) && $textBlockVBtnCheck == 'video'):
                        if (!empty($textBlockVideoBtn)): ?>
                            <button class="<?php if (!empty($textBtnSize)): echo $textBtnSize.' '; endif; ?>btn-rounded btn-rounded-red btn video-btn video-gtnp bg-pro-red btn-type-custom" type="button" aria-label="<?php echo $textBlockVideoBtn; ?>">
                                <span class="color-pro-white"><?php echo $textBlockVideoBtn; ?></span>
                            </button>
                        <?php endif;
                    endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
