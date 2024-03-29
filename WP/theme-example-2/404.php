<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Templates
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://my.studiopress.com/themes/genesis/
 */

$heading = get_field('404_heading', 'option');
$short_description = get_field('404_short_description', 'option');
$cta_link = get_field('404_cta_link', 'option');
get_header(); ?>
<?php if(!empty($heading) || !empty($short_description)|| !empty($cta_link)) { ?>
<section class="not-found-banner blog-banner full-width-banner-block" style="background-image: url('<?php the_field('404_background_image', 'option');?>')">
    <div class="container">
      <div class="row">
        <!--Image section code end-->
        <div class="col-lg-12 col-md-12">
          <div class="pol-box-section">
            <span><?php _e('sorry.', 'POL'); ?></span>
            <?php if(!empty($heading)) { ?>
         <h1><?php echo $heading;?></h1>
         <?php } ?>
         <?php if(!empty($short_description)) { ?>
          <p><?php echo $short_description;?></p>
          <?php } ?>
          <?php
            $link = get_field('404_cta_link', 'option');
            if( $link ):
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <a class="button default-btn bg-red" href="<?php echo esc_url( $link_url ); ?>"  target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
            <?php endif; ?>
            </div>
        </div>
      </div>
    </div>
  </section>
<?php } ?>
<?php get_footer(); ?>


