<?php

add_action('add_meta_boxes', 'cmt_latest_news_add_meta_box');

function cmt_latest_news_add_meta_box()
{
    add_meta_box('news_item_fields', __('News item additional fields'), 'cmt_latest_news_callback', LATEST_NEWS, 'normal', 'high');
}

function cmt_latest_news_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="news_item_url" class="news_item_url"><?php _e('News item URL:', '') ?></label>
        <input type="text" name="news_item_url" id="news_item_url" class="widefat"
               value="<?php if (isset ($aft_stored_meta['news_item_url'])) {
                   echo $aft_stored_meta['news_item_url'][0];
               } ?>"/>
        <br>
    </p>
    <?php
}


add_action('save_post', 'cmt_latest_news_meta_save');

function cmt_latest_news_meta_save($post_id)
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
    if (isset($_POST['news_item_url'])) {
        update_post_meta($post_id, 'news_item_url', $_POST['news_item_url']);
    }
}