<?php

class ThemeButton extends Theme_Builder_Module
{
    function init()
    {
        parent::getDefaults(); // load theme divi module defaults

        $this->name = esc_html__('THEME Button', 'et_builder');
        $this->slug = 'et_pb_theme_button';


    }

    function get_fields()
    {
        $fields = array(
            'button_text' => array(
                'label' => esc_html__('Button Text', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('Text für den Button', 'theme'),
            ),
            'button_link' => array(
                'label' => esc_html__('Button Link', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('Linkziel für den Button, kann auch Anker sein, z.B. #zielid', 'theme'),
            ),
            'url_new_window' => array(
                'label' => esc_html__('Url Opens', 'theme'),
                'type' => 'select',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'options' => array(
                    '_self' => esc_html__('In The Same Window', 'theme'),
                    '_blank' => esc_html__('In The New Tab', 'theme'),
                ),
                'description' => esc_html__('Here you can choose whether or not your link opens in a new window', 'theme'),
            ),
            'button_type' => array(
                'label' => esc_html__('Button Typ', 'theme'),
                'type' => 'select',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'options' => array(
                    'simple' => esc_html__('Simpel', 'theme'),
                    'primar' => esc_html__('Primär', 'theme'),
                ),
                'description' => esc_html__('Wie soll der Button ausschauen?', 'theme'),
            ),
            'button_center' => array(
                'label' => esc_html__('Button Ausrichtung', 'theme'),
                'type' => 'select',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'options' => array(
                    'left' => esc_html__('Links', 'theme'),
                    'center' => esc_html__('Zentriert', 'theme'),
                ),
                'description' => esc_html__('Wie soll der Button ausgerichtet sein?', 'theme'),
            ),
            'admin_label' => array(
                'label' => esc_html__('Admin Label', 'theme'),
                'type' => 'text',
                'description' => esc_html__('This will change the label of the module in the builder for easy identification.', 'theme'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ),
            'scroll_id' => array(
                'label' => esc_html__('ID für Page-Navigation', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('Hier kann ein einmaliger Name (Kleinschreibung, keine Leerschläge, einmaliger Name) definiert werden, welcher dann als Ziel in der Inhalts-Navigation verwendet werden muss.', 'theme'),
            ),
            'module_class' => array(
                'label' => esc_html__('CSS Class', 'theme'),
                'type' => 'text',
                'option_class' => 'et_pb_custom_css_regular',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ),
        );
        return $fields;
    }

    function render($atts, $content = NULL, $render_slug)
    {
        $button_text = $this->props['button_text'];
        $button_link = $this->props['button_link'];
        $url_new_window = $this->props['url_new_window'];
        $button_type = $this->props['button_type'];
        $button_center = $this->props['button_center'];
        $module_class = $this->props['module_class'];
        $scroll_id = $this->props['scroll_id'];


        $module_class = ET_Builder_Element::add_module_order_class($module_class, $render_slug);

        $class = " button__ausrichtung__{$button_center}";
        $button = '';

        if ($button_type == 'simple') {
            $button = sprintf('<a href="%2$s" target="%3$s" class="button button__simple">
                                    <svg width="29" height="29" viewBox="0 0 29 29" xmlns="http://www.w3.org/2000/svg"><g fill="#000" fill-rule="nonzero"><path d="M2 16.17a1.67 1.67 0 0 1 0-3.34h25a1.67 1.67 0 0 1 0 3.34H2z"/><path d="M24.64 14.5L13.32 3.18A1.67 1.67 0 0 1 15.68.82l12.5 12.5c.65.65.65 1.7 0 2.36l-12.5 12.5a1.67 1.67 0 0 1-2.36-2.36L24.64 14.5z"/></g></svg>
                                    %1$s
                                </a>',$button_text,$button_link,$url_new_window);
        } else {
            $button = sprintf('<a href="%2$s" target="%3$s" class="button button-big">%1$s</a>',$button_text,$button_link,$url_new_window);
        }

        $output = sprintf(
            '<div class="button__wrapper%2$s%4$s" id="%3$s">
                %1$s
            </div>',
            $button,
            ('' !== $module_class ? sprintf(' %1$s', esc_attr($module_class)) : ''),
            $scroll_id,
            $class
        );

        return $output;
    }
}
