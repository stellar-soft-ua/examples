<?php
/*
This page is used to display the post list.
*/
get_header(); ?>
<?php
    $post = get_post(get_queried_object_id());
    the_content();
?>

<section class="blog-filter-option py-5">
	<div class="container">
		<div class="row row justify-content-start align-items-center">
			<div class="col-lg-3 col-md-12"><?php echo do_shortcode('[facetwp facet="topics"]');?></div>
			<div class="col-lg-3 col-md-12"><?php echo do_shortcode('[facetwp facet="roles"]');?></div>
            <div class="col-lg-3 col-md-12">
                <button value="Reset" onclick="FWP.reset()" class="facet-reset d-flex flex-row align-items-center">
                    <span>Reset</span>
                    <i class='red-arrow-cta d-flex justify-content-center align-items-center right'><span></span></i>
                </button>
            </div>
		</div>
	</div>
</section>
<section class="blog-list-grid">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 d-flex flex-column justify-content-center two-column-text">
				<?php echo do_shortcode('[facetwp template="new_blog_posts"]');?>
			</div>
		</div>
	</div>
</section>
<section class="blog-pagination-listing">
	<div class="container">
		<div class="row">
			<?php echo do_shortcode('[facetwp facet="blog_pagination"]');?>
		</div>
	</div>
</section>
<?php
get_footer();

