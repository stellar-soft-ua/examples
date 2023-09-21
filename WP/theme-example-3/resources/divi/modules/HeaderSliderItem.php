<?php

class HeaderSliderItem extends Theme_Builder_Module
{
    function init()
    {

        parent::getDefaults(); // load theme divi module defaults


        $this->name = esc_html__('Slide', 'theme');
        $this->slug = 'et_pb_fullwidth_header_slider_item';
        $this->type = 'child';
        $this->child_title_var = 'admin_title';
        $this->child_title_fallback_var = 'statement';


        $this->advanced_setting_title_text = esc_html__('Neue hinzufügen', 'theme');
        $this->settings_text = esc_html__('Slide Einstellungen', 'theme');
        $this->main_css_element = '%%order_class%%';
    }


    function get_fields()
    {
        $fields = array(
            'image' => array(
                'label' => esc_html__('Slide Bild', 'theme'),
                'type' => 'upload',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'upload_button_text' => esc_attr__('Upload an image', 'theme'),
                'choose_text' => esc_attr__('Choose a Slide Image', 'theme'),
                'update_text' => esc_attr__('Set As Slide Image', 'theme'),
                'description' => esc_html__('Das Bild erscheint im Hintergrund des Sliders (JPG). Minimale Breite ist: 1920 Pixel. Je nach Bildschirmgrösse/Format werden oben und unten oder auf der Seite, Teile abgeschnitten, daher sollte das Motiv möglichst im Zentrum sein.', 'theme'),
            ),
            'statement' => array(
                'label' => esc_html__('Statement (optional)', 'theme'),
                'type' => 'textarea',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description' => esc_html__('Ein Statement für den Slide', 'theme'),
            ),
            'admin_title' => array(
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
        $image = $this->props['image'];
        $statement = $this->props['statement'];


        $statement_full = '';

        if ('' !== $statement) {
            $statement_full = sprintf('<div class="home-slider__statement h5">%1$s</div>', $statement);
        }


        $output = sprintf(
            '<div class="swiper-slide">
                <div class="home-slider__slide">
                    <div class="home-slider__image__wrapper">
                         <img src="' . flyImage($image, 1920)->source . '"
                                  srcset="' . flyImage($image, 1920)->source . ' 722w,
                                 ' . flyImage($image, 1920)->source . ' 767w,
                                 ' . flyImage($image, 1920)->source . ' 992w,
                                 ' . flyImage($image, 1920)->source . ' 1300w,
                                 ' . flyImage($image, 1920)->source . ' 1920w"
                        sizes="(max-width: 600px) 722px,
                                (max-width: 767px) 767px,
                                (max-width: 992px) 992px,
                                (max-width: 1300px) 1300px,
                                (min-width: 1301px) 1920px"
                        alt="%1$s"
                        title="%1$s">
                     </div>
                     <div class="home-slider__content">
                        <div class="container">
                            <div class="row">
                                <div class="col s12 m9 l8 xl7 offset-m3 offset-l4 offset-xl5">
                                    %2$s
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
            </div>',
            $statement,
            $statement_full
        );


        return $output;
    }
}
