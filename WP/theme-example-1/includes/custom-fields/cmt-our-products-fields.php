<?php
function cmt_our_products_add_meta_box()
{

    add_meta_box('cmt_see_product_btn', __('See Product button'), 'cmt_our_products_see_btn_meta_callback', PRODUCT_POST_TYPE, 'normal', 'high');
    add_meta_box('cmt_download__btn', __('Download Software button'), 'cmt_our_products_download_btn_meta_callback', PRODUCT_POST_TYPE, 'normal', 'high');
    add_meta_box('cmt_demo_btn', __('Demo button'), 'cmt_our_demo_btn_meta_callback', PRODUCT_POST_TYPE, 'normal', 'high');
    add_meta_box('cmt_contact_btn', __('Contact button'), 'cmt_our_contact_btn_meta_callback', PRODUCT_POST_TYPE, 'normal', 'high');
    add_meta_box('cmt_product_big_image', __('Info image'), 'cmt_product_big_image_callback', PRODUCT_POST_TYPE, 'normal', 'high');
}

add_action('add_meta_boxes', 'cmt_our_products_add_meta_box');

function cmt_our_products_see_btn_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="cmt_see_btn_text" class="cmt_see_btn_text"><?php _e('See Product button text', '') ?></label>
        <input class="widefat" type="text" name="cmt_see_btn_text" id="cmt_see_btn_text"
               value="<?php if (isset ($aft_stored_meta['cmt_see_btn_text'])) {
                   echo $aft_stored_meta['cmt_see_btn_text'][0];
               } ?>"/> <br>
    </p>
    <p>
        <label for="cmt_see_btn_link" class="cmt_see_btn_link"><?php _e('See Product button link', '') ?></label>
        <input class="widefat" type="text" name="cmt_see_btn_link" id="cmt_see_btn_link"
               value="<?php if (isset ($aft_stored_meta['cmt_see_btn_link'])) {
                   echo $aft_stored_meta['cmt_see_btn_link'][0];
               } ?>"/> <br>
    </p>
    <?php
}

function cmt_our_products_download_btn_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="cmt_download_btn_text" class="cmt_download_btn_text"><?php _e('Download button text', '') ?></label>
        <input class="widefat" type="text" name="cmt_download_btn_text" id="cmt_download_btn_text"
               value="<?php if (isset ($aft_stored_meta['cmt_download_btn_text'])) {
                   echo $aft_stored_meta['cmt_download_btn_text'][0];
               } ?>"/> <br>
    </p>
    <p>
        <label for="cmt_download_btn_link" class="cmt_download_btn_link"><?php _e('Download button link', '') ?></label>
        <input class="widefat" type="text" name="cmt_download_btn_link" id="cmt_download_btn_link"
               value="<?php if (isset ($aft_stored_meta['cmt_download_btn_link'])) {
                   echo $aft_stored_meta['cmt_download_btn_link'][0];
               } ?>"/> <br>
    </p>
    <?php
}

function cmt_our_demo_btn_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="cmt_demo_btn_text" class="cmt_demo_btn_text"><?php _e('Demo button text', '') ?></label>
        <input class="widefat" type="text" name="cmt_demo_btn_text" id="cmt_demo_btn_text"
               value="<?php if (isset ($aft_stored_meta['cmt_demo_btn_text'])) {
                   echo $aft_stored_meta['cmt_demo_btn_text'][0];
               } ?>"/> <br>
    </p>
    <p>
        <label for="cmt_demo_btn_link" class="cmt_demo_btn_link"><?php _e('Demo button link', '') ?></label>
        <input class="widefat" type="text" name="cmt_demo_btn_link" id="cmt_demo_btn_link"
               value="<?php if (isset ($aft_stored_meta['cmt_demo_btn_link'])) {
                   echo $aft_stored_meta['cmt_demo_btn_link'][0];
               } ?>"/> <br>
    </p>
    <?php
}

function cmt_our_contact_btn_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="cmt_contact_btn_text" class="cmt_contact_btn_text"><?php _e('Contact button text', '') ?></label>
        <input class="widefat" type="text" name="cmt_contact_btn_text" id="cmt_contact_btn_text"
               value="<?php if (isset ($aft_stored_meta['cmt_contact_btn_text'])) {
                   echo $aft_stored_meta['cmt_contact_btn_text'][0];
               } ?>"/> <br>
    </p>
    <p>
        <label for="cmt_contact_btn_link" class="cmt_contact_btn_link"><?php _e('Contact button link', '') ?></label>
        <input class="widefat" type="text" name="cmt_contact_btn_link" id="cmt_contact_btn_link"
               value="<?php if (isset ($aft_stored_meta['cmt_contact_btn_link'])) {
                   echo $aft_stored_meta['cmt_contact_btn_link'][0];
               } ?>"/> <br>
    </p>
    <?php
}

function cmt_product_big_image_callback($post)
{
    wp_nonce_field(plugin_basename(__FILE__), 'product_noncename');

    $value = get_post_meta($post->ID, 'image_upload_val', true);
    $temp = explode(",", $value);

    if ($temp) {
        foreach ($temp as $img_id) {
            $image_attributes = wp_get_attachment_image_src($img_id, 'product-thumbnail');
            echo '<img src="' . $image_attributes[0] . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" data-id="' . $img_id . '" class="product-img">';
        }
    } else {
        $image_attributes = wp_get_attachment_image_src($value, [128, 128]);
        echo '<img src="' . $image_attributes[0] . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" data-id="' . $value . '" class="product-img">';
    }
    echo "<input type='hidden' name='image_upload_val' id='image_upload_val' value='" . $value . "' />";
    echo "</br><div class='upload_media button tagadd' id='product_image_upload'>Upload Images</div>";
    echo "<script type='text/javascript'>
</script>";
}


function cmt_our_products_meta_save($post_id)
{

    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpaft_nonce']) && wp_verify_nonce($_POST['wpaft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST['cmt_see_btn_text'])) {
        update_post_meta($post_id, 'cmt_see_btn_text',
            sanitize_text_field($_POST['cmt_see_btn_text']));
    }

    if (isset($_POST['cmt_see_btn_link'])) {
        update_post_meta($post_id, 'cmt_see_btn_link',
            sanitize_text_field($_POST['cmt_see_btn_link']));
    }

    if (isset($_POST['cmt_download_btn_text'])) {
        update_post_meta($post_id, 'cmt_download_btn_text',
            sanitize_text_field($_POST['cmt_download_btn_text']));
    }

    if (isset($_POST['cmt_download_btn_link'])) {
        update_post_meta($post_id, 'cmt_download_btn_link',
            sanitize_text_field($_POST['cmt_download_btn_link']));
    }

    if (isset($_POST['cmt_demo_btn_text'])) {
        update_post_meta($post_id, 'cmt_demo_btn_text',
            sanitize_text_field($_POST['cmt_demo_btn_text']));
    }

    if (isset($_POST['cmt_demo_btn_link'])) {
        update_post_meta($post_id, 'cmt_demo_btn_link',
            sanitize_text_field($_POST['cmt_demo_btn_link']));
    }

    if (isset($_POST['cmt_contact_btn_text'])) {
        update_post_meta($post_id, 'cmt_contact_btn_text',
            sanitize_text_field($_POST['cmt_contact_btn_text']));
    }

    if (isset($_POST['cmt_contact_btn_link'])) {
        update_post_meta($post_id, 'cmt_contact_btn_link',
            sanitize_text_field($_POST['cmt_contact_btn_link']));
    }

    if (isset($_POST['image_upload_val'])) {
        $images = explode(',', $_POST['image_upload_val']);
        update_post_meta($post_id, 'image_upload_val',
            sanitize_text_field($images[0]));
    }

}

add_action('save_post', 'cmt_our_products_meta_save');
