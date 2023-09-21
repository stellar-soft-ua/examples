<?php
add_filter('manage_posts_columns', 'cmt_add_post_thumbnail_column', 2);

function cmt_add_post_thumbnail_column($cols)
{

    global $post;
    $pst_type = $post->post_type;
    if ($pst_type == 'banner') {
        $cols['cmt_logo_thumb'] = __('Banner Image');
        $cols['cmt_client_url'] = __('Banner Url');
    }
    return $cols;
}

add_action('manage_posts_custom_column', 'cmt_display_post_thumbnail_column', 5, 2);

function cmt_display_post_thumbnail_column($col, $id)
{
    switch ($col) {
        case 'cmt_logo_thumb':
            if (function_exists('get_the_post_thumbnail_url')) {
                $banner_thumbnail_img = get_the_post_thumbnail_url($id, 'banner-thumbnail');
                if (!empty($banner_thumbnail_img)) {
                    echo '<img width="400" src="' . $banner_thumbnail_img . '" />';
                } else {
                    echo 'No banner added.';
                }
            } else {
                echo 'No banner added.';
            }
        case 'cmt_client_url':
            if ($col == 'cmt_client_url') {
                echo get_post_meta($id, 'cmt_banner_meta_url', true);
            }
            break;

    }
}


add_action('add_meta_boxes', 'cmt_banner_add_meta_box');

function cmt_banner_add_meta_box()
{
    // add meta Box
    remove_meta_box('postimagediv', 'banner', 'side');
    add_meta_box('postimagediv', __('Banner Image'), 'post_thumbnail_meta_box', 'banner', 'normal', 'high');
    add_meta_box('cmt_banner_meta_id', __('Banner Url'), 'cmt_meta_callback', 'banner', 'normal', 'high');
}


function cmt_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>

    <p>
        <label for="cmt_banner_meta_url"
               class="cmt_banner_meta_url"><?php _e('Banner Url:', '') ?></label>
        <input type="text" name="cmt_banner_meta_url" id="cmt_banner_meta_url" class="widefat"
               value="<?php if (isset ($aft_stored_meta['cmt_banner_meta_url'])) {
                   echo $aft_stored_meta['cmt_banner_meta_url'][0];
               } ?>"/>
        <br>
    </p>
    <?php
}


add_action('save_post', 'cmt_banner_meta_save');

function cmt_banner_meta_save($post_id)
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
    if (isset($_POST['cmt_banner_meta_url'])) {
        update_post_meta($post_id, 'cmt_banner_meta_url', sanitize_text_field($_POST['cmt_banner_meta_url']));
    }

}