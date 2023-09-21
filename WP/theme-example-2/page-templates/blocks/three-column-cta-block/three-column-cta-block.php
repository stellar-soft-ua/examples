<?php
/**
 * Block Name: Three Column CTA Block
 * This is the template that displays the Three Column CTA Block
 */
?>
<?php 
$three_cta_heading = get_field('three_cta_heading');
$three_cta_subheading = get_field('three_cta_subheading');
$three_cta_section_background_color = get_field('three_cta_section_background_color');
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$three_cta_select_grid_layout = get_field('three_cta_select_grid_layout');
if(!empty($three_cta_select_grid_layout) && $three_cta_select_grid_layout == 'Four Grid Block'){
  $customclass = 'col-lg-3 col-md-12';
}elseif(!empty($three_cta_select_grid_layout) && $three_cta_select_grid_layout == 'Three Grid Block'){
  $customclass = 'col-lg-4 col-md-4';
}else{
  $customclass = 'col-lg-6 col-md-12';
}
?>
<?php if(!empty($three_cta_heading) || !empty($three_cta_subheading)) { ?>
  <section class="three-column-cta-block padding-full-top-bottom <?php echo $align_class; ?>" <?php if(!empty($three_cta_section_background_color)) { ?> style="background-color:<?php echo $three_cta_section_background_color;?>" <?php } ?>>
    <div class="container">
      <?php if(!empty($three_cta_heading)) { ?>
        <h2 class="heading"> <?php echo $three_cta_heading;?></h2>    
      <?php } ?>
      <div class="explore_dis">
        <?php if(!empty($three_cta_subheading)) { ?>
          <?php echo $three_cta_subheading;?>    
        <?php } ?>
      </div>
      <div class="row text-center">
       <?php 
      // Check rows exists.
       if( have_rows('three_cta_grid_block') ):
        while( have_rows('three_cta_grid_block') ) : the_row();
          $three_cta_image = get_sub_field('three_cta_image');
          $three_cta_title = get_sub_field('three_cta_title');
          $three_cta_content = get_sub_field('three_cta_content');
          $three_cta_enable_overlay = get_sub_field('three_cta_enable_overlay');
          $three_cta_link_selection = get_sub_field('three_cta_link_selection');
          if(!empty($three_cta_link_selection) && $three_cta_link_selection == "pdflink"){
            $CTALINK = get_sub_field('three_cta_explore_pdf_link');
            $link = $CTALINK;
            $link_url = $link;
            $link_title = "Explore";
            $link_target = '_blank';
          }elseif(!empty($three_cta_link_selection) && $three_cta_link_selection == "pagelink"){
            $CTALINK = get_sub_field('three_cta_explore_cta');
            $link = $CTALINK;
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
          }else{
            $link_title = '*coming soon*';
          }

          $three_cta_select_grid_button_color =  get_sub_field('three_cta_select_grid_button_color');
          if($three_cta_select_grid_button_color=='Red'){
            $class='bg-red'; 
          }
          else{
            $class='bg-blue';
          }
          ?>
          <div class="<?php echo $customclass; ?>"> 
            <div class="explore_grid_inner_box">
              <?php if (!empty($three_cta_image)) { ?>




                <div class="grid_img">
                   <?php 
               $link = $CTALINK;
               if( !empty($link)){  
                ?>
                 <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="reporting-btn" tabindex="-1">
                  <img src="<?php echo $three_cta_image['url'];?>" class="img-fluid" alt="<?php echo $three_cta_image['alt'];?>" /></a>
                  <?php }else{ ?>
                      <img src="<?php echo $three_cta_image['url'];?>" class="img-fluid" alt="<?php echo $three_cta_image['alt'];?>" />
                    <?php  } ?>
                  <?php if(!empty($three_cta_title)) { ?>
                   <span class="grid_title"><?php echo $three_cta_title;?> </span>
                 <?php } ?>
                 <?php if(!empty($enable_overlay)){ ?><div class="overlay"></div><?php } ?>
               </div>

             

          
         <?php } ?>
         <div class="circle-info">
           <?php if(!empty($three_cta_content)) { ?>
             <p><?php echo $three_cta_content;?> </p>
           <?php } ?>
         </div>
         <?php 
         $link = $CTALINK;
         if( !empty($link)){  
          ?>
          <div class="text-center btn-bx">
           <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="reporting-btn default-btn <?php echo $class;?>" tabindex="-1"><?php echo esc_html( $link_title ); ?></a>
         </div>
       <?php } else {?> 
        <div class="text-center btn-bx">
          <span style="color:#dc0228"><span style="font-size:18px"><strong><?php echo esc_html( $link_title ); ?></strong></span></span>
        </div>
      <?php } ?>
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