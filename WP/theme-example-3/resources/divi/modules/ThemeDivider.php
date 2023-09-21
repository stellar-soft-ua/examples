<?php

class ThemeDivider extends Theme_Builder_Module
{
    function init()
    {
        parent::getDefaults(); // load theme divi module defaults

        $this->name = esc_html__('THEME Abstand', 'theme');
        $this->slug = 'et_pb_theme_divider';
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
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('This will disable the module on selected devices', 'theme'),
            ),
            'height' => array(
                'label' => esc_html__('Höhe des Trenners', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('Definiere die Höhe des Trenners auf Desktop-Geräten.', 'theme'),
            ),
            'module_class' => array(
                'label' => esc_html__('CSS Class', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'option_class' => 'et_pb_custom_css_regular',
            ),
            'admin_label' => array(
                'label' => esc_html__('Admin Label', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('This will change the label of the slide in the builder for easy identification.', 'theme'),
            ),
        );
        return $fields;
    }

    function render($atts, $content = NULL, $render_slug)
    {
        $height = $this->props['height'];
        $module_class = $this->props['module_class'];


        $module_class = ET_Builder_Element::add_module_order_class($module_class, $render_slug);


        $output = sprintf(
            '<style>
            .%5$s .divider-theme {
                height: %1$spx;
            }
            @media screen and (max-width: 1199px) {
                .%5$s .divider-theme {
                    height: %2$spx;
                }
            }
            @media screen and (max-width: 991px) {
                .%5$s .divider-theme {
                    height: %3$spx;
                }
            }
            @media screen and (max-width: 767px) {
                .%5$s .divider-theme {
                    height: %4$spx;
                }
            }
            </style>
            <div class="divider-wrapper %5$s">
                <div class="divider-theme">
                </div>
            </div>',
            $height,
            round($height / 1.3),
            round($height / 2),
            round($height / 3.6),
            ('' !== $module_class ? sprintf('%1$s', esc_attr(ltrim($module_class))) : '')
        );
        return $output;
    }
}
