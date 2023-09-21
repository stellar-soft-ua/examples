<?php /**
 * Block Name: Rd Experts Images Group Pattern Section
*
* This is the template that displays the Rd Experts Images Group Pattern Section
*/
// 1000+ topics fields
// Title fields
$topicTitle = get_field('topic_title');
$topicTitleFs = get_field('topic_title_fs');
$topicTitleFc = get_field('topic_title_fc');
// List fields
$topicRepeater = 'topic_repeater';
$topicTextFs = get_field('topic_text_fs');
$topicTextFc = get_field('topics_list_fc');
// Section fields
$topicbg = get_field('topic_bg');
$topicbgImg = get_field('topic_bg_img');
// Features overview fields
// Suptitle fields
$overviewSuptitle = get_field('overview_suptitle');
$overviewSuptitleFc = get_field('overview_suptitle_fc');
$overviewSuptitleFs = get_field('overview_suptitle_fs');
// Title fields
$overviewTitle = get_field('overview_title');
$overviewTitleFc = get_field('overview_title_fc');
$overviewTitleFs = get_field('overview_title_fs');
// Text fields
$overviewText = get_field('overview_text');
$overviewTextFc = get_field('overview_text_fc');
$overviewTextFs = get_field('overview_text_fs');
// Column fields
$overviewColRepeater = 'overview_repeater';
$overviewColTextFc = get_field('overview_col_text_fc');
$overviewColTextFs = get_field('overview_col_text_fs');
$overviewColTitleFc = get_field('overview_col_title_fc');
$overviewColTitleFs = get_field('overview_col_title_fs');
// Section fields
$overviewbgImg = get_field('overview_bg_img');
$overviewbgColor = get_field('overview_bg_color');
$overviewTheme = get_field('overview_theme');
$overviewBlockCol = get_field('overview_row');
?>
<section class="section-advanced d-3 features-section-d-3<?php if (!empty($overviewbgColor)): echo ' '.$overviewbgColor; else: ?> bg-transparent<?php endif; ?>"
    <?php if (!empty($overviewbgImg)):?>
        style="background-image: url('<?php echo esc_url($overviewbgImg['sizes']['full_hd']); ?>')"
    <?php endif; ?>>
    <?php if (!empty($topicTitle) || have_rows($topicRepeater)): ?>
        <section class="section-advanced d-2 features-section-d-2">
            <div class="container d-flex justify-content-center align-items-center">
                <div class="content<?php if (!empty($topicbg)): echo ' '.$topicbg; else: ?> bg-pro-white<?php endif; ?>"
                    <?php if (!empty($topicbgImg)):?>
                        style="background-image: url('<?php echo esc_url($topicbgImg['sizes']['full_hd']); ?>')"
                    <?php endif; ?>>
                    <?php if (!empty($topicTitle)): ?>
                        <div class="title-wrap">
                            <h2 class="<?php if (!empty($topicTitleFs)): echo $topicTitleFs.' '; else: ?>h4 <?php endif; if (!empty($topicTitleFc)): echo $topicTitleFc.' '; else: ?>color-pro-black <?php endif; ?>u-pro-red text-uppercase d-flex justify-content-center text-center mb-0"><?php echo $topicTitle; ?></h2>
                        </div>
                    <?php endif;
                    if (have_rows($topicRepeater)): ?>
                        <div class="text-block">
                            <ul class="ul-1000-topics">
                            <?php while(have_rows($topicRepeater)) :
                                the_row();
                                $topicText = get_sub_field('topic_li');
                                if (!empty($topicText)): ?>
                                    <li class="<?php if (!empty($topicTextFs)): echo $topicTextFs.' '; else: ?>default-topic <?php endif; if (!empty($topicTextFc)): echo $topicTextFc.' '; else: ?>color-pro-black<?php endif; ?>"><span><?php echo $topicText; ?></span></li>
                                <?php endif;
                            endwhile; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif;
    if (!empty($overviewTitle) || have_rows($overviewColRepeater) || !empty($overviewText) || !empty($overviewSuptitle)): ?>
        <div class="container d-3<?php if (!empty($overviewTheme)): echo ' '.$overviewTheme; else: ?> default-theme<?php endif; ?>">
            <div class="content">
                <?php if (!empty($overviewTitle) || !empty($overviewText) || !empty($overviewSuptitle)): ?>
                    <div class="title-wrap row">
                        <?php if(!empty($overviewSuptitle)): ?>
                            <h6 class="<?php if (!empty($overviewSuptitleFs)): echo $overviewSuptitleFs.' '; else: ?>h6 <?php endif; if (!empty($overviewSuptitleFc)): echo $overviewSuptitleFc.' '; else: ?>color-lt-blue <?php endif; ?>suptitle text-xl-center text-uppercase mb-0"><?php echo $overviewSuptitle; ?></h6>
                        <?php endif;
                        if(!empty($overviewTitle)): ?>
                        <h2 class="<?php if (!empty($overviewTitleFs)): echo $overviewTitleFs.' '; else: ?>h3 <?php endif; if (!empty($overviewTitleFc)): echo $overviewTitleFc.' '; else: ?>color-pro-white <?php endif; ?>u-pro-red text-xl-center text-uppercase mb-0"><?php echo $overviewTitle; ?></h2>
                            <?php endif;
                        if(!empty($overviewText)): ?>
                            <div class="<?php if (!empty($overviewTextFs)): echo $overviewTextFs.' '; else: ?>subtitle subtitle-secondary <?php endif; if (!empty($overviewTextFc)): echo $overviewTextFc.' '; else: ?>color-pro-white <?php endif; ?>text-xl-center custom-subtitle"><?php echo $overviewText; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif;
                if (have_rows($overviewColRepeater)): ?>
                    <div class="text-wrap row justify-content-xl-center">
                        <?php while(have_rows($overviewColRepeater)):
                            the_row(); 
                            $overviewColTitle = get_sub_field('overview_col_title');
                            $overviewColText = get_sub_field('overview_col_text');
                            if (!empty($overviewColTitle) || !empty($overviewColText)): ?>
                                <div class="info-col col-12 col-md-6 col-xl-<?php if (!empty($overviewBlockCol)): echo $overviewBlockCol; else:?>4<?php endif; ?>">
                                    <?php if (!empty($overviewColTitle)): ?>
                                        <div class="<?php if (!empty($overviewColTitleFs)): echo $overviewColTitleFs.' '; else: ?>h5 <?php endif; if (!empty($overviewColTitleFc)): echo $overviewColTitleFc.' '; else: ?>color-pro-white <?php endif; ?>u-pro-red text-uppercase"><?php echo $overviewColTitle; ?></div>
                                    <?php endif;
                                    if (!empty($overviewColText)): ?>
                                        <div class="<?php if (!empty($overviewColTextFs)): echo $overviewColTextFs.' '; else: ?>col-text <?php endif; if (!empty($overviewColTextFc)): echo $overviewColTextFc.' '; else: ?>color-pro-white<?php endif; ?>"><?php echo $overviewColText; ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endif;
                        endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</section>