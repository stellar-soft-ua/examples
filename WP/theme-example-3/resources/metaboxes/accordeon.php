<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
    $sectionsTemplate = '
        <% if (title) { %>
            <%- title.replace("&", "und") %>
        <% } %>
    ';

    Container::make('post_meta', __('Akkordeon', 'theme'))
             ->where('post_type', 'IN', ['project', 'event', 'page'])
             ->add_fields([
                 Field::make('complex', 'sections', __('Zeilen', 'theme'))
                      ->setup_labels([
                          'singular_name' => 'Zeile',
                          'plural_name'   => 'Zeilen',
                      ])
                      ->set_duplicate_groups_allowed(true)
                      ->add_fields('section', [
                          Field::make('text', 'title', __('Titel', 'theme')),
                          Field::make('select', 'background', __('Hintergrundfarbe'))
                               ->set_options([
                                   'white' => __('Weiss', 'theme'),
                                   'gray'  => __('Grau', 'theme')
                               ]),
                          Field::make('complex', 'content')
                               ->setup_labels([
                                   'singular_name' => 'Eintrag',
                                   'plural_name'   => 'Einträge',
                               ])
                               ->set_duplicate_groups_allowed(true)
                               ->add_fields('text', [
                                   Field::make('radio', 'columns', __('Spaltenanzahl', 'theme'))
                                        ->set_options([
                                            1 => 1,
                                            2 => 2
                                        ]),
                                   Field::make('rich_text', 'content', __('Inhalt', 'theme'))
                               ])
                               ->add_fields('file_link', __('Link zu Datei', 'theme'), [
                                   Field::make('text', 'title', __('Titel', 'theme')),
                                   Field::make('textarea', 'description', __('Beschreibung', 'theme')),
                                   Field::make('text', 'file_title', __('Text des Download-Links', 'theme'))
                                        ->set_attribute('placeholder', __('PDF', 'theme')),
                                   Field::make('text', 'file_url', __('URL des Download-Links', 'theme'))
                                       ->set_attribute('placeholder', __('URL', 'theme'))
                                       ->set_attribute('type', 'url'),
                                   Field::make('file', 'file', __('Oder Datei auswählen', 'theme'))
                                        ->set_conditional_logic(array(
                                            'relation' => 'AND', // Optional, defaults to "AND"
                                            array(
                                                'field'   => 'file_url',
                                                'value'   => '', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
                                                'compare' => '=',   // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
                                            )
                                        )),
                               ])
                               ->add_fields('external_link', __('Externer Link', 'theme'), [
                                   Field::make('text', 'title', __('Titel', 'theme')),
                                   Field::make('rich_text', 'content', __('Inhalt', 'theme'))
                               ])
                               ->add_fields('gallery', __('Galerie'), [
                                   Field::make('text', 'title', __('Titel', 'theme')),
                                   Field::make('textarea', 'description', __('Beschreibung', 'theme')),
                                   Field::make('media_gallery', 'items', __('Bilder', 'theme'))
                                        ->set_type(['image'])
                                        ->set_duplicates_allowed(false)
                               ])
                      ])
                      ->set_header_template($sectionsTemplate)
             ]);

    Container::make('post_meta', __('Kontaktbereich', 'theme'))
             ->where('post_type', 'IN', ['project', 'event'])
             ->add_fields([
                 Field::make('rich_text', 'footer', '')
                      ->set_help_text(__('Der Kontaktbereich kann genutzt, um weitere Informationen wie Kontaktdaten anzuzeigen.', 'theme'))
             ]);
});
