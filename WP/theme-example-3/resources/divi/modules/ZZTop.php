<?php

class ZZTop extends Theme_Builder_Module
{
    function init()
    {

        parent::getDefaults(); // load theme divi module defaults
        $this->name = esc_html__('ZZTop', 'et_builder');
        $this->slug = 'et_pb_theme_zztop';
        $this->child_slug = 'et_pb_theme_zztop_item';
        $this->child_item_text = esc_html__('Logo', 'et_builder');
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
                'description' => esc_html__('This will disable the module on selected devices', 'theme'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ),
            'module_class' => array(
                'label' => esc_html__('CSS Class', 'theme'),
                'type' => 'text',
                'option_class' => 'et_pb_custom_css_regular',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ),
            'admin_label' => array(
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

        $module_class = $this->props['module_class'];

        $module_class = ET_Builder_Element::add_module_order_class($module_class, $render_slug);

        $content = $this->content;

        $output = sprintf(
            '<div class="button">
               %1$s
            </div>',
            $content,
            ('' !== $module_class ? sprintf(' %1$s', esc_attr(ltrim($module_class))) : '')
        );


        return $output;
    }
}
