<?php
/**
 * Genesis Sample.
 *
 * This file adds the blog page template to the Genesis Sample Theme.
 *
 * Template Name: Blog Template
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */
get_header();?>
<?php
    do_action( 'qm/debug', get_the_ID() );

    the_content(get_the_ID());
?>
<section class="blog-filter-option py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-12"><?php echo do_shortcode('[facetwp facet="topics"]'); ?></div>
            <div class="col-lg-4 col-md-12"><?php echo do_shortcode('[facetwp facet="roles"]'); ?></div>
            <div class="col-lg-2 col-md-12"><button value="Reset" onclick="FWP.reset()"
                    class="facet-reset">Reset</button></div>
        </div>
    </div>
</section>
<section class="blog-list-grid">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 d-flex flex-column justify-content-center two-column-text">
                <?php echo do_shortcode('[facetwp template="blog_posts"]'); ?>
            </div>
        </div>
    </div>
</section>
<section class="blog-pagination-listing">
    <div class="container">
        <div class="row">
            <?php echo do_shortcode('[facetwp facet="blog_pagination"]'); ?>
        </div>
    </div>
</section>
<?php
get_footer();
