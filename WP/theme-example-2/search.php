<?php
/**
 * The template for displaying search results pages
*/ 
get_header();?>

<section class="search-page-content search-form-section">
	<div class="container">
		<form role="search" method="get" id="politicopro-searchform"
		class="politicopro-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="row ee-searchfilter">
			<div class="col-md-12 col-lg-12 ee-keyword">
				<label class="politicopro-searchkeyword" for="Search by keyword">Search by keyword</label>
				<input type="text" placeholder="SEARCH OUR SITE" class="datepicker" value="<?php echo get_search_query(); ?>" name="s" id="s" />
			</div>				
			<div class="col-md-12 col-lg-12 politicopro-sort">
				<div class="sort-by-inner">
					<label for="Sort by">Sort by:</label>
					<select id="ee-orders" name="ee-orders">
						<option value="date_asc" <?php if($_GET['ee-orders'] == 'date_asc'){
							echo "selected";
						} ?> >Relevance</option>

						<option value="date_desc" <?php if($_GET['ee-orders'] == 'date_desc'){
							echo "selected";
						} ?> >Most Recent</option>
						
							<option value="popular_post" <?php if($_GET['ee-orders'] == 'popular_post'){
							echo "selected";
						} ?> >Popularity</option>					
					</select>
				</div>					
			</div>
			<div class="col-md-12 col-lg-2 ee-searchbtn">
				<input type="submit" id="searchsubmit"
				class="search-form-submit" value="<?php echo esc_attr_x( 'Go', 'submit button' ); ?>" />
			</div>
		</div>
	</form>

<!-- Display output based on search term	 -->			
<?php 				
	$ee_keyword = $_GET['s']; //Get search keyword
	if(isset($_GET['ee-orders']) && $_GET['ee-orders']!=""){
			
		if($_GET['ee-orders'] == 'date_asc'){
				$order_by = 'Date';
				$order_sort = 'ASC';
			}elseif($_GET['ee-orders'] == 'date_desc'){
				$order_by = 'Date';
				$order_sort = 'DESC';
			}elseif($_GET['ee-orders'] == 'popular_post'){
				$order_by = 'meta_value_num';
				$order_sort = 'DESC';
				$metakey = '_popular_post';
			}		
		}else{
			$order_by = 'date';
			$order_sort = 'DESC';
		}

	$page_d = (get_query_var('paged')) ? get_query_var('paged') : 1;

	if($_GET['ee-orders'] == 'popular_post'){
		$args = array(
			'post_status' => 'publish',
			's' => $ee_keyword,
			'orderby' => $order_by,
			'order' => $order_sort,	
			'paged' => $page_d,
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => $metakey,
					'value' => '1', 
					'compare' => 'LIKE',
				),
				array(
					'key' => '_wds_meta-robots-noindex',
					'value' => '1', 
					'compare' => '!=',
				),
			),
		);
	}else{
		$args = array(
			'post_status' => 'publish',
			's' => $ee_keyword,
			'orderby' => $order_by,
			'order' => $order_sort,	
			'paged' => $page_d,
			'meta_query' => array(
				array(
					'key' => '_wds_meta-robots-noindex',
					'value' => '1', 
					'compare' => '!=',
				),
			),
		);
	}
	$get_items = new WP_Query($args); ?>
	<?php if ( $get_items->have_posts() ) { ?>
		<div class="row ee-header">		
			<div class="col-md-12">
				<?php
				$posts_per_page = $get_items->query_vars['posts_per_page'] . '</br>';
				$posts_found = $get_items->found_posts;
				$maxnumber = $get_items->max_num_pages;
				$pagedvar = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$ofpage = $pagedvar * $posts_per_page;
				$haspage = $posts_per_page - 1;
				$topage = $ofpage - $haspage;
				$formecho = true; 
				if($posts_found){ 
					echo'<div class="search-found-result"><p class="search-result-inner">Site Search Results: <span>' . $topage . '-' . $ofpage . '</span> <span>of</span> <span>' . $posts_found.'</span>';
					//printf(' <span> results for</span> <span class="red-search-text">%s</span>', '"politicopro"');
					echo '<span> results for</span> <span class="red-search-text">'; 
					printf( esc_html__( '“%s', 'politicopro' ), '' . get_search_query() . '”' );
					echo '</span>'; 
					echo "</p></div>"; 
				}
				?>
			</div>
		</div>
	</div>
</section>
<section class="search-result-content">
	<div class="container">
		<div class="search-result-box">
			<?php
				/* Start the Loop */
				while ( $get_items->have_posts() ) :
				$get_items->the_post();
			?>
				<div class="row three-list">
					<div class="col-md-12">
						<div class="content-excerpt-list-left search-result-body">
							<!--Show the title insight post end excerpt--> 
							<a href="<?php echo get_the_permalink($post->ID);?>"><h4 class="search-result-title"><?php echo get_the_title($post->ID);?></h4></a>
							<div class="post_date"><p><?php echo get_the_date( 'l d.m.y' );?></p></div>
							<p class="search_excerpt">
							<?php 
							$excerpt = get_the_excerpt(get_the_ID());
							if(!empty($excerpt)){ 
								echo wp_trim_words($excerpt, '140');
							}
							?></p>
							<!--End code the title insight post end excerpt--> 
						</div>
					</div>
				</div>
				<?php 
			endwhile;
			/* Restore original Post Data */
			wp_reset_postdata();
			$max_page1 = $get_items->max_num_pages;
			if ($max_page1 > 1) { 
				$num = wp_is_mobile() ? 1 : 2;
				?>
				<div class= "article-archive-paginate">
					<div class= "row align-items-center">
						<div class="col-12">
							<div class="blog-pagination">
								<?php
									the_posts_pagination(array(
										'mid_size' => $num,
										'end_size' => 1,
										'prev_text' => __('Prev', 'textdomain') ,
										'next_text' => __('Next', 'textdomain') ,
										'screen_reader_text' => __('Page') ,
										'total' => $max_page1,
										'current' => max(1, $page_d) ,
									));
								?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>					
	<?php }
	else {
		_e('<div class="politicopro-noresult">Sorry, but nothing matched your search term. Please try again with some different keywords.</div>', 'politicopro');
	}	
?>
</div>
</section>
<?php get_footer();