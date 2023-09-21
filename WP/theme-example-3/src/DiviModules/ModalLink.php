<?php

namespace THEME\Theme\DiviModules;

use ET_Builder_Module;
use THEME\Divi\Traits\IsBladeModule;
use THEME\Divi\Traits\IsPlainModule;
use THEME\Theme\Repositories\ModalRepository;

class ModalLink extends ET_Builder_Module
{
    use IsPlainModule, IsBladeModule;

    function init()
    {
        $this->setDefaults();

        $this->name = __('Link zu Modal', 'theme');
        $this->slug = 'et_pb_theme_modal_link';
    }

    public static function get_fields_definition()
    {
        $modals = ModalRepository::builder()
                                 ->get();

        if (is_array($modals)) {
            $modalOptions = array_map_keys($modals, 'ID', 'post_title');
        } else {
            $modalOptions = [];
        }

        $fields = [
            'title'       => [
                'label'           => __('Titel', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
            ],
            'modal_id'    => [
                'label'           => __('Modal', 'theme'),
                'type'            => 'select',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',
                'options'         => $modalOptions,
                'default'         => array_first(array_keys($modalOptions)),
                'description'     => __('Das zu öffnende Modal', 'theme'),
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

