<?php
/**
 * Block Name: Two Column Request Grid Block 
 * This is the template that displays the Two Column Request Grid Block
 */
?>
<?php 
$pol_heading = get_field('pol_heading');
$pol_subheading = get_field('pol_subheading');
$pol_section_background_color = get_field('pol_section_background_color');
$align_class = $block['align'] ? 'align' . $block['align'] : '';
?>

<section class="two-column-request-grid padding-full-top-bottom <?php echo $align_class; ?>" <?php if(!empty($pol_section_background_color)) { ?> style="background-color:<?php echo $pol_section_background_color;?>" <?php } ?>>
  <div class="container">
    <div class="request_grid_top">
      <?php if(!empty($pol_heading)) { ?>
        <h2 class="heading"> <?php echo $pol_heading;?></h2>    
      <?php } ?>
      <p>
      <?php if(!empty($pol_subheading)) { ?>
        <?php echo $pol_subheading;?>    
      <?php } ?>
    </p>
    </div>
    <div class="row text-center d-flex justify-content-center">
       <?php 
      // Check rows exists.
       if( have_rows('pol_grid_block') ):
        while( have_rows('pol_grid_block') ) : the_row();
          $pol_image = get_sub_field('pol_image');
          $pol_title = get_sub_field('pol_title');
          $pol_explore_cta = get_sub_field('pol_explore_cta');
          $image_size = get_sub_field('image_size');
          if($image_size=='Medium'){
            $class='medium-img'; 
          }
          else{
            $class='small-img';
          }
          ?>
          <div class="col-lg-4 col-md-12 col-sm-4">  
            <div class="request_box">
              <?php if (!empty($pol_image)) { ?>
                <div class="request_box_icon <?php echo $class; ?>">
                  <img src="<?php echo $pol_image['url'];?>" class="img-fluid " alt="<?php echo $pol_image['alt'];?>" />
                </div>
              <?php } ?>
              <div class="request_box_title">
               <?php if(!empty($pol_title)) { ?>
                 <span><?php echo $pol_title;?> </span>
               <?php } ?>
              </div>
               <?php 
               $link = $pol_explore_cta;
               if( !empty($link['title'])):
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <div class="request_box_button">
                  <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="reporting-btn default-btn bg-blue" tabindex="-1"><?php echo esc_html( $link_title ); ?></a>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <?php 
         endwhile;
        // No value.
       else :
        // Do something...
       endif;
     ?>
    </div>
  </div>
</section>
