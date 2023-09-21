<?php
function cmt_posts_add_meta_box()
{
    add_meta_box('postrelated', __('Related posts'), 'post_related_meta_box', 'post', 'normal', 'high');
    add_meta_box('postbutton', __('Button'), 'post_button_meta_box', 'post', 'normal', 'high');
}

add_action('add_meta_boxes', 'cmt_posts_add_meta_box');

function post_related_meta_box($post)
{
    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_select_stored_meta    = get_post_meta($post->ID, 'related-post', false);//right
    $aft_select_in_stored_meta = get_post_meta($post->ID, 'related-from', false); //left

    $args_not_in  = [
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'post__not_in'   => $aft_select_stored_meta[0],
        'posts_per_page' => -1,
        'numberposts'    => -1
    ];
    $args_in      = [
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_type'      => 'post',
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
            <select name="related-from[]" id="multiselect" class="form-control" size="8" multiple="multiple">
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
            <select name="related-post[]" id="multiselect_to" size="8" multiple="multiple">
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

function post_button_meta_box($post){
    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_button    = get_post_meta($post->ID, 'post_button_link');
    $aft_button_text    = get_post_meta($post->ID, 'post_button_text');
    ?>
    <label for="post_button_link" class="post_button_link"><?php _e('Button Link', '') ?></label>
    <input class="widefat" type="text" name="post_button_link" id="post_button_link"
           value="<?php if (isset ($aft_button[0])) {
               echo $aft_button[0];
           } ?>"/> <br>
    <label for="post_button_text" class="post_button_text"><?php _e('Button Text', '') ?></label>
    <input class="widefat" type="text" name="post_button_text" id="post_button_text"
           value="<?php if (isset ($aft_button_text[0])) {
               echo $aft_button_text[0];
           } ?>"/> <br>
<?php
}

function cmt_posts_meta_save($post_id)
{
    $is_autosave    = wp_is_post_autosave($post_id);
    $is_revision    = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpaft_nonce']) && wp_verify_nonce($_POST['wpaft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || ! $is_valid_nonce) {
        return;
    }

    if (isset($_POST['related-post'])) {
        update_post_meta($post_id, 'related-post', array_map('strip_tags', $_POST['related-post']));
    } else {
        delete_post_meta($post_id, 'related-post');
    }
    if (isset($_POST['related-from'])) {
        update_post_meta($post_id, 'related-from', array_map('strip_tags', $_POST['related-from']));
    } else {
        delete_post_meta($post_id, 'related-from');
    }

    if (isset($_POST['post_button_link'])) {
        update_post_meta($post_id, 'post_button_link',$_POST['post_button_link']);
    }
    if (isset($_POST['post_button_text'])) {
        update_post_meta($post_id, 'post_button_text',$_POST['post_button_text']);
    }
}

add_action('save_post', 'cmt_posts_meta_save');