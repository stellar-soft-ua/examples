<?php /**
 * Block Name: Rd Vertical Accordion
*
* This is the template that displays the Rd Vertical Accordion
*/
// Suptitle fields
$pfSuptitle = get_field('pf_suptitle');
$pfSuptitleFc = get_field('pf_suptitle_fc');
$pfSuptitleFs = get_field('pf_suptitle_fs');
// Accordion title fields
$pfAcc = 'pf_acc_repeater';
$pfAccTitleFc = get_field('pf_acc_title_fc');
$pfAccTitleFs = get_field('pf_acc_title_fs');
// Accordion text fields
$pfAccTextFs = get_field('pf_acc_text_fs');
$pfAccTextFc = get_field('pf_acc_text_fc');
// Text fields
$pfTextDesk = get_field('pf_text_desk');
$pfTextFc = get_field('pf_text_fc');
$pfTextFs = get_field('pf_text_fs');
// Section fields
$pfbgImg = get_field('pf_bg_img');
$pfbgSectionImg = get_field('pf_bg_section_img');
$pfbgColor = get_field('pf_bg_color');
$index = 0;
?>
<section class="section-advanced d-6 bg-cover<?php if (!empty($pfbgColor)): echo ' '.$pfbgColor; else: ?> bg-transparent<?php endif; ?>"
    <?php if (!empty($pfbgSectionImg)):?>
        style="background-image: url('<?php echo esc_url($pfbgSectionImg['sizes']['full_hd']); ?>')"
    <?php endif; ?>>
    <div class="container">
        <?php if (!empty($pfSuptitle) || !empty($pfTextDesk)): ?>
            <div class="row justify-content-center">
                <div class="col-lg-9 text-md-center">
                    <?php if (!empty($pfSuptitle)): ?>
                        <h6 class="<?php if (!empty($pfSuptitleFs)): echo $pfSuptitleFs.' '; else: ?>h6 <?php endif; if (!empty($pfSuptitleFc)): echo $pfSuptitleFc.' '; else: ?>color-pro-red <?php endif; ?>suptitle text-uppercase letter-spacing-4-61"><?php echo $pfSuptitle; ?></h6>
                    <?php endif;
                    if (!empty($pfTextDesk)): ?>
                        <div class="<?php if (!empty($pfTextFs)): echo $pfTextFs.' '; else: ?>extra-large <?php endif; ?><?php if (!empty($pfTextFc)): echo $pfTextFc.' '; else: ?>color-pro-black <?php endif; ?>d-6__descr"><?php echo $pfTextDesk; ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif;
        if (have_rows($pfAcc)): ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="accordion" id="accordionExample">
                        <?php while(have_rows($pfAcc)) :
                            the_row();
                            $pfAccTitle = get_sub_field('pf_acc_title');
                            $pfAccIcon = get_sub_field('pf_acc_icon');
                            $pfAccText = get_sub_field('pf_acc_text');
                            $pfAccImg = get_sub_field('pf_acc_img');
                            $pfBtn = get_sub_field('pf_btn');
                            $pfBtnClass = get_sub_field('pf_btn_class');
                            $pfLinkBtn = get_sub_field('pf_btn_link');
                            $pfBtnCheck = get_sub_field('pf_btn_check');
                            $pfLinkTarget = $pfLinkBtn['target'] ? $pfLinkBtn['target'] : '_self';
                            $index++; ?>
                            <div class="accordion-item">
                                <?php if (!empty($pfAccTitle)): ?>
                                    <h4 class="accordion-header" id="heading-<?php echo $index; ?>">
                                        <button class="accordion-button <?php if ($index > 1): ?>collapsed<?php endif; ?>" type="button" data-bs-toggle="collapse" aria-label="Features platform" data-bs-target="#collapse-<?php echo $index; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $index; ?>">
                                            <?php if (!empty($pfAccIcon)): ?>
                                                <img class="accordion-button__icon" src="<?php echo esc_url($pfAccIcon['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($pfAccIcon['alt']); ?>">
                                            <?php endif; ?>
                                            <div class="<?php if (!empty($pfAccTitleFs)): echo $pfAccTitleFs.' '; else: ?>h4 <?php endif; if (!empty($pfAccTitleFc)): echo $pfAccTitleFc.' '; else: ?>color-pro-black <?php endif; ?>text-uppercase"><?php echo $pfAccTitle; ?></div>
                                        </button>
                                    </h4>
                                <?php endif; ?>
                                <div id="collapse-<?php echo $index; ?>" class="accordion-collapse collapse <?php if ($index == 1): ?>show<?php endif; ?>" aria-labelledby="heading-<?php echo $index; ?>" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php if (!empty($pfAccText)): ?>
                                            <div class="<?php if (!empty($pfAccTextFs)): echo $pfAccTextFs.' '; else: ?>large <?php endif; if (!empty($pfAccTextFc)): echo $pfAccTextFc.' '; else: ?>color-pro-black <?php endif; ?>"><?php echo $pfAccText; ?></div>
                                        <?php endif;
                                        if (!empty($pfBtn) || !empty($pfLinkBtn)): ?>
                                            <div class="btn-wrap mb-4 mt-4 w-100 d-flex justify-content-center justify-content-xl-start align-atems-center">
                                                <?php if (!empty($pfBtnCheck) && $pfBtnCheck == 'link'):
                                                    if (!empty($pfLinkBtn)): ?>
                                                        <a class="<?php if (!empty($pfBtnClass)): echo $pfBtnClass.' '; endif; ?>btn-rounded btn-rounded-red btn bg-pro-red btn-link-custom" target="<?php echo esc_attr($linkTarget); ?>" href="<?php echo esc_url($pfLinkBtn['url']); ?>" aria-label="<?php echo esc_html($pfLinkBtn['title']); ?>">
                                                            <span class="color-pro-white"><?php echo esc_html( $pfLinkBtn['title'] ); ?></span>
                                                        </a>
                                                    <?php endif;
                                                elseif (!empty($pfBtnCheck) && $pfBtnCheck == 'video'):
                                                    if (!empty($pfBtn)): ?>
                                                        <button class="<?php if (!empty($pfBtnClass)): echo $pfBtnClass.' '; endif; ?>btn-rounded btn-rounded-red btn video-btn video-gtnp bg-pro-red btn-type-custom" type="button" aria-label="<?php echo $pfBtn; ?>">
                                                            <span class="color-pro-white"><?php echo $pfBtn; ?></span>
                                                        </button>
                                                    <?php endif;
                                                endif; ?>
                                            </div>
                                        <?php endif;
                                        if (!empty($pfAccText)): ?>
                                            <div class="d-6__image-wrapper d-flex">
                                                <img class="d-6__image show" src="<?php echo esc_url($pfAccImg['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($pfAccIcon['alt']); ?>">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php if (!empty($pfbgImg)): ?>
                    <div class="col-lg-6 acc-bg-desc d-none d-lg-block">
                        <?php if (!empty($pfbgImg)):?>
                           <div class="vertical-acc-bg" style="background-image: url('<?php echo esc_url($pfbgImg['sizes']['full_hd']); ?>')"></div>
                        <?php endif; ?>
                        <div class="accordion-border d-block d-lg-none"></div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>