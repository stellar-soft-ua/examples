<?php

class ThemeSlider extends Theme_Builder_Module
{


    function init()
    {

        parent::getDefaults(); // load theme divi module defaults


        $this->name = esc_html__('THEME Slider', 'theme');
        $this->slug = 'et_pb_theme_slider';

    }

    function get_fields()
    {
        $fields = [
            'title'           => [
                'label'           => esc_html__('Titel (optional) (H2)', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'description'     => esc_html__('Ein Titel für den Slider.', 'theme'),
            ],
            'gallery_ids'     => [
                'label'            => esc_html__('Slider Bilder', 'et_builder'),
                'type'             => 'upload-gallery',
                'computed_affects' => [
                    '__gallery',
                ],
                'option_category'  => 'basic_option', // Option category slug (for the Divi Role Editor)
            ],
            'gallery_orderby' => [
                'label'           => esc_html__('Slider Bilder', 'theme'),
                'type'            => 'hidden',
                'class'           => ['et-pb-gallery-ids-field'],
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
            ],
            'scroll_id'       => [
                'label'           => esc_html__('ID für Page-Navigation', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'description'     => esc_html__('Hier kann ein einmaliger Name (Kleinschreibung, keine Leerschläge, einmaliger Name) definiert werden, welcher dann als Ziel in der Inhalts-Navigation verwendet werden muss.',
                    'theme'),
            ],
            'disabled_on'     => [
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
            ],
            'admin_label'     => [
                'label'           => esc_html__('Admin Label', 'theme'),
                'type'            => 'text',
                'description'     => esc_html__('This will change the label of the module in the builder for easy identification.', 'theme'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
            ],
        ];

        return $fields;
    }

    function render($atts, $content = null, $render_slug)
    {
        $title = $this->props['title'];
        $gallery_ids = $this->props['gallery_ids'];
        $gallery_orderby = $this->props['gallery_orderby'];
        $scroll_id = $this->props['scroll_id'];

        $module_class = $this->module_classname($render_slug);

        if ($title !== '') {
            $title = "<h2>{$title}</h2>";
        }

        $attachments = [];
        if ( ! empty($gallery_ids)) {
            $attachments_args = [
                'include'        => $gallery_ids,
                'post_status'    => 'inherit',
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'order'          => 'ASC',
                'orderby'        => 'post__in',
            ];

            if ('rand' === $gallery_orderby) {
                $attachments_args['orderby'] = 'rand';
            }

            $_attachments = get_posts($attachments_args);

            foreach ($_attachments as $key => $val) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        }

        if (empty($attachments)) {
            return '';
        }

        wp_enqueue_script('hashchange');


        $output = sprintf(
            '<div class="theme-slider%2$s" id="%1$s">
                %3$s
                <div class="swiper-container swiper-container-theme">
                    <div class="swiper-wrapper">',
            $scroll_id,
            ('' !== $module_class ? sprintf(' %1$s', esc_attr(ltrim($module_class))) : ''),
            $title
        );

        $i = 0;
        foreach ($attachments as $id => $attachment) {
            $full_src = array_first(wp_get_attachment_image_src($id, 'full'));

            $output .= sprintf(
                '<div class="swiper-slide">
                    <div class="theme-slider__image__wrapper">
                        <a href="' . flyImage($full_src, 1200)->source . '"
                                data-caption="%1$s"
                                data-at-600="' . flyImage($full_src, 600)->source . '"
                                data-at-767="' . flyImage($full_src, 647)->source . '"
                                data-at-992="' . flyImage($full_src, 872)->source . '"
                                data-at-1300="' . flyImage($full_src, 1040)->source . '"
                                data-at-1920="' . flyImage($full_src, 1320)->source . '">
                             <img src="' . flyImage($full_src, 1920)->source . '"
                                  srcset="' . flyImage($full_src, 1920)->source . ' 293w,
                                     ' . flyImage($full_src, 1920)->source . ' 333w,
                                     ' . flyImage($full_src, 1920)->source . ' 400w"
                             sizes="(max-width: 600px) 293px,
                                    (max-width: 992px) 333px,
                                    (max-width: 1300px) 400px,
                                    (min-width: 1301px) 400px"
                                 class="theme-slider__image swiper-lazy"
                                 title="%1$s"
                                 alt="%1$s">
                        </a>
                    </div>
                </div>',
                esc_attr($attachment->post_excerpt)
            );


        }


        $output .= '</div>
                        <!-- If we need navigation buttons -->

                    <div class="swiper-pagination"></div>

                    <div class="swiper-button-prev">
                        <svg width="33" height="58" viewBox="0 0 33 58" xmlns="http://www.w3.org/2000/svg"><path d="M9.959 29l21.833 21.928a4.156 4.156 0 010 5.859 4.112 4.112 0 01-5.834 0L1.208 31.929a4.156 4.156 0 010-5.858l24.75-24.858a4.112 4.112 0 015.834 0 4.156 4.156 0 010 5.86L9.959 29z" fill="#fff" fill-rule="nonzero"/></svg>
                    </div>
                    <div class="swiper-button-next">
                        <svg width="33" height="58" viewBox="0 0 33 58" xmlns="http://www.w3.org/2000/svg"><path d="M23.041 29L1.208 7.072a4.156 4.156 0 010-5.859 4.112 4.112 0 015.834 0l24.75 24.858a4.156 4.156 0 010 5.858L7.042 56.787a4.112 4.112 0 01-5.834 0 4.156 4.156 0 010-5.86L23.041 29z" fill="#fff" fill-rule="nonzero"/></svg>
                    </div>
                </div>
            </div>';

        return $output;
    }
}
