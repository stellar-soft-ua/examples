<?php

namespace THEME\Theme\DiviModules;

use ET_Builder_Module;
use THEME\Divi\Traits\IsBladeModule;
use THEME\Divi\Traits\IsPlainModule;
use THEME\Theme\Repositories\EventRepository;
use THEME\Theme\Repositories\ProjectRepository;

class CurrentProjects extends ET_Builder_Module
{
    use IsPlainModule, IsBladeModule;

    function init()
    {
        $this->setDefaults();

        $this->name = __('Aktuelle Projekte', 'theme');
        $this->slug = 'et_pb_theme_current_projects';
    }

    public static function get_fields_definition()
    {
        $fields = [
            'text_tender' => [
                'label'           => __('Überschrift für Ausschreibungen', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => __('Ausschreibungen', 'theme')
            ],

            'text_ongoing' => [
                'label'           => __('Überschrift für laufende Projekte', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => __('Laufende Projekte', 'theme')
            ],

            'text_completed' => [
                'label'           => __('Überschrift für abgeschlossen Projekte', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => __('Studien', 'theme')
            ],

            'text_events' => [
                'label'           => __('Überschrift für Veranstaltungen', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'default'         => __('Anlässe', 'theme')
            ],

            'number_of_tender_projects' => [
                'label'           => __('Ausschreibungen', 'theme'),
                'description'     => __('Anzahl der anzuzeigenden Auschreibungen', 'theme'),
                'type'            => 'range',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'range_settings'  => [
                    'min'   => 0,
                    'max'   => 50,
                    'steps' => 1
                ]
            ],

            'number_of_ongoing_projects' => [
                'label'           => __('Laufende Projekte', 'theme'),
                'description'     => __('Anzahl der laufenden Projekte', 'theme'),
                'type'            => 'range',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'range_settings'  => [
                    'min'   => 0,
                    'max'   => 50,
                    'steps' => 1
                ]
            ],

            'number_of_completed_projects' => [
                'label'           => __('Studien', 'theme'),
                'description'     => __('Anzahl der anzuzeigenden Studien bzw. der abgeschlossen Projekte', 'theme'),
                'type'            => 'range',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'range_settings'  => [
                    'min'   => 0,
                    'max'   => 50,
                    'steps' => 1
                ]
            ],

            'number_of_events' => [
                'label'           => __('Anlässe', 'theme'),
                'description'     => __('Anzahl der anzuzeigenden Anlässe'),
                'type'            => 'range',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'tab_slug'        => 'general',
                'range_settings'  => [
                    'min'   => 0,
                    'max'   => 50,
                    'steps' => 1
                ]
            ],

            'admin_label' => [
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
        $limitProjects = 12;

        $requestedProjects = [
            'tender'  => min(intval($data['number_of_tender_projects']), $limitProjects),
            'ongoing' => min(intval($data['number_of_ongoing_projects']), $limitProjects),
            'done'    => min(intval($data['number_of_completed_projects']), $limitProjects),
        ];

        $projects = [];

        $events = EventRepository::builder()
            ->limit(min(intval($data['number_of_events']), $limitProjects))
            ->latest()
            ->get();

        foreach ($requestedProjects as $status => $limit) {
            if ($limit === 0) {
                $projects[$status] = null;
                continue;
            }

            $projects[$status] = ProjectRepository::builder()
                                                  ->withTopic()
                                                  ->whereProjectStatus($status)
                                                  ->orderByMetaKey('starts_at', 'desc')
                                                  ->limit($limit)
                                                  ->get();
        }

        return compact('projects', 'events');
    }
}

