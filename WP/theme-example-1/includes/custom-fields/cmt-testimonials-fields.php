<?php
function cmt_testimonial_add_meta_box()
{
    remove_meta_box('postimagediv', 'testimonial', 'side');
    add_meta_box('postimagediv', __('Testimonial image'), 'post_thumbnail_meta_box', 'testimonial', 'normal', 'high');
    add_meta_box('cmt_testimonial_meta_id', __('Other information'), 'cmt_testimonials_meta_callback', 'testimonial',
        'normal',
        'high');
}

add_action('add_meta_boxes', 'cmt_testimonial_add_meta_box');

function cmt_testimonials_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="cmt_customer" class="cmt_customer"><?php _e('Customer', '') ?></label>
        <input class="widefat" type="text" name="cmt_customer" id="cmt_customer"
               value="<?php if (isset ($aft_stored_meta['cmt_customer'])) {
                   echo $aft_stored_meta['cmt_customer'][0];
               } ?>"/> <br>
    </p>
    <p>
        <label for="cmt_company" class="cmt_company"><?php _e('Company', '') ?></label>
        <input class="widefat" type="text" name="cmt_company" id="cmt_company"
               value="<?php if (isset ($aft_stored_meta['cmt_company'])) {
                   echo $aft_stored_meta['cmt_company'][0];
               } ?>"/> <br>
    </p>
    <p>
        <label for="cmt_customer_website" class="cmt_customer_website"><?php _e('Customer website', '') ?></label>
        <input class="widefat" type="text" name="cmt_customer_website" id="cmt_customer_website"
               value="<?php if (isset ($aft_stored_meta['cmt_customer_website'])) {
                   echo $aft_stored_meta['cmt_customer_website'][0];
               } ?>"/> <br>
    </p>
    <?php

}

function cmt_testimonial_meta_save($post_id)
{

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpaft_nonce']) && wp_verify_nonce($_POST['wpaft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['cmt_customer'])) {
        update_post_meta($post_id, 'cmt_customer',
            sanitize_text_field($_POST['cmt_customer']));
    }

    if (isset($_POST['cmt_company'])) {
        update_post_meta($post_id, 'cmt_company', sanitize_text_field($_POST['cmt_company']));
    }

    if (isset($_POST['cmt_customer_website'])) {
        update_post_meta($post_id, 'cmt_customer_website', sanitize_text_field($_POST['cmt_customer_website']));
    }

}

add_action('save_post', 'cmt_testimonial_meta_save');
