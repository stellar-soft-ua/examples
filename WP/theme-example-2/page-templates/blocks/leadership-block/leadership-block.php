<?php
/**
 * Block Name: Leadership Block 
 *
 * This is the template that displays the Leadership Block
 */
?>
<?php 
$pol_section_heading = get_field('pol_section_heading');
$pol_short_description = get_field('pol_short_description');
$align_class = $block['align'] ? 'align' . $block['align'] : '';  
?>
<?php if(!empty($pol_section_heading) || !empty($pol_short_description)) { ?>
  <section class="leadership-block padding-full-top-bottom <?php echo $align_class; ?>" >
    <div class="container">
      <div class="text-center">
        <?php if(!empty($pol_section_heading)) { ?>
          <h2 ><?php echo $pol_section_heading;?></h2>
        <?php } ?>
        <?php if(!empty($pol_short_description)) { ?>
        <p> <?php echo $pol_short_description;?></p>
       <?php } ?>
      </div>
     <div class="row gy-4 text-center">
       <?php 
        // Check rows exists.
       if( have_rows('pol_leadership_grid') ):
        while( have_rows('pol_leadership_grid') ) : the_row();
          $pol_image = get_sub_field('pol_image');
          $pol_name = get_sub_field('pol_name');
          $pol_position = get_sub_field('pol_position');
          ?>
          <div class="col-lg-4 leadership-wrapper">
            <div class="leadership-box">
              <?php if (!empty($pol_image)) { ?>
                <div class="leadership-img">
                  <img src="<?php echo $pol_image['url'];?>" class="img-fluid" alt="<?php echo $pol_image['alt'];?>" />
                </div>
              <?php } ?>
              <div class="leadership-name">
                 <?php if(!empty($pol_name)) { ?>
                  <h5 class=""><?php echo $pol_name;?> </h5>
                <?php } ?>
                <?php if(!empty($pol_position)) { ?>
                  <p><?php echo $pol_position;?> </p>
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
        <div class="text-center">
         <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="reporting-btn default-btn bg-blue" tabindex="-1"><?php echo esc_html( $link_title ); ?>
       </a>
      </div>
      <?php endif; ?>
  </div>
</section>
<?php } ?>