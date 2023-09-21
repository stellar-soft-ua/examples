<?php

use THEME\Framework\Cache\Transient;

class LoveMap extends Theme_Builder_Module
{
    function init()
    {
        parent::getDefaults(); // load theme divi module defaults

        $this->name = esc_html__('Karte', 'theme');
        $this->slug = 'et_pb_theme_map';
        $this->child_slug = 'et_pb_theme_map_marker';
        $this->child_item_text = esc_html__('Marker', 'theme');
    }

    function get_fields()
    {
        $fields = [
            'mapheight' => [
                'label'           => esc_html__('Höhe in px', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
            ],
            'zoom'      => [
                'label'           => esc_html__('Zoom Wert', 'theme'),
                'type'            => 'text',
                'default'         => '8',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
            ],
            'geocoding' => [
                'label'           => esc_html__('Verwende Geocoding', 'theme'),
                'type'            => 'yes_no_button',
                'options'         => [
                    'on'  => esc_html__('Ja', 'theme'),
                    'off' => esc_html__('Nein', 'theme'),
                ],
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'affects'         => [
                    'centerx',
                    'centery',
                    'address',
                ],
            ],
            'centerx'   => [
                'label'           => esc_html__('X-Koordinate', 'theme'),
                'type'            => 'text',
                'depends_show_if' => 'off',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
            ],
            'centery'   => [
                'label'           => esc_html__('Y-Koordinate', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'depends_show_if' => 'off',
            ],
            'address'   => [
                'label'           => esc_html__('Adresse', 'theme'),
                'type'            => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'depends_show_if' => 'on',
            ],
        ];

        return $fields;
    }

    function render($atts, $content = null, $function_name)
    {
        wp_enqueue_script('googlemaps-infobox', get_template_directory_uri() . '/assets/js/plugins/googlemapsinfobox.js', [], '',
            true);

        wp_enqueue_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?&key=' . get_option('google_maps_api_key') . '&callback=prepareInfoBox',
            ['googlemaps-infobox'], '',
            true);

        $centerx = $this->props['centerx'];
        $centery = $this->props['centery'];
        $zoom = $this->props['zoom'];
        $mapheight = $this->props['mapheight'];
        $address = $this->props['address'];

        if ( ! empty($address)) {
            $cacheKey = 'theme_map_address_' . md5($address);

            try {
                $result = Transient::remember($cacheKey, 1, function () use ($address) {
                    $address = urlencode($address);
                    $googlemapskey = get_option('google_maps_api_key');
                    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=" . $googlemapskey;

                    $c = curl_init();
                    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($c, CURLOPT_URL, $url);
                    $contents = curl_exec($c);
                    curl_close($c);
                    $contents = json_decode($contents);

                    if ($contents->status !== 'OK') {
                        throw new \Exception('Google Maps returned an invalid response.');
                    }

                    return $contents->results[0];
                });

                $output = "var center_lat = '" . $result->geometry->location->lat . "'; var center_lng = '" . $result->geometry->location->lng . "';";
            } catch (\Exception $exception) {
                // Something went wrong...
                $output = 'console.error("An error occured during the Google Maps request.");';
            }
        } else {
            $output = "var center_lat = '" . $centerx . "'; var center_lng = '" . $centery . "'";
        }


        $content = $this->content;

        return
            '<div class="map__wrapper">
                <div class="map__holder" id="map" style="height: ' . $mapheight . 'px"></div>
            </div>
            <script type="text/javascript" language="javascript">
                var infoBoxes = [];
                var markers = [];
                ' . $output . '
                function loadMap()
                {
                    prepareInfoBox();
                
                    var mapOptions = {
                        zoom: ' . $zoom . ',
                        scrollwheel: false,
                        center: new google.maps.LatLng(center_lat, center_lng)
                    }

                    var map = new google.maps.Map(document.getElementById("map"), mapOptions);
                    ' . $content . '
                    google.maps.event.addDomListener(window, "load", loadMap);
                    google.maps.event.addListener(map, "click", function(event){
                      this.setOptions({scrollwheel:true});
                    });
                }
            </script>';
    }
}
