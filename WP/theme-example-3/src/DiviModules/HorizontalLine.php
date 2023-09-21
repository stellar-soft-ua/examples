<?php

namespace THEME\Theme\DiviModules;

use ET_Builder_Module;
use THEME\Divi\Traits\IsPlainModule;

class HorizontalLine extends ET_Builder_Module
{
    use IsPlainModule;

    function init()
    {
        $this->setDefaults();

        $this->name = __('Horizontale Linie', 'theme');
        $this->slug = 'et_pb_theme_horizontal_line';
    }

    public static function get_fields_definition()
    {
        $fields = [
            'title' => [
                'label'           => __('Titel', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description'     => __('Ein optionaler Titel, der in der Mitte angezeigt werden soll.', 'theme'),
            ],
            'title_tag' => [
                'label'           => __('Grösse des Titels', 'theme'),
                'type'            => 'select',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description'     => __('Die Grösse des Titels ist einerseits für die Darstellung, als auch für die SEO-Struktur wichtig..', 'theme'),
                'options'         => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                ],
                'default' => 'h2'
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


    public function render($attrs, $content = null, $render_slug)
    {
        if($title = trim($this->prop('title'))) {
            $tag = trim($this->prop('title_tag'));

            return "<{$tag} class=\"heading-bordered mt-5\">{$title}</{$tag}>";
        }

        return '<hr/>';
    }
}

