<?php
/**
* Block Name: Fact sheet      
* 
*/
?>
<?php 
  $pol3_fs_sec_title = get_field('pol3_fs_sec_title');
  $pol3_fs_down_cta_button = get_field('pol3_fs_down_cta_button');
  $align_class = $block['align'] ? 'align' . $block['align'] : '';
?>
<section class="fact-sheet features_sec padding-half-top-bottom <?php echo $align_class; ?>">
  <div class="container">
    <?php if(!empty($pol3_fs_sec_title)) { ?>
      <h2 class="heading text-center"> <?php echo $pol3_fs_sec_title;?> </h2>
    <?php } ?>
    <div class="features_sec_inner">
      <div class="row">
        <?php 
        // Check rows exists.
        if( have_rows('fact_rep') ):
        while( have_rows('fact_rep') ) : the_row();
        $pol3_fs_heading = get_sub_field('pol3_fs_heading');
        $pol3_fs_sec_description = get_sub_field('pol3_fs_sec_description');
        ?>
          <div class="col-lg-6 col-md-6">
            <div class="features_box">
              <div class="inner_features">
                <?php if(!empty($pol3_fs_heading)) { ?>
                  <h3 class="small_heading"> <?php the_sub_field('pol3_fs_heading');?></h3>
                <?php } ?>    
                <?php if(!empty($pol3_fs_sec_description)) { ?>
                  <p class="text"><?php the_sub_field('pol3_fs_sec_description');?></p>
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
    </div>    
    <div class="text-center col-lg-12">
      <?php 
      $link = $pol3_fs_down_cta_button;
      if( !empty($link)):
      $link_url = $link['url'];
      $link_title = $link['title'];
      $link_target = $link['target'] ? $link['target'] : '_self';
      ?>
      <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="default-btn bg-red" tabindex="-1" <?php if(!empty($pol5_cta_bg_color)) { ?> style="background-color:<?php echo $pol5_cta_bg_color;?>" <?php } ?>><?php echo esc_html( $link_title ); ?></a>
      <?php endif; ?>
    </div>
  </div>
</section>