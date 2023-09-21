<?php
/**
  * Block Name: Hero Block
  *
  * This is the template that displays the Hero Block
*/
$pol_banner_heading = get_field('pol_banner_heading');
$pol_banner_description = get_field('pol_banner_description');
$pol_banner_cta_button = get_field('pol_banner_cta_button');
$pol_banner_right_image = get_field('pol_banner_right_image');
$align_class = $block['align'] ? 'align' . $block['align'] : '';

if(!empty($pol_banner_heading) || !empty($pol_banner_description) || !empty($pol_banner_cta_button) || !empty($pol_banner_right_image)) { 
?>
<section id="banner" class="home-hero-block banner d-flex align-items-center padding-half-top-bottom <?php echo $align_class; ?>">
  <div class="container">
    <div class="row">
       <div class="col-lg-6 d-flex flex-column banner-left-text">
         <?php if(!empty($pol_banner_heading)) { ?>
          <h1 class="banner-heading heading"><?php echo ($pol_banner_heading);?></h1>
        <?php } ?>
        <?php if(!empty($pol_banner_description)) { ?>
          <span class="banner-text"><?php echo ($pol_banner_description);?></span>
        <?php } ?>
        <p>
        <?php 
          $link = $pol_banner_cta_button;
          if( !empty($link['title'])):
           $link_url = $link['url'];
           $link_title = $link['title'];
           $link_target = $link['target'] ? $link['target'] : '_self';
        ?>
           <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="default-btn bg-blue"><?php echo esc_html( $link_title ); ?></a>
         <?php endif; ?>
       </p>
     </div>
     <div class="col-lg-6 banner-img">
       <?php if(!empty($pol_banner_right_image)) { ?>
         <img src="<?php echo $pol_banner_right_image['url']; ?>" class="img-fluid" alt="<?php echo $pol_banner_right_image['alt']; ?>" width="<?php echo $pol_banner_right_image['sizes']['medium_large-width']; ?>" height="<?php echo $pol_banner_right_image['sizes']['medium_large-height']; ?>"/>
       <?php } ?>
     </div>
   </div>
  </div>
</section>
<?php } ?>