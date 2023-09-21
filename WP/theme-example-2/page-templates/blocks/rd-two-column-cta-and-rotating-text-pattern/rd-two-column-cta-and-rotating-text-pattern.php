<?php /**
 * Block Name: Rd Two Column CTA & Rotating Text Pattern
*
* This is the template that displays the Rd Two Column CTA & Rotating Text Pattern
*/
// Suptitle fields
$prRotSubTitle = get_field('pr_rot_subtitle');
$prRotSubTitleFs = get_field('pr_rot_subtitle_fs');
// Title fields
$prRotTitle = get_field('pr_rot_title');
$prRotTitleFs = get_field('pr_rot_title_fs');
// Text fields
$prRotText = 'pr_rot_text';
// Section fields
$prRotBg = get_field('pr_rot_bg');
$prRotBgImg1 = get_field('pr_rot_bg_img_1');
$prRotBgImg2 = get_field('pr_rot_bg_img_2');
$arr = [];
$json;
// Rotating block fields
$prRotTextAnim = 'pr_rot_text_arr';
$prRotTextStatic = get_field('pr_rot_text_static');

if (!empty($prRotSubTitle) || !empty($prRotTitle) || have_rows($prRotText) || have_rows($prRotText)): ?>
    <section class="section-advanced d-3 pro-reporting-section-d-3 bg-transparent">
        <div class="container">
            <div class="content">
                <div class="newsroom-covers d-flex justify-content-center">
                    <div class="newsroom-covers-animate d-flex align-items-center justify-content-center<?php if (!empty($prRotBg)): echo ' '.$prRotBg; else: ?> bg-pro-lt-gray<?php endif; ?>"
                        <?php if (!empty($prRotBgImg1)):?>
                            style="background-image: url('<?php echo esc_url($prRotBgImg1['sizes']['full_hd']); ?>')"
                        <?php endif; ?>>
                        <?php if (!empty($prRotBgImg2)):?>
                            <img src="<?php echo esc_url($prRotBgImg2['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($prRotBgImg2['alt']); ?>"/>
                        <?php endif;
                        if (!empty($prRotTextStatic) || have_rows($prRotText)): ?>
                            <ul class="newsroom-covers-animate-wrap d-flex flex-column">
                                <?php if (!empty($prRotTextStatic)): ?>
                                    <li class="newsroom-covers-animate-el h2 text-uppercase"><?php echo $prRotTextStatic; ?></li>
                                <?php endif;
                                if (have_rows($prRotTextAnim)):
                                    while (have_rows($prRotTextAnim)):
                                        the_row();
                                        $rotatingAnimText = get_sub_field('rotating_anim_text');
                                        $arr[] = $rotatingAnimText;
                                        endwhile;
                                        $json = json_encode($arr); ?>
                                    <li class="newsroom-covers-animate-el h2 underline text-uppercase" id='ladder'></li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($prRotSubTitle) || !empty($prRotTitle) || !empty($prRotText)): ?>
                        <div class="newsroom-covers-static d-flex align-items-center justify-content-center">
                            <div class="newsroom-covers-static-wrap">
                                <?php if (!empty($prRotSubTitle) || !empty($prRotTitle)): ?>
                                    <div class="title-wrap">
                                        <?php if (!empty($prRotSubTitle)): ?>
                                            <h6 class="<?php if (!empty($prRotSubTitleFs)): echo $prRotSubTitleFs.' '; else: ?>h6 <?php endif; ?>color-pro-red suptitle text-uppercase mb-0"><?php echo $prRotSubTitle; ?></h6>
                                        <?php endif;
                                        if (!empty($prRotTitle)): ?>
                                            <h2 class="<?php if (!empty($prRotTitleFs)): echo $prRotTitleFs.' '; else: ?>h3 <?php endif; ?>text-uppercase u-pro-red color-pro-black mb-0 title-rotating-custom"><?php echo $prRotTitle; ?></h2>
                                        <?php endif; ?>
                                    </div>
                                <?php endif;
                                if (have_rows($prRotText)): ?>
                                    <div class="text-wrap">
                                        <?php while (have_rows($prRotText)):
                                            the_row();
                                            $prRepeaterText = get_sub_field('pr_repeater_text');
                                            if (!empty($prRepeaterText)): ?>
                                                <p class="paragraph color-pro-black"><?php echo $prRepeaterText; ?></p>
                                            <?php endif;
                                        endwhile; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <script>
        let rotatingJson = <?php print_r($json); ?>;
        console.log(rotatingJson);
    </script>
<?php endif; ?>