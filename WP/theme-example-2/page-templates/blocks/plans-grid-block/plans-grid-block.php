<?php
/**
* Block Name: Plans Grid Block
*
* This is the template that displays the Plans Grid Block
*/
?>
<?php   
$align_class = $block['align'] ? 'align' . $block['align'] : ''; 
?>  
<section class="plans-grid-block PoliticoPro_Brick padding-half-top-bottom <?php echo $align_class; ?>">
    <div class="container">
        <div class="interior">
            <div class="row">
                <?php
                if( have_rows('pol_plans_grid_section') ):
                while( have_rows('pol_plans_grid_section') ) : the_row();
                $pol_rep_grid_title = get_sub_field('pol_rep_grid_title');
                $pol_rep_grid_title_description = get_sub_field('pol_rep_grid_title_description');
                $pol_rep_grid_listing_title = get_sub_field('pol_rep_grid_listing_title');
                $pol_rep_grid_sub_heading = get_sub_field('pol_rep_grid_sub_heading');
                ?>
                    <div class="col-lg-6 main_rail">
                        <div class="">
                        <?php if(!empty($pol_rep_grid_title)) { ?> 
                            <h2 class="heading"> <?php echo $pol_rep_grid_title;?></h2> 
                        <?php } ?>
                                <div class="intro">
                                <?php if(!empty($pol_rep_grid_sub_heading)) { ?> 
                                    <p><span> <?php echo $pol_rep_grid_sub_heading;?></span></p>
                                    <?php } ?>
                                
                                <?php if(!empty($pol_rep_grid_title_description)) { ?> 
                                    <p><?php echo $pol_rep_grid_title_description;?></p>
                                    <?php } ?>
                                </div>
                                <div class="brick_content">
                                    <div class="content">
                                    <?php if(!empty($pol_rep_grid_listing_title)) { ?> 
                                        <h4><?php echo $pol_rep_grid_listing_title;?></h4>
                                        <?php } ?>
                                        <ul>
                                            <?php
                                            if( have_rows('pol_rep_grid_listing_list') ):
                                            while( have_rows('pol_rep_grid_listing_list') ) : the_row();
                                            $pol_rep_grid_list_text = get_sub_field('pol_rep_grid_list_text');
                                            ?>
                                              <?php if(!empty($pol_rep_grid_list_text)) { ?> 
                                                <li><?php echo $pol_rep_grid_list_text;?></li>
                                                <?php } ?>
                                            <?php endwhile;?>
                                            <?php endif;?>  
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    <?php endwhile;?>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>
