<?php
function getting_started_add_meta_box() {
    add_meta_box( 'getting_started_editor_box', __( 'Buttons' ), 'getting_started_editor_meta_box',
        GETTING_STARTED_POST_TYPE, 'normal', 'high' );
}

add_action( 'add_meta_boxes', 'getting_started_add_meta_box' );

function getting_started_editor_meta_box( $post ) {

    wp_nonce_field( plugin_basename( __FILE__ ), 'getting_started_noncename' );

    $leadership_stored_meta = get_post_meta( $post->ID );
    ?>
    <label for="getting_started_button_name" class="getting_started_button_name"><?php _e( 'Button name',
            '' ) ?></label>
    <input class="widefat" type="text" name="getting_started_button_name" id="getting_started_button_name"
           value="<?php if ( isset ( $leadership_stored_meta['getting_started_button_name'] ) ) {
               echo $leadership_stored_meta['getting_started_button_name'][0];
           } ?>"/> <br>
    <label for="getting_started_button_link" class="getting_started_button_link"><?php _e( 'Button link',
            '' ) ?></label>
    <input class="widefat" type="text" name="getting_started_button_link" id="getting_started_button_link"
           value="<?php if ( isset ( $leadership_stored_meta['getting_started_button_link'] ) ) {
               echo $leadership_stored_meta['getting_started_button_link'][0];
           } ?>"/> <br>
    <?php

}

add_action( 'save_post', 'cmt_getting_started_meta_save' );

function cmt_getting_started_meta_save( $post_id ) {
    $is_autosave    = wp_is_post_autosave( $post_id );
    $is_revision    = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['getting_started_noncename'] ) && wp_verify_nonce( $_POST['getting_started_noncename'],
            basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    update_post_meta( $post_id, 'getting_started_button_name',
        sanitize_text_field( $_POST['getting_started_button_name'] ) );
    update_post_meta( $post_id, 'getting_started_button_link',
        sanitize_text_field( $_POST['getting_started_button_link'] ) );
}