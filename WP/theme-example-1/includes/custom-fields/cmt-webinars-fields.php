<?php
add_filter('manage_posts_columns', 'cmt_add_webinar_post_columns', 2);

function cmt_add_webinar_post_columns($cols)
{

    global $post;
    $pst_type = $post->post_type;
    if ($pst_type == 'webinar') {
        $cols['cmt_webinar_video_url'] = __('Video URL');
        $cols['cmt_webinar_register_url'] = __('Register URL');
    }
    return $cols;
}

add_action('manage_posts_custom_column', 'cmt_display_webinar_post_columns', 5, 2);

function cmt_display_webinar_post_columns($col, $id)
{
    switch ($col) {
        case 'cmt_webinar_video_url':
            echo get_post_meta($id, 'cmt_webinar_video_url', true);
            break;
        case 'cmt_webinar_register_url':
            echo get_post_meta($id, 'cmt_webinar_register_url', true);
            break;
    }
}


add_action('add_meta_boxes', 'cmt_webinar_add_meta_box');

function cmt_webinar_add_meta_box()
{
    add_meta_box('cmt_webinar_registerUrl_meta_callback', __('Register URL'), 'cmt_webinar_registerUrl_meta_callback', 'webinar', 'normal', 'high');
    add_meta_box('cmt_webinar_videoUrl_meta_callback', __('Video URL'), 'cmt_webinar_videoUrl_meta_callback', 'webinar', 'normal', 'high');
    add_meta_box('cmt_webinar_date_meta_callback', __('Webinar Date'), 'cmt_webinar_date_meta_callback', 'webinar', 'normal', 'high');
}


function cmt_webinar_registerUrl_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>

    <p>
        <label for="cmt_webinar_register_url"
               class="cmt_webinar_register_url"><?php _e('Register URL:', '') ?></label>
        <input type="text" name="cmt_webinar_register_url" id="cmt_webinar_register_url" class="widefat"
               value="<?php if (isset ($aft_stored_meta['cmt_webinar_register_url'])) {
                   echo $aft_stored_meta['cmt_webinar_register_url'][0];
               } ?>"/>
        <br>
    </p>
    <?php
}

function cmt_webinar_videoUrl_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="cmt_webinar_video_url"
               class="cmt_webinar_video_url"><?php _e('Video URL:', '') ?></label>
        <input type="text" name="cmt_webinar_video_url" id="cmt_webinar_video_url" class="widefat"
               value="<?php if (isset ($aft_stored_meta['cmt_webinar_video_url'])) {
                   echo $aft_stored_meta['cmt_webinar_video_url'][0];
               } ?>"/>
        <br>
    </p>
    <?php
}

function cmt_webinar_date_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="cmt_webinar_date"
               class="cmt_webinar_date"><?php _e('Webinar Date:', '') ?></label>
        <input type="text" name="cmt_webinar_date" id="cmt_webinar_date" class="widefat"
               value="<?php if (isset ($aft_stored_meta['cmt_webinar_date'])) {
                   echo $aft_stored_meta['cmt_webinar_date'][0];
               } ?>" readonly="readonly"/>
        <br>
    </p>
    <?php
}

add_action('save_post', 'cmt_webinar_meta_save');

function cmt_webinar_meta_save($post_id)
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
    if (isset($_POST['cmt_webinar_register_url'])) {
        update_post_meta($post_id, 'cmt_webinar_register_url', sanitize_text_field($_POST['cmt_webinar_register_url']));
    }
    if (isset($_POST['cmt_webinar_video_url'])) {
        update_post_meta($post_id, 'cmt_webinar_video_url', sanitize_text_field($_POST['cmt_webinar_video_url']));
    }
    if (isset($_POST['cmt_webinar_date'])) {
        update_post_meta($post_id, 'cmt_webinar_date', sanitize_text_field($_POST['cmt_webinar_date']));
    }
}
