<?php
function leadership_add_meta_box()
{
    add_meta_box('leadership_editor_box', __('Info'), 'leadership_editor_meta_box',
        LEADERSHIP_POST_TYPE, 'normal', 'high');
}

add_action('add_meta_boxes', 'leadership_add_meta_box');

function leadership_editor_meta_box($post)
{

    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'leadership_description_noncename');

    $field_value = get_post_meta($post->ID, 'leadership_description', false);
    $leadership_stored_meta = get_post_meta($post->ID);
?>
    <label for="leadership_name" class="leadership_name"><?php _e('Name', '') ?></label>
    <input class="widefat" type="text" name="leadership_name" id="leadership_name"
           value="<?php if (isset ($leadership_stored_meta['leadership_name'])) {
               echo $leadership_stored_meta['leadership_name'][0];
           } ?>"/> <br>
    <label>Description</label>
<?php
    wp_editor($field_value[0], 'leadership_description');

}
add_action('save_post', 'cmt_leadership_meta_save');

function cmt_leadership_meta_save($post_id)
{
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['leadership_description_noncename']) && wp_verify_nonce($_POST['leadership_description_noncename'],
            basename(__FILE__))) ? 'true' : 'false';

    // Exits script depending on save status
    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }
    $postarr_leadership = str_replace('<ul>', '<ul class="list-text">', $_POST['leadership_description']);
    $postarr_leadership = str_replace('<ol>', '<ol class="list-text">', $postarr_leadership);
    // Checks for input and sanitizes/saves if needed
        update_post_meta($post_id, 'leadership_name', sanitize_text_field($_POST['leadership_name']));
        update_post_meta($post_id, 'leadership_description', $postarr_leadership);
}