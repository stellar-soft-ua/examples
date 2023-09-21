<?php

class ThemeGallery extends Theme_Builder_Module
{
    function init()
    {

        parent::getDefaults(); // load theme divi module defaults
        $this->name = esc_html__('THEME Galerie', 'theme');
        $this->slug = 'et_pb_theme_gallery';


        $this->fields_defaults = array(
            'show_title_and_caption' => array('off'),
        );
    }

    function get_fields()
    {
        $fields = array(
            'gallery_ids' => array(
                'label'            => esc_html__( 'Gallery Images', 'et_builder' ),
                'type'             => 'upload-gallery',
                'computed_affects' => array(
                    '__gallery',
                ),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ),
            'gallery_orderby' => array(
                'label' => esc_html__('Gallery Images', 'theme'),
                'type' => 'hidden',
                'class' => array('et-pb-gallery-ids-field'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
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
                'description' => esc_html__('This will disable the module on selected devices', 'theme'),
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug' => 'main_content', // Modal tab settings group toggle slug
                'tab_slug' => 'general', // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
            ),
            'admin_label' => array(
                'label' => esc_html__('Admin Label', 'theme'),
                'type' => 'text',
                'description' => esc_html__('This will change the label of the module in the builder for easy identification.', 'theme'),
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
        );

        return $fields;
    }

    function render($atts, $content = NULL, $render_slug)
    {
        $module_class = $this->props['module_class'];
        $gallery_ids = $this->props['gallery_ids'];
        $gallery_orderby = $this->props['gallery_orderby'];

        $module_class = ET_Builder_Element::add_module_order_class($module_class, $render_slug);

        $attachments = array();
        if (!empty($gallery_ids)) {
            $attachments_args = array(
                'include' => $gallery_ids,
                'post_status' => 'inherit',
                'post_type' => 'attachment',
                'post_mime_type' => 'image',
                'order' => 'ASC',
                'orderby' => 'post__in',
            );

            if ('rand' === $gallery_orderby) {
                $attachments_args['orderby'] = 'rand';
            }

            $_attachments = get_posts($attachments_args);

            foreach ($_attachments as $key => $val) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        }

        if (empty($attachments))
            return '';

        wp_enqueue_script('hashchange');


        $output = sprintf(
            '<div class="%1$s"><div class="theme-masonry galleria gallery">',
            ('' !== $module_class ? sprintf('%1$s', esc_attr(ltrim($module_class))) : '')
        );

        $i = 0;
        foreach ($attachments as $id => $attachment) {


            list($full_src, $full_width, $full_height) = wp_get_attachment_image_src($id, 'full');
            list($thumb_src, $thumb_width, $thumb_height) = wp_get_attachment_image_src($id, array(500, 500));

            $description = esc_attr($attachment->post_excerpt);

            if($description !== '') {
                $description = "<div class='gallery__description'>{$description}</div>";
            }

            $output .= sprintf(
                '<div class="galleria-item">
                    <div class="et_pb_gallery_image landscape">
                        <a href="' . flyImage($full_src, 1420)->source . '"
                                data-caption="%2$s"
                                data-at-370="' . flyImage($full_src, 330)->source . '"
                                data-at-600="' . flyImage($full_src, 560)->source . '"
                                data-at-992="' . flyImage($full_src, 792)->source . '"
                                data-at-1200="' . flyImage($full_src, 1000)->source . '"
                                data-at-1450="' . flyImage($full_src, 1220)->source . '"
                                data-at-1920="' . flyImage($full_src, 1420)->source . '">
                            <img src="' . flyImage($full_src, 480, 480)->source . '"
                                     srcset="' . flyImage($full_src, 185, 185)->source . ' 185w,
                                             ' . flyImage($full_src, 331, 331)->source . ' 331w,
                                             ' . flyImage($full_src, 300, 300)->source . ' 300w,
                                             ' . flyImage($full_src, 363, 363)->source . ' 363w,
                                             ' . flyImage($full_src, 480, 480)->source . ' 480w"
                                       sizes="(max-width: 370px) 185px,
                                            (max-width: 600px) 300px,
                                            (max-width: 992px) 331px,
                                            (max-width: 1200px) 300px,
                                            (max-width: 1450px) 363px,
                                            (min-width: 1451px) 480px"
                                 title="%2$s"
                                 class="responsive-img"
                                 alt="%2$s">
                            <div class="gallery__zoomer">
                                <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><g fill="#606060" fill-rule="nonzero"><path d="M1.6 10C.716 10 0 9.105 0 8s.716-2 1.6-2h12.8c.884 0 1.6.895 1.6 2s-.716 2-1.6 2H1.6z"/><path d="M6 1.6C6 .716 6.895 0 8 0s2 .716 2 1.6v12.8c0 .884-.895 1.6-2 1.6s-2-.716-2-1.6V1.6z"/></g></svg>
                            </div>
                            %2$s
                        </a>
                    </div>
                </div>',
                esc_url($full_src),
                $description,
                esc_url($thumb_src),
                ('' !== $module_class ? sprintf(' %1$s', esc_attr(ltrim($module_class))) : '')
            );


        }

        $output .= "</div><!-- .js-masonry --></div>";

        return $output;
    }
}
