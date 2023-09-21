<?php


add_action('add_meta_boxes', 'cmt_location_add_meta_box');

function cmt_location_add_meta_box()
{
    add_meta_box('location_info', __('Location info'), 'cmt_location_info_callback', LOCATION_POST_TYPE, 'normal',
        'high');
    add_meta_box('coordinates', __('Coordinates'), 'cmt_location_meta_callback', LOCATION_POST_TYPE, 'normal', 'high');
}


function cmt_location_info_callback($post)
{
    wp_nonce_field(__FILE__, 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>
    <p>
        <label for="name" class="name"><?php _e('Name:', '') ?></label>
        <input type="text" name="name" id="name" class="widefat"
               value="<?php if (isset ($aft_stored_meta['name'])) {
                   echo $aft_stored_meta['name'][0];
               } ?>"/>
        <br>
    </p>
    <p>
        <label for="order_location" class="order_location"><?php _e('Order:', '') ?></label>
        <input type="number" name="order_location" min="0" id="order_location" class="widefat"
               value="<?php if (isset ($aft_stored_meta['order_location'])) {
                   echo $aft_stored_meta['order_location'][0];
               } ?>" required/>
        <br>
    </p>
    <p>
        <label for="email" class="email"><?php _e('Email:', '') ?></label>
        <input type="text" name="email" id="email" class="widefat"
               value="<?php if (isset ($aft_stored_meta['email'])) {
                   echo $aft_stored_meta['email'][0];
               } ?>"/>
        <br>
    </p>
    <p>
        <label for="phone" class="phone"><?php _e('Phone (for example:123.456.7890):', '') ?></label>
        <input type="text" name="phone" id="phone" class="widefat" pattern="^\[0-9]{3}\.[0-9]{3}.[0-9]{4}$"
               value="<?php if (isset ($aft_stored_meta['phone'])) {
                   echo $aft_stored_meta['phone'][0];
               } ?>"/>
        <br>
    </p>

    <p>
        <label for="website_url" class="website_url"><?php _e('Website url', '') ?></label>
        <input type="url" name="website_url" id="website_url" class="widefat"
               value="<?php if (isset ($aft_stored_meta['website_url'])) {
                   echo $aft_stored_meta['website_url'][0];
               } ?>"/>
        <br>
    </p>
    <p>
        <label for="location_address" class="location_address"><?php _e('Location address', '') ?></label>
        <input type="text" name="location_address" id="location_address" class="widefat"
               value="<?php if (isset ($aft_stored_meta['location_address'])) {
                   echo $aft_stored_meta['location_address'][0];
               } ?>"/>
        <br>
    </p>
    <p>
        <label for="location_key_words" class="location_key_words"><?php _e('Search key words', '') ?></label>
        <textarea type="text" name="location_key_words" id="location_key_words" class="widefat"><?php if (isset ($aft_stored_meta['location_key_words'])) {echo $aft_stored_meta['location_key_words'][0];}?></textarea>
        <br>
    </p>
    <p>
        <label for="location_account_link" class="location_account_link"><?php _e('Location account link', '') ?></label>
        <input type="text" name="location_account_link" id="location_account_link" class="widefat"
               value="<?php if (isset ($aft_stored_meta['location_account_link'])) {
                   echo $aft_stored_meta['location_account_link'][0];
               } ?>"/>
        <br>
    </p>
    <?php
}

function cmt_location_meta_callback($post)
{

    wp_nonce_field(basename(__FILE__), 'aft_nonce');
    $aft_stored_meta = get_post_meta($post->ID);
    ?>

    <p>
        <label for="latitude" class="latitude"><?php _e('Latitude:', '') ?></label>
        <input step="any" type="number" name="latitude" id="latitude" class="widefat"
               value="<?php if (isset ($aft_stored_meta['latitude'])) {
                   echo $aft_stored_meta['latitude'][0];
               } ?>" required/>
        <br>
    </p>
    <p>
        <label for="longitude" class="longitude"><?php _e('Longitude:', '') ?></label>
        <input step="any" type="number" name="longitude" id="longitude" class="widefat"
               value="<?php if (isset ($aft_stored_meta['longitude'])) {
                   echo $aft_stored_meta['longitude'][0];
               } ?>" required/>
        <br>
    </p>
    <?php
}


add_action('save_post', 'cmt_location_meta_save');

function cmt_location_meta_save($post_id)
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
    if (isset($_POST['latitude'])) {
        update_post_meta($post_id, 'latitude', $_POST['latitude']);
    }
    if (isset($_POST['longitude'])) {
        update_post_meta($post_id, 'longitude', $_POST['longitude']);
    }
    if (isset($_POST['name'])) {
        update_post_meta($post_id, 'name', $_POST['name']);
    }
    if (isset($_POST['order_location'])) {
        update_post_meta($post_id, 'order_location', $_POST['order_location']);
    }
    if (isset($_POST['email'])) {
        update_post_meta($post_id, 'email', $_POST['email']);
    }
    if (isset($_POST['phone'])) {
        update_post_meta($post_id, 'phone', $_POST['phone']);
    }
    if (isset($_POST['website_url'])) {
        update_post_meta($post_id, 'website_url', $_POST['website_url']);
    }
    if (isset($_POST['location_address'])) {
        update_post_meta($post_id, 'location_address', $_POST['location_address']);
    }
    if (isset($_POST['location_key_words'])) {
        update_post_meta($post_id, 'location_key_words', sanitize_text_field($_POST['location_key_words']));
    }
    if (isset($_POST['location_account_link'])) {
        update_post_meta($post_id, 'location_account_link', sanitize_text_field($_POST['location_account_link']));
    }

}