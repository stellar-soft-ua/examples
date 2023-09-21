<?php
/**
* Block Name: Four Column Image Grid Block
*
* This is the template that displays the Secondary Hero Block
*/ 

$pol_section_heading = get_field('pol_section_heading');
$trial_cta_btn = get_field('trial_cta_btn');
$background_color = get_field('background_color');
$align_class = $block['align'] ? 'align' . $block['align'] : '';

?>
<section id="reporting-section" class="four-column-image-grid-block reporting-section padding-half-top-bottom <?php echo $align_class; ?>" <?php if(!empty($background_color)) { ?> style="background-color:<?php echo $background_color;?>" <?php } ?>> 
  <div class="container">
    <div class="reporting-header text-center p-0">
      <?php if(!empty($pol_section_heading)) { ?>
        <h2 class="heading"><?php echo $pol_section_heading;?></h2>
      <?php } ?>    
    </div>
    <div class="row gy-4 justify-content-center">
      <?php if( have_rows('grid_block') ):
        $i=1;
        while ( have_rows('grid_block') ) : the_row();
          $pol_rep_image = get_sub_field('pol_rep_image');
          $pol_rep_tagline = get_sub_field('pol_rep_tagline');
          $pol_rep_title = get_sub_field('pol_rep_title');
          $page_link_cta = get_sub_field('page_link_cta');
          ?>
          <div class="col-lg-3 col-md-6 col-sm-6 d-flex align-items-stretch"> 
            <div class="member">
              <div class="member-img">
                <img src="<?php echo esc_url($pol_rep_image['url']); ?>" alt="<?php echo esc_attr($pol_rep_image['alt']); ?>" width="<?php echo $pol_rep_image['sizes']['medium_large-width']; ?>" height="<?php echo $pol_rep_image['sizes']['medium_large-height']; ?>"/>   
              </div>
              <div class="member-info">
                <?php if(!empty($pol_rep_tagline)) { ?>
                  <span class="text-red" ><?php the_sub_field('pol_rep_tagline');?></span>
                <?php } ?>
                <?php if(!empty($pol_rep_title)) { ?>
                  <h4><?php the_sub_field('pol_rep_title');?></h4>
                <?php } ?>
                <?php 
                $link = $page_link_cta;
                if( !empty($link)):
                  $link_url = $link['url'];
                  $link_title = $link['title'];
                  $link_target = $link['target'] ? $link['target'] : '_self';
                  ?>
                  <a aria-label="<?php echo esc_html( $link_title ); ?>" href="<?php echo esc_url( $link_url ); ?>" id="<?php echo "hp-section" . $i;?>" target="<?php echo esc_attr( $link_target ); ?>" ><?php echo esc_html( $link_title ); ?></a>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php 
          $i++;
        endwhile;
      endif;
      ?>
    </div>
    <div class="text-center">
      <?php 
      $link2 = $trial_cta_btn;
      if( !empty($link2)):
        $link_url2 = $link2['url'];
        $link_title2= $link2['title'];
        $link_target2 = $link2['target'] ? $link2['target'] : '_self';
        ?>
        <a aria-label="<?php echo esc_html( $link_title2 ); ?>" href="<?php echo esc_url( $link_url2 ); ?>" target="<?php echo esc_attr( $link_target2 ); ?>" class="reporting-btn default-btn bg-red" ><?php echo esc_html( $link_title2 ); ?></a>
      <?php endif; ?>
    </div>
  </div>
</section> 