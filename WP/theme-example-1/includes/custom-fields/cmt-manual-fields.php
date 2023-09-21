<?php


add_action('add_meta_boxes', 'cmt_manual_add_meta_box');

function cmt_manual_add_meta_box()
{
    add_meta_box('manual_url', __('Manual Url'), 'cmt_manual_meta_callback', 'manual', 'normal', 'high');
}


function cmt_manual_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>

    <p>
        <label for="manual_url" class="manual_url"><?php _e('Manual Url*:', '') ?></label>
        <input type="text" name="manual_url" id="manual_url" class="widefat"
               value="<?php if (isset ($aft_stored_meta['manual_url'])) {
                   echo $aft_stored_meta['manual_url'][0];
               } ?>" required/>
        <br>
    </p>
    <?php
}


add_action('save_post', 'cmt_manual_meta_save');

function cmt_manual_meta_save($post_id)
{

    // Checks save status
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['cmt_nonce']) && wp_verify_nonce($_POST['cmt_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    // Exits script depending on save status
    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    if (isset($_POST['manual_url'])) {
        update_post_meta($post_id, 'manual_url', sanitize_text_field($_POST['manual_url']));
    }

}