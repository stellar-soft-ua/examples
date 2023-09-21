<?php /**
 * Block Name: Rd Text & Image Pattern
*
* This is the template that displays the Rd Text & Image Pattern
*/
// Title fields
$wpwTitle = get_field('wpw_title');
$wpwTitleFs = get_field('wpw_title_fs');
$wpwTitleFc = get_field('wpw_title_fc');
// Text fields
$wpwText = get_field('wpw_text');
$wpwTextFc = get_field('wpw_text_fc');
// Section fields
$wpwbgColor = get_field('wpw_bg_color');
$wpwImg = get_field('wpw_img');
$wpwbgImg1 = get_field('wpw_bg_img_1');
$wpwbgImg2 = get_field('wpw_bg_img_2');

if (!empty($wpwTitle) || !empty($wpwText) || !empty($wpwImg)): ?>
    <section class="section-advanced d-6 pro-reporting-section-d-6<?php if (!empty($wpwbgColor)): echo ' '.$wpwbgColor; else: ?> bg-transparent<?php endif; ?>"
        <?php if (!empty($wpwbgImg1)):?>
            style="background-image: url('<?php echo esc_url($wpwbgImg1['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
        <div class="container d-flex flex-column align-items-center justify-content-center">
            <div class="content row d-flex flex-column flex-xl-row">
                <?php if (!empty($wpwTitle) || !empty($wpwText)): ?>
                    <div class="content-info d-flex align-items-xl-center justify-content-xl-center">
                        <div class="content-info-wrap">
                            <?php if (!empty($wpwTitle)): ?>
                                <div class="title-wrap">
                                    <h2 class="<?php if (!empty($wpwTitleFs)): echo $wpwTitleFs.' '; else: ?>h3 <?php endif; if (!empty($wpwTitleFc)): echo $wpwTitleFc.' '; else: ?>color-pro-black <?php endif; ?>u-pro-red text-uppercase mb-0"><?php echo $wpwTitle; ?></h2>
                                </div>
                            <?php endif;
                            if (!empty($wpwText)): ?>
                                <div class="<?php if (!empty($wpwTextFc)): echo $wpwTextFc.' '; else: ?>color-pro-black <?php endif; ?>paragraph content-info-text"><?php echo $wpwText; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="content-img d-flex align-items-center justify-content-center justify-content-xl-end"
                    <?php if (!empty($wpwbgImg2)):?>
                        style="background-image: url('<?php echo esc_url($wpwbgImg2['sizes']['full_hd']); ?>')"
                    <?php endif; ?>>
                    <?php if (!empty($wpwImg)): ?>
                        <div class="content-img-wrap d-flex align-items-center justify-content-center">
                            <img src="<?php echo esc_url($wpwImg['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($wpwImg['alt']); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>