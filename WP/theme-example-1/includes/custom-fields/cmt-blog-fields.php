<?php
function cmt_blog_add_meta_box()
{
    add_meta_box('cmt_testimonial_meta_id', __('Short Description'), 'cmt_blog_meta_callback', BLOG_POST_TYPE,
        'normal',
        'high');
}

add_action('add_meta_boxes', 'cmt_blog_add_meta_box');

function cmt_blog_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);

    wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');

    $field_value = get_post_meta($post->ID, 'blog_description', false);
    wp_editor($field_value[0], 'blog_description');


}

function cmt_blog_meta_save($post_id)
{

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpaft_nonce']) && wp_verify_nonce($_POST['wpaft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['blog_description'])) {
        update_post_meta($post_id, 'blog_description', sanitize_text_field($_POST['blog_description']));
    }

}

add_action('save_post', 'cmt_blog_meta_save');
