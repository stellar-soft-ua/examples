<?php
function cmt_cal_service_add_meta_box()
{
    add_meta_box('cmt_calibration_service', "Calibration Services page", 'cmt_cal_service_meta_callback',
        CALIBRATION_SERVICE,
        'normal',
        'high');
}

add_action('add_meta_boxes', 'cmt_cal_service_add_meta_box');

function cmt_cal_service_meta_callback($post)
{
    wp_nonce_field(__FILE__, 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="instrument" class="instrument">Instrument</label>
        <input type="text" name="instrument" id="instrument" class="widefat"
               value="<?php if (isset ($aft_stored_meta['instrument'])) {
                   echo $aft_stored_meta['instrument'][0];
               } ?>"/>
        <br>
    </p>
    <p>
        <?php $select_options = get_post_meta($post->ID, 'calibration_type', true) ?>
        <label for="calibration_type" class="calibration_type">Calibration Type</label>
        <br>
        <select name="calibration_type">
            <option value="">Choose Calibration Type</option>
            <option value="Accredited" <?php selected($select_options, 'Accredited'); ?>>Accredited
            </option>
            <option value="Unaccredited" <?php selected($select_options, 'Unaccredited'); ?>>Unaccredited
            </option>
            <option value="N/A" <?php selected($select_options, 'N/A'); ?>>N/A
            </option>
        </select>
        <br>
    </p>
    <p>
        <label for="cal_price" class="cal_price">Price</label>
        <input type="text" name="cal_price" id="cal_price" class="widefat"
               value="<?php if (isset ($aft_stored_meta['cal_price'])) {
                   echo $aft_stored_meta['cal_price'][0];
               } ?>"/>
        <br>
    </p>

    <p>
        <label for="cal_url" class="cal_url">URL</label>
        <input type="url" name="cal_url" id="cal_url" class="widefat"
               value="<?php if (isset ($aft_stored_meta['cal_url'])) {
                   echo $aft_stored_meta['cal_url'][0];
               } ?>"/>
        <br>
    </p>
    <?php
}


function cmt_cal_service_meta_save($post_id)
{

    $is_autosave    = wp_is_post_autosave($post_id);
    $is_revision    = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpaft_nonce']) && wp_verify_nonce($_POST['wpaft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || ! $is_valid_nonce) {
        return;
    }

    if (isset($_POST['instrument'])) {
        update_post_meta($post_id, 'instrument', $_POST['instrument']);
    }
    if (isset($_POST['calibration_type'])) {
        update_post_meta($post_id, 'calibration_type', $_POST['calibration_type']);
    }
    if (isset($_POST['cal_price'])) {
        update_post_meta($post_id, 'cal_price', $_POST['cal_price']);
    }
    if (isset($_POST['cal_url'])) {
        update_post_meta($post_id, 'cal_url', $_POST['cal_url']);
    }

}

add_action('save_post', 'cmt_cal_service_meta_save');
