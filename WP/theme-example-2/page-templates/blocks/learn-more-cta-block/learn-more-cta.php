<?php
 /**
  * Block Name: Learn More CTA Block
  *
  * This is the template that displays the Secondary Hero Block
  */
  ?>
 <?php 
   $pol_cta_description = get_field('pol_cta_description');
   $pol_cta_heading = get_field('pol_cta_heading');
   $pol_cta_bg_color = get_field('pol_cta_bg_color');
   $pol_cta_text_color = get_field('pol_cta_text_color');
   $button_background_color = get_field('button_background_color');
   $button_hover_background_color = get_field('button_hover_background_color');
   $button_hover_text_color = get_field('button_hover_text_color');
   $heading_color = get_field('heading_color');
   $align_class = $block['align'] ? 'align' . $block['align'] : '';
 ?>
 <?php if(!empty($pol_cta_description) || !empty($pol_cta_btn) || !empty($pol_cta_heading) || !empty($button_background_color) || !empty($pol_cta_bg_color)) { ?>
  <section class="learn-more-cta policy-makers text-center padding-half-top-bottom <?php echo $align_class; ?>" id="policy-makers" <?php if(!empty($pol_cta_bg_color)) { ?> style="background-color:<?php echo $pol_cta_bg_color;?>" <?php } ?>>
    <div class="container-fluid container-xl">
    <?php if(!empty($pol_cta_heading)) { ?>
        <h2><?php echo $pol_cta_heading;?></h2>
      <?php } ?>
      <?php if(!empty($pol_cta_description)) { ?>
        <p><?php echo $pol_cta_description;?></p>
      <?php } ?>
      <?php 
      $link = get_field('pol_cta_btn');
      if( !empty($link['title'])):
        $link_url = $link['url'];
        $link_title = $link['title'];
        $link_target = $link['target'] ? $link['target'] : '_self';
        ?>
        <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" <?php if(!empty($button_background_color)) { ?> style="background-color:<?php echo $button_background_color;?>" <?php } ?>><?php echo esc_html( $link_title ); ?></a>
      <?php endif; ?>
    </div>
      <style> 
     .learn-more-cta a{
       color:<?php echo $pol_cta_text_color;?>;
       background-color:<?php echo $button_background_color;?>;
     }
    .learn-more-cta a:hover{
      color:<?php echo $button_hover_text_color;?>;
      background-color:<?php echo $button_hover_background_color;?>!important;
    }    
    .learn-more-cta h1{
      color:<?php echo $heading_color;?>;
    }
  </style>
  </section>
<?php } ?>
