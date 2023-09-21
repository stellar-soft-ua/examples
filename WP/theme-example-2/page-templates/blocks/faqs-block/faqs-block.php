<?php
/**
 * Block Name: Faq Block
 * 
 */
?>
<?php 
  $pol_faq_serial_no = get_field('pol_faq_serial_no');
  $pol_section_heading = get_field('pol_section_heading');
  $pol_faq_background_color = get_field('pol_faq_background_color');    
  $align_class = $block['align'] ? 'align' . $block['align'] : '';  
?>
<?php if(!empty($pol_faq_serial_no) || !empty($pol_section_heading) || !empty($pol_faq_background_color)) { ?>
  <section class="faqs-block who-we-are padding-half-top-bottom <?php echo $align_class; ?>" <?php if(!empty($pol_faq_background_color)) { ?> style="background-color:<?php echo $pol_faq_background_color;?>" <?php } ?>>
            <div class="container">
                <div class="row">
                    <div class="who-image">
                      <?php if(!empty($pol_faq_serial_no)) { ?>
                        <img src="<?php echo esc_url($pol_faq_serial_no['url']); ?>" alt="<?php echo esc_attr($pol_faq_serial_no['alt']); ?>" />
                       <?php } ?>
                    </div>
                </div>
                <div class="row">
                <div class="who-intro">
                    <?php if(!empty($pol_section_heading)) { ?>
                      <h3 class="heading"> <?php echo $pol_section_heading;?></h3>
                    <?php } ?>
                    </div>  
                    <div class="who-we-are-box">
                    <?php 
                    // Check rows exists.
                    if( have_rows('pol_faq_rows') ):
                    while( have_rows('pol_faq_rows') ) : the_row();
                    $pol_faq_title = get_sub_field('pol_faq_title');
                    $pol_faq_description = get_sub_field('pol_faq_description');
                    ?>
                    
                        <div class="col-lg-4 ">  
                          <div class="who-box height">
                            <div class="who-box-text">
                                <div class="text">
                                    <?php if(!empty($pol_faq_title)) { ?>
                                      <h4><strong><?php echo $pol_faq_title;?></strong></h4>
                                    <?php } ?>
                                    <span>
                                      <?php if(!empty($pol_faq_description)) { ?>
                                        <?php echo $pol_faq_description;?>
                                      <?php } ?>
                                    </span>
                                </div>
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
            </div>
        </section>
<?php  } ?>