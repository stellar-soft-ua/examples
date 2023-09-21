<?php /**
 * Block Name: Rd Cards Scroller
*
* This is the template that displays the Rd Cards Scroller
*/
// Title fields
$prPlanTitle = get_field('pr_plan_title');
$prPlanTitleFs = get_field('pr_plan_title_fs');
$prPlanTitleFc = get_field('pr_plan_title_fc');
// Text fields
$prPlanText = get_field('pr_plan_text');
$prPlanTextFs = get_field('pr_plan_text_fs');
$prPlanTextFc = get_field('pr_plan_text_fc');
// Plan fields
$prPlanRepeater = 'pr_plan_repeater';
$prPlanCardTextRepTop = 'pr_plan_card_text_top';
$prPlanCardTextRepBot = 'pr_plan_card_text_bottom';
$prPlanCardSecBg = get_field('pr_plan_card_sec_bg');
$prPlanCardLogo = get_field('pr_plan_card_logo');
// Section fields
$prPlanBgColor = get_field('pr_plan_bg_color');
$prPlanBgImg = get_field('pr_plan_bg_img');
$prPlanPremium = get_field('premium_plan_icon');

if (!empty($prPlanTitle) || !empty($prPlanText) || !empty($prPlanText) || have_rows($prPlanRepeater)): ?>
    <section class="section-advanced d-1 pro-plans-section-d-1<?php if (!empty($prPlanBgColor)): echo ' '.$prPlanBgColor; else: ?> bg-transparent<?php endif; ?>"
        <?php if (!empty($prPlanBgImg)):?>
            style="background-image: url('<?php echo esc_url($prPlanBgImg['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
        <div class="container  d-flex flex-column  align-items-center justify-content-center">
            <span class="cross-wrap cross-wrap-red"><?php get_template_part('page-templates/blocks/cross-block/cross'); ?></span>
            <span class="cross-wrap cross-wrap-red"><?php get_template_part('page-templates/blocks/cross-block/cross'); ?></span>
            <span class="cross-wrap cross-wrap-red"><?php get_template_part('page-templates/blocks/cross-block/cross'); ?></span>
            <span class="cross-wrap cross-wrap-red d-none d-xl-block"><?php get_template_part('page-templates/blocks/cross-block/cross'); ?></span>
            <span class="cross-wrap cross-wrap-red d-none d-xl-block"><?php get_template_part('page-templates/blocks/cross-block/cross'); ?></span>
            <span class="cross-wrap cross-wrap-red d-none d-xl-block"><?php get_template_part('page-templates/blocks/cross-block/cross'); ?></span>
            <?php if (!empty($prPlanTitle) || !empty($prPlanText)): ?>
                <div class="content d-flex flex-column  align-items-center justify-content-center">
                    <div class="title-wrap d-flex flex-column align-items-center justify-content-center">
                        <?php if (!empty($prPlanTitle)): ?>
                            <h1 class="<?php if (!empty($prPlanTitleFs)): echo $prPlanTitleFs.' '; else: ?>h1 <?php endif; if (!empty($prPlanTitleFc)): echo $prPlanTitleFc.' '; else: ?>color-pro-black <?php endif; ?>u-pro-red text-uppercase text-center mb-0"><?php echo $prPlanTitle; ?></h1>
                        <?php endif;
                        if (!empty($prPlanText)): ?>
                            <div class="<?php if (!empty($prPlanTextFs)): echo $prPlanTextFs.' '; else: ?>subtitle-large <?php endif; if (!empty($prPlanTextFc)): echo $prPlanTextFc.' '; else: ?>color-pro-black <?php endif; ?>text-center subtitle-custom"><?php echo $prPlanText; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="container-wrap d-flex flex-column  align-items-center justify-content-center w-100"
            <?php if (!empty($prPlanCardSecBg)):?>
                style="background-image: url('<?php echo esc_url($prPlanCardSecBg['sizes']['full_hd']); ?>')"
            <?php endif; ?>>
            <?php if (have_rows($prPlanRepeater)): ?>
                <div class="container d-flex flex-column  align-items-center justify-content-center">
                    <div class="content d-flex flex-column  align-items-center justify-content-center">
                        <div class="plans w-100">
                            <div class="plans-carousel d-xl-flex flex-xl-row  align-items-xl-stretch justify-content-xl-center" id="plans-carousel">
                                <?php while (have_rows($prPlanRepeater)):
                                    the_row();
                                    $prPlanCardSubtitle = get_sub_field('pr_plan_card_subtitle');
                                    $prPlanCardtitleTop = get_sub_field('pr_plan_card_title_top');
                                    $prPlanCardtitleBottom = get_sub_field('pr_plan_card_title_bottom');
                                    $prPlanCardLink = get_sub_field('pr_plan_card_link');
                                    $planType = get_sub_field('pr_plan_card_type');
                                    $prPlanLinkTarget = $prPlanCardLink['target'] ? $prPlanCardLink['target'] : '_self'; ?>
                                    <div class="carousel-cell">
                                        <div class="<?php if ($planType == 'premium'): ?>premium <?php endif; ?>bg-pro-white plans-card d-flex flex-column">
                                            <?php if (!empty($prPlanCardLogo) || !empty($prPlanCardSubtitle) || !empty($prPlanCardtitleTop) || have_rows($prPlanCardTextRepTop)): ?>
                                                <div class="plans-card-head d-flex flex-column">
                                                    <?php if (!empty($prPlanCardLogo)): ?>
                                                        <div class="plans-card-head-icon">
                                                            <img src="<?php echo esc_url($prPlanCardLogo['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($prPlanCardLogo['alt']); ?>"/>
                                                        </div>
                                                    <?php endif;
                                                    if (!empty($prPlanCardSubtitle)): ?>
                                                        <span class="color-pro-black plans-card-head-plan text-uppercase d-flex align-items-end">
                                                            <?php if (!empty($prPlanPremium)): ?>
                                                                <span class="plans-card-head-plan-icon">
                                                                    <img src="<?php echo esc_url($prPlanPremium['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($prPlanPremium['alt']); ?>">
                                                                </span>
                                                            <?php endif;
                                                            echo $prPlanCardSubtitle; ?>
                                                        </span>
                                                    <?php endif;
                                                    if (!empty($prPlanCardtitleTop) || have_rows($prPlanCardTextRepTop)): ?>
                                                        <div class="plans-card-head-text-block d-flex flex-column">
                                                            <?php if (!empty($prPlanCardtitleTop)): ?>
                                                                <span class="color-pro-black plans-card-head-title"><?php echo $prPlanCardtitleTop; ?></span>
                                                            <?php endif;
                                                            if (have_rows($prPlanCardTextRepTop)):
                                                                while (have_rows($prPlanCardTextRepTop)):
                                                                    the_row();
                                                                    $planTopText = get_sub_field('plan_top_text'); ?>
                                                                    <p class="color-pro-black plans-card-text plans-card-text-top mb-0"><?php echo $planTopText; ?></p>
                                                                <?php endwhile;
                                                            endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif;
                                            if (!empty($prPlanCardtitleBottom) || !empty($prPlanCardLink) || have_rows($prPlanCardTextRepBot)): ?>
                                                <div class="plans-card-body d-flex flex-column">
                                                    <?php if (!empty($prPlanCardtitleBottom)): ?>
                                                        <span class="color-pro-black plans-card-body-title"><?php echo $prPlanCardtitleBottom; ?></span>
                                                    <?php endif;
                                                    if (have_rows($prPlanCardTextRepBot)):
                                                        while (have_rows($prPlanCardTextRepBot)):
                                                            the_row();
                                                            $planBotText = get_sub_field('plan_bot_text'); ?>
                                                            <p class="color-pro-black paragraph plans-card-text"><?php echo $planBotText; ?></p>
                                                        <?php endwhile;
                                                    endif;
                                                    if (!empty($prPlanCardLink)): ?>
                                                        <p class="paragraph plans-card-text">
                                                            <a href="<?php echo esc_url($prPlanCardLink['url']); ?>" target="<?php echo esc_attr($prPlanLinkTarget); ?>" aria-label="<?php echo esc_html($prPlanCardLink['title']); ?>" class="btn btn-link"><?php echo esc_html($prPlanCardLink['title']); ?></a>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>