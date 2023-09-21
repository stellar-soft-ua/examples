<div class="wrap">
    <h2><img src="{{ theme_resource_url() }}assets/dist/images/admin/theme_icon_m.png"> WeLoveYou</h2>
    <p>Das theme theme basiert auf
        <a href="http://getbootstrap.com/" target="_blank">Bootstrap</a>,
        <a href="http://materializecss.com/" target="_blank">materialize css</a> und
        <a href="mmenu.frebsite.nl/" target="_blank">mmenu</a>.
    </p>
    <p>Der Slider im DIVI Builder Modul "Slider" basiert auf <a href="http://idangero.us/swiper" target="_blank">swiper</a>.
        Falls dieses Modul verwendet wird, muss Swiper in den Theme Einstellungen aktiviert werden.</p>
    <p>Für Icons steht <a href="https://material.io/icons/" target="_blank">Material Icons</a> zur Verfügung.</p>

    <h2>Einstellungen</h2>
    <form method="post" action="options.php">
        <?php settings_fields( 'theme_option_group' ); ?>
        <?php do_settings_sections( 'theme_option_group' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Google Tag Manager</th>
                <td>
                    <p><label for="google_tag_manager_head">Head</label></p>
                    <p><textarea class="large-text code" rows="10" cols="50" name="google_tag_manager_head" id="google_tag_manager_head"><?php echo esc_attr( get_option('google_tag_manager_head') ); ?></textarea></p>
                    <p><label for="google_tag_manager_body">Body</label></p>
                    <p><textarea class="large-text code" rows="10" cols="50" name="google_tag_manager_body" id="google_tag_manager_body"><?php echo esc_attr( get_option('google_tag_manager_body') ); ?></textarea></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Google Recaptcha</th>
                <td>
                    <p><label for="recaptcha_secret">Secret</label></p>
                    <p><input class="regular-text" type="text" id="recaptcha_secret" name="recaptcha_secret" value="<?php echo esc_attr( get_option('recaptcha_secret') ); ?>" /></p>
                    <p><label for="recaptcha_sitekey">Sitekey</label></p>
                    <p><input class="regular-text" type="text" id="recaptcha_sitekey" name="recaptcha_sitekey" value="<?php echo esc_attr( get_option('recaptcha_sitekey') ); ?>" /></p>
                    <p class="description">Codes <a href="https://www.google.com/recaptcha/admin#list" target="_blank">hier</a> generieren. Mit dem weloveyou-Account. Zugangsdaten im Passpack. Es ist wichtig, jedes Formualr mit einem Captcha gegen Bots abzusichern.</p>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Google Maps</th>
                <td>
                    <p><label for="google_maps_api_key">Google Maps API Key</label></p>
                    <p><input class="regular-text" type="text" id="google_maps_api_key" name="google_maps_api_key" value="<?php echo esc_attr( get_option('google_maps_api_key') ); ?>" /></p>
                    <p class="description">Codes <a href="https://developers.google.com/maps/documentation/javascript/get-api-key?hl=de" target="_blank">hier</a> generieren. Mit dem weloveyou-Account. Zugangsdaten im Passpack.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Erlaube SVG</th>
                <td>
                    <input type="checkbox" name="allow_svg" value="1" <?php checked( '1', get_option( 'allow_svg' ) ) ?> />
                    <p class="description">Erlaube SVGs im Tiny MCE Editor</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">deaktiviere wpautop</th>
                <td>
                    <input type="checkbox" name="enable_wpautop" value="1" <?php checked( '1', get_option( 'enable_wpautop' ) ) ?> />
                    <p class="description"><a href="https://codex.wordpress.org/Function_Reference/wpautop" target="_blank">wpautop</a> wandelt doppelte Zeilenumbrüche in p tags um. Nicht immer ist dieser Effekt willkommen.</p>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Materialize css generieren</th>
                <td>
                    <label for="enable_materialize">
                        generieren
                    </label>
                    <p class="description">Materialize CSS (Grid, Formular, ...) wird ohne _navbar.scss geladen. _navbar.scss wird auch geladen, sobald Materialize als Menu Frontend Framework gewählt ist.</p>
                    <p>
                        <a class="button button-primary" id="rendermaterializecss">materializecss neu berechnen</a>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Zeige Admin-Menü</th>
                <td>
                    <label for="enable_admin_menu">
                        <input type="checkbox" id="enable_admin_menu" name="enable_admin_menu" value="1" <?php checked( '1', get_option( 'enable_admin_menu' ) ) ?> />
                        Aktiviere diese Option, um im Frontend das Wordpress Admin Menü anzuzeigen.
                    </label>
                    <p class="description">Wir empfehlen, dieses Menü nicht anzuzeigen.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Menu Frontend Framework</th>
                <td>
                    <select name="menu_frontend_framework">
                        <option <?php selected( '', get_option( 'menu_frontend_framework' ) ) ?> value="">- bitte wählen -</option>
                        <option <?php selected( 'clean', get_option( 'menu_frontend_framework' ) ) ?> value="clean">clean html</option>
                        <option <?php selected( 'bootstrap', get_option( 'menu_frontend_framework' ) ) ?> value="bootstrap">Bootstrap</option>
                        <option <?php selected( 'materialize', get_option( 'menu_frontend_framework' ) ) ?> value="materialize">Materialize</option>
                    </select>
                    <p class="description">In der Regel sollte man Clean wählen. Ausser man will Bootstrap oder Materialize als Menü.</p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Divi Love Form Framework</th>
                <td>
                    <select name="love_form_framework">
                        <option <?php selected( '', get_option( 'love_form_framework' ) ) ?> value="">- bitte wählen -</option>
                        <option <?php selected( 'clean', get_option( 'love_form_framework' ) ) ?> value="clean">clean html</option>
                        <option <?php selected( 'bootstrap', get_option( 'love_form_framework' ) ) ?> value="bootstrap">Bootstrap</option>
                        <option <?php selected( 'materialize', get_option( 'love_form_framework' ) ) ?> value="materialize">Materialize</option>
                    </select>
                    <p class="description">Diese Einstellung hat eine Auswirkung auf den dom (klassen, elemente) vom Formular. Stelle sicher, dass das entsprechende Framework korrekt geladen wird.</p>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
    <p>Diese Plugins werden benötigt:</p>
    <ul>
        <li>
            @if (is_plugin_active('theme.wp.plugin.divi/index.php')) <span class="dashicons dashicons-yes"></span> @else <span class="dashicons dashicons-no"></span> @endif
            <a href="https://github.com/WeLoveYouCH/theme.wp.plugin.divi" target="_blank">
                theme divi
            </a>
            <code>https://github.com/WeLoveYouCH/theme.wp.plugin.divi.git</code>
        </li>
        <li>
            @if (is_plugin_active('theme.wp.plugin.love/index.php')) <span class="dashicons dashicons-yes"></span> @else <span class="dashicons dashicons-no"></span> @endif
            <a href="https://github.com/WeLoveYouCH/theme.wp.plugin.love" target="_blank">
                theme love
            </a>
            <code>https://github.com/WeLoveYouCH/theme.wp.plugin.love.git</code>
        </li>
        <li>
            @if (is_plugin_active('theme.wp.plugin.flyimage/index.php')) <span class="dashicons dashicons-yes"></span> @else <span class="dashicons dashicons-no"></span> @endif
            <a href="https://github.com/WeLoveYouCH/theme.wp.plugin.flyimage" target="_blank">
                theme fly image
            </a>
            <code>https://github.com/WeLoveYouCH/theme.wp.plugin.flyimage.git</code>
        </li>
        <li>
            @if (is_plugin_active('theme.wp.plugin.remove-emojis/index.php')) <span class="dashicons dashicons-yes"></span> @else <span class="dashicons dashicons-no"></span> @endif
            <a href="https://github.com/WeLoveYouCH/theme.wp.plugin.remove-emojis" target="_blank">
                theme remove-emojis
            </a>
            <code>https://github.com/WeLoveYouCH/theme.wp.plugin.remove-emojis.git</code>
        </li>
        <li>
            @if (is_plugin_active('divi-builder/divi-builder.php')) <span class="dashicons dashicons-yes"></span> @else <span class="dashicons dashicons-no"></span> @endif
            <a href="https://www.elegantthemes.com/members-area/download.php?file=divi-builder" target="_blank">
                Divi Builder</a>
        </li>
    </ul>
    <p>
        @if (is_dir(get_home_path() . 'app/uploads/fly'))
            <span class="dashicons dashicons-yes"></span> Der Ordner <code>uploads/fly</code> existiert.
        @else
            <span class="dashicons dashicons-no"></span> Der Ordner <code>uploads/fly</code> fehlt.
            <a class="button button-primary" id="createflydir">ordner erstellen</a>
        @endif
    </p>
    <p>Die theme Plugins können direkt in den plugins-Ordner gecloned werden: <code>$ git clone {url}</code>.<br>
        Das theme Framework muss in den Ordner <code>mu-plugins</code> gecloned werden.<br>
    <ul>
        <li>
            @if ( defined( 'theme_CORE_DIR' ) ) <span class="dashicons dashicons-yes"></span> @else <span class="dashicons dashicons-no"></span> @endif
            <a href="https://github.com/WeLoveYouCH/theme.wp.framework" target="_blank">
                theme framework
            </a>
            <code>https://github.com/WeLoveYouCH/theme.wp.framework.git</code>
        </li>
    </ul>
    <p> Nach dem clonen vom Git muss noch composer ausgeführt werden: <br>
        <code>$ composer install</code><br>
        <code>$ composer update</code></p>
    <p>Weitere oft genutzte Plugins:</p>
    <ul>
        <li>
            @if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) <span class="dashicons dashicons-yes"></span> @else <span class="dashicons dashicons-no"></span> @endif
            <a href="https://wpml.org/account/downloads/" target="_blank">
                WPML Multilingual CMS</a>
        </li>
        <li>
            @if (is_plugin_active('wpml-string-translation/plugin.php')) <span class="dashicons dashicons-yes"></span> @else <span class="dashicons dashicons-no"></span> @endif
            <a href="https://wpml.org/account/downloads/" target="_blank">
                WPML String Translation</a>
        </li>
        <li>
            @if (is_plugin_active('wpml-translation-management/plugin.php')) <span class="dashicons dashicons-yes"></span> @else <span class="dashicons dashicons-no"></span> @endif
            <a href="https://wpml.org/account/downloads/" target="_blank">
                WPML Translation Management</a>
        </li>
        <li>
            @if (is_plugin_active('wordpress-seo/wp-seo.php')) <span class="dashicons dashicons-yes"></span> @else <span class="dashicons dashicons-no"></span> @endif
            <a href="http://downloads.wordpress.org/plugin/wordpress-seo.latest-stable.zip" target="_blank">
                Yoast SEO</a>
        </li>
        <li>
            @if (is_plugin_active('tinymce-advanced/tinymce-advanced.php')) <span class="dashicons dashicons-yes"></span> @else <span class="dashicons dashicons-no"></span> @endif
            <a href="https://de-ch.wordpress.org/plugins/tinymce-advanced/" target="_blank">
                Tinymce advanced</a>
        </li>

        <li>
            @if (is_plugin_active('real-media-library/real-media-library.php')) <span class="dashicons dashicons-yes"></span> @else <span class="dashicons dashicons-no"></span> @endif
            <a href="https://themeforest.net/downloads" target="_blank">
                WordPress Real Media Library - Media Categories / Folders</a>
        </li>
    </ul>
</div>