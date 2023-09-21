<?php

namespace THEME\Theme\DiviModules;

use ET_Builder_Module;
use THEME\Divi\Traits\IsBladeModule;
use THEME\Divi\Traits\IsPlainModule;

class HeaderImage extends ET_Builder_Module
{
    use IsPlainModule, IsBladeModule;

    function init()
    {
        $this->setDefaults();

        $this->name = __('Hauptbild', 'theme');
        $this->slug = 'et_pb_theme_header_image';
    }

    public static function get_fields_definition()
    {
        $fields = [
            'title'       => [
                'label'           => __('Titel', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
            ],
            'link'        => [
                'label'           => __('Link', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',
                'description'     => __('Linkziel für den Button, kann auch Anker sein, z.B. #zielid', 'theme'),
            ],
            'link_target' => [
                'label'           => __('Link Ziel', 'theme'),
                'type'            => 'select',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',
                'default'         => '_self',
                'options'         => [
                    '_self'  => __('Im selben Fenster', 'theme'),
                    '_blank' => __('Im neuen Tab', 'theme'),
                ],
                'description'     => __('Ob der Link in einem neuen Fenster geöffnet werden soll', 'theme'),
            ],
            'image'       => [
                'label'           => __('Bild', 'theme'),
                'type'            => 'upload',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',

                'upload_button_text' => esc_attr__('Ein Bild hochladen', 'theme'),
                'choose_text'        => esc_attr__('Ein Bild auswählen', 'theme'),
                'update_text'        => esc_attr__('Bild aktualisieren', 'theme'),
                'description'        => esc_html__('Das Hauptbild', 'theme'),
                'dynamic_content'    => 'image',
                'mobile_options'     => true,
                'hover'              => 'tabs',
            ],
            'scroll_id'   => [
                'label'           => esc_html__('ID für Page-Navigation', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description'     => esc_html__('Hier kann ein einmaliger Name (Kleinschreibung, keine Leerschläge, einmaliger Name) definiert werden, welcher dann als Ziel in der Inhalts-Navigation verwendet werden muss.',
                    'theme'),
            ],
            'admin_label' => [
                'label'           => esc_html__('Admin Label', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description'     => esc_html__('This will change the label of the module in the builder for easy identification.', 'theme'),
            ],

        ];

        return $fields;
    }
}

