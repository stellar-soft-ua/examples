<?php

use THEME\Framework\Cache\Transient;

class LoveMapItem extends Theme_Builder_Module
{
    function init()
    {

        parent::getDefaults(); // load theme divi module defaults

        $this->name = esc_html__('THEME Karte Marker', 'theme');
        $this->slug = 'et_pb_theme_map_marker';
        $this->type = 'child';
        $this->child_title_var = 'marker_id';

        $this->advanced_setting_title_text = esc_html__('Neuer Marker', 'theme');
        $this->settings_text = esc_html__('Marker Einstellungen', 'theme');
    }

    function get_fields()
    {
        $fields = array(
            'marker_id' => array(
                'label' => esc_html__('Marker ID', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'description' => esc_html__('Einmalige ID für den Marker.', 'theme'),
            ),
            'marker_title' => array(
                'label' => esc_html__('Title', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'description' => esc_html__('Titel für den Marker.', 'theme'),
            ),
            'marker_text' => array(
                'label' => esc_html__('Text', 'theme'),
                'type' => 'tiny_mce',
                'description' => esc_html__('Inhalt auf der Markierung.', 'theme'),
            ),
            'geocoding' => array(
                'label' => esc_html__('Verwende Geocoding', 'theme'),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'options' => array(
                    'on' => esc_html__('Ja', 'theme'),
                    'off' => esc_html__('Nein', 'theme'),
                ),
                'affects' => array(
                    'marker_x',
                    'marker_y',
                    'address',
                ),
            ),
            'marker_x' => array(
                'label' => esc_html__('X-Koordinate', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'depends_show_if' => 'off',
            ),
            'marker_y' => array(
                'label' => esc_html__('Y-Koordinate', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'depends_show_if' => 'off',
            ),
            'address' => array(
                'label' => esc_html__('Adresse', 'theme'),
                'type' => 'text',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'depends_show_if' => 'on',
            ),
            'showroute' => array(
                'label' => esc_html__('Link zu Route anzeigen?'),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option', // Option category slug (for the Divi Role Editor)
                'options' => array(
                    'on' => esc_html__('Ja', 'theme'),
                    'off' => esc_html__('Nein', 'theme'),
                ),
            ),
        );
        return $fields;
    }

    function render($atts, $content = NULL, $function_name)
    {
        $marker_id = $this->props['marker_id'];
        $marker_title = $this->props['marker_title'];
        $marker_text = $this->props['marker_text'];
        $marker_x = $this->props['marker_x'];
        $marker_y = $this->props['marker_y'];
        $address = $this->props['address'];
        $showroute = $this->props['showroute'];

        if (!empty($address)) {


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

                $output = "var lat = '" . $result->geometry->location->lat . "'; var lng = '" . $result->geometry->location->lng . "';";
                $marker_x = $result->geometry->location->lat;
                $marker_y = $result->geometry->location->lng;
            } catch (\Exception $exception) {
                // Something went wrong...
                $output = 'console.error("An error occured during the Google Maps request.");';
            }

        } else {
            $output = "var lat = '" . $marker_x . "'; var lng = '" . $marker_y . "'";
        }
        $route = "";

        if ($showroute == 'on') {
            $route = '<a class="link-bold" target="_blank" href="http://maps.google.com/maps?daddr=' . $marker_x . ',' . $marker_y . '">Route planen</a>';
        }

        $output .= '
			var marker' . $marker_id . ' = new google.maps.Marker({
	    		position: new google.maps.LatLng(lat, lng),
	    		map: map,
	    		title: "' . html_entity_decode($marker_title) . '",
	    		icon: "/app/themes/theme.wp.theme/assets/images/icons/maps-pin.png"
	  		});
	  		markers.push(marker' . $marker_id . ');
	  	    var infobox' . $marker_id . ' = new InfoBox({
			    content: "<div class=\"marker-content \">" +
			    				"<p><strong>' . html_entity_decode($marker_title) . '</strong><br />" +
			    				"' . str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$marker_text), "\0..\37'\\"))) . '</p>' . addcslashes(str_replace("\n", '', (string)$route), '"') . '</div>",

			});
			infoBoxes.push(infobox' . $marker_id . ');
			marker' . $marker_id . '.addListener("click", function() {
				for(var i = 0; i<infoBoxes.length; i++){
				    infoBoxes[i].close();
				}
			    infobox' . $marker_id . '.open(map, marker' . $marker_id . ');
			  });
  		';

        return $output;
    }
}
