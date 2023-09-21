<?php

function add_languages_field_to_general_admin_page()
{
    add_menu_page('Countries languages', 'Countries languages', 'manage_options', 'country-options',
        'languages_list_setting_callback_function', '');
    add_option('chinese_countries', [], 'List of chinese countries', 'yes');
    add_option('spanish_countries', [], 'List of chinese countries', 'yes');
    add_option('portuguese_countries', [], 'List of chinese countries', 'yes');
    add_option('japanese_countries', [], 'List of chinese countries', 'yes');
}

add_action('admin_menu', 'add_languages_field_to_general_admin_page');

function languages_list_setting_callback_function()
{
    $countries         = json_decode(curl_get_file_contents("http://country.io/names.json"));
    $chinese_countries = get_option('chinese_countries');
    $portuguese_countries = get_option('portuguese_countries');
    $spanish_countries = get_option('spanish_countries');
    $japanese_countries = get_option('japanese_countries');
    ?>
    <div id="wpbody">
    <h2>Chinese countries</h2>
    <div class="row-main">
        <div class="row-1">
            <select name="from[]" id="chinese_select" class="form-control" size="20" multiple="multiple">
                <?php foreach ($countries as $country): ?>
                    <option value="<?= $country ?>"><?= $country ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="row-2">
            <div class="col-xs-2">
                <button type="button" id="chinese_select_rightAll" class="preview button"><span
                        class="dashicons dashicons-controls-forward"></button>
                <button type="button" id="chinese_select_rightSelected" class="preview button"><span
                        class="dashicons dashicons-arrow-right-alt"></span></button>
                <button type="button" id="chinese_select_leftSelected" class="preview button"><span
                        class="dashicons dashicons-arrow-left-alt"></span></button>
                <button type="button" id="chinese_select_leftAll" class="preview button"><span
                        class="dashicons dashicons-controls-back"></span></button>
            </div>
        </div>
        <div class="row-1">
            <select name="to[]" id="chinese_select_to" size="20" multiple="multiple" class="chinese">
                <?php foreach ($chinese_countries as $chinese): ?>
                    <option value="<?= $chinese ?>"><?= $chinese ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <button class="button button-primary button-large update-btn chinese-btn">UPDATE</button>

        <h2>Portuguese countries</h2>
        <div class="row-main">
            <div class="row-1">
                <select name="from[]" id="portuguese_select" class="form-control" size="20" multiple="multiple">
                    <?php foreach ($countries as $country_2): ?>
                        <option value="<?= $country_2 ?>"><?= $country_2 ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="row-2">
                <div class="col-xs-2">
                    <button type="button" id="portuguese_select_rightAll" class="preview button"><span
                                class="dashicons dashicons-controls-forward"></button>
                    <button type="button" id="portuguese_select_rightSelected" class="preview button"><span
                                class="dashicons dashicons-arrow-right-alt"></span></button>
                    <button type="button" id="portuguese_select_leftSelected" class="preview button"><span
                                class="dashicons dashicons-arrow-left-alt"></span></button>
                    <button type="button" id="portuguese_select_leftAll" class="preview button"><span
                                class="dashicons dashicons-controls-back"></span></button>
                </div>
            </div>
            <div class="row-1">
                <select name="to[]" id="portuguese_select_to" size="20" multiple="multiple" class="portuguese">
                    <?php foreach ($portuguese_countries as $portuguese): ?>
                        <option value="<?= $portuguese ?>"><?= $portuguese ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button class="button button-primary button-large update-btn portuguese-btn">UPDATE</button>

        <h2>Spanish countries</h2>
        <div class="row-main">
            <div class="row-1">
                <select name="from[]" id="spanish_select" class="form-control" size="20" multiple="multiple">
                    <?php foreach ($countries as $country_2): ?>
                        <option value="<?= $country_2 ?>"><?= $country_2 ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="row-2">
                <div class="col-xs-2">
                    <button type="button" id="spanish_select_rightAll" class="preview button"><span
                                class="dashicons dashicons-controls-forward"></button>
                    <button type="button" id="spanish_select_rightSelected" class="preview button"><span
                                class="dashicons dashicons-arrow-right-alt"></span></button>
                    <button type="button" id="spanish_select_leftSelected" class="preview button"><span
                                class="dashicons dashicons-arrow-left-alt"></span></button>
                    <button type="button" id="spanish_select_leftAll" class="preview button"><span
                                class="dashicons dashicons-controls-back"></span></button>
                </div>
            </div>
            <div class="row-1">
                <select name="to[]" id="spanish_select_to" size="20" multiple="multiple" class="spanish">
                    <?php foreach ($spanish_countries as $spanish): ?>
                        <option value="<?= $spanish ?>"><?= $spanish ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button class="button button-primary button-large update-btn spanish-btn">UPDATE</button>

        <h2>Japanese countries</h2>
        <div class="row-main">
            <div class="row-1">
                <select name="from[]" id="japanese_select" class="form-control" size="20" multiple="multiple">
                    <?php foreach ($countries as $country_2): ?>
                        <option value="<?= $country_2 ?>"><?= $country_2 ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="row-2">
                <div class="col-xs-2">
                    <button type="button" id="japanese_select_rightAll" class="preview button"><span
                                class="dashicons dashicons-controls-forward"></button>
                    <button type="button" id="japanese_select_rightSelected" class="preview button"><span
                                class="dashicons dashicons-arrow-right-alt"></span></button>
                    <button type="button" id="japanese_select_leftSelected" class="preview button"><span
                                class="dashicons dashicons-arrow-left-alt"></span></button>
                    <button type="button" id="japanese_select_leftAll" class="preview button"><span
                                class="dashicons dashicons-controls-back"></span></button>
                </div>
            </div>
            <div class="row-1">
                <select name="to[]" id="japanese_select_to" size="20" multiple="multiple" class="japanese">
                    <?php foreach ($japanese_countries as $japanese): ?>
                        <option value="<?= $japanese ?>"><?= $japanese ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button class="button button-primary button-large update-btn japanese-btn">UPDATE</button>
    </div>

    <?php
}