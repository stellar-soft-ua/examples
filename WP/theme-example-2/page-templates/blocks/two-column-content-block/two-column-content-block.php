<?php
/**
 * Block Name: Two Column Content Block
 * This is the template that displays the Two Column Content Block
 */
?>
<?php 
$pol_twc_rtl_heading = get_field('pol_twc_rtl_heading');
$pol_twc_rtl_subheading = get_field('pol_twc_rtl_subheading');
$pol_twc_rtl_description = get_field('pol_twc_rtl_description');
$pol_twc_rtl_cta = get_field('pol_twc_rtl_cta');
$pol_twc_lcl_heading = get_field('pol_twc_lcl_heading');
$pol_twc_lcl_top_description = get_field('pol_twc_lcl_top_description');
$pol_twc_lcl_btm_description = get_field('pol_twc_lcl_btm_description');
$align_class = $block['align'] ? 'align' . $block['align'] : '';
?>
<?php if(!empty($pol_twc_rtl_heading) || !empty($pol_twc_rtl_subheading) || !empty($pol_twc_rtl_description) || !empty($pol_twc_rtl_cta) || !empty($pol_twc_lcl_heading) || !empty($pol_twc_lcl_top_description) || !empty($pol_twc_lcl_btm_description)) { ?>
<section class="two-column-content-block <?php echo $align_class; ?>"> 
    <div class="container">
        <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="two-column-content-block-left">
                    <?php if(!empty($pol_twc_rtl_heading)) { ?>
                        <h2 class="heading"> <?php echo $pol_twc_rtl_heading;?></h2>    
                    <?php } ?>
                    <div class="two-column-content-block-left-inner">
                    <?php if(!empty($pol_twc_rtl_subheading)) { ?>
                        <h3 class="heading"> <?php echo $pol_twc_rtl_subheading;?></h3>    
                    <?php } ?>
                    <?php if(!empty($pol_twc_rtl_description)) { ?>
                        <p > <?php echo $pol_twc_rtl_description;?></hp>    
                    <?php } ?>
                    <?php 
                    $link = $pol_twc_rtl_cta;
                    if( $link ): 
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                        ?>
                        <a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                    <?php endif; ?>
                </div>
                </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="two-column-content-block-right">
                    <?php if(!empty($pol_twc_lcl_heading)) { ?>
                        <h2 class="heading"> <?php echo $pol_twc_lcl_heading;?></h2>    
                    <?php } ?>
                    <?php if(!empty($pol_twc_lcl_top_description)) { ?>
                        <p class="quote-para-one"> <?php echo $pol_twc_lcl_top_description;?></hp>    
                    <?php } ?>
                    <?php if(!empty($pol_twc_lcl_btm_description)) { ?>
                        <p class="quote-para-two"> <?php echo $pol_twc_lcl_btm_description;?></hp>    
                    <?php } ?>
                </div>
                </div>
            </div>
        </div>
</section>
<?php } ?>