<?php
/**
 * Block Name: Explore Grid block
 * This is the template that displays the Explore Grid Block
 */
?>
<?php 
  $pol_heading = get_field('pol_heading');
  $pol_subheading = get_field('pol_subheading');
  $pol_section_background_color = get_field('pol_section_background_color');
  $pol_section_id = get_field('pol_section_id');
  $align_class = $block['align'] ? 'align' . $block['align'] : '';
  $pol_select_grid_layout = get_field('pol_select_grid_layout');
  if(!empty($pol_select_grid_layout) && $pol_select_grid_layout == 'Four Grid Block'){
    $customclass = 'col-lg-3 col-md-12';
  }elseif(!empty($pol_select_grid_layout) && $pol_select_grid_layout == 'Three Grid Block'){
    $customclass = 'col-lg-4 col-md-12';
  }else{
    $customclass = 'col-lg-6 col-md-12';
  }
  $alignment_center = get_field('alignment_center');
  if($alignment_center){
    $sectionclass = 'text-center';
    $rowclass = 'justify-content-center';
  }
  else{
    $sectionclass = '';
    $rowclass = '';
  }
?>
<?php if(!empty($pol_heading) || !empty($pol_subheading)) { ?>
<section <?php if (!empty($pol_section_id)) { ?> id="<?php echo $pol_section_id;?>" <?php } ?> class="explore-grid-block padding-full-top-bottom <?php echo $sectionclass; ?> <?php echo $align_class; ?>" <?php if(!empty($pol_section_background_color)) { ?> style="background-color:<?php echo $pol_section_background_color;?>" <?php } ?>>
  <div class="container">
    <?php if(!empty($pol_heading)) { ?>
        <h2 class="heading"> <?php echo $pol_heading;?></h2>    
      <?php } ?>
    <div class="explore_dis">
      <?php if(!empty($pol_subheading)) { ?>
        <?php echo $pol_subheading;?>    
      <?php } ?>
    </div>
    <div class="row text-center <?php echo $rowclass; ?>">
       <?php 
      // Check rows exists.
       if( have_rows('pol_grid_block') ):
        while( have_rows('pol_grid_block') ) : the_row();
          $pol_image = get_sub_field('pol_image');
          $pol_title = get_sub_field('pol_title');
          $pol_content = get_sub_field('pol_content');
          
          $enable_overlay = get_sub_field('enable_overlay');
          $link_selection = get_sub_field('link_selection');
          if(!empty($link_selection) && $link_selection == "pdflink"){
            $CTALINK = get_sub_field('explore_pdf_link');
            $link = $CTALINK;
            $link_url = $link;
            $link_title = "Download";
            $link_target = '_blank';
          }elseif(!empty($link_selection) && $link_selection == "pagelink"){
            $CTALINK = get_sub_field('pol_explore_cta');
            $link = $CTALINK;
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
          }else{
            $link_title = '*coming soon*';
          }

          $pol_select_grid_button_color =  get_sub_field('pol_select_grid_button_color');
          if($pol_select_grid_button_color=='Red'){
            $class='bg-red'; 
          }
          else{
            $class='bg-blue';
          }
      ?>
          <div class="<?php echo $customclass; ?>"> 
            <div class="explore_grid_inner_box">
                <?php if (!empty($pol_image)) { ?>
                  <div class="grid_img">
                    <img src="<?php echo $pol_image['url'];?>" class="img-fluid" alt="<?php echo $pol_image['alt'];?>" />
                    <?php if(!empty($pol_title)) { ?>
                     <span class="grid_title"><?php echo $pol_title;?> </span>
                   <?php } ?>
                    <?php if(!empty($enable_overlay)){ ?><div class="overlay"></div><?php } ?>
                  </div>
                <?php } ?>
                <?php if(!empty($pol_content)) { ?>
                  <div class="circle-info">
                    <p><?php echo $pol_content;?> </p>
                  </div>
                <?php } ?>
                <?php 
                  $link = $CTALINK;
                  if( !empty($link)){ 
                    if (!empty($link_selection != "nolink")) {
                ?>
                  <div class="text-center btn-bx">
                   <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="reporting-btn default-btn <?php echo $class;?>" tabindex="-1"><?php echo esc_html( $link_title ); ?></a>
                  </div>
                <?php } else {?> 
                  <div class="text-center btn-bx">
                    <span style="color:#dc0228"><span style="font-size:18px"><strong><?php echo esc_html( $link_title ); ?></strong></span></span>
                  </div>
                <?php } } ?>
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
<?php } ?>