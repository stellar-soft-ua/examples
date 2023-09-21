<?php

class ThemeAccordeonItem extends Theme_Builder_Module
{
    function init()
    {

        parent::getDefaults(); // load theme divi module defaults


        $this->name = esc_html__('Inhalt', 'theme');
        $this->slug = 'et_pb_theme_accordeon_item';
        $this->type = 'child';
        $this->child_title_var = 'admin_title';
        $this->child_title_fallback_var = 'title';


        $this->advanced_setting_title_text = esc_html__('Neue hinzufügen', 'theme');
        $this->settings_text = esc_html__('Inhalt Einstellungen', 'theme');
        $this->main_css_element = '%%order_class%%';
    }


    function get_fields()
    {
        $fields = array(
            'title' => array(
                'label' => esc_html__('Titel', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'description' => esc_html__('Ein Titel für die Box.', 'theme'),
            ),
            'content' => array(
                'label' => esc_html__('Content', 'theme'),
                'type' => 'tiny_mce',
                'description' => esc_html__('Here you can create the content that will be used within the module.', 'theme'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
            ),
            'admin_title' => array(
                'label' => esc_html__('Admin Label', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'description' => esc_html__('This will change the label of the slide in the builder for easy identification.', 'theme'),
            ),
        );
        return $fields;
    }

    function render($atts, $content = NULL, $render_slug)
    {
        $title = $this->props['title'];

        $content = $this->content;


        $output = sprintf(
            '<div class="theme-accordeon__item">
                <div class="theme-accordeon__title h3">
                    <span>%1$s</span>
                    <div class="theme-accordeon__switcher">
                        <svg width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg"><g fill="#000" fill-rule="nonzero"><path d="M14 27.2C6.71 27.2.8 21.29.8 14 .8 6.71 6.71.8 14 .8 21.29.8 27.2 6.71 27.2 14c0 7.29-5.91 13.2-13.2 13.2zm0-2.4c5.965 0 10.8-4.835 10.8-10.8 0-5.965-4.835-10.8-10.8-10.8C8.035 3.2 3.2 8.035 3.2 14c0 5.965 4.835 10.8 10.8 10.8z"/><path d="M9.2 15.2a1.2 1.2 0 110-2.4h9.6a1.2 1.2 0 110 2.4H9.2z"/><path class="minusser" d="M12.8 9.2a1.2 1.2 0 112.4 0v9.6a1.2 1.2 0 11-2.4 0V9.2z"/></g></svg>
                    </div>
                </div>
                <div class="theme-accordeon__content">
                    %2$s
                </div>
            </div>',
            $title,
            $content
        );


        return $output;
    }
}
