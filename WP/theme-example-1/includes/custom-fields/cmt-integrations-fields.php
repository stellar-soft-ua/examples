<?php
function cmt_integrations_add_meta_box()
{
    remove_meta_box('postdivrich', INTEGRATIONS_POST_TYPE, 'advanced');
    add_meta_box('cmt_integrations_meta_id', __('Button settings'), 'cmt_integrations_meta_callback', INTEGRATIONS_POST_TYPE, 'normal', 'high');
}

add_action('add_meta_boxes', 'cmt_integrations_add_meta_box');

function cmt_integrations_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="cmt_integrations_btn_text" class="cmt_integrations_btn_text"><?php _e('Button text', '') ?></label>
        <input class="widefat" type="text" name="cmt_integrations_btn_text" id="cmt_integrations_btn_text"
               value="<?php if (isset ($aft_stored_meta['cmt_integrations_btn_text'])) {
                   echo $aft_stored_meta['cmt_integrations_btn_text'][0];
               } ?>"/> <br>
    </p>
    <p>
        <label for="cmt_integrations_btn_link" class="cmt_integrations_btn_link"><?php _e('Button link', '') ?></label>
        <input class="widefat" type="text" name="cmt_integrations_btn_link" id="cmt_integrations_btn_link"
               value="<?php if (isset ($aft_stored_meta['cmt_integrations_btn_link'])) {
                   echo $aft_stored_meta['cmt_integrations_btn_link'][0];
               } ?>"/> <br>
    </p>
    <?php

}


function cmt_integrations_meta_save($post_id)
{

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpaft_nonce']) && wp_verify_nonce($_POST['wpaft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['cmt_integrations_btn_text'])) {
        update_post_meta($post_id, 'cmt_integrations_btn_text',
            sanitize_text_field($_POST['cmt_integrations_btn_text']));
    }

    if (isset($_POST['cmt_integrations_btn_link'])) {
        update_post_meta($post_id, 'cmt_integrations_btn_link',
            sanitize_text_field($_POST['cmt_integrations_btn_link']));
    }

}

add_action('save_post', 'cmt_integrations_meta_save');

