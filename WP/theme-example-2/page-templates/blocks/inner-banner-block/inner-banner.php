<?php
/**
 * Block Name: Inner Banner 
 *
 * This is the template that displays the Inner Banner Block
 */
?>
<?php
$pol_inr_banner_tagline = get_field('pol_inr_banner_tagline'); 
$pol_inr_banner_heading = get_field('pol_inr_banner_heading');
$pol_inr_banner_description = get_field('pol_inr_banner_description');
$pol_inr_banner_background_image = get_field('pol_inr_banner_background_image');
$align_class = $block['align'] ? 'align' . $block['align'] : '';
?>
<?php if(!empty($pol_inr_banner_heading) || !empty($pol_inr_banner_description) || !empty($pol_inr_banner_cta) ||  !empty($pol_inr_banner_background_image)) { ?>
	<section class="inner-banner padding-half-top-bottom <?php echo $align_class; ?>" style="<?php if (!empty($pol_inr_banner_background_image)) { ?>background-image: url('<?php echo $pol_inr_banner_background_image;?>');<?php }else{ ?>background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/blog-default.png');<?php } ?>"> 
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12 d-flex flex-column justify-content-center">
                    <?php if(!empty($pol_inr_banner_tagline)) { ?>
							<span class="tagline"><?php echo $pol_inr_banner_tagline;?></span>
						<?php } ?>
						<?php if(!empty($pol_inr_banner_heading)) { ?>
							<h1 class="heading"><?php echo $pol_inr_banner_heading;?></h1>
						<?php } ?>
						<?php if(!empty($pol_inr_banner_description)) { ?>
							<span class="text"><?php echo $pol_inr_banner_description;?></span>
						<?php } ?>
					</div>
				</div>
                </div>
     </section>
<?php  } ?>