<?php
/**
 * Block Name: Two Column Success Grid Block
 * This is the template that displays the Two Column Success Grid Block
 */
?>
<?php 
$success_heading = get_field('success_heading');
$success_subheading = get_field('success_subheading');
$success_grid_background_color = get_field('success_grid_background_color');
$align_class = $block['align'] ? 'align' . $block['align'] : '';
?>

<section class="two-column-success-grid-block grid-bottom <?php echo $align_class; ?>">
    <div class="container">
            <div class="grid-header text-center">
                <?php if(!empty($success_heading)) { ?>
                    <h2 class="heading"> <?php echo $success_heading;?></h2>    
                <?php } ?>
                <?php if(!empty($success_subheading)) { ?>
                    <p><?php echo $success_subheading;?></p>    
                <?php } ?>
            </div>
    <div class="row text-center d-flex justify-content-center">
        <?php 
            // Check rows exists.
            if( have_rows('success_grid_block') ):
            while( have_rows('success_grid_block') ) : the_row();
            $success_image = get_sub_field('success_image');
            $success_title = get_sub_field('success_title');
            $success_cta = get_sub_field('success_cta');
            ?>
            <div class="col-lg-6 col-md-6"> 
                <div class="request_box">
                    <?php if (!empty($success_image)) { ?>
                        <div class="request_box_icon">
                            <img src="<?php echo $success_image['url'];?>" class="img-fluid " alt="<?php echo $success_image['alt'];?>" />
                        </div>
                    <?php } ?>
                <div class="request_box_title">
                    <?php if(!empty($success_title)) { ?>
                        <span><?php echo $success_title;?> </span>
                    <?php } ?>
                </div>
                <?php 
                    $link = $success_cta;
                    if( !empty($link['title'])):
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>
                    <div class="request_box_button">
                        <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="reporting-btn default-btn bg-red" tabindex="-1"><?php echo esc_html( $link_title ); ?></a>
                    </div>
                <?php endif; ?>
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
