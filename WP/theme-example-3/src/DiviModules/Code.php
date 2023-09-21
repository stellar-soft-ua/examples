<?php

namespace THEME\Theme\DiviModules;

use ET_Builder_Module;
use THEME\Divi\Traits\IsPlainModule;

class Code extends ET_Builder_Module
{
    use IsPlainModule;

    function init()
    {
        $this->setDefaults();

        $this->name            = esc_html__('THEME Code', 'theme');
        $this->slug            = 'et_pb_theme_code';
    }

    public static function get_fields_definition()
    {
        $fields = [
            'content' => [
                'label'           => esc_html__('Code', 'et_builder'),
                'type'            => 'codemirror',
                'mode'            => 'html',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Here you can create the content that will be used within the module.', 'et_builder'),
                'is_fb_content'   => true,
                'toggle_slug'     => 'main_content',
                'mobile_options'  => true,
                'hover'           => 'tabs',
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


    function render($atts, $content = null, $render_slug)
    {
        // Module classnames
        $this->add_classname($this->get_text_orientation_classname());

        return sprintf(
            '<div%2$s class="%3$s">
				%1$s
			</div> <!-- .et_pb_code -->',
            $this->props['content'],
            $this->module_id(),
            $this->module_classname($render_slug)
        );
    }
}
