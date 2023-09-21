<?php
   /**
    * Block Name: Cta With Icon  Block
    * 
    */
   ?>
<?php    
   $align_class = $block['align'] ? 'align' . $block['align'] : '';  
   ?>

<section class="cta-with-icon-block padding-half-top-bottom  command-center <?php echo $align_class; ?>" <?php if(!empty($pol_tcb_background_color)) { ?> style="background-color:<?php echo $pol_tcb_background_color;?>" <?php } ?>>
   <div class="container">
      <div class="row gy-4 text-center">
         <?php 
            // Check rows exists.
             if( have_rows('pol_tcb_image_block') ):
              while( have_rows('pol_tcb_image_block') ) : the_row();
                $pol_tcb_icon_image = get_sub_field('pol_tcb_icon_image');
                $cta_button = get_sub_field('cta_button');
            ?>
         <div class="col-lg-4 col-md-4 col-xs-4 p-0" >
            <div class="command-settings">
               <?php if (!empty($pol_tcb_icon_image)) { ?>
               <div class="circle-img mb-16">
                  <img src="<?php echo $pol_tcb_icon_image['url'];?>" class="img-fluid" alt="<?php echo $pol_tcb_icon_image['alt'];?>" />
               </div>
               <?php } ?>
               <div class="circle-info three-b ">
               <?php 
         $link = $cta_button;
         if( !empty($link['title'])):
           $link_url = $link['url'];
           $link_title = $link['title'];
           $link_target = $link['target'] ? $link['target'] : '_self';
           ?>
           <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="text-link"><?php echo esc_html( $link_title ); ?></a>
         <?php endif; ?>
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
   </div>
        </section>