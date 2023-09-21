<?php
function cal_kits_add_meta_box() {
    remove_meta_box( 'calibration_kits_portsdiv', CALIBRATION_KITS_POST_TYPE, 'side' );
    remove_meta_box( 'calibration_kits_typesdiv', CALIBRATION_KITS_POST_TYPE, 'side' );
    remove_meta_box( 'calibration_kits_lengthdiv', CALIBRATION_KITS_POST_TYPE, 'side' );
    remove_meta_box( 'calibration_kits_compatible_proddiv', CALIBRATION_KITS_POST_TYPE, 'side' );
    add_meta_box( 'specifications_meta_box', __( 'Specifications' ), 'cal_kits_specifications_editor_meta_box', [ CALIBRATION_KITS_POST_TYPE ],
        'normal', 'high' );
    add_meta_box( 'product_links_meta_box', __( 'Button Links' ), 'cal_kits_links_meta_callback',
        [ CALIBRATION_KITS_POST_TYPE ], 'normal', 'high' );
    add_meta_box( 'software_editor_box', __( 'Software' ), 'cal_kits_software_editor_meta_box',
        [ CALIBRATION_KITS_POST_TYPE ], 'normal', 'high' );
    add_meta_box( 'applications_editor_box', __( 'Applications' ), 'cal_kits_applications_editor_meta_box',
        [ CALIBRATION_KITS_POST_TYPE ], 'normal', 'low' );
    add_meta_box( 'product_meta_box', __( 'Сharacteristic' ), 'cal_kits_meta_callback', [ CALIBRATION_KITS_POST_TYPE ],
        'normal', 'high' );
    add_meta_box( 'reviews_cal_kits_block_meta_box', __( 'Reviews block' ), 'reviews_cal_kits_block_meta_box',
        CALIBRATION_KITS_POST_TYPE , 'normal', 'high' );
}

add_action( 'add_meta_boxes', 'cal_kits_add_meta_box' );

function cal_kits_meta_callback( $post ) {

    wp_nonce_field( basename( __FILE__ ), 'aft_nonce' );
    $aft_stored_meta = get_post_meta( $post->ID );
    ?>


    <label for="product_id" class="product_id"><?php _e( 'Product ID', '' ) ?></label>
    <input class="widefat" type="text" name="product_id" id="product_id"
           value="<?php if ( isset ( $aft_stored_meta['product_id'] ) ) {
               echo $aft_stored_meta['product_id'][0];
           } ?>"/> <br>
    <label for="product_price" class="product_price"><?php _e( 'Product Price ($)', '' ) ?></label>
    <input class="widefat" type="number" name="product_price" id="product_price"
           value="<?php if ( isset ( $aft_stored_meta['product_price'] ) ) {
               echo $aft_stored_meta['product_price'][0];
           } ?>" step="any"/>
    <small></small>
    <br>
    <label for="product_price_to" class="product_price_to"><?php _e('Product Price To ($)', '') ?></label>
    <input class="widefat" type="number" name="product_price_to" id="product_price_to"
           value="<?php if (isset ($aft_stored_meta['product_price_to'])) {
               echo $aft_stored_meta['product_price_to'][0];
           } ?>" step="any"/>
    <small></small>
    <br>
    <br>
    <input class="widefat" type="checkbox" name="in_stock" id="in_stock"
    <?php if ( $aft_stored_meta['in_stock'][0] == true ) { ?>checked="checked"<?php } ?> /><?php _e( 'In Stock?',
        '' ) ?><br>

    <?php
    $frequency_min  = get_post_meta( $post->ID, 'frequency_min',
        true ); //true ensures you get just one value instead of an array
    $_frequency_min = get_terms( [
        'taxonomy'   => CALIBRATION_KITS_AND_ACCESSORIES_FREQUENCY,
        'hide_empty' => false,
    ] );
    ?>
    <label>Frequency min (kHz) </label>
    </br>
    <select name="frequency_min" id="frequency_min">
        <option value disabled selected>Frequency min (kHz)</option>
        <?php foreach ( $_frequency_min as $__frequency_min ): ?>
            <option value=<?= $__frequency_min->slug ?> <?php selected( $frequency_min,
                $__frequency_min->slug ); ?>><?= freguency_converter( $__frequency_min->name ) ?></option>
        <?php endforeach; ?>
    </select>

    <?php
    $frequency_max  = get_post_meta( $post->ID, 'frequency_max',
        true ); //true ensures you get just one value instead of an array
    $_frequency_max = get_terms( [
        'taxonomy'   => CALIBRATION_KITS_AND_ACCESSORIES_FREQUENCY,
        'hide_empty' => false,
    ] );
    ?>
    </br>
    <label>Frequency max (kHz) </label>
    </br>
    <select name="frequency_max" id="frequency_max">
        <option value disabled selected>Frequency max (kHz)</option>
        <?php foreach ( $_frequency_max as $__frequency_max ): ?>
            <option value=<?= $__frequency_max->slug ?> <?php selected( $frequency_max,
                $__frequency_max->slug ); ?>><?= freguency_converter( $__frequency_max->name ) ?></option>
        <?php endforeach; ?>
    </select>
    </br>
    <label for="measured_parameters" class="measured_parameters"><?php _e( 'Measured parameters', '' ) ?></label>
    <input class="widefat" type="text" name="measured_parameters" id="measured_parameters"
           value="<?php if ( isset ( $aft_stored_meta['measured_parameters'] ) ) {
               echo $aft_stored_meta['measured_parameters'][0];
           } ?>"/> <br>
    <label for="sweep_types" class="sweep_types"><?php _e( 'Sweep types', '' ) ?></label>
    <input class="widefat" type="text" name="sweep_types" id="sweep_types"
           value="<?php if ( isset ( $aft_stored_meta['sweep_types'] ) ) {
               echo $aft_stored_meta['sweep_types'][0];
           } ?>"/> <br>
    <label for="effective_directivity_dynamic" class="effective_directivity_dynamic"><?php _e( 'Effective Directivity',
            '' ) ?></label>
    <input class="widefat" type="text" name="effective_directivity_dynamic" id="effective_directivity_dynamic"
           value="<?php if ( isset ( $aft_stored_meta['effective_directivity_dynamic'] ) ) {
               echo $aft_stored_meta['effective_directivity_dynamic'][0];
           } ?>"/> <br>
    <label for="measurement_speed" class="measurement_speed"><?php _e( 'Measurement speed (µs)',
            '' ) ?></label>
    <input class="widefat" type="number" name="measurement_speed" id="measurement_speed"
           value="<?php if ( isset ( $aft_stored_meta['measurement_speed'] ) ) {
               echo $aft_stored_meta['measurement_speed'][0];
           } ?>"/>
    <label for="cholesterol" class="cholesterol"><?php _e( 'Impedance',
            '' ) ?></label> <br/>
    <input type="radio" class="widefat" name="cholesterol"
           value="50" <?php checked( $aft_stored_meta['cholesterol'][0], '50' ); ?> /> 50 Ohm <br/>
    <input type="radio" class="widefat" name="cholesterol"
           value="75" <?php checked( $aft_stored_meta['cholesterol'][0], '75' ); ?> /> 75 Ohm
    <br>
    <br>
    <input class="widefat" type="checkbox" name="auto_related_content" id="auto_related_content"
    <?php if ( $aft_stored_meta['auto_related_content'][0] == true ) { ?>checked="checked"<?php } ?> /><?php _e( 'Use Automatic Related Products?',
        '' ) ?>
    <?php
    $meta_element_class = get_post_meta( $post->ID, 'number_of_ports',
        true ); //true ensures you get just one value instead of an array
    $_number_of_portss  = get_terms( [
        'taxonomy'   => CALIBRATION_KITS_AND_ACCESSORIES_PORTS,
        'hide_empty' => false,
    ] );
    ?>
    </br>
    </br>
    <label>Number of ports: </label>
    </br>
    <select name="number_of_ports" id="number_of_ports">
        <option value disabled selected>Number of ports</option>
        <?php foreach ( $_number_of_portss as $_number_of_ports ): ?>
            <option value=<?= $_number_of_ports->slug ?> <?php selected( $meta_element_class,
                $_number_of_ports->slug ); ?>><?= $_number_of_ports->name ?></option>
        <?php endforeach; ?>
    </select>
    <?php
    $cal_kits_type   = get_post_meta( $post->ID, 'cal_kits_type',
        true ); //true ensures you get just one value instead of an array
    $_cal_kits_types = get_terms( [
        'taxonomy'   => CALIBRATION_KITS_AND_ACCESSORIES_TYPES,
        'hide_empty' => false,
    ] );
    ?>
    </br>
    </br>
    <label>Calibration Kit Type: </label>
    </br>
    <select name="cal_kits_type" id="cal_kits_type">
        <option value disabled selected>Calibration Kit Type</option>
        <?php foreach ( $_cal_kits_types as $_cal_kits_type ): ?>
            <option value=<?= $_cal_kits_type->slug ?> <?php selected( $cal_kits_type,
                $_cal_kits_type->slug ); ?>><?= $_cal_kits_type->name ?></option>
        <?php endforeach; ?>
    </select>
    <?php
    $cal_kits_length   = get_post_meta( $post->ID, 'cal_kits_length',
        true ); //true ensures you get just one value instead of an array
    $_cal_kits_lengths = get_terms( [
        'taxonomy'   => CALIBRATION_KITS_AND_ACCESSORIES_LENGTH,
        'hide_empty' => false,
    ] );
    ?>
    </br>
    </br>
    <label>Length: </label>
    </br>
    <select name="cal_kits_length" id="cal_kits_length">
        <option value disabled selected>Length</option>
        <?php foreach ( $_cal_kits_lengths as $_cal_kits_length ): ?>
            <option value=<?= $_cal_kits_length->slug ?> <?php selected( $cal_kits_length,
                $_cal_kits_length->slug ); ?>><?= $_cal_kits_length->name ?></option>
        <?php endforeach; ?>
    </select>

    <?php
    $cal_kits_compatible_products  = get_post_meta( $post->ID, 'cal_kits_compatible_products',
        false ); //true ensures you get just one value instead of an array
    $_cal_kits_compatible_products = get_terms( [
        'taxonomy'   => CALIBRATION_KITS_AND_ACCESSORIES_PRODUCTS,
        'hide_empty' => false,
    ] );
    ?>
    </br>
    </br>
    <label>Compatible Products: </label>
    </br>
    <select name="cal_kits_compatible_products[]" id="cal_kits_compatible_products" multiple="multiple">
        <?php foreach ( $_cal_kits_compatible_products as $_cal_kits_compatible_product ): ?>
            <option value=<?= $_cal_kits_compatible_product->slug ?> <?php selected( $cal_kits_compatible_products,
                $_cal_kits_compatible_product->slug ); ?>><?= $_cal_kits_compatible_product->name ?></option>
        <?php endforeach; ?>
    </select>
    </br>
    <label for="product_tag" class="product_tag"><?php _e( 'Product Tag: ', '' ) ?></label></br>
    <?php $select_options = get_post_meta( $post->ID, 'product_tag', true ) ?>
    <select name="product_tag">
        <option value="">Choose product tag</option>
        <option value="new" <?php selected( $select_options, 'new' ); ?>>New</option>
        <option value="end-of-sale" <?php selected( $select_options, 'end-of-sale' ); ?>>End of Sale</option>
        <option value="discontinued" <?php selected( $select_options, 'discontinued' ); ?>>Discontinued</option>
    </select>
    </br>
    <?php

}

function cal_kits_links_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'aft_nonce' );
    $aft_stored_meta = get_post_meta( $post->ID );

    ?>
    <p>
        <label for="buy_now" class="buy_now"><?php _e( 'Buy Now button link', '' ) ?></label>
        <input class="widefat" type="text" name="buy_now" id="buy_now"
               value="<?php if ( isset ( $aft_stored_meta['buy_now'] ) ) {
                   echo $aft_stored_meta['buy_now'][0];
               } ?>"/> <br>
        <label for="find_rep" class="find_rep"><?php _e( 'Find a Rep button link', '' ) ?></label>
        <input class="widefat" type="text" name="find_rep" id="find_rep"
               value="<?php if ( isset ( $aft_stored_meta['find_rep'] ) ) {
                   echo $aft_stored_meta['find_rep'][0];
               } ?>"/> <br>
        <label for="req_qoute" class="req_qoute"><?php _e( 'Request a Quote button link', '' ) ?></label>
        <input class="widefat" type="text" name="req_qoute" id="req_qoute"
               value="<?php if ( isset ( $aft_stored_meta['req_qoute'] ) ) {
                   echo $aft_stored_meta['req_qoute'][0];
               } ?>"/> <br>
        <label for=" btn_try" class="btn_try"><?php _e( 'Try button link', '' ) ?></label>
        <input class="widefat" type="text" name="btn_try" id="btn_try"
               value="<?php if ( isset ( $aft_stored_meta['btn_try'] ) ) {
                   echo $aft_stored_meta['btn_try'][0];
               } ?>"/> <br>
        <label for=" btn_download" class="btn_download"><?php _e( 'Download button link', '' ) ?></label>
        <input class="widefat" type="text" name="btn_download" id="btn_download"
               value="<?php if ( isset ( $aft_stored_meta['btn_download'] ) ) {
                   echo $aft_stored_meta['btn_download'][0];
               } ?>"/> <br>
        <label for=" btn_documentation" class="btn_documentation"><?php _e( 'Software/Documentation button link', '' ) ?></label>
        <input class="widefat" type="text" name="btn_documentation" id="btn_documentation"
               value="<?php if ( isset ( $aft_stored_meta['btn_documentation'] ) ) {
                   echo $aft_stored_meta['btn_documentation'][0];
               } ?>"/> <br>

        <label for="_refurbished__button_name" class="_refurbished__button_name"><?php _e( 'View Refurbished Products Button Name', '' ) ?></label>
        <input class="widefat" type="text" name="_refurbished__button_name" id="_refurbished__button_name"
               value="<?php if ( isset ( $aft_stored_meta['_refurbished__button_name'] ) ) {
                   echo $aft_stored_meta['_refurbished__button_name'][0];
               } ?>"/> <br>

        <label for="_refurbished__button_link" class="_refurbished__button_link"><?php _e( 'View Refurbished Products Button Link', '' ) ?></label>
        <input class="widefat" type="text" name="_refurbished__button_link" id="_refurbished__button_link"
               value="<?php if ( isset ( $aft_stored_meta['_refurbished__button_link'] ) ) {
                   echo $aft_stored_meta['_refurbished__button_link'][0];
               } ?>"/> <br>
    </p>
    <?php
}

function cal_kits_video_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'aft_nonce' );
    $aft_stored_meta = get_post_meta( $post->ID );
    ?>
    <p>
        <label for="vimeo_video" class="vimeo_video"><?php _e( 'Video link', '' ) ?></label>
        <input class="widefat" type="url" name="vimeo_video" id="vimeo_video"
               value="<?php if ( isset ( $aft_stored_meta['vimeo_video'] ) ) {
                   echo $aft_stored_meta['vimeo_video'][0];
               } ?>"/> <br>
    </p>
    <?php
}

function cal_kits_testimonial_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'aft_nonce' );
    $aft_stored_meta = get_post_meta( $post->ID );
    ?>
    <p>
        <select name="testimonial">
            <option value=""><?php echo esc_attr( __( 'Select Testimonial' ) ); ?></option>
            <?php
            $saved_cat      = get_post_meta( $post->ID, 'testimonial', true );
            $categories     = get_posts( array( 'post_type' => 'testimonial', 'post_status' => 'publish', 'posts_per_page' => -1 ) );
            $select_options = '';
            foreach ( $categories as $category ) {
                $option         = '<option value="' . $category->ID . '">';
                $option         .= $category->post_title;
                $option         .= '</option>';
                $select_options .= $option;
            }
            $select_options = str_replace( 'value="' . $saved_cat . '"',
                'value="' . $saved_cat . '" selected="selected"', $select_options );
            echo $select_options;
            ?>
        </select>
    </p>
    <?php
}

function cal_kits_software_editor_meta_box( $post ) {

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

    $field_value = get_post_meta( $post->ID, 'software', false );
    wp_editor( $field_value[0], 'software' );

}

function cal_kits_specifications_editor_meta_box( $post ) {

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

    $specifications = get_post_meta( $post->ID, 'specifications', false );
    wp_editor( $specifications[0], 'specifications' );

}

function cal_kits_applications_editor_meta_box( $post ) {

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

    $product_app = get_post_meta( $post->ID, 'product_app', false );
    wp_editor( $product_app[0], 'product_app' );
}

function reviews_cal_kits_block_meta_box( $post )
{
    wp_nonce_field( basename( __FILE__ ), 'aft_nonce' );
    $aft_stored_meta = get_post_meta( $post->ID );
    ?>
    <div class="review-block-container">
        <label for="_review_software_title" class="_review_software_title"><?php _e( 'App notes title:', '' ) ?></label>
        <input class="widefat" type="text" name="_review_software_title" id="_review_software_title"
               value="<?php if ( isset ( $aft_stored_meta['_review_software_title'] ) ) {
                   echo $aft_stored_meta['_review_software_title'][0];
               } ?>"/> <br>
        <label for="_review_software_link" class="_review_software_link"><?php _e( 'App notes link:', '' ) ?></label>
        <input class="widefat" type="text" name="_review_software_link" id="_review_software_link"
               value="<?php if ( isset ( $aft_stored_meta['_review_software_link'] ) ) {
                   echo $aft_stored_meta['_review_software_link'][0];
               } ?>"/> <br>
        <label for="_review_software_btn_name" class="_review_software_btn_name"><?php _e( 'App notes button name:', '' ) ?></label>
        <input class="widefat" type="text" name="_review_software_btn_name" id="_review_software_btn_name"
               value="<?php if ( isset ( $aft_stored_meta['_review_software_btn_name'] ) ) {
                   echo $aft_stored_meta['_review_software_btn_name'][0];
               } ?>"/> <br>
        <div class="review-software-image">
            <label for="_review_software_image" class="_review_software_image"><?php _e( 'App notes image:', '' ) ?></label>
            <img style="max-width:200px;height:auto;" id="meta-image-preview" src="<?php if ( isset ( $aft_stored_meta['_review_software_image'] ) ){ echo $aft_stored_meta['_review_software_image'][0]; } ?>" />
            <input type="text" name="_review_software_image" id="_review_software_image" class="_review_software_image" value="<?php if ( isset ( $aft_stored_meta['_review_software_image'] ) ){ echo $aft_stored_meta['_review_software_image'][0]; } ?>" />
            <input type="button" id="meta-image-button" class="button" value="Choose or Upload an Image" />
        </div>
    </div>

    <div class="review-block-container">
        <label for="_review_title" class="_review_title"><?php _e( 'Quotes title:', '' ) ?></label>
        <input class="widefat" type="text" name="_review_title" id="_review_title"
               value="<?php if ( isset ( $aft_stored_meta['_review_title'] ) ) {
                   echo $aft_stored_meta['_review_title'][0];
               } ?>"/> <br>
        <label for="_review_link" class="_review_link"><?php _e( 'Quotes link:', '' ) ?></label>
        <input class="widefat" type="text" name="_review_link" id="_review_link"
               value="<?php if ( isset ( $aft_stored_meta['_review_link'] ) ) {
                   echo $aft_stored_meta['_review_link'][0];
               } ?>"/> <br>
        <label for="_review_btn_name" class="_review_btn_name"><?php _e( 'Quotes button name:', '' ) ?></label>
        <input class="widefat" type="text" name="_review_btn_name" id="_review_software_btn_name"
               value="<?php if ( isset ( $aft_stored_meta['_review_btn_name'] ) ) {
                   echo $aft_stored_meta['_review_btn_name'][0];
               } ?>"/> <br>
        <div class="review-software-image">
            <label for="_review_image" class="_review_image"><?php _e( 'Quotes image:', '' ) ?></label>
            <img style="max-width:200px;height:auto;" id="review-meta-image-preview" src="<?php if ( isset ( $aft_stored_meta['_review_image'] ) ){ echo $aft_stored_meta['_review_image'][0]; } ?>" />
            <input type="text" name="_review_image" id="_review_image" class="_review_image" value="<?php if ( isset ( $aft_stored_meta['_review_image'] ) ){ echo $aft_stored_meta['_review_image'][0]; } ?>" />
            <input type="button" id="review-meta-image-button" class="button" value="Choose or Upload an Image" />
        </div>
    </div>

    <div class="review-block-container">
        <label for="_video_title" class="_review_title"><?php _e( 'Video title:', '' ) ?></label>
        <input class="widefat" type="text" name="_video_title" id="_video_title"
               value="<?php if ( isset ( $aft_stored_meta['_video_title'] ) ) {
                   echo $aft_stored_meta['_video_title'][0];
               } ?>"/> <br>
        <label for="_video_link" class="_review_link"><?php _e( 'Video link:', '' ) ?></label>
        <input class="widefat" type="text" name="_video_link" id="_video_link"
               value="<?php if ( isset ( $aft_stored_meta['_video_link'] ) ) {
                   echo $aft_stored_meta['_video_link'][0];
               } ?>"/> <br>
        <label for="_video_btn_name" class="_video_btn_name"><?php _e( 'Video button name:', '' ) ?></label>
        <input class="widefat" type="text" name="_video_btn_name" id="_video_btn_name"
               value="<?php if ( isset ( $aft_stored_meta['_video_btn_name'] ) ) {
                   echo $aft_stored_meta['_video_btn_name'][0];
               } ?>"/> <br>
        <div class="review-software-image">
            <label for="_video_image" class="_video_image"><?php _e( 'Video image:', '' ) ?></label>
            <img style="max-width:200px;height:auto;" id="video-meta-image-preview" src="<?php if ( isset ( $aft_stored_meta['_video_image'] ) ){ echo $aft_stored_meta['_video_image'][0]; } ?>" />
            <input type="text" name="_video_image" id="_video_image" class="_video_image" value="<?php if ( isset ( $aft_stored_meta['_video_image'] ) ){ echo $aft_stored_meta['_video_image'][0]; } ?>" />
            <input type="button" id="video-meta-image-button" class="button" value="Choose or Upload an Image" />
        </div>
    </div>

    <div class="review-block-container">
        <input class="widefat" type="checkbox" name="show_video" id="show_video"
               <?php if ( $aft_stored_meta['show_video'][0] == true ) { ?>checked="checked"<?php } ?> /><?php _e( 'Show only video',
            '' ) ?><br>
        <label for="vimeo_video" class="vimeo_video"><?php _e( 'Embed video link', '' ) ?></label>
        <input class="widefat" type="url" name="vimeo_video" id="vimeo_video"
               value="<?php if ( isset ( $aft_stored_meta['vimeo_video'] ) ) {
                   echo $aft_stored_meta['vimeo_video'][0];
               } ?>"/> <br>
    </div>
    <?php
}

function cal_kits_meta_save( $post_id ) {

    $is_autosave    = wp_is_post_autosave( $post_id );
    $is_revision    = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['wpaft_nonce'] ) && wp_verify_nonce( $_POST['wpaft_nonce'],
            basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
        return;
    }

    $postarr_software = str_replace('<ul>', '<ul class="list-text">', $_POST['software']);
    $postarr_software = str_replace('<ol>', '<ol class="list-text">', $postarr_software);
    $postarr_product_app = str_replace('<ul>', '<ul class="list-text">', $_POST['product_app']);
    $postarr_product_app = str_replace('<ol>', '<ol class="list-text">', $postarr_product_app);
    $specifications = str_replace('<ul>', '<ul class="list-text">', $_POST['specifications']);
    $specifications = str_replace('<ol>', '<ol class="list-text">', $specifications);

    update_post_meta( $post_id, 'product_id', sanitize_text_field( $_POST['product_id'] ) );
    update_post_meta( $post_id, 'frequency_min', sanitize_text_field( $_POST['frequency_min'] ) );
    update_post_meta( $post_id, 'frequency_max', sanitize_text_field( $_POST['frequency_max'] ) );
    update_post_meta( $post_id, 'measured_parameters', sanitize_text_field( $_POST['measured_parameters'] ) );
    update_post_meta( $post_id, 'sweep_types', sanitize_text_field( $_POST['sweep_types'] ) );
    update_post_meta( $post_id, 'effective_directivity', sanitize_text_field( $_POST['effective_directivity'] ) );
    update_post_meta( $post_id, 'effective_directivity_dynamic',
        sanitize_text_field( $_POST['effective_directivity_dynamic'] ) );
    update_post_meta( $post_id, 'measurement_speed', sanitize_text_field( $_POST['measurement_speed'] ) );
    update_post_meta( $post_id, 'buy_now', sanitize_text_field( $_POST['buy_now'] ) );
    update_post_meta( $post_id, 'find_rep', sanitize_text_field( $_POST['find_rep'] ) );
    update_post_meta( $post_id, 'req_qoute', sanitize_text_field( $_POST['req_qoute'] ) );
    update_post_meta( $post_id, 'btn_try', sanitize_text_field( $_POST['btn_try'] ) );
    update_post_meta( $post_id, 'btn_download', sanitize_text_field( $_POST['btn_download'] ) );
    update_post_meta( $post_id, 'vimeo_video', sanitize_text_field( $_POST['vimeo_video'] ) );
    update_post_meta( $post_id, 'testimonial', sanitize_text_field( $_POST['testimonial'] ) );
    update_post_meta( $post_id, 'cholesterol', sanitize_text_field( $_POST['cholesterol'] ) );
    update_post_meta( $post_id, 'software', $postarr_software );
    update_post_meta( $post_id, 'product_app', $postarr_product_app );
    update_post_meta( $post_id, 'specifications', $specifications );
    update_post_meta( $post_id, 'auto_related_content', $_POST['auto_related_content'] );
    update_post_meta( $post_id, 'in_stock', $_POST['in_stock'] );
    update_post_meta( $post_id, 'product_price', $_POST['product_price'] );
    update_post_meta( $post_id, 'product_price_to', $_POST['product_price_to'] );
    update_post_meta( $post_id, 'number_of_ports', $_POST['number_of_ports'] );
    update_post_meta( $post_id, 'cal_kits_type', $_POST['cal_kits_type'] );
    update_post_meta( $post_id, 'cal_kits_length', $_POST['cal_kits_length'] );
    update_post_meta( $post_id, 'cal_kits_compatible_products', $_POST['cal_kits_compatible_products'] );
    update_post_meta( $post_id, 'btn_documentation', sanitize_text_field( $_POST['btn_documentation'] ) );
    update_post_meta( $post_id, '_refurbished__button_link', sanitize_text_field( $_POST['_refurbished__button_link'] ) );
    update_post_meta( $post_id, '_refurbished__button_name', sanitize_text_field( $_POST['_refurbished__button_name'] ) );
    update_post_meta( $post_id, 'product_tag', sanitize_text_field( $_POST['product_tag'] ) );

    update_post_meta( $post_id, '_review_software_image', sanitize_text_field( $_POST['_review_software_image'] ) );
    update_post_meta( $post_id, '_review_software_title', sanitize_text_field( $_POST['_review_software_title'] ) );
    update_post_meta( $post_id, '_review_software_link', sanitize_text_field( $_POST['_review_software_link'] ) );
    update_post_meta( $post_id, '_review_software_btn_name', sanitize_text_field( $_POST['_review_software_btn_name'] ) );

    update_post_meta( $post_id, '_review_title', sanitize_text_field( $_POST['_review_title'] ) );
    update_post_meta( $post_id, '_review_link', sanitize_text_field( $_POST['_review_link'] ) );
    update_post_meta( $post_id, '_review_image', sanitize_text_field( $_POST['_review_image'] ) );
    update_post_meta( $post_id, '_review_btn_name', sanitize_text_field( $_POST['_review_btn_name'] ) );

    update_post_meta( $post_id, '_video_title', sanitize_text_field( $_POST['_video_title'] ) );
    update_post_meta( $post_id, '_video_link', sanitize_text_field( $_POST['_video_link'] ) );
    update_post_meta( $post_id, '_video_image', sanitize_text_field( $_POST['_video_image'] ) );
    update_post_meta( $post_id, '_video_btn_name', sanitize_text_field( $_POST['_video_btn_name'] ) );

    update_post_meta( $post_id, 'show_video', sanitize_text_field( $_POST['show_video'] ) );
}

add_action( 'save_post', 'cal_kits_meta_save' );
