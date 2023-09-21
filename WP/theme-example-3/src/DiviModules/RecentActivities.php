<?php

namespace THEME\Theme\DiviModules;

use ET_Builder_Module;
use THEME\Divi\Traits\IsBladeModule;
use THEME\Divi\Traits\IsPlainModule;

class RecentActivities extends ET_Builder_Module
{
    use IsPlainModule, IsBladeModule;

    function init()
    {
        $this->setDefaults();

        $this->name            = __('Aktuelle Aktivitäten', 'theme');
        $this->slug            = 'et_pb_theme_recent_activities';
        $this->child_slug      = 'et_pb_theme_recent_activities_carousel_item';
        $this->child_item_text = __('Field', 'theme');
    }

    function get_fields()
    {
        $fields = [
            'scroll_id'    => [
                'label'           => __('ID für Page-Navigation', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description'     => __('Hier kann ein einmaliger Name (Kleinschreibung, keine Leerschläge, einmaliger Name) definiert werden, welcher dann als Ziel in der Inhalts-Navigation verwendet werden muss.',
                    'theme'),
            ],
            'admin_label'  => [
                'label'           => __('Admin Label', 'theme'),
                'type'            => 'text',
                'description'     => __('This will change the label of the module in the builder for easy identification.', 'theme'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ],
            'module_class' => [
                'label'           => __('CSS Class', 'theme'),
                'type'            => 'text',
                'option_class'    => 'et_pb_custom_css_regular',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ],
        ];

        return $fields;
    }

    public function get_additional_blade_data($content = null)
    {
        $slides = [];
        $pattern = get_shortcode_regex(['et_pb_theme_recent_activities_carousel_item']);
        preg_match_all('/' . $pattern . '/s', $content, $matches);

        foreach ($matches[3] as $field) {
            $slides[] = shortcode_parse_atts($field);
        }

        $args = [
            'post_type'      => ['project', 'event'],
            'posts_per_page' => 4,
            'meta_key'       => 'starts_at',
            'orderby'        => 'meta_value_num',
            'order'          => 'desc'
        ];

        $query = new \WP_Query($args);

        return [
            'slides' => $slides,
            'posts' => $query->posts
        ];
    }
}
