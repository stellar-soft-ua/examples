<?php
function cmt_documentation_add_meta_box()
{
    add_meta_box('cmt_documentation_description_meta_id', __('Short Description'), 'cmt_documentation_description_callback', DOCUMENTATION_POST_TYPE, 'normal', 'high');
    add_meta_box('documentationRelated', __('Related Documentations'), 'documentation_related_meta_box', DOCUMENTATION_POST_TYPE, 'normal', 'high');
    add_meta_box('documentationButton', __('Button'), 'documentation_button_meta_box', DOCUMENTATION_POST_TYPE, 'normal', 'high');
}

add_action('add_meta_boxes', 'cmt_documentation_add_meta_box');

function cmt_documentation_description_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);

    wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');

    $field_value = get_post_meta($post->ID, 'documentation_description', false);
    wp_editor($field_value[0], 'documentation_description');


}

function documentation_related_meta_box($post)
{
    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_select_stored_meta    = get_post_meta($post->ID, 'related-documentation', false);//right
    $aft_select_in_stored_meta = get_post_meta($post->ID, 'related-from-documentation', false); //left

    $args_not_in  = [
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_type'      => DOCUMENTATION_POST_TYPE,
        'post_status'    => 'publish',
        'post__not_in'   => $aft_select_stored_meta[0],
        'posts_per_page' => -1,
        'numberposts'    => -1
    ];
    $args_in      = [
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_type'      => DOCUMENTATION_POST_TYPE,
        'post_status'    => 'publish',
        'post__in'       => $aft_select_stored_meta[0],
        'posts_per_page' => -1,
        'numberposts'    => -1
    ];
    $posts_not_in = get_posts($args_not_in); //left
    $posts_in     = get_posts($args_in);

    ?>
    <div class="row-main">
        <div class="row-1">
            <select name="related-from-documentation[]" id="multiselect" class="form-control" size="8" multiple="multiple">
                <?php foreach ($posts_not_in as $post): ?>
                    <option value="<?= $post->ID ?>"><?= $post->post_title ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="row-2">
            <div class="col-xs-2">
                <button type="button" id="multiselect_rightAll" class="preview button"><span
                        class="dashicons dashicons-controls-forward"></button>
                <button type="button" id="multiselect_rightSelected" class="preview button"><span
                        class="dashicons dashicons-arrow-right-alt"></span></button>
                <button type="button" id="multiselect_leftSelected" class="preview button"><span
                        class="dashicons dashicons-arrow-left-alt"></span></button>
                <button type="button" id="multiselect_leftAll" class="preview button"><span
                        class="dashicons dashicons-controls-back"></span></button>
            </div>
        </div>
        <div class="row-1">
            <select name="related-documentation[]" id="multiselect_to" size="8" multiple="multiple">
                <?php if ( ! empty($aft_select_stored_meta)): ?>
                    <?php foreach ($posts_in as $post_in): ?>
                        <option value="<?= $post_in->ID ?>"><?= $post_in->post_title ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    </div>

    <?php
}

function documentation_button_meta_box($post){
    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_button    = get_post_meta($post->ID, 'documentation_button_link');
    $aft_button_text    = get_post_meta($post->ID, 'documentation_button_text');
    ?>
    <label for="documentation_button_link" class="documentation_button_link"><?php _e('Button Link', '') ?></label>
    <input class="widefat" type="text" name="documentation_button_link" id="documentation_button_link"
           value="<?php if (isset ($aft_button[0])) {
               echo $aft_button[0];
           } ?>"/> <br>
    <label for="documentation_button_text" class="documentation_button_text"><?php _e('Button Text', '') ?></label>
    <input class="widefat" type="text" name="documentation_button_text" id="documentation_button_text"
           value="<?php if (isset ($aft_button_text[0])) {
               echo $aft_button_text[0];
           } ?>"/> <br>
    <?php
}

function cmt_documentation_meta_save($post_id)
{
    $is_autosave    = wp_is_post_autosave($post_id);
    $is_revision    = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpaft_nonce']) && wp_verify_nonce($_POST['wpaft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || ! $is_valid_nonce) {
        return;
    }

    if (isset($_POST['documentation_description'])) {
        update_post_meta($post_id, 'documentation_description', sanitize_text_field($_POST['documentation_description']));
    }

    if (isset($_POST['related-documentation'])) {
        update_post_meta($post_id, 'related-documentation', array_map('strip_tags', $_POST['related-documentation']));
    } else {
        delete_post_meta($post_id, 'related-documentation');
    }
    if (isset($_POST['related-from-documentation'])) {
        update_post_meta($post_id, 'related-from-documentation', array_map('strip_tags', $_POST['related-from-documentation']));
    } else {
        delete_post_meta($post_id, 'related-from-documentation');
    }

    if (isset($_POST['documentation_button_link'])) {
        update_post_meta($post_id, 'documentation_button_link',$_POST['documentation_button_link']);
    }
    if (isset($_POST['documentation_button_text'])) {
        update_post_meta($post_id, 'documentation_button_text',$_POST['documentation_button_text']);
    }
}

add_action('save_post', 'cmt_documentation_meta_save');
