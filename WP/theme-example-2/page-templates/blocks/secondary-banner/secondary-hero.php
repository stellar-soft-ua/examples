<?php
/**
 * Block Name: Secondary Banner 
 *
 * This is the template that displays the Secondary Banner Block
 */
?>
<?php 
$pol_sec_banner_heading = get_field('pol_sec_banner_heading');
$pol_sec_banner_description = get_field('pol_sec_banner_description');
$pol_sec_banner_cta = get_field('pol_sec_banner_cta');
$pol_sec_banner_image = get_field('pol_sec_banner_image');
$pol_sec_banner_background_color = get_field('pol_sec_banner_background_color');
$sec_select_button_color = get_field('sec_select_button_color');

/* define top bottom padding*/
$pol4_versions = get_field('pol4_versions');
if (!empty($pol4_versions) && $pol4_versions == 'verison3') {
  $section_padding  = 'padding-half-full-top-bottom';
}elseif (!empty($pol4_versions) && $pol4_versions == 'verison2') {
  $section_padding  = 'padding-full-top-bottom';
}else{
  $section_padding = 'padding-half-top-bottom';
}

/* Define button color */
if(!empty($sec_select_button_color) && $sec_select_button_color == 'Blue'){
  $btnclass = 'bg-blue';
}else{
	$btnclass = 'bg-red';
}

/* Define block alignment */
$align_class = $block['align'] ? 'align' . $block['align'] : '';
?>
<?php if(!empty($pol_sec_banner_heading) || !empty($pol_sec_banner_description) || !empty($pol_sec_banner_cta) ||  !empty($pol_sec_banner_image) ||  !empty($pol_sec_banner_background_color)) { ?>
	<section class="secondary-block <?php echo $section_padding.' '.$align_class; ?>" style="background-color:<?php echo $pol_sec_banner_background_color;?>">
            <div class="container"> 
                <div class="row">
                    <div class="col-lg-6  d-flex flex-column justify-content-center">
						<?php if(!empty($pol_sec_banner_heading)) { ?>
							<h1 class="heading"><?php echo $pol_sec_banner_heading;?></h1>
						<?php } ?>
						<?php if(!empty($pol_sec_banner_description)) { ?>
							<p class="text"><?php echo $pol_sec_banner_description;?></p>
						<?php } ?>
								
							<div class="sec-ban-button">
							<?php
							$link = $pol_sec_banner_cta;
							if( !empty($link['title'])):
							$link_url = $link['url'];
							$link_title = $link['title'];
							$link_target = $link['target'] ? $link['target'] : '_self';
							?>
							<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="default-btn <?php echo $btnclass; ?>"><?php echo esc_html( $link_title ); ?></a>
							<?php endif; ?>
							</div>	
					</div>
					<div class="col-lg-6 secondary-block-right" data-aos="fade-left" data-aos-duration="1000">
						<?php if(!empty($pol_sec_banner_image)) { ?>
							<img src="<?php echo $pol_sec_banner_image['url'];?>" class="img-fluid" alt="<?php echo $pol_sec_banner_image['alt'];?>" />
						<?php } ?>
					</div>
				</div>
                </div>
     </section>
<?php  } ?>
