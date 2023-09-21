<?php

class ThemeVideoYoutube extends Theme_Builder_Blade_Module
{
    function init()
    {
        parent::getDefaults(); // load theme divi module defaults


        $this->name = esc_html__('THEME Video Youtube', 'theme');
        $this->slug = 'et_pb_theme_video_youtube';

    }


    function get_fields()
    {
        $fields = array(
            'disabled_on' => array(
                'label' => esc_html__('Disable on', 'theme'),
                'type' => 'multiple_checkboxes',
                'options' => array(
                    'phone' => esc_html__('Phone', 'theme'),
                    'tablet' => esc_html__('Tablet', 'theme'),
                    'desktop' => esc_html__('Desktop', 'theme'),
                ),
                'additional_att' => 'disable_on',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('This will disable the module on selected devices', 'theme'),
            ),
            'youtube_link' => array(
                'label' => esc_html__('Youtube ID', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('Die ID des Youtube Videos, z.B. (dzpFg7D4nNo). Wenn bei Youtube auf Teilen geklickt wird, dann ist die ID der letzte Block hinter dem Slash.', 'theme'),
            ),
            'image' => array(
                'label' => esc_html__('Vorschaubild', 'theme'),
                'type' => 'upload',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'upload_button_text' => esc_attr__('Upload an image', 'theme'),
                'choose_text' => esc_attr__('Choose a Slide Image', 'theme'),
                'update_text' => esc_attr__('Set As Slide Image', 'theme'),
                'description' => esc_html__('Hier bitte das Bild hochladen. Das Bild sollte mindestens 800 Pixel breit sein, am Besten Querformat.', 'theme'),
            ),
            'title' => array(
                'label' => esc_html__('Beschreibung', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('Die Beschreibung, welche vor dem Abspielen angezeigt werden soll. Wird nicht angezeigt, wenn das Video in einem Mehrspaltigen Layout ist.', 'theme'),
            ),
            'scroll_id' => array(
                'label' => esc_html__('ID für Page-Navigation', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('Hier kann ein einmaliger Name (Kleinschreibung, keine Leerschläge, einmaliger Name) definiert werden, welcher dann als Ziel in der Inhalts-Navigation verwendet werden muss.', 'theme'),
            ),
            'admin_label' => array(
                'label' => esc_html__('Admin Label', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('This will change the label of the module in the builder for easy identification.', 'theme'),
            ),
        );
        return $fields;
    }

    function get_additional_blade_data()
    {
        return [
            'open_as_overlay' => intval(($this->props['open_as_overlay'] ?? 'on') === 'on')
        ];
    }
}
