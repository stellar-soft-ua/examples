<?php
/**
* Block Name: Two column Image Content Block
* This is the template that displays the Two column Image Content Block
*/
$align_class = $block['align'] ? 'align' . $block['align'] : '';  

$pol5_heading = get_field('pol5_heading');
$pol5_editor = get_field('pol5_editor');
$pol5_section_bg_color = get_field('pol5_section_bg_color');
$pol5_right_image = get_field('pol5_right_image');
$pol5_select_section = get_field('pol5_select_section');
$pol5_link_color = get_field('pol5_link_color');
$pol5_cta_bg_color = get_field('pol5_cta_bg_color');
$pol5_section_heading_color = get_field('pol5_section_heading_color');
$cta_button = get_field('cta_button');  
$select_button =  get_field('select_button');

if($select_button=='Red'){
	$class='bg-red'; 
}
elseif($select_button=='Blue'){
 $class='bg-blue'; 
}
else{
  $class='btn-link';
}

if(!empty($pol5_heading) || !empty($pol5_editor) || !empty($pol5_cta_button) || !empty($pol5_section_bg_color) || !empty($pol5_right_image) || !empty($pol5_cta_bg_color)) { 
?>
<section class="two-column-image-content-block padding-full-top-bottom d-flex align-items-center <?php echo $align_class; ?>" <?php if(!empty($pol5_section_bg_color)) { ?> style="background-color:<?php echo $pol5_section_bg_color;?>" <?php } ?>>
   <div class="container">
      <div class="row <?php echo $pol5_select_section;?>">
         <div class="col-lg-6 d-flex flex-column justify-content-center two-column-text">
            <?php if(!empty($pol5_heading)) { ?>
               <h2 class="heading" style=" color:  <?php echo $pol5_section_heading_color;?>;"> <?php echo $pol5_heading;?></h2>
            <?php } ?>

            <?php if(!empty($pol5_editor)) { echo $pol5_editor; } ?>

            <?php if(!empty($cta_button)) { ?> 
            <p class="two-column-image-content-block_linkBtn">
               <?php 
                  $link = $cta_button;
                  if( !empty($link['title'])):
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>
               <a aria-label="<?php echo esc_html( $link_title ); ?>" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="default-btn <?php echo $class; ?>"><?php echo esc_html( $link_title ); ?></a>
               <?php endif; ?>
            </p>
            <?php } ?>
         </div>
         <div class="col-lg-6 two-column-img">
            <?php if (!empty($pol5_right_image)) { ?>
            <img src="<?php echo $pol5_right_image['url']; ?>" class="img-fluid" alt="<?php echo $pol5_right_image['alt']; ?>" width="<?php echo $pol5_right_image['sizes']['medium_large-width']; ?>" height="<?php echo $pol5_right_image['sizes']['medium_large-height']; ?>" />
            <?php } ?>
         </div>
      </div>
   </div>
</section>
<?php } ?>