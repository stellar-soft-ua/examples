<?php

class Theme_Builder_Module extends ET_Builder_Module
{
    public $settings_modal_toggles = array();
    public $advanced_fields = array();
    public $custom_css_fields = array();
    public $vb_support = 'off';

    // https://www.elegantthemes.com/documentation/developers/divi-module/defining-custom-css-fields-for-modules/
    public function get_custom_css_fields_config() {
        return array(
/*            'before' => false,
            'main_element' => false,
            'after' => false,*/
        );
    }
    // Do not include these fields:
    public function get_advanced_fields_config() {
        return array(
            'background' => false,
            'borders'        => false,
            'margin_padding' => false,
            'text_shadow' => false,
            'box_shadow'     => false,
            'fonts' => false,
            'button' => false,
            'filters' => false,
            'text' => false,
            'max_width' => false,
            'animation' => false,
            'module_id' => array(),
            'module_class' => array(),
        );
    }

    function getDefaults()
    {

        // TODO add custom toggles in custom tab
        // https://www.elegantthemes.com/documentation/developers/divi-module/module-settings-groups/#custom-settings-groups


        $this->settings_modal_toggles = array(
            'general'  => array(
                'toggles' => array(
                    'main_content' => esc_html__( 'Content', 'theme' ),
                ),
            ),
        );
    }
}