<?php /**
 * Block Name: Rd Glimpse Block
*
* This is the template that displays the Rd Glimpse Block
*/
// Suptitle fields
$glSuptitle = get_field('gl_suptitle');
$glSuptitleFc = get_field('gl_suptitle_fc');
$glSuptitleFs = get_field('gl_suptitle_fs');
// Title fields
$glTitle = get_field('gl_title');
$glTitleFc = get_field('gl_title_fc');
$glTitleFs = get_field('gl_title_fs');
// Blocks title fields
$glAcc = 'gl_acc_repeater';
$glAccTitleFc = get_field('gl_acc_title_fc');
// Blocks fields
$glblockRowNum = get_field('gl_block_row_num');
// Blocks text fields
$glAccTextFs = get_field('gl_acc_text_fs');
$glAccTextFc = get_field('gl_acc_text_fc');
// Section fields
$glbg = get_field('gl_bg');
$glbgImg = get_field('gl_bg_img');
$index = -1;
$in = -1;

if (have_rows($glAcc) || !empty($glSuptitle) || !empty($glTitle)): ?>
    <section class="section-advanced d-7-home<?php if (!empty($glbg)): echo ' '.$glbg; else: ?> bg-pro-white-smoke<?php endif; ?>"
        <?php if (!empty($glbgImg)):?>
            style="background-image: url('<?php echo esc_url($glbgImg['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
        <div class="container">
            <?php if (!empty($glSuptitle) || !empty($glTitle)): ?>
                <div class="row">
                    <div class="col-12 text-center">
                        <?php if (!empty($glSuptitle)): ?>
                            <h6 class="<?php if (!empty($glSuptitleFs)): echo $glSuptitleFs.' '; else: ?>h6 <?php endif; if (!empty($glSuptitleFc)): echo $glSuptitleFc.' '; else: ?>color-pro-red <?php endif; ?>suptitle text-uppercase letter-spacing-4-61"><?php echo $glSuptitle; ?></h6>
                        <?php endif;
                        if (!empty($glTitle)): ?>
                            <h2 class="<?php if (!empty($glTitleFs)): echo $glTitleFs.' '; else: ?>h3 <?php endif; if (!empty($glTitleFc)): echo $glTitleFc.' '; else: ?>color-pro-black <?php endif; ?>u-pro-red title text-uppercase"><?php echo $glTitle; ?></h2>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif;
            if (have_rows($glAcc)): ?>
                <div class="d-7-posts d-none d-md-block">
                    <div class="row justify-content-center">
                        <?php while(have_rows($glAcc)) :
                            the_row();
                            $glAccTitle = get_sub_field('gl_acc_title');
                            $glAccLink = get_sub_field('gl_acc_link');
                            $readMoreBtn = get_sub_field('gl_read_more_btn');
                            $linkTarget = get_sub_field('gl_link_target');
                            $glAccText = get_sub_field('gl_acc_text');
                            $glAccImg = get_sub_field('gl_acc_img');
                            if (!empty($glAccTitle) || !empty($glAccText) || !empty($glAccImg) || !empty($glAccText) || !empty($glAccLink)): ?>
                                <div class="col-md-<?php if (!empty($glblockRowNum)): echo $glblockRowNum; else: ?>3<?php endif; ?>">
                                    <div class="d-7-posts-item">
                                        <?php if (!empty($glAccTitle)): ?>
                                            <div class="<?php if (!empty($glAccTitleFc)): echo $glAccTitleFc.' '; else: ?>color-pro-balck <?php endif; ?>d-7-posts-item__cat"><?php echo $glAccTitle; ?></div>
                                        <?php endif;
                                        if (!empty($glAccImg)): ?>
                                        <a target="<?php echo $linkTarget; ?>" href="<?php echo $glAccLink; ?>" class="d-7-posts-item__img-wrapper" aria-label="<?php echo esc_attr($glAccImg['alt']); ?>">
                                            <img class="d-7-posts-item__img" src="<?php echo esc_url($glAccImg['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($glAccImg['alt']); ?>">
                                        </a>
                                        <?php endif;
                                        if (!empty($glAccText)): ?>
                                            <h5 class="<?php if (!empty($glAccTextFs)): echo $glAccTextFs.' '; else: ?>h5 small <?php endif; ?><?php if (!empty($glAccTextFc)): echo $glAccTextFc.' '; else: ?>color-pro-black <?php endif; ?>d-7-posts-item__title"><?php echo $glAccText; ?></h5>
                                        <?php endif;
                                        if (!empty($glAccLink) || !empty($readMoreBtn)): ?>
                                            <a class="d-7-posts-item__link" target="<?php if (!empty($linkTarget)): echo $linkTarget; else: ?>_self<?php endif; ?>" href="<?php echo $glAccLink; ?>" aria-label="<?php echo $readMoreBtn; ?>"><?php echo $readMoreBtn; ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif;
                        endwhile; ?>
                    </div>
                </div>
            <?php endif;
            if (have_rows($glAcc)): ?>
                <div id="carouselExampleIndicators" class="carousel slide d-7-posts d-block d-md-none" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php while(have_rows($glAcc)) :
                            the_row();
                            $glAccLink = get_sub_field('gl_acc_link');
                            $index++; ?>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $index; ?>" <?php if ($index == 0): ?>class="active" aria-current="true"<?php endif; ?> aria-label="<?php echo esc_html($glAccLink['title']); ?>"></button>
                        <?php endwhile; ?>
                    </div>
                    <div class="carousel-inner">
                        <?php while(have_rows($glAcc)) :
                            the_row();
                            $glAccTitle = get_sub_field('gl_acc_title');
                            $glAccLink = get_sub_field('gl_acc_link');
                            $glAccText = get_sub_field('gl_acc_text');
                            $glAccImg = get_sub_field('gl_acc_img');
                            $in++;
                            $linkTarget = $glAccLink['target'] ? $fypBtn['target'] : '_self';
                            if (!empty($glAccTitle) || !empty($glAccText) || !empty($glAccImg) || !empty($glAccText) || !empty($glAccLink)): ?>
                                <div class="carousel-item<?php if ($in == 0): ?> active<?php endif; ?>">
                                    <div class="col-md-<?php if (!empty($glblockRowNum)): echo $glblockRowNum; else: ?>3<?php endif; ?>">
                                        <div class="d-7-posts-item">
                                            <?php if (!empty($glAccTitle)): ?>
                                                <div class="<?php if (!empty($glAccTitleFc)): echo $glAccTitleFc.' '; else: ?>color-pro-balck <?php endif; ?>d-7-posts-item__cat"><?php echo $glAccTitle; ?></div>
                                            <?php endif;
                                            if (!empty($glAccImg)): ?>
                                                <a href="#" class="d-7-posts-item__img-wrapper">
                                                    <img class="d-7-posts-item__img" src="<?php echo esc_url($glAccImg['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($glAccImg['alt']); ?>">
                                                </a>
                                            <?php endif;
                                            if (!empty($glAccText)): ?>
                                                <h5 class="<?php if (!empty($glAccTextFs)): echo $glAccTextFs.' '; else: ?>h5 small <?php endif; ?><?php if (!empty($glAccTextFc)): echo $glAccTextFc.' '; else: ?>color-pro-black <?php endif; ?>d-7-posts-item__title"><?php echo $glAccText; ?></h5>
                                            <?php endif;
                                            if (!empty($glAccLink)): ?>
                                                <a class="d-7-posts-item__link" target="<?php echo esc_attr($linkTarget); ?>" href="<?php echo esc_url($glAccLink['url']); ?>" aria-label="<?php echo esc_html($glAccLink['title']); ?>"><?php echo $readMoreBtn; ?></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;
                        endwhile; ?>
                    </div>
                    <button class="carousel-control-prev carousel-control-nav" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon carousel-control-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next carousel-control-nav" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon carousel-control-icon" aria-hidden="true"></span>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>