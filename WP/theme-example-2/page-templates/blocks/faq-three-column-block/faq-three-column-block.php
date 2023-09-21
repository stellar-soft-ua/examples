<?php
/**
 * Block Name: Three Column Image  Block
 * 
 */
?>
<?php 
  $pol_tcb_heading = get_field('pol_tcb_heading');
  $pol_tcb_cta_button = get_field('pol_tcb_cta_button');
  $pol_tcb_background_color = get_field('pol_tcb_background_color');    
  
  $align_class = $block['align'] ? 'align' . $block['align'] : '';  
?>
<?php if(!empty($pol_tcb_heading) || !empty($pol_tcb_cta_button) || !empty($pol_tcb_background_color)) { ?>
<section class="faq-three-column-block padding-half-top-bottom <?php echo $align_class; ?>" <?php if(!empty($pol_tcb_background_color)) { ?> style="background-color:<?php echo $pol_tcb_background_color;?>" <?php } ?>>
  <div class="container">
     <div class="command-center-header text-center p-0">
      <?php if(!empty($pol_tcb_heading)) { ?>
        <h3 class="heading"> <?php echo $pol_tcb_heading;?></h3>
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
          $pol_tcb_description_more = get_sub_field('pol_tcb_description_more');
          ?>
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="command-settings">
              <?php if (!empty($pol_tcb_icon_image)) { ?>
              <div class="circle-img mb-16">
                <img src="<?php echo $pol_tcb_icon_image['url'];?>" class="img-fluid" alt="<?php echo $pol_tcb_icon_image['alt'];?>" />
              </div>
            <?php } ?>
              <div class="circle-info three-b">
                 <?php if(!empty($pol_tcb_title)) { ?>
                   <h4 class="mb-16 inine-block"><?php echo $pol_tcb_title;?> </h4>
                 <?php } ?>
                 <?php if(!empty($pol_tcb_description)) { ?>
                   <p>
                    <?php echo $pol_tcb_description;?> <span>
                      <?php
                    $link = $pol_tcb_description_more;
                    if( !empty($link['title'])):
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>
                      <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="learn" tabindex="-1"><?php echo esc_html( $link_title ); ?>
                      </a>
                      <?php endif; ?>
                    </span>
                  </p>
                <?php } ?>
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
      <div class="text-center seeFaqBtn">
         <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="reporting-btn default-btn bg-blue" tabindex="-1"><?php echo esc_html( $link_title ); ?>
        </a>
     </div>
    <?php endif; ?>
  </div>
</section>
<?php  } ?>