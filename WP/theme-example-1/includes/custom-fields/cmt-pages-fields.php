<?php
function cmt_pages_add_meta_box()
{
    add_meta_box('cmt_pages_meta', __('Product selector'), 'cmt_pages_meta_callback', 'page', 'normal', 'high');
    //Use list of countries entered on Blocked Countries page. Nevet used, so hide thi meta box
//    add_meta_box('cmt_pages_meta_block', __('Blocked Country'), 'cmt_pages_meta_blocked_callback', 'page', 'normal', 'low');
}

add_action('add_meta_boxes', 'cmt_pages_add_meta_box');

function cmt_pages_meta_callback($post)
{
    ?>
    <div class="product-selector-container">
        <select class="pages-product-selector">
            <option value="">Choose Product Type</option>
            <option value="<?=VNA_POST_TYPE?>">VNAs</option>
            <option value="<?=CALIBRATION_KITS_POST_TYPE?>">50 Ohm Calibration Kits and Accessories</option>
            <option value="<?=FREQUENCY_EXTENSION_POST_TYPE?>">50 Ohm Frequency Extension System</option>
        </select>
        <div class="products-list-container">
            <label>Products list:</label>
            <ul class="list-container">
                <p class="product-no-items">No items to display</p>
            </ul>
        </div>
    </div>
    <?php

}

function cmt_pages_meta_blocked_callback($post)
{
    $blocked_page_by_country = get_post_meta($post->ID, 'blocked_page_by_country', true);
    ?>
    <div class="blocked-country-container">
        <p><label><input type="checkbox" name="blocked_page_by_country"<?=$blocked_page_by_country ? " checked" : ""?> value="1"></label> - Blocked this page by country IP</p>
    </div>
    <?php

}

add_action('save_post', 'cmt_save_page_meta');

function cmt_save_page_meta($post_id)
{
    $is_autosave    = wp_is_post_autosave($post_id);
    $is_revision    = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpaft_nonce']) && wp_verify_nonce($_POST['wpaft_nonce'],
            basename(__FILE__))) ? 'true' : 'false';
    if ($is_autosave || $is_revision || ! $is_valid_nonce) {
        return;
    }

    if (isset($_POST['blocked_page_by_country']) && $_POST['blocked_page_by_country']) {
        update_post_meta($post_id, 'blocked_page_by_country', 1);
    } else {
        delete_post_meta($post_id, 'blocked_page_by_country');
    }
}
