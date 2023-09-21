<?php
add_filter('manage_posts_columns', 'cmt_add_partner_post_thumbnail_column', 2);

function cmt_add_partner_post_thumbnail_column($cols)
{

    global $post;
    $pst_type = $post->post_type;
    if ($pst_type == 'partner') {
        $cols['cmt_partner_thumb'] = __('Partner Image');
    }

    return $cols;
}


add_action('manage_posts_custom_column', 'cmt_display_partner_post_thumbnail_column', 5, 2);

function cmt_display_partner_post_thumbnail_column($col, $id)
{
    if ($col == 'cmt_partner_thumb') {
        if (function_exists('get_the_post_thumbnail_url')) {
            $thumbnail_url = get_the_post_thumbnail_url($id, 'partner-img');
            if ( ! empty($thumbnail_url)) {
                echo '<img src="' . $thumbnail_url . '" />';
            } else {
                echo 'No banner added.';
            }
        } else {
            echo 'No partner image added.';
        }
    }
}

function partner_short_info($post)
{
    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);

    ?>
    <label for="partner_short_description" class="partner_short_description"><?php _e('Short Description',
            '') ?></label>
    <input class="widefat" type="text" name="partner_short_description" id="partner_short_description"
           value="<?php if (isset ($aft_stored_meta['partner_short_description'])) {
               echo $aft_stored_meta['partner_short_description'][0];
           } ?>"/> <br>
    <label for="partner_short_description" class="partner_short_description"><?php _e('Partner website url',
            '') ?></label>
    <input class="widefat" type="text" name="partner_website_url" id="partner_website_url"
           value="<?php if (isset ($aft_stored_meta['partner_website_url'])) {
               echo $aft_stored_meta['partner_website_url'][0];
           } ?>"/> <br>
    <?php
}

function cmt_partner_meta_save($post_id)
{
    $is_autosave    = wp_is_post_autosave($post_id);
    $is_revision    = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['aft_nonce']) && wp_verify_nonce($_POST['aft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || ! $is_valid_nonce) {
        return;
    }

    if (isset($_POST['partner_short_description'])) {
        update_post_meta($post_id, 'partner_short_description',
            sanitize_text_field($_POST['partner_short_description']));
    }
    if (isset($_POST['partner_website_url'])) {
        update_post_meta($post_id, 'partner_website_url',
            sanitize_text_field($_POST['partner_website_url']));
    }
}

add_action('add_meta_boxes', 'cmt_partner_add_meta_box');
add_action('save_post', 'cmt_partner_meta_save');

function cmt_partner_add_meta_box()
{
    // add meta Box
    remove_meta_box('postimagediv', 'partner', 'side');
    add_meta_box('description_postimagediv', __('Info'), 'partner_short_info', 'partner', 'normal', 'high');
    add_meta_box('postimagediv', __('Partner Image'), 'post_thumbnail_meta_box', 'partner', 'normal', 'high');
}
