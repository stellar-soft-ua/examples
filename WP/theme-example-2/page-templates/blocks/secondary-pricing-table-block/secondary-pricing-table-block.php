<?php

$pol_section_title = !empty(get_field('pol_section_title')) ? get_field('pol_section_title') : '';

$product_plan_1 = get_field('product_plan_1');
$product_plan_name_one = $product_plan_1['product_plan_name_one'];
$product_plan_1_title = $product_plan_1['product_plan_1_title'];
$product_plan_description_1 = $product_plan_1['product_plan_description_1'];

                                        
$product_plan_2 = get_field('product_plan_2');
$product_plan_name_2 = $product_plan_2['product_plan_name_2'];
$product_plan_2_title = $product_plan_2['product_plan_2_title'];
$product_plan_description_2 = $product_plan_2['product_plan_description_2'];


?>
<!-- start feature-suite -->
<section class="secondary-pricing-table-block feature-suite padding-full-top-bottom custom-pricing-table-block"> 
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php if(!empty($pol_section_title)) { ?>
                    <h2><strong><?php echo $pol_section_title;?></strong></h2>
                <?php } ?>
            </div>
            <div class="feature-plans feature-plans-desktop">
                <div class="col-lg-4">
                    <div class="block empty"></div>
                </div>
                <div class="col-lg-4">
                    <div class="block plan red-color-block">
                        
                        <?php if(!empty($product_plan_name_one)) { ?>
                            <div class="top">
                                <h3><span><strong><?php echo $product_plan_name_one; ?></strong></span></h3>
                            </div>
                        <?php } ?>                        
                       
                        <?php 
                           $link = $product_plan_1_title;
                           if( !empty($link['title'])):
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self';
                            ?>
                            <div class="cta">
                                <a href="#proplusplan" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> ><?php echo esc_html( $link_title ); ?></a>
                            </div>
                        <?php endif;?>

                        <?php if(!empty($product_plan_description_1)) { ?>
                            <div class="plan-description">
                                <p><?php echo $product_plan_description_1; ?></p>
                            </div>
                        <?php } ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="block plan premium blue-color-block">
                    <?php if(!empty($product_plan_name_2)) { ?>
                        <div class="top">
                            <h3><span><strong><?php echo $product_plan_name_2; ?></strong></span></h3>
                            </div>
                    <?php } ?>                    
                   
                    <?php 
                        $link = $product_plan_2_title;
                        if( !empty($link['title'])):
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>
                        <div class="cta">
                            <a href="#propremiumplan" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> ><?php echo esc_html( $link_title ); ?></a>
                        </div>
                    <?php endif;?>

                    <?php if(!empty($product_plan_description_2)) { ?>
                        <div class="plan-description">
                            <p><?php echo $product_plan_description_2; ?></p>
                        </div>
                    <?php } ?>  
                    
                </div>
            </div>
        </div>
        <div class="feature-plans feature-plans-mobile">
            <!-- First Column Start Here -->
            <div class="col-lg-4">
                <div class="block empty"></div>
                <div class="block legend">
                    <ul>
                        <?php
                    // Check rows exists.
                        if (have_rows('product_categoty_repeater')):
                            while (have_rows('product_categoty_repeater')) : the_row();
                            // Get parent value.
                                $product_category = get_sub_field('product_category');
                                if(!empty($product_category)){
                                ?>
                                <li class="heading"><span class="text"><?php echo $product_category;?></span></li>
                                <?php
                                } /* end if $product_category */
                            // Loop over sub repeater rows.
                                if (have_rows('product_feature_repeator')):
                                    while (have_rows('product_feature_repeator')) : the_row();
                                // Get sub value.
                                        $product_feature = get_sub_field('product_feature');
                                        $feature_tool_tip = get_sub_field('feature_tool_tip');
                                        $plan_new = get_sub_field('plan_new');
                                        ?>
                                        <?php if(!empty($product_feature)){?>
                                            <li class="">
                                                <span class="text"><?php echo $product_feature; ?></span>
                                                <?php if(!empty($feature_tool_tip)){?>
                                                    <a href="#" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo $feature_tool_tip;?>"><span class="label right has-tip" data-tooltip="" tabindex="1" title="" aria-describedby="" data-yeti-box="" data-toggle="" data-resize="" data-events="resize">?</span></a>
                                                <?php } ?>
                                                 <?php if(!empty($plan_new)){?>
                                                    <span class="plan_new"><?php echo $plan_new; ?></span>
                                                    <?php } ?>
                                            </li>
                                        <?php } ?>
                                        <?php
                                    endwhile;
                                endif;
                            endwhile;
                        endif;
                        ?>      
                    </ul>
                </div>        
            </div>
            <!-- First Column End Here -->

            <!-- Second Column Start Here -->
            <div class="col-lg-4">
                <div class="block plan">
                   
                    <?php if(!empty($product_plan_name_one)) { ?>
                        <div class="top">
                            <h3><span><strong><?php echo $product_plan_name_one; ?></strong></span></h3>
                        </div>
                    <?php } ?>
                   
                    
                    <?php 
                        $link = $product_plan_1_title;
                        if( !empty($link['title'])):
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>
                        <div class="cta">
                            <a href="#propremiumplan" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> ><?php echo esc_html( $link_title ); ?></a>
                        </div>
                    <?php endif;?>
                    
                    <?php if(!empty($product_plan_description_1)) { ?>
                        <div class="plan-description">
                            <p><?php echo $product_plan_description_1; ?></p>
                        </div>
                    <?php } ?>
                </div>
                <div class="block features red-color-block">
                    <ul>
                        <?php
                // Check rows exists.
                        if (have_rows('product_categoty_repeater')):
                            while (have_rows('product_categoty_repeater')) : the_row();
                            // Get parent value.
                                $product_category = get_sub_field('product_category');
                                ?>
                                <?php if(!empty($product_category)) { ?>
                                    <li class="has-feature heading"><span class="label"><?php echo $product_category;?></span></li>
                                <?php } ?>
                                <?php
                                // Loop over sub repeater rows.
                                if (have_rows('product_feature_repeator')):
                                    while (have_rows('product_feature_repeator')) : the_row();
                                // Get sub value.
                                        $product_feature = get_sub_field('product_feature');
                                        $plan_1_feature_availability = get_sub_field('plan_1_feature_availability');
                                        ?>

                                        <li class="has-feature <?php if(!empty($plan_1_feature_availability)){ ?>active-feature<?php } ?>">
                                            <?php if(!empty($plan_1_feature_availability)){ ?>
                                                <span class="icon">X</span>
                                            <?php } ?>
                                            <?php if(!empty($product_feature)){ ?>
                                                <span class="label"><?php echo $product_feature; ?></span>
                                            <?php } ?>
                                        </li>
                                        <?php
                                    endwhile;
                                endif;
                            endwhile;
                        endif;
                        ?>      
                    </ul>
                </div>
            </div>  
            <!-- Second Column End Here -->
            <!-- Third Column Start Here -->
            <div class="col-lg-4 premium-plan">
                <div class="block plan premium ">
                   
                <?php if(!empty($product_plan_name_2)){ ?>
                    <div class="top">
                        <h3><span><strong><?php echo $product_plan_name_2; ?></strong></span></h3>
                    </div>
                <?php } ?>                
                
                <?php 
                    $link = $product_plan_2_title;
                    if( !empty($link['title'])):
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                    <div class="cta">
                        <a href="#propremiumplan" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> ><?php echo esc_html( $link_title ); ?></a>
                    </div>
                <?php endif;?>
                
                <?php if(!empty($product_plan_description_2)) { ?>
                    <div class="plan-description">
                        <p><?php echo $product_plan_description_2; ?></p>
                    </div>
                <?php } ?>
            </div>
            <div class="block features premium blue-color-block">
                <ul>
                    <?php
                    // Check rows exists.
                    if (have_rows('product_categoty_repeater')):
                        while (have_rows('product_categoty_repeater')) : the_row();
                            // Get parent value.
                            $product_category = get_sub_field('product_category');
                            ?>
                            <?php if(!empty($product_category)){ ?>
                                <li class="has-feature heading"><span class="label"><?php echo $product_category;?></span></li>
                            <?php } ?>
                            <?php
                            // Loop over sub repeater rows.
                            if (have_rows('product_feature_repeator')):
                                while (have_rows('product_feature_repeator')) : the_row();
                                    // Get sub value.
                                    $product_feature = get_sub_field('product_feature');
                                    $plan_2_feature_availability = get_sub_field('plan_2_feature_availability');
                                    ?>
                                    <li class="has-feature <?php if(!empty($plan_2_feature_availability)){ ?>active-feature<?php } ?>">
                                        <?php if(!empty($plan_2_feature_availability)){ ?>
                                            <span class="icon">X</span>
                                        <?php } ?>
                                        <?php if(!empty($product_feature)){ ?>
                                            <span class="label"><?php echo $product_feature; ?></span>
                                        <?php } ?>
                                    </li>
                                    <?php
                                endwhile;
                            endif;
                        endwhile;
                    endif;
                    ?>      
                </ul>
            </div>
        </div>  
        <!-- Third Column End Here -->
    </div>
</div>
</div>
</section>
<!-- End feature-suite -->