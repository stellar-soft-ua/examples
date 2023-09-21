<?php

namespace THEME\Theme\DiviModules;

use ET_Builder_Module;
use THEME\Divi\Traits\IsBladeModule;
use THEME\Divi\Traits\IsPlainModule;
use THEME\Theme\Repositories\TopicsRepository;

class TopicOverview extends ET_Builder_Module
{
    use IsPlainModule, IsBladeModule;

    function init()
    {
        $this->setDefaults();

        $this->name = __('Themen Übersicht', 'theme');
        $this->slug = 'et_pb_theme_topic_overview';
    }

    public static function get_fields_definition()
    {
        $fields = [
            'filter_overview' => [
                'label'           => __('Name des Filters für alle Themen', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => __('Übersicht')
            ],
            'admin_label'     => [
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
        $topics = TopicsRepository::all();

        return [
            'topics' => $topics
        ];

    }
}

