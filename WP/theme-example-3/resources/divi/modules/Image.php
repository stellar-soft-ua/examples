<?php

use THEME\Divi\Traits\IsPlainModule;

class Image extends ET_Builder_Module
{
    use IsPlainModule;

    public function init()
    {
        $this->setDefaults();

        $this->name = esc_html__('THEME Bild', 'et_builder');
        $this->slug = 'et_pb_theme_image';
    }

    public function get_fields()
    {
        $fields = [
            'src'              => [
                'label'              => esc_html__('Image URL', 'theme'),
                'type'               => 'upload',
                'upload_button_text' => esc_attr__('Upload an image', 'theme'),
                'choose_text'        => esc_attr__('Choose an Image', 'theme'),
                'update_text'        => esc_attr__('Set As Image', 'theme'),
                'description'        => esc_html__('Upload your desired image, or type in the URL to the image you would like to display.', 'theme'),
                'option_category'    => 'basic_option',
                // Option category slug (for the Divi Role Editor)
                'toggle_slug'        => 'main_content',
                // Modal tab settings group toggle slug
                'tab_slug'           => 'general',
                // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ],
            'alt'              => [
                'label'           => esc_html__('Bildunterschrift', 'theme'),
                'type'            => 'textarea',
                'description'     => esc_html__('Der Text erscheint unterhalb des Bildes.', 'theme'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ],
            'show_in_lightbox' => [
                'label'           => esc_html__('Open in Lightbox', 'theme'),
                'type'            => 'yes_no_button',
                'options'         => [
                    'off' => esc_html__("No", 'theme'),
                    'on'  => esc_html__('Yes', 'theme'),
                ],
                'affects'         => [
                    'url',
                    'url_new_window',
                    'use_overlay',
                ],
                'description'     => esc_html__('Here you can choose whether or not the image should open in Lightbox. Note: if you select to open the image in Lightbox, url options below will be ignored.',
                    'theme'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ],
            'url'              => [
                'label'           => esc_html__('Link URL', 'theme'),
                'type'            => 'text',
                'depends_show_if' => 'off',
                'affects'         => [
                    'use_overlay',
                ],
                'description'     => esc_html__('If you would like your image to be a link, input your destination URL here. No link will be created if this field is left blank.',
                    'theme'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ],
            'url_new_window'   => [
                'label'           => esc_html__('Url Opens', 'theme'),
                'type'            => 'select',
                'options'         => [
                    'off' => esc_html__('In The Same Window', 'theme'),
                    'on'  => esc_html__('In The New Tab', 'theme'),
                ],
                'depends_show_if' => 'off',
                'description'     => esc_html__('Here you can choose whether or not your link opens in a new window', 'theme'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ],
            'disabled_on'      => [
                'label'           => esc_html__('Disable on', 'theme'),
                'type'            => 'multiple_checkboxes',
                'options'         => [
                    'phone'   => esc_html__('Phone', 'theme'),
                    'tablet'  => esc_html__('Tablet', 'theme'),
                    'desktop' => esc_html__('Desktop', 'theme'),
                ],
                'additional_att'  => 'disable_on',
                'description'     => esc_html__('This will disable the module on selected devices', 'theme'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ],
            'admin_label'      => [
                'label'           => esc_html__('Admin Label', 'theme'),
                'type'            => 'text',
                'description'     => esc_html__('This will change the label of the module in the builder for easy identification.', 'theme'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ],
            'module_class'     => [
                'label'           => esc_html__('CSS Class', 'theme'),
                'type'            => 'text',
                'option_class'    => 'et_pb_custom_css_regular',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ],
        ];

        return $fields;
    }

    function render($atts, $content = null, $render_slug)
    {
        $module_class = $this->props['module_class'];
        $src = $this->props['src'];
        $alt = $this->props['alt'];
        $url = $this->props['url'];
        $url_new_window = $this->props['url_new_window'];
        $show_in_lightbox = $this->props['show_in_lightbox'];

        $module_class = ET_Builder_Element::add_module_order_class($module_class, $render_slug);


        $output = sprintf(
            '<img src="' . flyImage($src, 1200)->source . '"
                                  srcset="' . flyImage($src, 310)->source . ' 310w,
                                 ' . flyImage($src, 540)->source . ' 540w,
                                 ' . flyImage($src, 902)->source . ' 902w,
                                 ' . flyImage($src, 1110)->source . ' 1110w,
                                 ' . flyImage($src, 1200)->source . ' 1200w"
                         sizes="(max-width: 370px) 310px,
                                (max-width: 600px) 540px,
                                (max-width: 992px) 902px,
                                (max-width: 1200px) 1110px,
                                (max-width: 1450px) 1200px,
                                (min-width: 1451px) 1200px">'
        );


        if ('on' === $show_in_lightbox) {
            $output = sprintf(
                '<div class="image-wrapper">
                    <a href="' . flyImage($src, 1420)->source . '"
                                data-at-370="' . flyImage($src, 330)->source . '"
                                data-at-600="' . flyImage($src, 560)->source . '"
                                data-at-992="' . flyImage($src, 792)->source . '"
                                data-at-1200="' . flyImage($src, 1000)->source . '"
                                data-at-1450="' . flyImage($src, 1220)->source . '"
                                data-at-1920="' . flyImage($src, 1420)->source . '">
                         ' . $output . '
                    </a>
                </div>'
            );
        } elseif ('' !== $url) {
            $output = sprintf('<a href="%1$s"%3$s>%2$s</a>',
                esc_url($url),
                $output,
                ('on' === $url_new_window ? ' target="_blank"' : '')
            );
        }


        if ($alt !== '') {
            $output = sprintf(
                '<div class="%2$s">
                            <div class="image-container">
                                %1$s
                                <div class="image-description">%3$s</div>
                            </div>
                        </div>',
                $output,
                ('' !== $module_class ? sprintf('%1$s', esc_attr(ltrim($module_class))) : ''),
                esc_attr($alt)
            );
        } else {
            $output = sprintf(
                '<div class="%2$s">
                            <div class="image-container">
                                %1$s
                            </div>
                        </div>',
                $output,
                ('' !== $module_class ? sprintf('%1$s', esc_attr(ltrim($module_class))) : ''),
                esc_attr($alt)
            );
        }


        return $output;
    }
}
