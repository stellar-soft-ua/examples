<?php /**
 * Block Name: Rd Horizontal Accordion
*
* This is the template that displays the Rd Horizontal Accordion
*/
// Suptitle fields
$rdBLockSuptitle = get_field('rd_ttl_block_suptitle');
$rdBLockSuptitleFs = get_field('rd_ttl_block_suptitle_fs');
// Title fields
$rdBLockTitle = get_field('rd_ttl_block_title');
$rdBLockTitleFs = get_field('rd_ttl_block_title_fs');
// Button fields
$textBtn = get_field('rd_ttl_block_btn');
$textBtnSize = get_field('rd_ttl_block_btn_size');
$textBlockVideoBtn = get_field('rd_ttl_block_video_btn');
$textBlockVBtnCheck = get_field('rd_ttl_block_btn_check');
$linkTarget = $textBtn['target'] ? $textBtn['target'] : '_self';
// Text fields
$rdBLockTextDesc = get_field('rd_ttl_block_text_desc');
// Section fields
$ttlbg = get_field('rd_ttl_bg_color');
$ttlbgImg = get_field('rd_ttl_bg_img');

if (!empty($rdBLockTitle) || !empty($rdBLockSuptitle) || !empty($rdBLockTextDesc) || !empty($rdBLockTextDesc)): ?>
    <section class="section-advanced d-4-home section-only-text <?php if (!empty($ttlbg)): echo ' '.$ttlbg; else: ?> bg-transparent<?php endif; ?>"
        <?php if (!empty($ttlbgImg)):?>
            style="background-image: url('<?php echo esc_url($ttlbgImg['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 text-md-center">
                    <?php if ($rdBLockSuptitle): ?>
                        <h6 class="<?php if (!empty($rdBLockSuptitleFs)): echo $rdBLockSuptitleFs.' '; else: ?>h6 <?php endif; ?>color-pro-red suptitle text-uppercase letter-spacing-4-61"><?php echo $rdBLockSuptitle; ?></h6>
                    <?php endif;
                    if ($rdBLockTitle): ?>
                        <h2 class="<?php if (!empty($rdBLockTitleFs)): echo $rdBLockTitleFs.' '; else: ?>h3 <?php endif; ?>color-pro-black u-pro-red title text-uppercase"><?php echo $rdBLockTitle; ?></h2>
                    <?php endif;
                    if ($rdBLockTextDesc): ?>
                        <div class="large color-pro-black text"><?php echo $rdBLockTextDesc; ?></div>
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
        </div>
    </section>
<?php endif; ?>