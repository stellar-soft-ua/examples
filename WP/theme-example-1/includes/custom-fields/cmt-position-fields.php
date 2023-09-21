<?php

function create_new_metabox_context($post)
{

    do_meta_boxes(null, 'custom-metabox-holder', $post);
}

add_action('edit_form_after_title', 'create_new_metabox_context');

function add_custom_meta_box()
{

    add_meta_box('awesome_metabox_id', __('Other information'), 'render_awesome_metabox', POSITION_POST_TYPE,
        'custom-metabox-holder');
    add_meta_box('not_available_text_editor_box', __('Not Available Text'), 'not_available_text_editor_box',
        POSITION_POST_TYPE, 'normal', 'high');
    remove_meta_box('postimagediv', POSITION_POST_TYPE, 'side');
    add_meta_box('postimagediv', __('Position image'), 'post_thumbnail_meta_box', POSITION_POST_TYPE, 'normal', 'high');
    add_meta_box('wp_custom_attachment', 'PDF File', 'wp_custom_attachment', POSITION_POST_TYPE,
        'custom-metabox-holder');

}

add_action('add_meta_boxes', 'add_custom_meta_box');

function render_awesome_metabox($post)
{
    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta        = get_post_meta($post->ID);
    $aft_select_stored_meta = get_post_meta($post->ID, 'type-of-engagement', true);
    ?>
    <div class="awesome-meta-admin">
        <p>
            <label for="short_title" class="short_title"><?php _e('Short title', '') ?></label>
            <input class="widefat" type="text" name="short_title" id="short_title"
                   value="<?php if (isset ($aft_stored_meta['short_title'])) {
                       echo $aft_stored_meta['short_title'][0];
                   } ?>"/> <br>
        </p>
        <p>
            <label for="department" class="department"><?php _e('Department', '') ?></label>
            <input class="widefat" type="text" name="department" id="department"
                   value="<?php if (isset ($aft_stored_meta['department'])) {
                       echo $aft_stored_meta['department'][0];
                   } ?>"/> <br>
        </p>
        <p>
            <label for="reports-to" class="reports-to"><?php _e('Reports to', '') ?></label>
            <input class="widefat" type="text" name="reports-to" id="reports-to"
                   value="<?php if (isset ($aft_stored_meta['reports-to'])) {
                       echo $aft_stored_meta['reports-to'][0];
                   } ?>"/> <br>
        </p>
        <p>
            <label for="location" class="location"><?php _e('Location', '') ?></label>
            <input class="widefat" type="text" name="location" id="location"
                   value="<?php if (isset ($aft_stored_meta['location'])) {
                       echo $aft_stored_meta['location'][0];
                   } ?>"/> <br>
        </p>
        <p>
            <label for="pdf-job-description-link" class="pdf-job-description-link"><?php _e('PDF Job Description Link',
                    '') ?></label>
            <input class="widefat" type="text" name="pdf-job-description-link" id="pdf-job-description-link"
                   value="<?php if (isset ($aft_stored_meta['pdf-job-description-link'])) {
                       echo $aft_stored_meta['pdf-job-description-link'][0];
                   } ?>"/> <br>
        </p>
        <p>
            <label for="apply-for-job-form-link" class="apply-for-job-form-link"><?php _e('Apply for Job Form Link',
                    '') ?></label>
            <input class="widefat" type="text" name="apply-for-job-form-link" id="apply-for-job-form-link"
                   value="<?php if (isset ($aft_stored_meta['apply-for-job-form-link'])) {
                       echo $aft_stored_meta['apply-for-job-form-link'][0];
                   } ?>"/> <br>
        </p>
        <p>
            <input class="widefat" type="checkbox" name="available-position" id="available-position"
                   <?php if ($aft_stored_meta['available-position'][0] == true) { ?>checked="checked"<?php } ?> /><?php _e('Available Position?',
                '') ?>
            </br>
        </p>
        <p>
            <label for="type-of-engagement" class="type-of-engagement"><?php _e('Type of engagement', '') ?></label>

            <select name="type-of-engagement" id="type-of-engagement">
                <option value="Full Time" <?php selected($aft_select_stored_meta, 'Full Time'); ?>>Full
                    Time
                </option>
                <option value="Half Time" <?php selected($aft_select_stored_meta, 'Half Time'); ?>>Half
                    Time
                </option>
            </select>
        </p>
        <p>
            <label for="salary" class="salary"><?php _e('Salary', '') ?></label>
            <input class="widefat" type="text" name="salary" id="salary"
                   value="<?php if (isset ($aft_stored_meta['salary'])) {
                       echo $aft_stored_meta['salary'][0];
                   } ?>"/> <br>
        </p>
    </div>
    <?php
}

function wp_custom_attachment()
{
    wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_attachment_nonce');
    $html = '<p class="description">Upload your PDF here.</p>';
    $html .= '<input id="wp_custom_attachment" name="wp_custom_attachment" size="25" type="file" value="" />';

    $filearray = get_post_meta(get_the_ID(), 'wp_custom_attachment', true);
    $this_file = $filearray;
    if ($this_file != '') {
        $html .= '<div><p><strong>Current file:</strong> ' . $this_file['url'] . '</p></div>';
    }
    echo $html;
}

function not_available_text_editor_box($post)
{
    wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');

    $field_value = get_post_meta($post->ID, 'not_available_text', false);
    wp_editor($field_value[0], 'not_available_text');
}

function cmt_position_meta_save($post_id)
{

    $is_autosave    = wp_is_post_autosave($post_id);
    $is_revision    = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpaft_nonce']) && wp_verify_nonce($_POST['wpaft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';

    if ($is_autosave || $is_revision || ! $is_valid_nonce) {
        return;
    }

    if (isset($_POST['short_title'])) {
        update_post_meta($post_id, 'short_title',
            sanitize_text_field($_POST['short_title']));
    }

    if (isset($_POST['department'])) {
        update_post_meta($post_id, 'department',
            sanitize_text_field($_POST['department']));
    }
    if (isset($_POST['reports-to'])) {
        update_post_meta($post_id, 'reports-to',
            sanitize_text_field($_POST['reports-to']));
    }
    if (isset($_POST['location'])) {
        update_post_meta($post_id, 'location',
            sanitize_text_field($_POST['location']));
    }
    if (isset($_POST['reports-to'])) {
        update_post_meta($post_id, 'reports-to',
            sanitize_text_field($_POST['reports-to']));
    }
    if (isset($_POST['apply-for-job-form-link'])) {
        update_post_meta($post_id, 'apply-for-job-form-link', $_POST['apply-for-job-form-link']);
    }
    if (isset($_POST['pdf-job-description-link'])) {
        update_post_meta($post_id, 'pdf-job-description-link', $_POST['pdf-job-description-link']);
    }
    if (isset($_POST['available-position'])) {
        update_post_meta($post_id, 'available-position', $_POST['available-position']);
    } else {
        delete_post_meta($post_id, 'available-position');
    }
    if (isset($_POST['type-of-engagement'])) {
        update_post_meta($post_id, 'type-of-engagement', $_POST['type-of-engagement']);
    }
    if (isset($_POST['salary'])) {
        update_post_meta($post_id, 'salary',
            sanitize_text_field($_POST['salary']));
    }
    if (isset($_POST['not_available_text'])) {
        $postarr = str_replace('<ul>', '<ul class="list-text">', $_POST['not_available_text']);
        $postarr = str_replace('<ol>', '<ol class="list-text">', $postarr);
        update_post_meta($post_id, 'not_available_text', $postarr);
    }

    if ( ! empty($_FILES['wp_custom_attachment']['name'])) {
        $supported_types = array('application/pdf');
        $arr_file_type   = wp_check_filetype(basename($_FILES['wp_custom_attachment']['name']));
        $uploaded_type   = $arr_file_type['type'];

        if (in_array($uploaded_type, $supported_types)) {
            $upload = wp_upload_bits($_FILES['wp_custom_attachment']['name'], null,
                file_get_contents($_FILES['wp_custom_attachment']['tmp_name']));
            if (isset($upload['error']) && $upload['error'] != 0) {
                wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
            } else {
                update_post_meta($post_id, 'wp_custom_attachment', $upload);
            }
        } else {
            wp_die("The file type that you've uploaded is not a PDF.");
        }
    }

}

add_action('save_post', 'cmt_position_meta_save');

function update_edit_form()
{
    echo ' enctype="multipart/form-data"';
}

add_action('post_edit_form_tag', 'update_edit_form');