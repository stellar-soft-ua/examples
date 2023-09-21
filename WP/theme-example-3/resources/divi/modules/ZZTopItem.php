<?php

class ZZTopItem extends Theme_Builder_Module
{
    function init()
    {

        parent::getDefaults(); // load theme divi module defaults
        $this->name = esc_html__('Item', 'et_builder');
        $this->slug = 'et_pb_theme_zztop_item';
        $this->type = 'child';
        $this->child_title_var = 'admin_title';
        $this->child_title_fallback_var = 'title';


        $this->advanced_setting_title_text = esc_html__('Neue hinzufügen', 'et_builder');
        $this->settings_text = esc_html__('Logo Einstellungen', 'et_builder');
        $this->main_css_element = '%%order_class%%';
    }


    function get_fields()
    {
        $fields = array(
            'admin_title' => array(
                'label' => esc_html__('Admin Label', 'theme'),
                'type' => 'text',
                'description' => esc_html__('This will change the label of the slide in the builder for easy identification.', 'theme'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ),
        );
        return $fields;
    }

    function render($atts, $content = NULL, $render_slug)
    {


        $output = sprintf(
            '<div class="verein-logo-inner">

            </div>'
        );


        return $output;
    }
}
