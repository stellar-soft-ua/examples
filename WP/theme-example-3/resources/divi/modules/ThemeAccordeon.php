<?php

class ThemeAccordeon extends Theme_Builder_Module
{
    function init()
    {

        parent::getDefaults(); // load theme divi module defaults


        $this->name = esc_html__('THEME Akkordeon', 'theme');
        $this->slug = 'et_pb_theme_accordeon';
        $this->child_slug = 'et_pb_theme_accordeon_item';
        $this->child_item_text = esc_html__('Inhalt', 'theme');
    }

    function get_fields()
    {
        $fields = array(
            'title' => array(
                'label' => esc_html__('Titel (optional) (H2)', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'description' => esc_html__('Ein Titel für den Slider.', 'theme'),
            ),
            'disabled_on' => array(
                'label' => esc_html__('Disable on', 'theme'),
                'type' => 'multiple_checkboxes',
                'options' => array(
                    'phone' => esc_html__('Phone', 'theme'),
                    'tablet' => esc_html__('Tablet', 'theme'),
                    'desktop' => esc_html__('Desktop', 'theme'),
                ),
                'additional_att' => 'disable_on',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'description' => esc_html__('This will disable the module on selected devices', 'theme'),
            ),
            'scroll_id' => array(
                'label' => esc_html__('ID für Page-Navigation', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'description' => esc_html__('Hier kann ein einmaliger Name (Kleinschreibung, keine Leerschläge, einmaliger Name) definiert werden, welcher dann als Ziel in der Inhalts-Navigation verwendet werden muss.', 'theme'),
            ),
            'admin_label' => array(
                'label' => esc_html__('Admin Label', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'description' => esc_html__('This will change the label of the module in the builder for easy identification.', 'theme'),
            ),

        );
        return $fields;
    }


    function shortcode_callback( $atts, $content = null, $function_name ) {
        $title                   = $this->shortcode_atts['title'];
        $module_class                   = $this->shortcode_atts['module_class'];
        $scroll_id                      = $this->shortcode_atts['scroll_id'];


        if ($title !== '') {
            $title = "<h2>{$title}</h2>";
        }

        $content = $this->shortcode_content;

        $module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

        $output = sprintf(
            '<div class="theme-accordeon%4$s" id="%3$s">
                %1$s
                <div class="theme-accordeon__inner">
                    %2$s
                </div>
        </div>',
            $title,
            $content,
            $scroll_id,
            ('' !== $module_class ? sprintf(' %1$s', esc_attr(ltrim($module_class))) : '')
        );



        return $output;
    }
}

