<?php

namespace THEME\Theme\DiviModules;

use ET_Builder_Module;
use THEME\Divi\Traits\IsBladeModule;
use THEME\Divi\Traits\IsPlainModule;
use THEME\Theme\Repositories\ModalRepository;
use THEME\Theme\Repositories\TopicsRepository;

class Deposits extends ET_Builder_Module
{
    use IsPlainModule, IsBladeModule;

    function init()
    {
        $this->setDefaults();

        $this->name = __('Publikationen', 'theme');
        $this->slug = 'et_pb_theme_deposits';
    }

    public static function get_fields_definition()
    {
        $modals = ModalRepository::builder()
                                 ->get();

        if (is_array($modals)) {
            $modalOptions = array_map_keys($modals, 'ID', 'post_title');
        } else {
            $modalOptions = [];
        }

        $fields = [
            'compact_mode'        => [
                'label'           => __('Anzeigemodus', 'theme'),
                'type'            => 'yes_no_button',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => 'off',
                'options'         => [
                    'off' => esc_html__('Normal', 'theme'),
                    'on'  => esc_html__('Kompakt', 'theme'),
                ],
                'affects'         => [
                    'label_heading'
                ]
            ],
            'label_heading'       => [
                'label'           => __('Überschrift', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => __('Publikationen', 'theme'),
                'depends_show_if' => 'on'
            ],
            'show_filter'         => [
                'label'           => __('Filter anzeigen', 'theme'),
                'type'            => 'yes_no_button',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => 'off',
                'options'         => [
                    'on'  => esc_html__('Ja', 'theme'),
                    'off' => esc_html__('Nein', 'theme'),
                ],
                'affects'         => [
                    'filter_topics',
                    'filter_year'
                ]
            ],
            'filter_topics'       => [
                'label'           => __('Name des Filter für Themen', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => __('Themen', 'theme'),
                'depends_show_if' => 'on'
            ],
            'filter_year'         => [
                'label'           => __('Name des Filters für Jahre', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => __('Jahr', 'theme'),
                'depends_show_if' => 'on'
            ],
            'label_order_deposit' => [
                'label'           => __('Text für "Broschüre bestellen"', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => __('Broschüre bestellen', 'theme')
            ],
            'order_modal_id'      => [
                'label'           => __('Modal für "Broschüre bestellen"', 'theme'),
                'type'            => 'select',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',
                'options'         => $modalOptions,
                'default'         => array_first(array_keys($modalOptions)),
                'description'     => __('Das zu öffnende Modal', 'theme'),
            ],
            'number_entries'      => [
                'label'           => __('Anzahl der Einträge', 'theme'),
                'description'     => __('Anzahl der zu ladenen Einträge. Bei der Nutzung der "Mehr"-Buttons werden die Einträge um diese Anzahl nachgeladen.'),
                'type'            => 'range',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => 10,
                'range_settings'  => [
                    'min'  => 1,
                    'max'  => 50,
                    'step' => 1
                ]
            ],
            'show_more_button'    => [
                'label'           => __('Einträge nachladen möglich', 'theme'),
                'description'     => __('Ermöglich das Nachladen von Einträgen'),
                'type'            => 'yes_no_button',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => 'off',
                'options'         => [
                    'on'  => esc_html__('Ja', 'theme'),
                    'off' => esc_html__('Nein', 'theme'),
                ],
                'affects'         => [
                    'label_more_button'
                ]
            ],
            'admin_label'         => [
                'label'           => esc_html__('Admin Label', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'toggle_slug'     => 'main_content', // Modal tab settings group toggle slug
                'tab_slug'        => 'general',      // Modal tab slug ("general", "custom_css", "advanced" or a custom tab slug, if defined in getDefaults())
                'description'     => esc_html__('This will change the label of the module in the builder for easy identification.', 'theme'),
            ],

        ];

        return $fields;
    }

    public function get_additional_blade_data($content = null, $data = [])
    {
        $topics = TopicsRepository::all();

        $years = [];

        // Let's generate an array for the last 5 years
        for ($i = 0; $i <= 5; $i++) {
            // The year of the current loop.
            $year = intval(date("Y")) - $i;

            if ($i === 0) {
                // The current year

                $years[$year] = [
                    'after' => $year
                ];
            } elseif ($i === 5) {
                // Everything before 5 ago

                $years[__(sprintf('Vor %0d', ($year + 1)))] = [
                    'before' => $year + 1
                ];
            } else {
                // Between current year and 5th last year
                $years[$year] = [
                    'after'  => $year,
                    'before' => $year + 1
                ];
            }
        }

        return [
            'topics' => $topics,
            'years'  => $years
        ];

    }
}

