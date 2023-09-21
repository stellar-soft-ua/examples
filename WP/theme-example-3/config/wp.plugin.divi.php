<?php

use THEME\Divi\Module\GreaterLoveForm;
use THEME\Divi\Module\GreaterLoveFormField;
use THEME\Divi\Module\Paragraph;
use THEME\Theme\DiviModules\Code;
use THEME\Theme\DiviModules\CurrentProjects;
use THEME\Theme\DiviModules\Deposits;
use THEME\Theme\DiviModules\HeaderImage;
use THEME\Theme\DiviModules\HorizontalLine;
use THEME\Theme\DiviModules\ModalLink;
use THEME\Theme\DiviModules\MostRead;
use THEME\Theme\DiviModules\RecentActivities;
use THEME\Theme\DiviModules\RecentActivitiesCarouselItem;
use THEME\Theme\DiviModules\TopicOverview;

return [
    'layout'                                      => 'compact',
    'enabled_modules'                             => [
        Paragraph::class,
        RecentActivities::class,
        RecentActivitiesCarouselItem::class,
        HeaderImage::class,
        CurrentProjects::class,
        TopicOverview::class,
        GreaterLoveForm::class,
        GreaterLoveFormField::class,
        MostRead::class,
        HorizontalLine::class,
        ModalLink::class,
        Code::class,
        Deposits::class
    ],
    'enabled_builtin_modules' => [
//        'Gallery'
    ],
    'modify_fields_for_' . GreaterLoveForm::class => [
        'success_title' => false
    ],
    'modify_fields_for_' . GreaterLoveFormField::class => function ($fields) {
        $fields['field_type']['options'] = [
            'input'      => esc_html__('Text', 'theme'),
            'email'      => esc_html__('E-Mail', 'theme'),
            'text'       => esc_html__('Textbox', 'theme'),
            'checkbox'   => esc_html__('Kontrollkästchen', 'theme'),
            'radio'      => esc_html__('Radiobuttons', 'theme'),
            'select'     => esc_html__('Dropdown / Select', 'theme'),
            'phone'      => esc_html__('Telefonnummer', 'theme'),
            'number'     => esc_html__('Zahl', 'theme'),
            'html'       => esc_html__('HTML', 'theme'),
        ];

        $fields['fullwidth_field']['toggle_slug'] = 'hidden';

        $fields['field_width'] = [
            'label'           => esc_html__('Breite', 'et_builder'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => [
                'col-lg-4'  => esc_html__('Ein Drittel', 'theme'),
                'col-lg-6'  => esc_html__('Halbe Breite', 'theme'),
                'col-lg-8'  => esc_html__('Zwei Drittel', 'theme'),
                'col-lg-12' => esc_html__('Ganze Breite', 'theme')
            ],
            'description'     => esc_html__('Die Breite des Feldes', 'theme'),
            'default' => 'col-lg-12',
            'default_on_front' => 'col-lg-12',
            'toggle_slug'     => 'field_options',
        ];

        return $fields;
    }
];
