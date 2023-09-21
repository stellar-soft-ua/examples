<?php
/**
 * Block Name: Hero Block
 *
 * This is the template that displays the Hero Block
 */
?>
<?php 
$heading = get_field('heading');
$description = get_field('description');
$cta_button = get_field('cta_button');
$hero_image = get_field('hero_image');
$hero_text_color = get_field('hero_text_color');
$right_column_color = get_field('right_column_color');
?>
<?php if(!empty($heading) || !empty($description) || !empty($cta_button) ||  !empty($hero_image) ||  !empty($hero_text_color) || !empty($right_column_color)) { ?>
	<section class="hero-banner" style="background-color:<?php echo $right_column_color;?>"> 
		<div class="container">
			<div class="row">
				
				<!--Image section code start-->
				<div class="col-lg-7 col-md-12 category-right-padding">   
					<div class="right-category-image">
						<?php if(!empty($hero_image)){ 
							$image_url = $hero_image['url'];
							$image_alt = $hero_image['title'];
							?>
							<img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
						<?php } else { ?>
							<img src="<?php echo get_stylesheet_directory_uri();?>/images/hero-default.png" alt="" />
						<?php } ?>
					</div>
				</div>
				<!--Image section code end-->
				<div class="col-lg-5 col-md-12 category-left-padding">
					<div class="left-category-contant">
						<!--This is the heading code start-->
						<?php if(!empty($heading)) { ?>
							<h1 class="left-hero-head" <?php if(!empty($hero_text_color)) { ?> style="color:<?php echo $hero_text_color;?>" <?php } ?>><?php echo $heading;?></h1>
						<?php } ?>
						<!--This is the heading code end-->

						<!--This is the description code start-->
						<?php if(!empty($description)) { ?>
							<p <?php if(!empty($hero_text_color)) { ?> style="color:<?php echo $hero_text_color;?>" <?php } ?>><?php echo $description;?></p>
						<?php } ?>
						<!--This is the description code end-->

						<!--This is the Button code start-->
						<?php 
						$link = $cta_button;
						if( !empty($link['title'])):
							$link_url = $link['url'];
							$link_title = $link['title'];
							$link_target = $link['target'] ? $link['target'] : '_self';
							?>
							<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="read-more"><?php echo esc_html( $link_title ); ?></a>
						<?php endif; ?>
						<!--This is the Button code end-->
					</div>
				</div>

			</div>
		</div>
	</section>
<?php  } ?>