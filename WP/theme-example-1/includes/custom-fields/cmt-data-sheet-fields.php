<?php
add_action('add_meta_boxes', 'cmt_data_sheet_add_meta_box');

function cmt_data_sheet_add_meta_box()
{
    add_meta_box('data_sheet_url', __('Data Sheet Url'), 'cmt_data_sheet_meta_callback', DATA_SHEET_POST_TYPE, 'normal', 'high');
}


function cmt_data_sheet_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>

    <p>
        <label for="data_sheet_url" class="data_sheet_url"><?php _e('Data Sheet URL*:', '') ?></label>
        <input type="text" name="data_sheet_url" id="data_sheet_url" class="widefat"
               value="<?php if (isset ($aft_stored_meta['data_sheet_url'])) {
                   echo $aft_stored_meta['data_sheet_url'][0];
               } ?>" required/>
        <br>
    </p>
    <?php
}


add_action('save_post', 'cmt_data_sheet_meta_save');

function cmt_data_sheet_meta_save($post_id)
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
    if (isset($_POST['data_sheet_url'])) {
        update_post_meta($post_id, 'data_sheet_url', sanitize_text_field($_POST['data_sheet_url']));
    }

}
