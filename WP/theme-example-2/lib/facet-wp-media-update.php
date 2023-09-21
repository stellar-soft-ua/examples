<?php
/**
 *   Do something when a new book is created
 */
function indexPost($post_id, $post, $update) {
    if (function_exists('FWP')) {
        FWP()->indexer->index( $post_id );
    }
}

function indexAttachment($post_id, $post_after, $post_before) {
    if (function_exists('FWP')) {
        FWP()->indexer->index( $post_id );
    }
}

add_action( 'attachment_updated', 'indexAttachment', 10, 3 );
add_action( 'save_post', 'indexPost', 10, 3 );
