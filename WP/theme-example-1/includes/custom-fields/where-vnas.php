<?php
function cmt_where_vnas_add_meta_box()
{
    add_meta_box('anchor-app', __('Anchor'), 'where_vnas_meta_box', 'where_vnas', 'normal', 'high');
}

add_action('add_meta_boxes', 'cmt_where_vnas_add_meta_box');


function where_vnas_meta_box($post)
{
    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_app_id = get_post_meta($post->ID, 'application_id');
    ?>
    <label for="application_id" class="application_id"><?php _e('Application ID', '') ?></label>
    <input class="widefat" type="text" name="application_id" id="application_id"
           value="<?php if (isset ($aft_app_id[0])) {
               echo $aft_app_id[0];
           } ?>"/> <br>
    <?php
}

function cmt_where_vnas_meta_save($post_id)
{
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpaft_nonce']) && wp_verify_nonce($_POST['wpaft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['application_id'])) {
        update_post_meta($post_id, 'application_id', $_POST['application_id']);
    }
}

add_action('save_post', 'cmt_where_vnas_meta_save');