<?php
/**
 * Block Name: Values block
 * This is the template that displays the Values Block
*/ 
$pol_heading = get_field('pol_heading');
$pol_short_description = get_field('pol_short_description');
$align_class = $block['align'] ? 'align' . $block['align'] : '';

if(!empty($pol4_heading) || !empty($pol_short_description)) { 

?>
<section class="values-block padding-full-top-bottom <?php echo $align_class; ?>">
  <div class="container">
     <div class="text-center">
      <?php if(!empty($pol_heading)) { ?>
        <h2 class="heading"> <?php echo $pol_heading;?></h2>     
      <?php } ?> 
      <?php if(!empty($pol_short_description)) { ?>
       <p> <?php echo $pol_short_description;?></p>
      <?php } ?>
    </div>
    <div class="row gy-4 text-center">
       <?php 
      /*Check rows exists.*/
       if( have_rows('pol_grid_block') ):
        while( have_rows('pol_grid_block') ) : the_row();
          $pol_image = get_sub_field('pol_image');
          $pol_title = get_sub_field('pol_title');
          $pol_description = get_sub_field('pol_description');
          ?>
          <div class="col-lg-6"> 
            <div>
              <?php if (!empty($pol_image)) { ?>
              <div class="values-image">
                <img src="<?php echo $pol_image['url'];?>" class="img-fluid" alt="<?php echo $pol_image['alt'];?>" />
              </div>
            <?php } ?>
              <div class="values-info">
                 <?php if(!empty($pol_title)) { ?>
                   <h4><?php echo $pol_title;?></h4>
                 <?php } ?>
                 <?php if(!empty($pol_description)) { ?>
                   <p><?php echo $pol_description;?></p>
                <?php } ?>
              </div>
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
      <?php 
        $link = $pol4_cta_button;
        if( !empty($link['title'])):
          $link_url = $link['url'];
          $link_title = $link['title'];
          $link_target = $link['target'] ? $link['target'] : '_self';
      ?>
      <div class="text-center">
         <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="reporting-btn default-btn bg-blue" tabindex="-1"><?php echo esc_html( $link_title ); ?>
        </a>
     </div>
    <?php endif; ?>
  </div>
</section>
<?php } ?>