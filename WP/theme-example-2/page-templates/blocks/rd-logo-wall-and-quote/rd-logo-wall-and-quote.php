<?php /**
 * Block Name: Rd Logo Wall & Quote
*
* This is the template that displays the Rd Logo Wall & Quote
*/
// Suptitle fields
$gsSuptitle = get_field('gs_suptitle');
$gsSuptitleFs = get_field('gs_suptitle_fs');
$gsSuptitleFc = get_field('gs_suptitle_fc');
// Title fields
$gsTitle = get_field('gs_title');
$gsTitleFs = get_field('gs_title_fs');
$gsTitleFc = get_field('gs_title_fc');
// Logo fields
$gslogo = 'gs_logo_repeater';
$gslogoC = get_field('gs_logo_c');
// Section fields
$gsBgImg = get_field('gs_bg_img');
$gsBgColor = get_field('gs_bg_color');
// quote legend field
$gsQuote = get_field('gs_quote');

if (have_rows($gslogo) || !empty($gsSuptitle) || empty($gsTitle)):?>
    <section class="section-advanced d-5-home bg-cover bg-pro-dk-blue<?php if (!empty($gsBgColor)): echo ' '.$gsBgColor; else: ?> bg-transparent<?php endif; ?>"
        <?php if (!empty($gsBgImg)):?>
            style="background-image: url('<?php echo esc_url($gsBgImg['sizes']['full_hd']); ?>')"
        <?php endif; ?>>
        <div class="container">
            <?php if (!empty($gsSuptitle)): ?>
                <div class="row">
                    <div class="col-12 text-center">
                        <h6 class="<?php if (!empty($gsSuptitleFs)): echo $gsSuptitleFs.' '; else: ?>h6 <?php endif; if (!empty($gsSuptitleFc)): echo $gsSuptitleFc.' '; else: ?>color-pro-lt-blue <?php endif; ?>suptitle text-uppercase letter-spacing-4-61"><?php echo $gsSuptitle; ?></h6>
                    </div>
                </div>
            <?php endif;
            if (have_rows($gslogo)): ?>
                <div class="d-5-home-logos">
                    <div class="row justify-content-between">
                        <?php while(have_rows($gslogo)) :
                            the_row();
                            $gslogoSIngle = get_sub_field('gs_logo');
                            $gslogoLink = get_sub_field('gs_logo_link');
                            $linkTarget = $gslogoLink['target'] ? $gslogoLink['target'] : '_self';
                            if (!empty($gslogoLink['url'])):
                                if (!empty($gslogoSIngle)): $img = $gslogoSIngle; ?>
                                    <div class="col-4 col-lg-auto">
                                        <a class="d-5-home-logos__item<?php if (!empty($gslogoC)): echo ' '.$gslogoC; else: ?> icon-pro-white<?php endif; ?>" target="<?php echo esc_attr($linkTarget); ?>" href="<?php echo esc_url($gslogoLink['url']); ?>" aria-label="<?php echo esc_html( $gslogoLink['title'] ); ?>">
                                            <?php
                                                $svg_markup = file_get_contents( get_attached_file( $img['ID'] ) );
                                                echo $svg_markup;
                                            ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php else:
                                if (!empty($gslogoSIngle)): $img = $gslogoSIngle; ?>
                                <div class="col-4 col-lg-auto">
                                    <div class="d-5-home-logos__item<?php if (!empty($gslogoC)): echo ' '.$gslogoC; else: ?> icon-pro-white<?php endif; ?>">
                                        <?php
                                            $svg_markup = file_get_contents( get_attached_file( $img['ID'] ) );
                                            echo $svg_markup;
                                        ?>
                                    </div>
                                </div>
                                <?php endif;
                            endif;
                        endwhile; ?>
                    </div>
                </div>
            <?php endif;
            if (!empty($gsTitle)): ?>
                <div class="d-5-home-quote text-center" <?php if (!empty($gsQuote)): ?>data-quote="<?php echo $gsQuote; endif; ?>">
                    <h3 class="<?php if (!empty($gsTitleFs)): echo $gsTitleFs.' '; else: ?>h3 small <?php endif; ?><?php if (!empty($gsTitleFc)): echo $gsTitleFc.' '; else: ?>color-pro-white <?php endif; ?>u-pro-red d-5-home-quote__title text-uppercase large"><?php echo $gsTitle; ?></h3>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>