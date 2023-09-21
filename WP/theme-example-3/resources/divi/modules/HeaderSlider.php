<?php

class HeaderSlider extends Theme_Builder_Module
{
    function init()
    {

        parent::getDefaults(); // load theme divi module defaults


        $this->name = esc_html__('Header Slider', 'theme');
        $this->slug = 'et_pb_fullwidth_header_slider';
        $this->child_slug = 'et_pb_fullwidth_header_slider_item';
        $this->child_item_text = esc_html__('Slide', 'theme');
        $this->fullwidth = true;
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
            'scroll_id' => array(
                'label' => esc_html__('ID für Page-Navigation', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('Hier kann ein einmaliger Name (Kleinschreibung, keine Leerschläge, einmaliger Name) definiert werden, welcher dann als Ziel in der Inhalts-Navigation verwendet werden muss.', 'theme'),
            ),
            'admin_label' => array(
                'label' => esc_html__('Admin Label', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('This will change the label of the module in the builder for easy identification.', 'theme'),
            ),

        );
        return $fields;
    }


    function shortcode_callback( $atts, $content = null, $function_name ) {
        $module_class                   = $this->shortcode_atts['module_class'];
        $scroll_id                      = $this->shortcode_atts['scroll_id'];

        $content = $this->shortcode_content;

        $module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

        $output = sprintf(
            '<div class="home-slider swiper-container swiper-container-header%3$s" id="%2$s">
                <div class="swiper-wrapper">
                    %1$s
                </div>


                <div class="swiper-pagination"></div>


                <div class="swiper-button-prev">
                    <svg width="33" height="58" viewBox="0 0 33 58" xmlns="http://www.w3.org/2000/svg"><path d="M9.959 29l21.833 21.928a4.156 4.156 0 010 5.859 4.112 4.112 0 01-5.834 0L1.208 31.929a4.156 4.156 0 010-5.858l24.75-24.858a4.112 4.112 0 015.834 0 4.156 4.156 0 010 5.86L9.959 29z" fill="#F4F2E9" fill-rule="nonzero"/></svg>
                </div>
                <div class="swiper-button-next">
                    <svg width="33" height="58" viewBox="0 0 33 58" xmlns="http://www.w3.org/2000/svg"><path d="M23.041 29L1.208 7.072a4.156 4.156 0 010-5.859 4.112 4.112 0 015.834 0l24.75 24.858a4.156 4.156 0 010 5.858L7.042 56.787a4.112 4.112 0 01-5.834 0 4.156 4.156 0 010-5.86L23.041 29z" fill="#F4F2E9" fill-rule="nonzero"/></svg>
                </div>
        </div>',
            $content,
            $scroll_id,
            ('' !== $module_class ? sprintf(' %1$s', esc_attr(ltrim($module_class))) : '')
        );



        return $output;
    }
}

