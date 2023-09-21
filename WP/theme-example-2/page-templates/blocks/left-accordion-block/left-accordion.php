<?php 
$section_heading = (get_field('section_heading')) ? get_field('section_heading') : "";
$short_description = (get_field('short_description')) ? get_field('short_description') : "";
$background_color = (get_field('background_color')) ? get_field('background_color') : "";
$align_class = $block['align'] ? 'align' . $block['align'] : '';
?>

<section class="left-accordion custom-tabs main-left-accordion <?php echo $align_class; ?>" <?php if(!empty($background_color)) { ?> style="background-color:<?php echo $background_color;?>" <?php } ?>>
	<div class="container">
		<div class="tabs-heading">
			<?php if(!empty($section_heading)) { ?>
				<h2><?php echo $section_heading;?></h2>
			<?php } ?>
			<?php if(!empty($short_description)) { ?>
				<?php echo $short_description;?>
			<?php } ?>
		</div>
		
		<div class="accordion" id="accordionExample">
			<div class="accordion-row">
				<div class="left-accordion-link">
					<?php
        		// Check rows exists.
					if( have_rows('tab_repeator') ):
               	// Loop through rows.
						$k=1;
						while( have_rows('tab_repeator') ) : the_row();
							$heading = get_sub_field('heading');
							if(!empty($heading)){
								?>
								<h2 class="mb-0" id="heading-<?php echo $k; ?>">
									<button class="btn btn-link btn-block text-left <?php if( $k!=1 ) { echo "collapsed";} ?>" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $k; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $k; ?>">
										<?php echo $heading;?>
									</button>
								</h2>
							<?php } ?>
							<?php 
							$k++;
						endwhile;
            		// No value.
					else :
           			// Do something...
					endif;
					?>
				</div>
				<div class="right-accordion-content">
					<?php
        		// Check rows exists.
					if( have_rows('tab_repeator') ):
						$j=1;
						while( have_rows('tab_repeator') ) : the_row();
							$content = get_sub_field('content');
							$image = get_sub_field('image');
							$image_caption = get_sub_field('image_caption');
							$heading = get_sub_field('heading');
							if(!empty($heading)){
								?>
								<h2 class="mb-0 desktop-none" id="heading-<?php echo $j; ?>">
									<button class="btn btn-link btn-block text-left <?php if( $j!=1 ) { echo "collapsed";} ?> <?php if( $j==1 ) { echo "show";} ?>" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $j; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $j; ?>">
										<?php echo $heading;?>
									</button>
								</h2>
							<?php } ?>
							<div id="collapse-<?php echo $j; ?>" class="collapse <?php if( $j==1 ) { echo "show";} ?>" aria-labelledby="headingOne" data-parent="#accordionExample">
								<div class="custom-tabs-content">
									<?php if(!empty(get_sub_field('header_content'))){ ?>
										<div class="row">
											<div class="col-lg-12">
												<div class="full-width-text">
													<?php echo get_sub_field('header_content'); ?>
												</div>
											</div>
										</div>
									<?php } ?>
									<div class="row">
										<?php if (!empty($content)) { ?>
											<div class="col-lg-6 col-md-7 left-mobile-half-column">
												<div class="custom-tabs-left">
													<?php echo $content; ?>
												</div>
											</div>
										<?php } ?>
										<?php if(!empty($image_caption) || !empty($image) ){ ?>
											<div class="col-lg-6  col-md-5 d-flex flex-column justify-content-center right-mobile-half-column">
												<div class="custom-tabs-left">
													<?php if (!empty($image_caption)) { ?>
														<span> <?php echo $image_caption;?> </span>
													<?php } ?>
													<?php if (!empty($image)) { ?>
														<img src="<?php echo $image['url'];?>" alt="<?php echo $image['alt'];?>" />
													<?php } ?>
												</div>

											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<?php 
							$j++;
						endwhile;
            		// No value. 
					else :
           			// Do something...
					endif;
					?>
				</div>
			</div>
		</div>
			<?php
			$pol_cta_heading = get_field('pol_cta_heading');
			$pol_cta_link = get_field('pol_cta_link');

			if(!empty($pol_cta_heading) || !empty($pol_cta_link)) { ?>
				<div class="acc-cta">
					<?php if(!empty($pol_cta_heading)) { ?>
						<h3 class="banner-heading heading"><?php echo ($pol_cta_heading);?></h3>
					<?php } ?>
					<?php 
					$link = $pol_cta_link;
					if( !empty($link['title'])):
						$link_url = $link['url'];
						$link_title = $link['title'];
						$link_target = $link['target'] ? $link['target'] : '_self';
						?>
						<a class="default-btn bg-red" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" <?php if(!empty($button_background_color)) { ?> style="background-color:<?php echo $button_background_color;?>" <?php } ?>><?php echo esc_html( $link_title ); ?></a>
					<?php endif; ?>
				</div>
			<?php } ?>
		</div>
	</section> 