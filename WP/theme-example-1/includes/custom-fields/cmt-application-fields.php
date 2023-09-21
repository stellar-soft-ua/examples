<?php
function cmt_application_add_meta_box()
{
    remove_meta_box('postimagediv', 'testimonial', 'side');
    add_meta_box('postimagediv', __('Application image'), 'post_thumbnail_meta_box', 'application', 'normal', 'high');
    add_meta_box('cmt_application_meta_id', __('Button settings'), 'cmt_application_meta_callback', 'application', 'normal', 'high');
    add_meta_box('cmt_application_testimonial_id', __('Testimonial button settings'), 'cmt_application_testimonial_btn_callback', 'application', 'normal', 'high');

}

add_action('add_meta_boxes', 'cmt_application_add_meta_box');

function cmt_application_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="cmt_app_btn_text" class="cmt_app_btn_text"><?php _e('Button text', '') ?></label>
        <input class="widefat" type="text" name="cmt_app_btn_text" id="cmt_app_btn_text"
               value="<?php if (isset ($aft_stored_meta['cmt_app_btn_text'])) {
                   echo $aft_stored_meta['cmt_app_btn_text'][0];
               } ?>"/> <br>
    </p>
    <p>
        <label for="cmt_app_btn_link" class="cmt_app_btn_link"><?php _e('Button link', '') ?></label>
        <input class="widefat" type="text" name="cmt_app_btn_link" id="cmt_app_btn_link"
               value="<?php if (isset ($aft_stored_meta['cmt_app_btn_link'])) {
                   echo $aft_stored_meta['cmt_app_btn_link'][0];
               } ?>"/> <br>
    </p>
    <?php

}

function cmt_application_testimonial_btn_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="cmt_testimonial_btn_text" class="cmt_testimonial_btn_text"><?php _e('Button text', '') ?></label>
        <input class="widefat" type="text" name="cmt_testimonial_btn_text" id="cmt_testimonial_btn_text"
               value="<?php if (isset ($aft_stored_meta['cmt_testimonial_btn_text'])) {
                   echo $aft_stored_meta['cmt_testimonial_btn_text'][0];
               } ?>"/> <br>
    </p>
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

function cmt_application_meta_save($post_id)
{

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpaft_nonce']) && wp_verify_nonce($_POST['wpaft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['cmt_app_btn_text'])) {
        update_post_meta($post_id, 'cmt_app_btn_text',
            sanitize_text_field($_POST['cmt_app_btn_text']));
    }

    if (isset($_POST['cmt_app_btn_link'])) {
        update_post_meta($post_id, 'cmt_app_btn_link', sanitize_text_field($_POST['cmt_app_btn_link']));
    }

    if (isset($_POST['cmt_testimonial_btn_text'])) {
        update_post_meta($post_id, 'cmt_testimonial_btn_text', sanitize_text_field($_POST['cmt_testimonial_btn_text']));
    }

    if (isset($_POST['testimonial'])) {
        update_post_meta( $post_id, 'testimonial', sanitize_text_field( $_POST['testimonial'] ) );
    }



}

add_action('save_post', 'cmt_application_meta_save');
