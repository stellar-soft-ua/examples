<?php
function frequency_add_meta_box()
{
    remove_meta_box('frequency_portsdiv', FREQUENCY_EXTENSION_POST_TYPE, 'side');
    remove_meta_box('frequency_extension_frequencydiv', FREQUENCY_EXTENSION_POST_TYPE, 'side');
    remove_meta_box('frequency_extension_typesdiv', FREQUENCY_EXTENSION_POST_TYPE, 'side');
    remove_meta_box('frequency_extension_variationsdiv', FREQUENCY_EXTENSION_POST_TYPE, 'side');
    add_meta_box('product_meta_box', __('Сharacteristic'), 'frequency_meta_callback',
        FREQUENCY_EXTENSION_POST_TYPE, 'normal', 'high');
    add_meta_box('product_links_meta_box', __('Button Links'), 'frequency_links_meta_callback',
        FREQUENCY_EXTENSION_POST_TYPE, 'normal',
        'high');
    add_meta_box( 'product_frequency_filter', __( 'Extensions Selector' ), 'product_frequency_filter',
        FREQUENCY_EXTENSION_POST_TYPE , 'normal', 'high' );
    add_meta_box('product_app_notes_meta_box', __('Select App Notes'), 'frequency_app_notes_meta_callback',
        FREQUENCY_EXTENSION_POST_TYPE, 'normal', 'high');
    add_meta_box('software_editor_box', __('Software'), 'frequency_software_editor_meta_box',
        FREQUENCY_EXTENSION_POST_TYPE, 'normal', 'high');
    add_meta_box('applications_editor_box', __('Applications'), 'frequency_applications_editor_meta_box',
        FREQUENCY_EXTENSION_POST_TYPE, 'normal', 'low');
    add_meta_box( 'reviews_frequency_block_meta_box', __( 'Reviews block' ), 'reviews_frequency_block_meta_box',
        FREQUENCY_EXTENSION_POST_TYPE , 'normal', 'high' );
    add_meta_box( 'ext_sys_specifications_meta_box', __( 'Specifications' ), 'frequency_extensions_specifications_editor_meta_box', [ FREQUENCY_EXTENSION_POST_TYPE ],
        'normal', 'high' );
}

add_action('add_meta_boxes', 'frequency_add_meta_box');

function product_frequency_filter( $post ){
    ?>
    <label><?php _e( 'Extension type: ', '' ) ?></label></br>
        <?php
        $saved_ext_type    = maybe_unserialize(get_post_meta( $post->ID, 'freq_ext_type', true ));
        $ext_types          = get_terms( [
            'taxonomy'   => FREQUENCY_EXTENSION_TYPE,
            'hide_empty' => false,
            'order'      => 'DESC'
        ] );
        foreach ( $ext_types as $ext_type ) {
            if ( is_array( $saved_ext_type ) && in_array( $ext_type->term_id, $saved_ext_type ) ) {
                $checked = 'checked="checked"';
            } else {
                $checked = null;
            }
            ?>
            <p>
                <input  type="checkbox" name="multval[]" value="<?php echo $ext_type->term_id;?>" <?php echo $checked; ?> />
                <?php echo $ext_type->name;?>
            </p>
            <?php
        }
        ?>
    <br/>
    <br/>

    <label for="freq_ext_variation" class="freq_ext_variation"><?php _e( 'Extension variation:', '' ) ?></label></br>
    <select name="freq_ext_variation">
        <option value=""><?php echo esc_attr( __( 'Select extension variation' ) ); ?></option>
        <?php
        $saved_variation = get_post_meta( $post->ID, 'freq_ext_variation', true );
        $select_options  = '';
        $variations     = get_terms( [
            'taxonomy'   => FREQUENCY_EXTENSION_VARIATIONS,
            'hide_empty' => false,
            'orderby'    => 'id',
            'order'      => 'ASC',
        ] );

        foreach ( $variations as $variation ) {
            $option         = '<option value="' . $variation->name . '">';
            $option         .= $variation->name.'('.$variation->description.')';
            $option         .= '</option>';
            $select_options .= $option;
        }
        $select_options = str_replace( 'value="' . $saved_variation . '"',
            'value="' . $saved_variation . '" selected="selected"', $select_options );
        echo $select_options;
        ?>
    </select>
    </br>
    <?php
}

function frequency_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    $frequencies = get_terms([
        'taxonomy'   => FREQUENCY_EXTENSION_FREQUENCY,
        'hide_empty' => false,
        'orderby'    => 'id',
        'order'      => 'ASC',
    ]);
    ?>


    <label for="product_id" class="product_id"><?php _e('Product ID', '') ?></label>
    <input class="widefat" type="text" name="product_id" id="product_id"
           value="<?php if (isset ($aft_stored_meta['product_id'])) {
               echo $aft_stored_meta['product_id'][0];
           } ?>"/> <br>
    <label for="product_price" class="product_price"><?php _e('Product Price From ($)', '') ?></label>
    <input class="widefat" type="number" name="product_price" id="product_price"
           value="<?php if (isset ($aft_stored_meta['product_price'])) {
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
    <?php if ($aft_stored_meta['in_stock'][0] == true) { ?>checked="checked"<?php } ?> /><?php _e('In Stock?',
    '') ?><br>
    <label for="frequency_min" class="frequency_min"><?php _e('Frequency min(kHz) ', '') ?></label></br>
    <select name="frequency_min">
        <option value=""><?php echo esc_attr(__('Select frequency')); ?></option>
        <?php
        $saved_frequency = get_post_meta($post->ID, 'frequency_min', true);
        $select_options = '';

        foreach ($frequencies as $frequency) {
            $option = '<option value="' . $frequency->name . '">';
            $option .= freguency_converter($frequency->name);
            $option .= '</option>';
            $select_options .= $option;
        }
        $select_options = str_replace('value="' . $saved_frequency . '"',
            'value="' . $saved_frequency . '" selected="selected"', $select_options);
        echo $select_options;
        ?>
    </select>
    </br>

    <label for="frequency_max" class="frequency_max"><?php _e('Frequency max(kHz) ', '') ?></label></br>
    <select name="frequency_max">
        <option value=""><?php echo esc_attr(__('Select frequency')); ?></option>
        <?php
        $saved_frequency = get_post_meta($post->ID, 'frequency_max', true);
        $select_options = '';

        foreach ($frequencies as $frequency) {
            $option = '<option value="' . $frequency->name . '">';
            $option .= freguency_converter($frequency->name);
            $option .= '</option>';
            $select_options .= $option;
        }
        $select_options = str_replace('value="' . $saved_frequency . '"',
            'value="' . $saved_frequency . '" selected="selected"', $select_options);
        echo $select_options;
        ?>
    </select>
    </br>


    <label for="measured_parameters" class="measured_parameters"><?php _e('Measured parameters', '') ?></label>
    <input class="widefat" type="text" name="measured_parameters" id="measured_parameters"
           value="<?php if (isset ($aft_stored_meta['measured_parameters'])) {
               echo $aft_stored_meta['measured_parameters'][0];
           } ?>"/> <br>
    <label for="sweep_types" class="sweep_types"><?php _e('Sweep types', '') ?></label>
    <input class="widefat" type="text" name="sweep_types" id="sweep_types"
           value="<?php if (isset ($aft_stored_meta['sweep_types'])) {
               echo $aft_stored_meta['sweep_types'][0];
           } ?>"/> <br>
    <label for="effective_directivity_dynamic" class="effective_directivity_dynamic"><?php _e('Effective Directivity',
            '') ?></label>
    <input class="widefat" type="text" name="effective_directivity_dynamic" id="effective_directivity_dynamic"
           value="<?php if (isset ($aft_stored_meta['effective_directivity_dynamic'])) {
               echo $aft_stored_meta['effective_directivity_dynamic'][0];
           } ?>"/> <br>
    <label for="effective_directivity" class="effective_directivity"><?php _e('Dynamic range (dB)',
            '') ?></label>
    <input class="widefat" type="number" name="effective_directivity" id="effective_directivity"
           value="<?php if (isset ($aft_stored_meta['effective_directivity'])) {
               echo $aft_stored_meta['effective_directivity'][0];
           } ?>"/> <br>
    <label for="measurement_speed" class="measurement_speed"><?php _e('Measurement speed (µs)',
            '') ?></label>
    <input class="widefat" type="number" name="measurement_speed" id="measurement_speed"
           value="<?php if (isset ($aft_stored_meta['measurement_speed'])) {
               echo $aft_stored_meta['measurement_speed'][0];
           } ?>"/>
    <label for="number_of_ports" class="number_of_ports"><?php _e('Number of Ports: ', '') ?></label></br>
    <select name="number_of_ports">
        <option value=""><?php echo esc_attr(__('Select number of ports')); ?></option>
        <?php
        $saved_ports = get_post_meta($post->ID, 'number_of_ports', true);
        $ports = get_terms([
            'taxonomy'   => FREQUENCY_EXTENSION_PORTS,
            'hide_empty' => false,
            'order'      => 'DESC'
        ]);
        $select_options = '';

        foreach ($ports as $port) {
            $option = '<option value="' . $port->name . '">';
            $option .= $port->name;
            $option .= '</option>';
            $select_options .= $option;
        }
        $select_options = str_replace('value="' . $saved_ports . '"',
            'value="' . $saved_ports . '" selected="selected"', $select_options);
        echo $select_options;
        ?>
    </select>
    <br/>
    <label for="measurement_type" class="measurement_type"><?php _e('Measurement Type: ', '') ?></label></br>
    <?php $select_options = get_post_meta($post->ID, 'measurement_type', true) ?>
    <select name="measurement_type">
        <option value="">Choose measurement type</option>
        <option value="Transmit/Receive" <?php selected($select_options, 'Transmit/Receive'); ?>>Transmit/Receive
        </option>
        <option value="Full S-parameter matrix" <?php selected($select_options, 'Full S-parameter matrix'); ?>>Full
            S-parameter matrix
        </option>
    </select></br>
    <label for="cholesterol" class="cholesterol"><?php _e('Impedance',
            '') ?></label> <br/>
    <input type="radio" class="widefat" name="cholesterol"
           value="50" <?php checked($aft_stored_meta['cholesterol'][0], '50'); ?> /> 50 Ohm <br/>
    <input type="radio" class="widefat" name="cholesterol"
           value="75" <?php checked($aft_stored_meta['cholesterol'][0], '75'); ?> /> 75 Ohm
    <br>
    <br>
    <input class="widefat" type="checkbox" name="auto_related_content" id="auto_related_content"
    <?php if ($aft_stored_meta['auto_related_content'][0] == true) { ?>checked="checked"<?php } ?> /><?php _e('Use Automatic Related Products?',
    '') ?>
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

function frequency_links_meta_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <label for="buy_now" class="buy_now"><?php _e('Buy Now button link', '') ?></label>
    <input class="widefat" type="text" name="buy_now" id="buy_now"
           value="<?php if (isset ($aft_stored_meta['buy_now'])) {
               echo $aft_stored_meta['buy_now'][0];
           } ?>"/> <br>
    <label for="edit_button_1_name" class="edit_button_1_name"><?php _e( 'Edit button1 name', '' ) ?></label>
    <input class="widefat" type="text" name="edit_button_1_name" id="edit_button_1_name"
           value="<?php if ( isset ( $aft_stored_meta['edit_button_1_name'] ) ) {
               echo $aft_stored_meta['edit_button_1_name'][0];
           } ?>"/> <br>
    <label for="edit_button_1_link" class="edit_button_1_link"><?php _e( 'Edit button1 link', '' ) ?></label>
    <input class="widefat" type="text" name="edit_button_1_link" id="edit_button_1_link"
           value="<?php if ( isset ( $aft_stored_meta['edit_button_1_link'] ) ) {
               echo $aft_stored_meta['edit_button_1_link'][0];
           } ?>"/> <br>
    <label for="find_rep" class="find_rep"><?php _e('Find a Rep button link', '') ?></label>
    <input class="widefat" type="text" name="find_rep" id="find_rep"
           value="<?php if (isset ($aft_stored_meta['find_rep'])) {
               echo $aft_stored_meta['find_rep'][0];
           } ?>"/> <br>
    <label for="req_qoute" class="req_qoute"><?php _e('Request a Quote button link', '') ?></label>
    <input class="widefat" type="text" name="req_qoute" id="req_qoute"
           value="<?php if (isset ($aft_stored_meta['req_qoute'])) {
               echo $aft_stored_meta['req_qoute'][0];
           } ?>"/> <br>
    <label for=" btn_try" class="btn_try"><?php _e('Try button link', '') ?></label>
    <input class="widefat" type="text" name="btn_try" id="btn_try"
           value="<?php if (isset ($aft_stored_meta['btn_try'])) {
               echo $aft_stored_meta['btn_try'][0];
           } ?>"/> <br>
    <label for=" btn_download" class="btn_download"><?php _e('Download button link', '') ?></label>
    <input class="widefat" type="text" name="btn_download" id="btn_download"
           value="<?php if (isset ($aft_stored_meta['btn_download'])) {
               echo $aft_stored_meta['btn_download'][0];
           } ?>"/> <br>
    <label for=" btn_documentation" class="btn_documentation"><?php _e('Software/Documentation button link',
            '') ?></label>
    <input class="widefat" type="text" name="btn_documentation" id="btn_documentation"
           value="<?php if (isset ($aft_stored_meta['btn_documentation'])) {
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
    <?php
}

function frequency_video_meta_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="vimeo_video" class="vimeo_video"><?php _e('Video link', '') ?></label>
        <input class="widefat" type="url" name="vimeo_video" id="vimeo_video"
               value="<?php if (isset ($aft_stored_meta['vimeo_video'])) {
                   echo $aft_stored_meta['vimeo_video'][0];
               } ?>"/> <br>
    </p>
    <?php
}

function frequency_testimonial_meta_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <select name="testimonial">
            <option value=""><?php echo esc_attr(__('Select Testimonial')); ?></option>
            <?php
            $saved_cat = get_post_meta($post->ID, 'testimonial', true);
            $categories = get_posts(array('post_type'      => 'testimonial',
                                          'post_status'    => 'publish',
                                          'posts_per_page' => -1
            ));
            $select_options = '';
            foreach ($categories as $category) {
                $option = '<option value="' . $category->ID . '">';
                $option .= $category->post_title;
                $option .= '</option>';
                $select_options .= $option;
            }
            $select_options = str_replace('value="' . $saved_cat . '"',
                'value="' . $saved_cat . '" selected="selected"', $select_options);
            echo $select_options;
            ?>
        </select>
    </p>
    <?php
}

function frequency_app_notes_meta_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <select name="app_note">
            <option value=""><?php echo esc_attr(__('Select App Notes')); ?></option>
            <?php
            $saved_cat = get_post_meta($post->ID, 'app_note', true);
            $categories = get_posts([
                'post_type'      => 'getting-started',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'tax_query'      => [
                    [
                        'taxonomy' => APP_NOTE_CATEGORY,
                        'field'    => 'slug',
                        'terms'    => 'cobalt-fx'
                    ]
                ]
            ]);
            $select_options = '';
            foreach ($categories as $category) {
                $option = '<option value="' . $category->ID . '">';
                $option .= $category->post_title;
                $option .= '</option>';
                $select_options .= $option;
            }
            $select_options = str_replace('value="' . $saved_cat . '"',
                'value="' . $saved_cat . '" selected="selected"', $select_options);
            echo $select_options;
            ?>
        </select>
    </p>
    <?php
}

function frequency_software_editor_meta_box($post)
{

    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');

    $field_value = get_post_meta($post->ID, 'software', false);
    wp_editor($field_value[0], 'software');

}

function frequency_applications_editor_meta_box($post)
{

    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');

    $product_app = get_post_meta($post->ID, 'product_app', false);
    wp_editor($product_app[0], 'product_app');
}

function reviews_frequency_block_meta_box( $post )
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

function frequency_extensions_specifications_editor_meta_box( $post ) {

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

    $specifications = get_post_meta( $post->ID, 'specifications', false );
    wp_editor( $specifications[0], 'specifications' );

}

function frequency_meta_save($post_id)
{

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpaft_nonce']) && wp_verify_nonce($_POST['wpaft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    $postarr_software = str_replace('<ul>', '<ul class="list-text">', $_POST['software']);
    $postarr_software = str_replace('<ol>', '<ol class="list-text">', $postarr_software);
    $postarr_product_app = str_replace('<ul>', '<ul class="list-text">', $_POST['product_app']);
    $postarr_product_app = str_replace('<ol>', '<ol class="list-text">', $postarr_product_app);
    $specifications = str_replace('<ul>', '<ul class="list-text">', $_POST['specifications']);
    $specifications = str_replace('<ol>', '<ol class="list-text">', $specifications);


    update_post_meta($post_id, 'product_id', sanitize_text_field($_POST['product_id']));
    update_post_meta($post_id, 'frequency_min', sanitize_text_field($_POST['frequency_min']));
    update_post_meta($post_id, 'frequency_max', sanitize_text_field($_POST['frequency_max']));
    update_post_meta($post_id, 'measured_parameters', sanitize_text_field($_POST['measured_parameters']));
    update_post_meta($post_id, 'sweep_types', sanitize_text_field($_POST['sweep_types']));
    update_post_meta($post_id, 'effective_directivity', sanitize_text_field($_POST['effective_directivity']));
    update_post_meta($post_id, 'effective_directivity_dynamic',
        sanitize_text_field($_POST['effective_directivity_dynamic']));
    update_post_meta($post_id, 'measurement_speed', sanitize_text_field($_POST['measurement_speed']));
    update_post_meta($post_id, 'buy_now', sanitize_text_field($_POST['buy_now']));
    update_post_meta($post_id, 'edit_button_1_link', sanitize_text_field($_POST['edit_button_1_link']));
    update_post_meta($post_id, 'edit_button_1_name', sanitize_text_field($_POST['edit_button_1_name']));
    update_post_meta($post_id, 'find_rep', sanitize_text_field($_POST['find_rep']));
    update_post_meta($post_id, 'req_qoute', sanitize_text_field($_POST['req_qoute']));
    update_post_meta($post_id, 'btn_try', sanitize_text_field($_POST['btn_try']));
    update_post_meta($post_id, 'btn_download', sanitize_text_field($_POST['btn_download']));
    update_post_meta($post_id, 'vimeo_video', sanitize_text_field($_POST['vimeo_video']));
    update_post_meta($post_id, 'testimonial', sanitize_text_field($_POST['testimonial']));
    update_post_meta($post_id, 'app_note', sanitize_text_field($_POST['app_note']));
    update_post_meta($post_id, 'cholesterol', sanitize_text_field($_POST['cholesterol']));
    update_post_meta($post_id, 'software', $postarr_software);
    update_post_meta($post_id, 'product_app', $postarr_product_app);
    update_post_meta($post_id, 'auto_related_content', $_POST['auto_related_content']);
    update_post_meta($post_id, 'in_stock', $_POST['in_stock']);
    update_post_meta($post_id, 'product_price', $_POST['product_price']);
    update_post_meta($post_id, 'product_price_to', $_POST['product_price_to']);
    update_post_meta($post_id, 'number_of_ports', sanitize_text_field($_POST['number_of_ports']));
    update_post_meta($post_id, 'measurement_type', sanitize_text_field($_POST['measurement_type']));
    update_post_meta($post_id, 'btn_documentation', sanitize_text_field($_POST['btn_documentation']));
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

    update_post_meta( $post_id, 'freq_ext_variation', sanitize_text_field( $_POST['freq_ext_variation'] ) );
    update_post_meta( $post_id, 'specifications', $specifications );

    if ( ! empty( $_POST['multval'] ) ) {
        update_post_meta( $post_id, 'freq_ext_type', $_POST['multval'] );
    } else {
        delete_post_meta( $post_id, 'freq_ext_type' );
    }

}

add_action('save_post', 'frequency_meta_save');
