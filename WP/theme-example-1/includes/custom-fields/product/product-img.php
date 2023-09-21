<?php
add_action('admin_enqueue_scripts', 'load_script');

function load_script($hook)
{
    global $post;

    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if (in_array($post->post_type, [FREQUENCY_EXTENSION_POST_TYPE, CALIBRATION_KITS_POST_TYPE, VNA_POST_TYPE, PRODUCT_POST_TYPE])) {
            wp_enqueue_script('product-img-script', get_template_directory_uri() . '/assets/js/product-img.js');
        }
    }
}


add_action('add_meta_boxes', 'add_product_img_custom_box');
add_action('wp_insert_post', 'product_img_insert_postdata');


function add_product_img_custom_box()
{

    add_meta_box('product_img', 'Images For Product', 'product_render_images', [FREQUENCY_EXTENSION_POST_TYPE, CALIBRATION_KITS_POST_TYPE, VNA_POST_TYPE], 'normal', 'default');
}


function product_render_images()
{
    global $post;
    wp_nonce_field(plugin_basename(__FILE__), 'product_noncename');

    $value = get_post_meta($post->ID, '_multi_img_array', true);
    $temp  = explode(",", $value);

    if ($temp) {
        foreach ($temp as $img_id) {
            $image_attributes = wp_get_attachment_image_src($img_id, 'product-thumbnail');
            echo '<img src="' . $image_attributes[0] . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" data-id="' . $img_id . '" class="product-img">';
        }
    } else {
        $image_attributes = wp_get_attachment_image_src($value, [128, 128]);
        echo '<img src="' . $image_attributes[0] . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" data-id="' . $value . '" class="product-img">';
    }
    echo "<style type='text/css'>
</style>";
    echo "<input type='hidden' name='image_upload_val' id='image_upload_val' value='" . $value . "' />";
    echo "</br><div class='upload_media button tagadd' id='product_image_upload'>Upload Images</div>";
    echo "<script type='text/javascript'>
</script>";
}

function product_img_insert_postdata($post_id)
{
    if ( ! current_user_can('edit_page', $post_id)) {
        return;
    }

    if ( ! current_user_can('edit_post', $post_id)) {
        return;
    }

    if ( ! isset($_POST['product_noncename']) || ! wp_verify_nonce($_POST['product_noncename'],
            plugin_basename(__FILE__))) {
        return;
    }

    $post_ID = $_POST['post_ID'];
    $mydata  = $_POST['image_upload_val'];

    if ($mydata) {
        $cur_data = get_post_meta($post_ID, '_multi_img_array', true);
        if ( ! (empty($cur_data))) {
            update_post_meta($post_ID, '_multi_img_array', $mydata);
        } else {
            add_post_meta($post_id, '_multi_img_array', $mydata, true);
        }
    }else{
        delete_post_meta($post_id,'_multi_img_array');
    }

}
