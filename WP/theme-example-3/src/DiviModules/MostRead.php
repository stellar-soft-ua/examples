<?php

namespace THEME\Theme\DiviModules;

use ET_Builder_Module;
use THEME\Divi\Traits\IsBladeModule;
use THEME\Divi\Traits\IsPlainModule;
use THEME\Theme\Repositories\ProjectRepository;

class MostRead extends ET_Builder_Module
{
    use IsPlainModule, IsBladeModule;

    function init()
    {
        $this->setDefaults();

        $this->name = __('Oft gelesen', 'theme');
        $this->slug = 'et_pb_theme_most_read';
    }

    public static function get_fields_definition()
    {
        $fields = [
            'number_of_entries' => [
                'label'           => __('Anzahl Einträge', 'theme'),
                'type'            => 'range',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => 5,
                'range_settings'  => [
                    'min'   => 1,
                    'max'   => 50,
                    'steps' => 1
                ]
            ],
            'admin_label'       => [
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

    public function get_additional_blade_data($content = null, $data = [])
    {
        $posts = ProjectRepository::builder()
                                  ->mostRead(intval($this->prop('number_of_entries')))
                                  ->withEvents()
                                  ->withTopic()
                                  ->get();

        return compact('posts');
    }
}

