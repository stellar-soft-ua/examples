<?php /**
 * Block Name: Rd Hero Full Image Background
*
* This is the template that displays the Rd Hero Full Image Background
*/
// Title fields
$ftrTitle = get_field('ftr_title');
$ftrTitleFc = get_field('ftr_title_fc');
$ftrTitleFs = get_field('ftr_title_fs');
// Paragraph fields
$ftrText = get_field('ftr_text');
$ftrTextFc = get_field('ftr_text_fc');
$ftrTextFs = get_field('ftr_text_fs');
// Section fields
$ftrbgImg = get_field('ftr_bg_img');
$ftrbgColor = get_field('ftr_bg_color');
$ftrImg = get_field('ftr_img');
$secTmpl = get_field('ftr_sec_tmpl');
$numId = get_field('ftr_num_id');
$scrollBtnText = get_field('ftr_scroll_btn_txt');
$scrollBtnTextCheck = get_field('ftr_scroll_btn_check');

if (!empty($ftrTitle) || !empty($ftrText) || !empty($ftrTitle) || !empty($ftrImg)): ?>
    <section class="section-advanced d-1<?php if (!empty($secTmpl)): echo ' '.$secTmpl; else: ?> features-section-d-1<?php endif; if (!empty($ftrbgColor)): echo ' '.$ftrbgColor; else: ?> bg-transparent<?php endif; ?>"
        <?php if (!empty($ftrbgImg)):?>
            style="background-image: url('<?php echo esc_url($ftrbgImg['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
        <div class="container">
            <div class="content">
                <?php if (!empty($ftrTitle) || !empty($ftrText)): ?>
                    <div class="title-wrap">
                        <?php if (!empty($ftrTitle)): ?>
                            <h1 class="<?php if (!empty($ftrTitleFs)): echo $ftrTitleFs.' '; else: ?>h2 <?php endif; if (!empty($ftrTitleFc)): echo $ftrTitleFc.' '; else: ?>color-pro-black <?php endif; ?>u-pro-red hero-title text-uppercase mb-0 text-center text-xl-start"><?php echo $ftrTitle; ?></h1>
                        <?php endif;
                        if (!empty($ftrTitle)): ?>
                            <div class="<?php if (!empty($ftrTextFs)): echo $ftrTextFs.' '; else: ?>subtitle-large <?php endif; if (!empty($ftrTextFc)): echo $ftrTextFc.' '; else: ?>color-pro-black <?php endif; if ($secTmpl !== 'features-section-d-1'): ?>text-center text-xl-start <?php endif; ?>mb-0 subtitle-custom-hero"><?php echo $ftrText; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif;
                if (!empty($ftrImg)): ?>
                    <div class="hero-wrap">
                        <img src="<?php echo esc_url($ftrImg['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($ftrImg['alt']); ?>">
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!empty($scrollBtnTextCheck) && $scrollBtnTextCheck == true): ?>
            <a class="scroll-btn" href="#d-<?php if (!empty($numId)): echo $numId; else: ?>2<?php endif; ?>">
                <?php if (!empty($scrollBtnText)): ?>
                    <span class="scroll-btn-text text-uppercase text-primary fw-bold"><?php echo $scrollBtnText; ?></span>
                <?php endif; ?>
                <span class="scroll-btn-icon"></span>
            </a>
        <?php endif; ?>
    </section>
<?php endif; ?>