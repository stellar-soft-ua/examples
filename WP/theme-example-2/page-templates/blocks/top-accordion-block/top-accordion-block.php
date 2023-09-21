<?php 
$pol_top_acc_heading = (get_field('pol_top_acc_heading')) ? get_field('pol_top_acc_heading') : "";
$pol_top_acc_description = (get_field('pol_top_acc_description')) ? get_field('pol_top_acc_description') : "";
$pol_top_acc_background_color = (get_field('background_color')) ? get_field('pol_top_acc_background_color') : "";
$section_color =  get_field('section_color');
if($section_color=='Grey'){
  $class='grey-custom-tabs'; 
}
else{
  $class='blue-custom-tabs'; 
}
$pol_top_acc_cta_heading = (get_field('pol_top_acc_cta_heading')) ? get_field('pol_top_acc_cta_heading') : "";
$pol_top_acc_cta_button = (get_field('pol_top_acc_cta_button')) ? get_field('pol_top_acc_cta_button') : "";

$align_class = $block['align'] ? 'align' . $block['align'] : '';
?>
<?php if(!empty($pol_top_acc_heading) || !empty($pol_top_acc_description)) { ?>
   <section class="top-accordion-block padding-full-top-bottom custom-tabs <?php echo $class; ?> <?php echo $align_class; ?>" <?php if(!empty($pol_top_acc_background_color)) { ?> style="background-color:<?php echo $pol_top_acc_background_color;?>" <?php } ?>>
      <div class="container">
         <div class="tabs-heading">
            <?php if(!empty($pol_top_acc_heading)) { ?>
               <h2><?php echo $pol_top_acc_heading;?></h2>
            <?php } ?>
            <?php if(!empty($pol_top_acc_description)) { ?>
               <p><?php echo $pol_top_acc_description;?></p>
            <?php } ?>
         </div>
         <div class="accordion" id="accordionExample">
         <div class="top-accordion-block-top main-top-accordion">
            <?php
               // Check rows exists.
               if( have_rows('accordian_itmes') ):
               // Loop through rows.
               $k=1;
               while( have_rows('accordian_itmes') ) : the_row();
                 $accordian_itmes_title = get_sub_field('accordian_itmes_title');
                 $accordian_itmes_sub_title = get_sub_field('accordian_itmes_sub_title');
                 if(!empty($accordian_itmes_title) || !empty($accordian_itmes_sub_title)){ ?>
                     <h2 id="step-<?php echo $k; ?>"> 
                        <button class="btn btn-link btn-block text-left <?php if( $k!=1 ) { echo "collapsed";} ?>" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $k; ?>" aria-expanded="true" aria-controls="collapseOne">
                           <?php if (!empty($accordian_itmes_title)) { ?>
                           <strong><?php echo $accordian_itmes_title;?></strong>
                        <?php } ?>
                          <?php if (!empty($accordian_itmes_sub_title)) { ?>
                           <span><?php echo $accordian_itmes_sub_title; ?></span>
                        <?php } ?>
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
         <div class="top-accordion-block-bottom">
              <?php
                  // Check rows exists.
                 if( have_rows('accordian_itmes') ):
                  $j=1;
                  while( have_rows('accordian_itmes') ) : the_row();
                     $accordian_content_title = get_sub_field('accordian_content_title');
                     $accordian_itmes_description = get_sub_field('accordian_itmes_description');
                     $accordian_itmes_editor = get_sub_field('accordian_itmes_editor');
                     $accordian_itmes_image = get_sub_field('accordian_itmes_image');
                     $accordian_itmes_title = get_sub_field('accordian_itmes_title');
                     $accordian_itmes_sub_title = get_sub_field('accordian_itmes_sub_title');
                     $accordian_item_layout = get_sub_field('accordian_item_layout');
                     if($accordian_item_layout=='Right Content Left Image'){
                        $lclass='right-content-left-image'; 
                     }
                     else{
                        $lclass='left-content-right-image'; 
                     }
                  ?>
                  <h2 id="step-<?php echo $j; ?>" class="desktop-none"> 
                     <button class="btn btn-link btn-block text-left <?php if( $j!=1 ) { echo "collapsed";} ?>" type="button" data-toggle="collapse" data-target="#collapse-<?php echo $j; ?>" aria-expanded="true" aria-controls="collapseOne">
                        <?php if (!empty($accordian_itmes_title)) { ?>
                           <strong><?php echo $accordian_itmes_title;?></strong>
                        <?php } ?>
                        <?php if (!empty($accordian_itmes_sub_title)) { ?>
                           <span><?php echo $accordian_itmes_sub_title; ?></span>
                        <?php } ?>
                     </button>
                  </h2>
                     <div id="collapse-<?php echo $j;?>" class="collapse <?php if( $j==1 ) { echo "show";} ?>" aria-labelledby="stepOne" data-parent="#accordionExample">
                        <div class="custom-tabs-content">
                            <?php if (!empty($accordian_content_title)) { ?>
                           <h2> <?php echo $accordian_content_title; ?></h2>
                        <?php } ?>
                        <?php if (!empty($accordian_itmes_description)) { ?>
                           <p class="tab_content"><?php echo $accordian_itmes_description; ?></p>
                        <?php } ?>
                           <div class="row <?php echo $lclass; ?>">
                              <?php if (!empty($accordian_itmes_editor)) { ?>
                              <div class="col-lg-8 col-md-8 mobile-half-column">
                                 <div class="custom-tabs-left">
                                    <?php echo $accordian_itmes_editor; ?>
                                 </div>
                              </div>
                           <?php } ?>
                           <?php if (!empty($accordian_itmes_image)) { ?>
                              <div class="col-lg-4 col-md-4 mobile-half-column">
                                 <div class="custom-tabs-left">
                                    <img src="<?php echo $accordian_itmes_image['url'];?>" alt="<?php echo $accordian_itmes_image['alt'];?>" />
                                    </div>
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                     <?php 
                  $j++;
               endwhile;
            endif;
            ?>
         </div>
      </div>
      <?php if(!empty($pol_top_acc_cta_heading) || !empty($pol_top_acc_cta_button)) { ?>
         <div class="acc-cta">
            <?php if(!empty($pol_top_acc_cta_heading)) { ?>
               <h3 class="banner-heading heading"><?php echo ($pol_top_acc_cta_heading);?></h3>
            <?php } ?>
            <?php 
            $link = get_field('pol_top_acc_cta_button');
            if( !empty($link['title'])):
               $link_url = $link['url'];
               $link_title = $link['title'];
               $link_target = $link['target'] ? $link['target'] : '_self';
               ?>
               <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" <?php if(!empty($button_background_color)) { ?> style="background-color:<?php echo $button_background_color;?>" <?php } ?>><?php echo esc_html( $link_title ); ?></a>
            <?php endif; ?>
         </div>
      <?php } ?>
   </div>
</section>
<?php } ?>