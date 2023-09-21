<?php
   /**
    * Block Name: Success Banner Block
    * This is the template that displays the Success Banner Block
    */
   ?>
<?php 
   $success_banner_heading = get_field('success_banner_heading');
   $success_banner_sub_text = get_field('success_banner_sub_text');
   $align_class = $block['align'] ? 'align' . $block['align'] : '';  
?>
<?php if(!empty($success_banner_heading) || !empty($success_banner_sub_text)) { ?>
    <section class="success-banner-block padding-half-top-bottom <?php echo $align_class; ?> ">
        <div class="container">
            <div class="banner-content">
                <?php if(!empty($success_banner_heading)) { ?>
                    <h1 class="heading"> <?php echo $success_banner_heading;?></h1>
                <?php } ?>
                <?php if(!empty($success_banner_sub_text)) { ?>
                    <p> <?php echo $success_banner_sub_text;?></p>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>