<?php
/**
 * Block Name: Three Column Image  Block
 * 
 */

$pol_tcb_heading = get_field('pol_tcb_heading');
$pol_tcb_cta_button = get_field('pol_tcb_cta_button');
$pol_tcb_background_color = get_field('pol_tcb_background_color');    

$align_class = $block['align'] ? 'align' . $block['align'] : '';  

if(!empty($pol_tcb_heading) || !empty($pol_tcb_cta_button) || !empty($pol_tcb_background_color)) { 

?>
<section class="three-column-image-block padding-full-top-bottom  command-center <?php echo $align_class; ?>" <?php if(!empty($pol_tcb_background_color)) { ?> style="background-color:<?php echo $pol_tcb_background_color;?>" <?php } ?>>
   <div class="container">
      <div class="command-center-header text-center p-0">
         <?php if(!empty($pol_tcb_heading)) { ?>
         <h2 class="heading"> <?php echo $pol_tcb_heading;?></h2>
         <?php } ?>
      </div>
      <div class="row gy-4 text-center">
         <?php 
            // Check rows exists.
             if( have_rows('pol_tcb_image_block') ):
              while( have_rows('pol_tcb_image_block') ) : the_row();
                $pol_tcb_icon_image = get_sub_field('pol_tcb_icon_image');
                $pol_tcb_title = get_sub_field('pol_tcb_title');
                $pol_tcb_description = get_sub_field('pol_tcb_description');
            ?>
         <div class="col-lg-4 col-md-6 col-xs-4 p-0" >
            <div class="command-settings">
               <?php if (!empty($pol_tcb_icon_image)) { ?>
               <div class="circle-img mb-16">
                  <img src="<?php echo $pol_tcb_icon_image['url'];?>" class="img-fluid" alt="<?php echo $pol_tcb_icon_image['alt'];?>" />
               </div>
               <?php } ?>
               <div class="circle-info three-b ">
                  <?php if(!empty($pol_tcb_title)) { ?>
                  <h4 class="mb-16 inine-block"><?php echo $pol_tcb_title;?> </h4>
                  <?php } ?>
                  <?php if(!empty($pol_tcb_description)) { ?>
                    <?php echo $pol_tcb_description;?>
                  <?php } ?>
                  <?php 
                     $pol_tcb_cta_button_type = get_sub_field('pol_tcb_cta_button_type');
                     $type = $pol_tcb_cta_button_type['type'];
                     
                     $link = $pol_tcb_cta_button_type['pol_th_cta_button'];
                     if( !empty($link['title'])):
                       $link_url = $link['url'];
                       $link_title = $link['title'];
                       $link_target = $link['target'] ? $link['target'] : '_self';
                     
                     if(!empty($type==1)) { 
                     ?> 
                  <p>
                     <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="default-btn bg-blue" tabindex="-1"><?php echo esc_html( $link_title ); ?></a>
                  </p>
                  <?php } else { ?>
                  <p>
                     <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?>  class="text-link" tabindex="-1"><?php echo esc_html( $link_title ) . " >>"; ?></a>
                  </p>
                  <?php } endif; ?>
               </div>
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
      <?php 
         $link = $pol_tcb_cta_button;
         if( !empty($link['title'])):
           $link_url = $link['url'];
           $link_title = $link['title'];
           $link_target = $link['target'] ? $link['target'] : '_self';
      ?>
      <div class="text-center">
         <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="reporting-btn default-btn bg-blue" tabindex="-1"><?php echo esc_html( $link_title ); ?>
         </a>
      </div>
      <?php endif; ?>
   </div>
</section>
<?php  } ?>