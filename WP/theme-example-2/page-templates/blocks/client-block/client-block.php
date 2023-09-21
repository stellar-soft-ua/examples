<?php
/**
* Block Name: Client Block
* This is the template that displays the Client Block
*/

$pol_heading = get_field('pol_heading');
$pol_clt_description = get_field('pol_clt_description');
$pol_cta = get_field('pol_cta');
$pol_image_repeater = get_field('pol_image_repeater');
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$select_heading_tags = get_field('select_heading_tags');

if(!empty($pol_heading) || !empty($pol_cta) || !empty($pol_image_repeater)) { 

?>
<section id="client-block" class="client-block padding-full-top-bottom <?php echo $align_class; ?>">
  <div class="container">
    <div class="text-center p-0">
      <?php 
        if(!empty($pol_heading)) { 
          if (!empty($select_heading_tags) && $select_heading_tags == 'h1-heading') {
            echo "<h1 class='heading'>".$pol_heading."</h1>";
          }elseif(!empty($select_heading_tags) && $select_heading_tags == 'h2-heading'){
            echo "<h2 class='heading'>".$pol_heading."</h2>";
          }elseif(!empty($select_heading_tags) && $select_heading_tags == 'h3-heading'){
            echo "<h3 class='heading'>".$pol_heading."</h3>";
          }elseif(!empty($select_heading_tags) && $select_heading_tags == 'h4-heading'){
            echo "<h4 class='heading'>".$pol_heading."</h4>";
          }elseif(!empty($select_heading_tags) && $select_heading_tags == 'h5-heading'){
            echo "<h5 class='heading'>".$pol_heading."</h5>";
          }else{
            echo "<h6 class='heading'>".$pol_heading."</h6>";
          }
        } 
      ?>

      <?php if(!empty($pol_clt_description)) { ?>
        <p class="client-desc"> <?php echo $pol_clt_description;?></p>
      <?php } ?>
    </div>
    <div class="row gy-4 text-center">
      <?php
      if( have_rows('pol_image_repeater') ):
        while( have_rows('pol_image_repeater') ) : the_row();
          $pol_image = get_sub_field('pol_image');
          ?>
          <?php if (!empty($pol_image)) { ?>
          <div class="col-lg-2 col-md-6 mob-w">  
            <img src="<?php echo $pol_image['url']; ?>" class="img-fluid" alt="<?php echo $pol_image['alt']; ?>" width="<?php echo $pol_image['sizes']['medium-width']; ?>" height="<?php echo $pol_image['sizes']['medium-height']; ?>" />
          </div>
        <?php } ?>
          <?php 
        endwhile;
      else :
      endif;
      ?>
    </div>
    <!--This is the Button code start-->
    <?php 
    $link = $pol_cta;
    if( !empty($link['title'])):
      $link_url = $link['url'];
      $link_title = $link['title'];
      $link_target = $link['target'] ? $link['target'] : '_self';
      ?>
      <div class="text-center">
        <a href="<?php echo esc_url( $link_url ); ?>" <?php if(!empty($link_target)){ ?> target="<?php echo esc_attr( $link_target ); ?>" <?php } ?> class="why-btn default-btn bg-blue"><?php echo esc_html( $link_title ); ?></a>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php  } ?>