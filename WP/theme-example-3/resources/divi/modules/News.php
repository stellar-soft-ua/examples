<?php

class News extends ET_Builder_Module
{
    function init() {
        $this->name = esc_html__( 'News', 'et_builder' );
        $this->slug = 'et_pb_theme_news';

    
    }

    function get_fields() {

        $post_categories = get_categories(array(
            'hide_empty' => false,
        ));
        $cats = array();
        foreach($post_categories as $c){
            $cat = get_category( $c );
            $cats[$cat->slug] = esc_html__(  $cat->name, 'et_builder' );
        }

        $fields = array(
            'disabled_on' => array(
                'label'           => esc_html__( 'Disable on', 'et_builder' ),
                'type'            => 'multiple_checkboxes',
                'options'         => array(
                    'phone'   => esc_html__( 'Phone', 'et_builder' ),
                    'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
                    'desktop' => esc_html__( 'Desktop', 'et_builder' ),
                ),
                'additional_att'  => 'disable_on',
                'option_category' => 'configuration',
                'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
            ),
            'title' => array(
                'label' => esc_html__('Titel (H2)', 'theme'),
                'type' => 'text',
                'option_category' => 'configuration', // Option category slug (for the Divi Role Editor)
                'description' => esc_html__('Der Titel erscheint oberhalb der News.', 'theme'),
            ),
            'categories' => array(
                'label'           => esc_html__( 'Filter nach Post Kategorien', 'et_builder' ),
                'type'            => 'multiple_checkboxes',
                'options'         =>  $cats,
                'additional_att'  => 'disable_on',
                'option_category' => 'configuration',
                'description'     => esc_html__( 'Filter nach Post-Kategorien.', 'et_builder' ),
            ),
            'countnews' => array(
                'label'           => esc_html__( 'Anzahl', 'et_builder' ),
                'type'            => 'range',
                'default'         => 5,
                'range_settings'  => array(
                    'step' => 1,
                    'min'  => 1,
                    'max'  => 200,
                ),
                'option_category' => 'configuration',
                'description'     => esc_html__( 'Anzahl anzuzeigender News', 'et_builder' ),
            ),
            'button_text' => array(
                'label' => esc_html__('Button Text', 'theme'),
                'type' => 'text',
                'option_category' => 'configuration', // Option category slug (for the Divi Role Editor)
                'description' => esc_html__('Text für den Button', 'theme'),
            ),
            'button_link' => array(
                'label' => esc_html__('Button Link', 'theme'),
                'type' => 'text',
                'option_category' => 'configuration', // Option category slug (for the Divi Role Editor)
                'description' => esc_html__('Linkziel für den Button.', 'theme'),
            ),
            'url_new_window' => array(
                'label' => esc_html__('Url Opens', 'theme'),
                'type' => 'select',
                'option_category' => 'configuration', // Option category slug (for the Divi Role Editor)
                'options' => array(
                    '_self' => esc_html__('In The Same Window', 'theme'),
                    '_blank' => esc_html__('In The New Tab', 'theme'),
                ),
                'description' => esc_html__('Here you can choose whether or not your link opens in a new window', 'theme'),
            ),
            'scroll_id' => array(
                'label' => esc_html__('ID für Page-Navigation', 'theme'),
                'type' => 'text',
                'option_category' => 'configuration', // Option category slug (for the Divi Role Editor)
                'description' => esc_html__('Hier kann ein einmaliger Name (Kleinschreibung, keine Leerschläge, einmaliger Name) definiert werden, welcher dann als Ziel in der Inhalts-Navigation verwendet werden muss.', 'theme'),
            ),
            'module_class' => array(
                'label'           => esc_html__( 'CSS Class', 'et_builder' ),
                'type'            => 'text',
                'option_category' => 'configuration',
                'tab_slug'        => 'custom_css',
                'option_class'    => 'et_pb_custom_css_regular',
            ),
            'admin_label' => array(
                'label'       => esc_html__( 'Admin Label', 'et_builder' ),
                'type'        => 'text',
                'description' => esc_html__( 'This will change the label of the slide in the builder for easy identification.', 'et_builder' ),
            ),
        );
        return $fields;
    }





    function shortcode_callback( $atts, $content = null, $function_name ) {
        $module_class           = $this->shortcode_atts['module_class'];
        $title                  = $this->shortcode_atts['title'];
        $categories             = $this->shortcode_atts['categories'];
        $countnews              = $this->shortcode_atts['countnews'];
        $button_text              = $this->shortcode_atts['button_text'];
        $button_link              = $this->shortcode_atts['button_link'];
        $url_new_window              = $this->shortcode_atts['url_new_window'];
        $scroll_id = $this->props['scroll_id'];

        $catstate = explode('|', $categories);

        $post_categories = get_categories(array(
            'hide_empty' => false,
        ));
        $cats = array();
        $catsOn = array();

        foreach($post_categories as $key=>$c){
            $cat = get_category( $c );

            $cats[] = array(
                'id' => $cat->cat_ID,
                'slug' => $cat->slug,
                'name' =>  esc_html__(  $cat->name, 'et_builder' ),
                'state' => $catstate[$key],
            );
            if ($catstate[$key] == 'on') {
                $catsOn[] = $cat->cat_ID;
            }
        }

        $args = array(
            'category' => $catsOn,
            'posts_per_page'   => $countnews,
            'offset'           => 0,
        );

        $posts = get_posts($args);

        $htmloutput = '<div class="news-wrapper%1$s" id="%2$s">
                        <h2>' . $title . '</h2>
                        <div class="row news-wrapper__post-wrapper">
                            ';

        foreach ($posts as $p) :



            $htmloutput .= '<div class="col-sm-4">
                                <div class="news-wrapper__post">';


            $categories = get_the_category( $p->ID );
            foreach ( $categories as  $category) {
                if ( has_post_thumbnail($p) ) {
                    $htmloutput .= '<div class="news-wrapper__image"><img src="' . flyImage(get_the_post_thumbnail_url($p), 722, 485)->source . '"
                                     srcset="' . flyImage(get_the_post_thumbnail_url($p), 360, 175)->source . ' 370w,
                                  ' . flyImage(get_the_post_thumbnail_url($p), 360, 175)->source . ' 440w,
                                  ' . flyImage(get_the_post_thumbnail_url($p), 360, 175)->source . ' 557w,
                                  ' . flyImage(get_the_post_thumbnail_url($p), 360, 175)->source . ' 690w,
                                  ' . flyImage(get_the_post_thumbnail_url($p), 360, 175)->source . ' 722w"
                                     sizes="(max-width: 415px) 370px,
                            (max-width: 768px) 722px,
                            (max-width: 992px) 440px,
                            (max-width: 1199px) 557px,
                            (min-width: 1200px) 690px"></div>';
                }
            }
            $htmloutput .= '<div class="news-wrapper__date">' . get_the_date(null, $p->ID) . '</div>
                             <div class="news-wrapper__title">' .  str_replace('%', '&#37;', $p->post_title) . '</div>
                             <div class="news-wrapper__subtitle">' . str_replace('%', '&#37;', $p->post_excerpt). '</div>
                             <a href="' . $p->guid . '" class="button button__simple">
                                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g fill="#1D1D1B" fill-rule="nonzero"><path d="M2 13.25a1.25 1.25 0 0 1 0-2.5h20a1.25 1.25 0 0 1 0 2.5H2z"/><path d="M11.12 2.88a1.25 1.25 0 0 1 1.76-1.76l10 10c.5.48.5 1.28 0 1.76l-10 10a1.25 1.25 0 0 1-1.76-1.76L20.23 12l-9.11-9.12z"/></g></svg>
                                Weiterlesen
                            </a>
                        </div>
                    </div>';
        endforeach;

        $htmloutput .= '</div>
                        <a href="' . $button_link . '" target="' . $url_new_window . '" class="button button-big">' . $button_text . '</a>
                    </div>';

        $module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );


        $output = sprintf(
            $htmloutput,
            ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '' ),
            $scroll_id
        );
        return $output;
    }
}

new News;