<?php
function cmt_product_add_meta_box()
{
    add_meta_box('postrelated', __('Related posts'), 'cmt_product_related_meta_box',
        [FREQUENCY_EXTENSION_POST_TYPE, CALIBRATION_KITS_POST_TYPE, VNA_POST_TYPE], 'normal', 'high');
}

add_action('add_meta_boxes', 'cmt_product_add_meta_box');

function cmt_product_related_meta_box($post)
{
    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_select_stored_meta    = get_post_meta($post->ID, 'related-product-post', false);//right
    $aft_select_in_stored_meta = get_post_meta($post->ID, 'related-product-from', false); //left

    $args_not_in  = [
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_type'      => [FREQUENCY_EXTENSION_POST_TYPE, CALIBRATION_KITS_POST_TYPE, VNA_POST_TYPE],
        'post_status'    => 'publish',
        'post__not_in'   => $aft_select_stored_meta[0],
        'posts_per_page' => -1,
        'numberposts'    => -1
    ];
    $args_in      = [
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_type'      => [FREQUENCY_EXTENSION_POST_TYPE, CALIBRATION_KITS_POST_TYPE, VNA_POST_TYPE],
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
            <select name="related-product-from[]" id="multiselect" class="form-control" size="8" multiple="multiple">
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
            <select name="related-product-post[]" id="multiselect_to" size="8" multiple="multiple" class="form-control">
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

function cmt_product_meta_save($post_id)
{
    $is_autosave    = wp_is_post_autosave($post_id);
    $is_revision    = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpaft_nonce']) && wp_verify_nonce($_POST['wpaft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || ! $is_valid_nonce) {
        return;
    }

    if (isset($_POST['related-product-post'])) {
        update_post_meta($post_id, 'related-product-post', array_map('strip_tags', $_POST['related-product-post']));
    } else {
        delete_post_meta($post_id, 'related-product-post');
    }
    if (isset($_POST['related-product-from'])) {
        update_post_meta($post_id, 'related-product-from', array_map('strip_tags', $_POST['related-product-from']));
    } else {
        delete_post_meta($post_id, 'related-product-from');
    }

}

add_action('save_post', 'cmt_product_meta_save');