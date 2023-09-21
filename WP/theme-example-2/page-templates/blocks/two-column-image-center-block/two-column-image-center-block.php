<?php
    /**
        * Block Name: Two Column Image Center Block
        *
        * 
        */
    ?>
    <?php 
    $pol_twc_section_heading = get_field('pol_twc_section_heading');
    $pol_twc_background_color = get_field('pol_twc_background_color');
    $align_class = $block['align'] ? 'align' . $block['align'] : '';
    ?>
    <section  class="two-column-image-center-block reporting-section padding-full-top-bottom <?php echo $align_class; ?>" <?php if(!empty($pol_twc_background_color)) { ?> style="background-color:<?php echo $pol_twc_background_color;?>" <?php } ?> id="reporting-section"> 
        <div class="container">
            <div class="reporting-header text-center p-0">
                <?php if(!empty($pol_twc_section_heading)) { ?>
                    <h2 class="heading"><?php echo ($pol_twc_section_heading);?></h2>
                <?php } ?>    
            </div>
            <div class="row gy-4 justify-content-center text-center">
                <?php if( have_rows('pol_twc_grid_block') ):
                    while ( have_rows('pol_twc_grid_block') ) : the_row();
                        $pol_twc_rep_image = get_sub_field('pol_twc_rep_image');
                        $pol_twc_rep_tagline = get_sub_field('pol_twc_rep_tagline');
                        $pol_twc_rep_title = get_sub_field('pol_twc_rep_title');
                        $pol_twc_page_link_cta = get_sub_field('pol_twc_page_link_cta');
                        ?>
                        <div class="col-lg-3 col-md-6 col-sm-6 d-flex align-items-stretch"> 
                            <div class="member">
                                <div class="member-img">
                                    <img src="<?php echo esc_url($pol_twc_rep_image['url']); ?>" alt="<?php echo esc_attr($pol_twc_rep_image['alt']); ?>" />   
                                </div>
                                <div class="member-info">
                                    <?php if(!empty($pol_twc_rep_tagline)) { ?>
                                        <span class="text-red" ><?php the_sub_field('pol_twc_rep_tagline');?></span>
                                    <?php } ?>
                                    <?php if(!empty($pol_twc_rep_title)) { ?>
                                        <h4><?php the_sub_field('pol_twc_rep_title');?></h4>
                                    <?php } ?>
                                    <?php 
                                    $link = $pol_twc_page_link_cta;
                                    if( !empty($link)):
                                        $link_url = $link['url'];
                                        $link_title = $link['title'];
                                        $link_target = $link['target'] ? $link['target'] : '_self';
                                        ?>
                                        <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" ><?php echo esc_html( $link_title ); ?></a>
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
    