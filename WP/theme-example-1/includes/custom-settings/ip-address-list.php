<?php

function add_option_field_to_general_admin_page()
{
    add_menu_page('Blacklist', 'Blocked countries', 'manage_options', 'site-options',
        'ip_list_setting_callback_function', '');
    add_option('countries_list', [], 'List of countries', 'yes');
}

add_action('admin_menu', 'add_option_field_to_general_admin_page');

function ip_list_setting_callback_function()
{
    $countries         = json_decode(curl_get_file_contents("http://country.io/names.json"));
    $blocked_countries = get_option('countries_list');
    ?>
    <h2>Countries whitelist</h2>
    <div class="row-main">
        <div class="row-1">
            <select name="blocked-country-from[]" id="multiselect" class="form-control" size="20" multiple="multiple">
                <?php foreach ($countries as $country): ?>
                    <option value="<?= $country ?>"><?= $country ?></option>
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
            <select name="blocked-country-post[]" id="multiselect_to" size="20" multiple="multiple" class="blocked">
                <?php foreach ($blocked_countries as $blocked_country): ?>
                    <option value="<?= $blocked_country ?>"><?= $blocked_country ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <button class="button button-primary button-large update-btn black-list">UPDATE</button>
    </div>
    <?php
}