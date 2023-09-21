<?php /**
 * Block Name: Rd Vertical Timeline Accordion
*
* This is the template that displays the Rd Vertical Timeline Accordion
*/
// Suptitle fields
$evoSuptitle = get_field('evo_suptitle');
$evoSuptitleFs = get_field('evo_suptitle_fs');
$evoSuptitleFc = get_field('evo_suptitle_fc');
// Title fields
$evoTitle = get_field('evo_title');
$evoTitleFc = get_field('evo_title_fc');
$evoTitleFs = get_field('evo_title_fs');
// Accordion fields
$evoAcc = 'evo_acc_repeater';
$evoAccTextFc = get_field('evo_acc_text_fc');
$evoAccDateFc = get_field('evo_acc_date_fc');
$evoAccQuoteColore = get_field('evo_acc_quote_color');
// Text fields
$evoTextDesk = get_field('evo_text_desk');
$evoTextFc = get_field('evo_text_fc');
$evoTextFs = get_field('evo_text_fs');
// Section fields
$evobgImg = get_field('evo_bg_img');
$evobgColor = get_field('evo_bg_color');

if (!empty($evoSuptitle) || !empty($evoTextDesk) || !empty($evoTitle) || have_rows($evoAcc)): ?>
    <section class="section-advanced d-3 about-pro-section-d-3<?php if (!empty($evobgColor)): echo ' '.$evobgColor; else: ?> bg-pro-white<?php endif; ?>"
        <?php if (!empty($evobgImg)):?>
            style="background-image: url('<?php echo esc_url($evobgImg['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
        <div class="container d-flex justify-content-center align-atems-center">
            <div class="content d-flex justify-content-xl-center align-items-xl-center flex-column">
                <?php if (!empty($evoSuptitle) || !empty($evoTextDesk) || !empty($evoTitle)): ?>
                    <div class="title-wrap">
                        <?php if (!empty($evoSuptitle)): ?>
                            <h6 class="<?php if (!empty($evoSuptitleFs)): echo $evoSuptitleFs.' '; else: ?>h6 <?php endif; if (!empty($evoSuptitleFc)): echo $evoSuptitleFc.' '; else: ?>color-pro-red <?php endif; ?> suptitle text-xl-center text-uppercase mb-0"><?php echo $evoSuptitle; ?></h6>
                        <?php endif;
                        if (!empty($evoTitle)): ?>
                            <h2 class="<?php if (!empty($evoTitleFs)): echo $evoTitleFs.' '; else: ?>h3 <?php endif; if (!empty($evoTitleFc)): echo $evoTitleFc.' '; else: ?>color-pro-black <?php endif; ?>text-xl-center text-uppercase mb-0"><?php echo $evoTitle; ?></h2>
                        <?php endif;
                        if (!empty($evoTextDesk)): ?>
                            <div class="<?php if (!empty($evoTextFs)): echo $evoTextFs.' '; else: ?>subtitle subtitle-secondary <?php endif; if (!empty($evoTextFc)): echo $evoTextFc.' '; else: ?>color-pro-black <?php endif; ?>subtitle-custom text-xl-center"><?php echo $evoTextDesk; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif;
                if (have_rows($evoAcc)): ?>
                    <div class="accordion-evo-wrap">
                        <?php while (have_rows($evoAcc)):
                            the_row();
                            $evoRepDate = get_sub_field('evo_rep_date');
                            $evoRepHeader = get_sub_field('evo_rep_header');
                            $evoRepText = get_sub_field('evo_rep_text');
                            $evoRepCheck = get_sub_field('evo_rep_check');
                            $evoRepImg = get_sub_field('evo_rep_img');
                            $evoRepQuoteTitle = get_sub_field('evo_rep_quote_title');
                            $evoRepQuote = get_sub_field('evo_rep_quote'); ?>
                            <div class="accordion-evo d-flex flex-column">
                                <?php if (!empty($evoRepDate) || !empty($evoRepHeader)): ?>
                                    <div class="accordion-evo-title-wrap d-flex flex-column flex-xl-row">
                                        <?php if (!empty($evoRepDate)): ?>
                                            <span class="<?php if (!empty($evoAccDateFc)): echo $evoAccDateFc.' '; else: ?>color-pro-black <?php endif; ?>accordion-evo-suptitle accordion-evo-title bold"><?php echo $evoRepDate; ?></span>
                                        <?php endif;
                                        if (!empty($evoRepHeader)): ?>
                                            <span class="<?php if (!empty($evoAccDateFc)): echo $evoAccDateFc.' '; else: ?>color-pro-black <?php endif; ?>accordion-evo-title d-flex justify-content-between align-items-end"><?php echo $evoRepHeader; ?><span class="cross-wrap cross-wrap-red"><?php get_template_part('page-templates/blocks/cross-block/cross'); ?></span></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif;
                                if (!empty($evoRepText) || !empty($evoRepImg) || !empty($evoRepQuote)): ?>
                                    <div class="accordion-evo-body d-flex flex-column flex-xl-row justify-content-xl-between">
                                        <?php if (!empty($evoRepText)): ?>
                                            <div class="<?php if (!empty($evoAccTextFc)): echo $evoAccTextFc.' '; else: ?>color-pro-black <?php endif; ?>accordion-evo-text-wrap"><?php echo $evoRepText; ?></div>
                                        <?php endif;
                                        if (!empty($evoRepCheck) && $evoRepCheck == 'quote'):
                                            if (!empty($evoRepQuote)): ?>
                                                <div class="accordion-evo-quote-wrap">
                                                    <blockquote class="<?php if (!empty($evobgImg)): ?>evo-section-bg <?php endif; if (!empty($evoAccQuoteColore)): echo $evoAccQuoteColore.' '; else: ?>quote-color-pro-red <?php endif; ?>accordion-evo-quote">
                                                        <?php if (!empty($evoRepQuoteTitle)): ?>
                                                            <span class="accordion-evo-quote-title title-small suptitle text-xl-center text-uppercase<?php if (!empty($evobgColor)): echo ' '.$evobgColor; else: ?> bg-pro-white<?php endif; ?>"><?php echo $evoRepQuoteTitle; ?></span>
                                                        <?php endif; ?>
                                                        <p class="<?php if (!empty($evoAccTextFc)): echo $evoAccTextFc.' '; else: ?>color-pro-black <?php endif; ?>paragraph accordion-evo-quote-text text-center"><?php echo $evoRepQuote; ?></p>
                                                        <img src="<?= get_stylesheet_directory_uri(); ?>/resources/assets/images/icon-quote.svg" alt="Quotes"/>
                                                    </blockquote>
                                                </div>
                                            <?php endif;
                                        elseif (!empty($evoRepCheck) && $evoRepCheck == 'img'):
                                            if (!empty($evoRepImg)): ?>
                                                <div class="accordion-evo-img-wrap">
                                                    <img src="<?php echo esc_url($evoRepImg['sizes']['full_hd']); ?>" alt="<?php echo esc_attr($evoRepImg['alt']); ?>"/>
                                                </div>
                                            <?php endif;
                                        endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
