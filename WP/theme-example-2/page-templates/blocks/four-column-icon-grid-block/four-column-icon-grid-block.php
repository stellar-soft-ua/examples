<?php
/**
 * Block Name: Four Column Icon Grid Block
 * This is the template that displays the Four Column Icon Grid Block
 */
?>
<?php 
  $pol4_heading = get_field('pol4_heading');
  $pol4_cta_button = get_field('pol4_cta_button');
  $pol_fr_bg_color = get_field('pol_fr_bg_color');
  $align_class = $block['align'] ? 'align' . $block['align'] : '';
  
  $pol4_versions = get_field('pol4_versions');
  if (!empty($pol4_versions) && $pol4_versions == 'verison1') {
    $section_padding  = 'padding-full-top-bottom';
    $section_font     = 'section-small-font';
  }else{
    $section_padding = 'padding-half-top-bottom';
    $section_font     = 'section-large-font';
  }
?>
<?php if(!empty($pol4_heading) || !empty($pol4_cta_button)) { ?>
<section id="four-column-icon-grid-block" class="four-column-icon-grid-block <?php echo $section_padding.' '.$section_font.' '.$align_class; ?>" <?php if(!empty($pol_fr_bg_color)) { ?> style="background-color:<?php echo $pol_fr_bg_color;?>" <?php } ?>>
  <div class="container">
     <div class="command-center-header text-center p-0">
      <?php if(!empty($pol4_heading)) { ?>
        <h3 class="heading"><?php echo $pol4_heading;?></h3>    
      <?php } ?>
    </div>
    <div class="row gy-4 text-center">
       <?php 
      // Check rows exists.
       if( have_rows('pol4_image_block') ):
        while( have_rows('pol4_image_block') ) : the_row();
          $pol4_icon_image = get_sub_field('pol4_icon_image');
          $pol4_title = get_sub_field('pol4_title');
          $pol4_description = get_sub_field('pol4_description');
          ?>
          <div class="col-lg-3 col-md-6 col-sm-6 d-flex align-items-stretch"> 
            <div class="command-settings">
              <?php if (!empty($pol4_icon_image)) { ?>
              <div class="circle-img mb-16">
                <img src="<?php echo $pol4_icon_image['url'];?>" class="img-fluid" alt="<?php echo $pol4_icon_image['alt'];?>" width="130" height="130" />
              </div>
            <?php } ?>
              <div class="circle-info ">
                 <?php if(!empty($pol4_title)) { ?>
                   <span class="mb-16 inine-block"><?php echo $pol4_title;?> </span>
                 <?php } ?>
                 <?php if(!empty($pol4_description)) { ?>
                   <p>
                    <?php echo $pol4_description;?> 
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
    $link = $pol4_cta_button;
    if( !empty($link['title'])):
      $link_url = $link['url'];
      $link_title = $link['title'];
      $link_target = $link['target'] ? $link['target'] : '_self';
      ?>
      <div class="text-center">
         <a aria-label="<?php echo esc_html( $link_title ); ?>" href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="reporting-btn default-btn bg-blue" tabindex="-1"><?php echo esc_html( $link_title ); ?>
        </a>
     </div>
    <?php endif; ?>
  </div>
</section>
<?php  } ?>