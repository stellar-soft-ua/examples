<?php
/**
 * Block Name: Testimonial Block
 * This is the template that displays the Testimonial Block
 */
?>
<?php 
$pol_testimonial_bg_color = get_field('pol_testimonial_bg_color');
$align_class = $block['align'] ? 'align' . $block['align'] : '';  
?>
<section class="testimonial-block padding-full-top-bottom d-flex align-items-center  <?php echo $align_class; ?>" <?php if(!empty($pol_testimonial_bg_color)) { ?> style="background-color:<?php echo $pol_testimonial_bg_color;?>" <?php } ?>>
    <div class="container">
      <div class="row">
          <?php
      if( have_rows('testimonial_items') ):
        while( have_rows('testimonial_items') ) : the_row();
          $pol_testimonial_items_description = get_sub_field('pol_testimonial_items_description');
          $pol_testimonial_items_author = get_sub_field('pol_testimonial_items_author');
            ?>
        <div class="col-lg-6 col-md-12">
          <div class="testm_content">
        <span class="testimonial_discrip"><?php the_sub_field('pol_testimonial_items_description');?></span>
            <p><?php the_sub_field('pol_testimonial_items_author');?></p>
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
