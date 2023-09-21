<?php
function cmt_custom_pages_search_add_meta_box()
{
    add_meta_box('cmt_custom_pages_search_meta', __('Include in Search Results'), 'cmt_custom_pages_search_meta_callback', 'page', 'normal', 'high');
}
add_action('add_meta_boxes', 'cmt_custom_pages_search_add_meta_box');

function cmt_custom_pages_search_meta_callback($post)
{
    wp_nonce_field(plugin_basename(__FILE__), 'custom_pages_search_nonce');

    $show_in_search_results_videos = get_post_meta($post->ID, CPM_SHOW_IN_SEARCH_RESULTS_VIDEOS, true);
    $show_in_search_results_webinars = get_post_meta($post->ID, CPM_SHOW_IN_SEARCH_RESULTS_WEBINARS, true);
    $show_in_search_results_latest_news = get_post_meta($post->ID, CPM_SHOW_IN_SEARCH_RESULTS_LATEST_NEWS, true);
    $show_in_search_results_case_studies = get_post_meta($post->ID, CPM_SHOW_IN_SEARCH_RESULTS_CASE_STUDIES, true);
    ?>
    <p>
        <input
            type="checkbox"
            id="show_in_search_results_videos"
            name="show_in_search_results_videos"
            <?=$show_in_search_results_videos ? 'checked' : '';?>
            value="1"
        />
        <label for="show_in_search_results_videos"><?php _e('Show in search results on Videos page:', ''); ?></label>
    </p>
    <p>
        <input
            type="checkbox"
            id="show_in_search_results_webinars"
            name="show_in_search_results_webinars"
            <?=$show_in_search_results_webinars ? 'checked' : '';?>
            value="1"
        />
        <label for="show_in_search_results_webinars"><?php _e('Show in search results on Webinars page:', ''); ?></label>
    </p>
    <p>
        <input
            type="checkbox"
            id="show_in_search_results_latest_news"
            name="show_in_search_results_latest_news"
            <?=$show_in_search_results_latest_news ? 'checked' : '';?>
            value="1"
        />
        <label for="show_in_search_results_latest_news"><?php _e('Show in search results on Latest News page:', ''); ?></label>
    </p>
    <p>
        <input
            type="checkbox"
            id="show_in_search_results_case_studies"
            name="show_in_search_results_case_studies"
            <?=$show_in_search_results_case_studies ? 'checked' : '';?>
            value="1"
        />
        <label for="show_in_search_results_case_studies"><?php _e('Show in search results on Case Studies page:', ''); ?></label>
    </p>
    <?php
}

function cmt_custom_pages_search_meta_save($post_id)
{
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = isset($_POST['custom_pages_search_nonce']) && wp_verify_nonce($_POST['custom_pages_search_nonce'],
            plugin_basename(__FILE__));

    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    if (isset($_POST[CPM_SHOW_IN_SEARCH_RESULTS_VIDEOS]) && $_POST[CPM_SHOW_IN_SEARCH_RESULTS_VIDEOS]) {
        update_post_meta($post_id, CPM_SHOW_IN_SEARCH_RESULTS_VIDEOS, 1);
    } else {
        delete_post_meta($post_id, CPM_SHOW_IN_SEARCH_RESULTS_VIDEOS);
    }

    if (isset($_POST[CPM_SHOW_IN_SEARCH_RESULTS_WEBINARS]) && $_POST[CPM_SHOW_IN_SEARCH_RESULTS_WEBINARS]) {
        update_post_meta($post_id, CPM_SHOW_IN_SEARCH_RESULTS_WEBINARS, 1);
    } else {
        delete_post_meta($post_id, CPM_SHOW_IN_SEARCH_RESULTS_WEBINARS);
    }

    if (isset($_POST[CPM_SHOW_IN_SEARCH_RESULTS_LATEST_NEWS]) && $_POST[CPM_SHOW_IN_SEARCH_RESULTS_LATEST_NEWS]) {
        update_post_meta($post_id, CPM_SHOW_IN_SEARCH_RESULTS_LATEST_NEWS, 1);
    } else {
        delete_post_meta($post_id, CPM_SHOW_IN_SEARCH_RESULTS_LATEST_NEWS);
    }

    if (isset($_POST[CPM_SHOW_IN_SEARCH_RESULTS_CASE_STUDIES]) && $_POST[CPM_SHOW_IN_SEARCH_RESULTS_CASE_STUDIES]) {
        update_post_meta($post_id, CPM_SHOW_IN_SEARCH_RESULTS_CASE_STUDIES, 1);
    } else {
        delete_post_meta($post_id, CPM_SHOW_IN_SEARCH_RESULTS_CASE_STUDIES);
    }
}
add_action('save_post', 'cmt_custom_pages_search_meta_save');
