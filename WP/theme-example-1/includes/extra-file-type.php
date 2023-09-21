<?php
add_filter( 'upload_mimes', 'my_myme_types', 1, 1 );
function my_myme_types( $mime_types ) {
    $mime_types['exe'] = 'application/octet-stream';
    $mime_types['txt'] = 'text/plain';
    $mime_types['sta'] = 'application/x-photoshop';
    $mime_types['cfg'] = 'application/octet-stream';
    $mime_types['ckd'] = 'application/octet-stream';

    return $mime_types;
}