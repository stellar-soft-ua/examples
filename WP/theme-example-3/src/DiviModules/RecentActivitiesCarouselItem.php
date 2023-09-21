<?php

namespace THEME\Theme\DiviModules;

use ET_Builder_Module;
use THEME\Divi\Traits\IsBladeModule;
use THEME\Divi\Traits\IsPlainModule;

class RecentActivitiesCarouselItem extends ET_Builder_Module
{
    use IsPlainModule, IsBladeModule;

    function init()
    {
        $this->setDefaults();

        $this->name            = __('Slide', 'theme');
        $this->slug            = 'et_pb_theme_recent_activities_carousel_item';
        $this->type            = 'child';
        $this->child_title_var = 'title';

        $this->advanced_setting_title_text = __('Neuer Slide', 'theme');
        $this->settings_text               = __('Slide Einstellungen', 'theme');
    }

    public static function get_fields_definition()
    {
        return [
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
                'description'     => __('Here you can choose whether or not your link opens in a new window', 'theme'),
            ],
            'image'       => [
                'label'           => __('Bild', 'theme'),
                'type'            => 'upload',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',

                'upload_button_text' => esc_attr__('Upload an image', 'et_builder'),
                'choose_text'        => esc_attr__('Choose an Image', 'et_builder'),
                'update_text'        => esc_attr__('Set As Logo', 'et_builder'),
                'description'        => esc_html__('Upload an image to display beside your menu.', 'et_builder'),
                'dynamic_content'    => 'image',
                'mobile_options'     => true,
                'hover'              => 'tabs',
            ],
        ];
    }
}
