<?php 
/**
 * Fires at start of header.php, immediately before `genesis_title` action hook to render the Doctype content.
 *
 * @since 1.3.0
 */
do_action( 'genesis_doctype' );

/**
 * Fires immediately after `genesis_doctype` action hook, in header.php to render the document title.
 *
 * @since 1.0.0
 */
do_action( 'genesis_title' );

/**
 * Fires immediately after `genesis_title` action hook, in header.php to render the meta elements.
 *
 * @since 1.0.0
 */
do_action( 'genesis_meta' );

wp_head(); // We need this for plugins.
?>
</head>
<?php
genesis_markup(
	[
		'open'    => '<body %s>',
		'context' => 'body',
	]
);

if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}

/**
 * Fires immediately after the `wp_body_open` action hook.
 *
 * @since 1.0.0
 */
do_action( 'genesis_before' );

genesis_markup(
	[
		'open'    => '<div %s>',
		'context' => 'site-container',
	]
);

if(!empty(get_field('global_header_background', get_the_ID()))){
	$headerclass = get_field('global_header_background', get_the_ID());
}else{
	$headerclass = 'white-bg-header';
}
if ( get_field('disable_header_navigation') == true ) {
	$headercenterlogo = "header-center-logo"; 
}
/* for disable header */
if ( get_field('disable_header') == false ) { 
?>
<!-- Header Start -->
<header itemtype="http://schema.org/WPHeader" itemscope="itemscope" class="site-header fixed-header <?php echo $headerclass; ?> <?php echo $headercenterlogo; ?>">
<?php  global $post;?>
<!-- Header Logo -->
<?php $image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' ); ?>
	<div class="poli-top-header">
		<div class="container">
			<div class="row mobile-menu-news-row">
				<div class="col-xl-2 col-lg-2 col-md-2">
					<div class="logo">
						<a href="<?php bloginfo('url')?>">
							<!-- <img src="<?php //echo $image[0]; ?>" alt="<?php //echo get_bloginfo( 'title' ); ?>" width="200" height="69" /> -->
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 354 48" focusable="false">
								<title>Politico Pro Logo</title>
								<path class="branding-politico" d="M200.025,23.821c-0.069-6.348,2.526-12.434,7.156-16.778c4.518-4.573,10.707-7.104,17.134-7.009 c13.363,0.081,24.13,10.979,24.049,24.341c-0.004,0.594-0.029,1.188-0.076,1.78c-0.36,5.007-2.377,9.751-5.734,13.483 c-8.894,10.166-24.345,11.197-34.51,2.304c-0.057-0.05-0.114-0.1-0.171-0.151C202.639,37.215,200.023,31.225,200.025,23.821 M207.062,23.896c-0.23,9.46,7.253,17.315,16.713,17.545c4.699,0.114,9.238-1.707,12.555-5.036 c6.644-6.914,6.671-17.833,0.062-24.78c-6.73-6.71-17.62-6.71-24.35,0c-3.283,3.227-5.084,7.669-4.974,12.271 M198.98,3.37v8.261 c-4.031-3.368-8.205-5.055-12.521-5.059c-4.55-0.086-8.921,1.776-12.01,5.118c-3.246,3.323-5.016,7.815-4.91,12.46 c-0.104,4.591,1.669,9.027,4.91,12.281c3.139,3.277,7.505,5.091,12.042,5.004c2.15,0.06,4.286-0.35,6.261-1.202 c1.043-0.443,2.041-0.985,2.981-1.619c1.129-0.754,2.213-1.572,3.247-2.452v8.43c-3.82,2.22-8.158,3.395-12.576,3.405 c-6.351,0.106-12.468-2.397-16.922-6.925c-4.554-4.405-7.08-10.499-6.98-16.833c-0.038-5.79,2.039-11.394,5.841-15.761 c4.562-5.541,11.426-8.666,18.601-8.468C191.183,0.036,195.339,1.196,198.98,3.37 M151.213,0.907h6.977v46.239h-6.977V0.907z M135.671,7.466v39.682h-6.98V7.466h-10.629V0.908h28.213v6.558H135.671z M106.15,0.907h6.979v46.239h-6.979V0.907z M87.593,0.908 v39.683h13.597v6.557H80.612V0.908H87.593z M28.401,23.821c-0.068-6.348,2.529-12.434,7.158-16.778 c4.518-4.573,10.707-7.104,17.134-7.009c13.252,0.079,23.975,10.802,24.054,24.054c0.105,6.391-2.482,12.533-7.128,16.922 c-9.185,8.998-23.772,9.339-33.368,0.78c-5.233-4.576-7.849-10.566-7.849-17.97 M35.442,23.895 c-0.227,9.46,7.257,17.314,16.718,17.541c4.695,0.113,9.23-1.706,12.546-5.032c6.645-6.914,6.671-17.834,0.059-24.78 c-3.166-3.311-7.579-5.138-12.16-5.034c-4.588-0.093-9.006,1.731-12.192,5.034C37.131,14.852,35.332,19.294,35.442,23.895 M7.201,28.368V47.15h-6.98V0.909h7.908c2.947-0.095,5.895,0.176,8.776,0.808c1.994,0.537,3.812,1.588,5.272,3.048 c2.643,2.575,4.087,6.14,3.98,9.829c0.176,3.825-1.388,7.523-4.255,10.061c-2.834,2.478-6.657,3.716-11.471,3.714L7.201,28.368z M7.201,21.905h2.606c6.409,0,9.614-2.469,9.615-7.406c0-4.765-3.306-7.151-9.918-7.158H7.198L7.201,21.905z"></path>
								<path class="branding-pro" d="M353.778,23.755c0.135,13.132-10.401,23.888-23.533,24.023c-13.132,0.135-23.888-10.401-24.023-23.533 s10.401-23.888,23.533-24.023c0.082-0.001,0.164-0.001,0.246-0.001C343.015,0.276,353.589,10.742,353.778,23.755 M309.141,23.755 c-0.034,11.521,9.278,20.887,20.798,20.921c11.521,0.034,20.887-9.278,20.921-20.798c0.034-11.521-9.278-20.887-20.798-20.921 c-0.02,0-0.041,0-0.061,0C318.536,3.032,309.25,12.29,309.141,23.755 M308.528,46.983h-3.343l-14.961-21.711h-5.834v21.711h-2.918 V1.129h5.711c3.71,0,7.359,0.06,10.461,2.307c3.114,2.285,4.855,5.995,4.622,9.851c-0.116,7.484-3.834,10.544-8.763,11.981 L308.528,46.983z M288.099,22.536c2.856,0,5.711-0.123,8.027-2.13c2.113-1.801,3.298-4.461,3.224-7.236 c0.168-3.479-1.743-6.727-4.866-8.271c-2.432-1.155-5.534-1.035-8.209-1.035h-1.886v18.672H288.099z M256.514,46.983h-2.918V1.129 h8.088c3.587,0,7.055,0.243,9.913,2.676c5.185,4.745,5.541,12.794,0.796,17.979c-0.159,0.174-0.323,0.344-0.492,0.509 c-2.797,2.433-6.63,2.919-10.215,2.919h-5.17L256.514,46.983z M261.804,22.474c2.981,0,5.655-0.365,8.028-2.492 c1.946-1.748,3.034-4.257,2.98-6.872c0.079-2.882-1.206-5.632-3.466-7.42c-2.306-1.757-5.229-1.824-8.027-1.824h-4.805v18.609 L261.804,22.474z"></path>
							</svg>
						</a>
					</div>
				</div>
				<div class="col-xl-10 col-lg-10 col-md-10 mobile-menu-news"> 
					<?php if ( get_field('disable_header_navigation') == false ) {  ?>
						<div class="nav-wrap-right">
							<div class="pol-request-btn">
								<?php
								wp_nav_menu( array( 'theme_location' => 'top-menu', 'container' => '', 'menu_class'=> 'menu genesis-nav-menu') );
								?>
							</div>
							<nav class="nav-primary genesis-responsive-menu genesis-nav-menu" id="genesis-nav-primary" aria-label="Main navigation">
							<?php
								wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '', 'menu_class' => 'menu genesis-nav-menu') );
							?>
							</nav>
						</div>
					<?php } ?>
			</div>
		</div>
		<div class="main-search-form"><div class="custom_search_form"><?php echo get_search_form( false ); ?></div></div>
	</div>
</div>
<!-- Header Navigation -->
</header>
<!-- Header End -->
<?php 
genesis_markup(
	[
		'open'    => '<div %s>',
		'context' => 'site-inner',
	]
);
genesis_structural_wrap( 'site-inner' );
/* end here disable header */
}else{ 
genesis_markup(
	[
		'open'    => '<div %s>',
		'context' => 'site-inner noheader-content',
	]
);
genesis_structural_wrap( 'site-inner' );
}
