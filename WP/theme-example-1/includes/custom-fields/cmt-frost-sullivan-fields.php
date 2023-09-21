<?php
add_filter('manage_posts_columns', 'cmt_add_frost_sullivan_post_year_column', 2);

function cmt_add_frost_sullivan_post_year_column($cols)
{

    global $post;
    $pst_type = $post->post_type;
    if ($pst_type == 'frost-sullivan') {
        $cols['cmt_frost_sullivan_year'] = __('Year');
    }
    return $cols;
}

add_action('manage_posts_custom_column', 'cmt_display_frost_sullivan_post_year_column', 5, 2);

function cmt_display_frost_sullivan_post_year_column($col, $id)
{
    if ($col == 'cmt_frost_sullivan_year') {
        echo get_post_meta($id, 'cmt_frost_sullivan_year', true);
    }
}


add_action('add_meta_boxes', 'cmt_frost_sullivan_add_meta_box');

function cmt_frost_sullivan_add_meta_box()
{
    add_meta_box('cmt_frost_sullivan_year', __('Year'), 'cmt_frost_sullivan_meta_callback', 'frost-sullivan', 'normal', 'high');
}


function cmt_frost_sullivan_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>

    <p>
        <label for="cmt_frost_sullivan_year"
               class="cmt_frost_sullivan_year"><?php _e('Year:', '') ?></label>
        <input type="date" name="cmt_frost_sullivan_year" id="cmt_frost_sullivan_year" class="widefat"
               value="<?php if (isset ($aft_stored_meta['cmt_frost_sullivan_year'])) {
                   echo $aft_stored_meta['cmt_frost_sullivan_year'][0];
               } ?>"/>
        <br>
    </p>
    <p>
        <label for="cmt_frost_sullivan_url"
               class="cmt_frost_sullivan_url"><?php _e('Image url:', '') ?></label>
        <input type="url" name="cmt_frost_sullivan_url" id="cmt_frost_sullivan_url" class="widefat"
               value="<?php if (isset ($aft_stored_meta['cmt_frost_sullivan_url'])) {
                   echo $aft_stored_meta['cmt_frost_sullivan_url'][0];
               } ?>"/>
        <br>
    </p>
    <?php
}


add_action('save_post', 'cmt_frost_sullivan_meta_save');

function cmt_frost_sullivan_meta_save($post_id)
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
    if (isset($_POST['cmt_frost_sullivan_year'])) {
        update_post_meta($post_id, 'cmt_frost_sullivan_year', sanitize_text_field($_POST['cmt_frost_sullivan_year']));
    } else {
        update_post_meta($post_id, 'cmt_frost_sullivan_year', date("Y"));
    }

    if (isset($_POST['cmt_frost_sullivan_url'])) {
        update_post_meta($post_id, 'cmt_frost_sullivan_url', sanitize_text_field($_POST['cmt_frost_sullivan_url']));
    }

}
