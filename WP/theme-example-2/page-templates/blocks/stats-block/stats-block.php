<?php
/**
 * Block Name: Stats Block
 * This is the template that displays the Stats Block
 */
?>
<?php 
$background_color = get_field('background_color');
$heading = get_field('heading');
$description = get_field('description');
$align_class = $block['align'] ? 'align' . $block['align'] : '';
?>
<?php if(!empty($background_color) || !empty($heading) || !empty($description)) { ?>
  <section class="stats padding-full-top-bottom <?php echo $align_class; ?>" <?php if(!empty($background_color)) { ?> style="background-color:<?php echo $background_color;?>" <?php } ?>>
    <div class="container">
      <header class="text-center p-0">
        <?php if(!empty($heading)) { ?>
          <h2 class="heading"> <?php echo $heading;?></h2>
        <?php } ?>
      </header>
      <div class="hashed-line-wrapper"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/piclist-divider-white.png" alt="stylized content divider"></div>
      <?php if(!empty($description)) { ?>
       <p> <?php echo $description;?></p>
      <?php } ?>
      <div class="row gy-4 text-center">
        <?php
        if( have_rows('number_repeter') ):
          while( have_rows('number_repeter') ) : the_row();
            $number = get_sub_field('number');
            $text = get_sub_field('text');
            ?>
            <?php if(!empty($number) || !empty($text)) { ?>
            <div class="col-lg-4 col-md-6 numbers">  
              <span><?php echo $number;?></span>
              <p><?php echo $text;?></p>
            </div>
          <?php  } ?>
            <?php 
          endwhile;
        else :
        endif;
        ?>
      </div>

    </div>
  </section>
<?php  } ?>
