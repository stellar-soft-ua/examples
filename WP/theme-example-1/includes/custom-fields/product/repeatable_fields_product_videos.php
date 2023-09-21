<?php
function cmt_get_videos_options()
{
    $options = array(
        'Internal Video' => 'a_sort_internal_video',
        'Wistia Video' => 'b_sort_wistia_video',
        'H5P Content' => 'c_sort_h5p_video',
        '360 Wistia Video' => 'd_sort_wistia_video_360',
    );
    return $options;
}

add_action('admin_enqueue_scripts', 'load_repeatable_product_video_fields_script');
function load_repeatable_product_video_fields_script()
{
    wp_enqueue_script('repeatable-product-video-fields-script', get_template_directory_uri() . '/assets/js/repeatable-product-video-fields-script.js');
}

add_action('admin_init', 'cmt_add_product_video_meta_boxes', 1);
function cmt_add_product_video_meta_boxes()
{
    add_meta_box('repeatable-fields-product-video', 'Video Contents', 'cmt_repeatable_video_meta_box_display', [VNA_POST_TYPE, FREQUENCY_EXTENSION_POST_TYPE, CALIBRATION_KITS_POST_TYPE], 'normal', 'default');
}

function cmt_repeatable_video_meta_box_display() {
    global $post;
    wp_nonce_field(plugin_basename(__FILE__), 'repeatable_product_video_nonce');

    $repeatable_fields = get_post_meta($post->ID, 'repeatable-fields-product-video', true);
    $options = cmt_get_videos_options(); ?>
    <table id="repeatable-fieldset-default" width="100%">
        <thead>
            <tr>
                <th width="12%">Select</th>
                <th width="80%">URL</th>
                <th width="8%"></th>
            </tr>
        </thead>
    <tbody>
    <?php
    if ($repeatable_fields) :
        foreach ($repeatable_fields as $field) { ?>
            <tr>
                <td>
                    <select name="video_types[]">
                        <option disabled selected value>--select--</option>
                        <?php foreach ($options as $label => $value) : ?>
                            <option
                                value="<?php echo $value; ?>"<?php selected($field['video_types'], $value); ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="text" class="widefat" name="url[]"
                           value="<?php if (!empty($field['url'])) echo esc_attr($field['url']); ?>"/>
                </td>
                <td>
                    <a class="button remove-row" href="#">Remove</a>
                </td>
            </tr>
        <?php } ?>
    <?php else : ?>
        <tr>
            <td>
                <select name="video_types[]">
                    <option disabled selected value>--select--</option>
                    <?php foreach ($options as $label => $value) : ?>
                        <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <input type="text" class="widefat" name="url[]" placeholder="Link"/>
            </td>
            <td>
                <a class="button remove-row" href="#">Remove</a>
            </td>
        </tr>
    <?php endif; ?>
    <tr class="empty-row screen-reader-text">
        <td>
            <select name="video_types[]">
                <option disabled selected value>--select--</option>
                <?php foreach ($options as $label => $value) : ?>
                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <input type="text" class="widefat" name="url[]" placeholder="Link"/>
        </td>
        <td>
            <a class="button remove-row" href="#">Remove</a>
        </td>
    </tr>
    </tbody>
    </table>

    <p>
        <a id="add-row" class="button" href="#">Add more</a>
    </p>
<?php } ?>
<?php
    add_action('save_post', 'cmt_repeatable_video_meta_box_save');
    function cmt_repeatable_video_meta_box_save($post_id)
    {
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = isset($_POST['repeatable_product_video_nonce']) && wp_verify_nonce($_POST['repeatable_product_video_nonce'],
                plugin_basename(__FILE__));

        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }

        $old = get_post_meta($post_id, 'repeatable-fields-product-video', true);
        $new = [];
//        $options = cmt_get_videos_options();
        if (!empty($_POST['video_types'])) {
            $video_types = $_POST['video_types'];
        }

        $urls = $_POST['url'];
        if (!isset($video_types)) {
            if ($old) {
                delete_post_meta($post_id, 'repeatable-fields-product-video', $old);
            }
            return;
        }
        $count = count($video_types);

        for ($i = 0; $i < $count; $i++) {
            if (!empty($video_types[$i])) {
                $new[$i]['video_types'] = $video_types[$i];
            } else {
                $new[$i]['video_types'] = '';
            }

            if (!empty($urls[$i])) {
                $new[$i]['url'] = $urls[$i];
            } else {
                $new[$i]['url'] = '';
            }
        }
        if (!empty($new) && $new != $old) {
            update_post_meta($post_id, 'repeatable-fields-product-video', $new);
        } else {
            if (empty($new) && $old) {
                delete_post_meta($post_id, 'repeatable-fields-product-video', $old);
            }
        }
    } ?>
