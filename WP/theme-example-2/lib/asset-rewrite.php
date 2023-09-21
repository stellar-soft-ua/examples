<?php
add_action('init', function() {
	// look for pdf under wp_upload dir
	add_rewrite_rule('^(.*\.pdf)', wp_upload_dir() . '$1', 'top');
    	do_action( 'qm/debug', wp_upload_dir() );
});

