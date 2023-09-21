<?php
   /**
    * Block Name: Resource CTA
    * This is the template that displays the Demo CTA
    */
   ?>
<?php 
   $pol_resource_cta_heading = get_field('pol_resource_cta_heading');
   $pol_demo_cta_content = get_field('pol_resource_cta_content');
   $pol_resource_cta_button = get_field('pol_resource_cta_button');
   $select_color =  get_field('select_color');
   if($select_color=='Blue'){
   	$class='cta-blue'; 
   }
   else{
   	$class='cta-grey';    
   }
   $align_class = $block['align'] ? 'align' . $block['align'] : '';
   ?>
<section class="resource-cta-block padding-full-top-bottom <?php echo $class; ?> <?php echo $align_class; ?>">  
      <?php if(!empty($pol_resource_cta_heading)) { ?>
      <h2 class="heading"> <?php echo $pol_resource_cta_heading;?></h2>
      <?php } ?>
      <?php if(!empty($pol_demo_cta_content)) { ?>
      <p class="cta-content"> <?php echo $pol_demo_cta_content;?></p>
      <?php } ?>
      <?php 
         $link = $pol_resource_cta_button;
         if( !empty($link['title'])):
           $link_url = $link['url'];
           $link_title = $link['title'];
           $link_target = $link['target'] ? $link['target'] : '_self';
           ?>
      <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="default-btn"><?php echo esc_html( $link_title ); ?></a>
      <?php endif; ?>
</section>