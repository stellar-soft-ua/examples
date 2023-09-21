<?php

//versions for styles and scripts
const STYLES_AND_SCRIPTS_VERSIONS = "0.0012";

// Post Types
const CALIBRATION_KITS_POST_TYPE = 'calibration-kits';
const VNA_POST_TYPE = 'vna';
const BLOG_POST_TYPE = 'post';
const FAQ_POST_TYPE = 'faq';
const POSITION_POST_TYPE = 'position';
const PRODUCT_POST_TYPE = 'product';
const LOCATION_POST_TYPE = 'location';
const LEADERSHIP_POST_TYPE = 'leadership';
const PARTNER_POST_TYPE = 'partner';
const GETTING_STARTED_POST_TYPE = 'getting-started';
const BANNER_POST_TYPE = 'banner';
const BANNER_GALLERIES_POST_TYPE = 'banners_gallery';
const FREQUENCY_EXTENSION_POST_TYPE = 'frequency-extension';
const DATA_SHEET_POST_TYPE = 'data-sheet';
const CALIBRATION_SERVICE = 'calibration-service';
const APP_PAGE_POST_TYPE = 'application-page';
const INTEGRATIONS_POST_TYPE = 'integrations';
const LATEST_NEWS = 'latest_news';
const DOCUMENTATION_POST_TYPE = 'documentation';

// Custom Taxonomies
const VNA_CATEGORY = 'vna_category';
const VNA_PORTS = 'vna_ports';
const VNA_FREQUENCY = 'vna_frequency';
const VNA_UPPER_FREQUENCY = 'vna_upper_frequency';
const APP_NOTE_CATEGORY = 'app-notes-category';
const DATA_SHEET_CATEGORY = 'data_sheet_category';
const VNA_APPLICATION_SOLUTIONS = 'vna_application_solutions';

const CALIBRATION_KITS_AND_ACCESSORIES_CATEGORY = 'calibration_kits_category';
const CALIBRATION_KITS_AND_ACCESSORIES_PORTS = 'calibration_kits_ports';
const CALIBRATION_KITS_AND_ACCESSORIES_TYPES = 'calibration_kits_types';
const CALIBRATION_KITS_AND_ACCESSORIES_LENGTH = 'calibration_kits_length';
const CALIBRATION_KITS_AND_ACCESSORIES_PRODUCTS = 'calibration_kits_compatible_prod';
const CALIBRATION_KITS_AND_ACCESSORIES_FREQUENCY = 'calibration_kits_frequency';

const FREQUENCY_EXTENSION_CATEGORY = 'frequency_category';
const FREQUENCY_EXTENSION_PORTS = 'frequency_ports';
const FREQUENCY_EXTENSION_FREQUENCY = 'frequency_extension_frequency';
const FREQUENCY_EXTENSION_TYPE = 'frequency_extension_types';
const FREQUENCY_EXTENSION_VARIATIONS = 'frequency_extension_variations';

//Custom Post Meta Key
const CPM_SHOW_IN_SEARCH_RESULTS_VIDEOS = 'show_in_search_results_videos';
const CPM_SHOW_IN_SEARCH_RESULTS_WEBINARS = 'show_in_search_results_webinars';
const CPM_SHOW_IN_SEARCH_RESULTS_LATEST_NEWS = 'show_in_search_results_latest_news';
const CPM_SHOW_IN_SEARCH_RESULTS_CASE_STUDIES = 'show_in_search_results_case_studies';

//API key for ipstack.com
const API_KEY = 'ce8721b702eb8ca7fa6c953885ac261b';

//define array constant for version php < 5.5
define ("REGIONS", serialize ([
    'Africa'         => [
        'Kenya',
        'Namibia',
        'South Africa',
        'Zambia',
        'Zimbabwe'
    ],
    'Asia & Pacific' => [
        'Australia',
        'Bangladesh',
        'China',
        'India',
        'Indonesia',
        'Japan',
        'Malaysia',
        'New Zealand',
        'Singapore',
        'South Korea',
        'Taiwan',
        'Thailand',
        'Vietnam'
    ],
    'Canada'         => [
        'Alberta',
        'British Columbia',
        'Manitoba',
        'Maritimes',
        'Ontario',
        'Saskatchewan',
        'Quebec'
    ],
    'Europe'         => [
        'Austria',
        'Belgium',
        'Bulgaria',
        'Croatia',
        'Cyprus',
        'Czech Republic',
        'Denmark',
        'Finland',
        'France',
        'Germany',
        'Greece',
        'Ireland',
        'Italy',
        'Luxembourg',
        'Moldova',
        'Montenegro',
        'Netherlands',
        'Norway',
        'Poland',
        'Portugal',
        'Romania',
        'Russia',
        'Serbia',
        'Slovakia',
        'Slovenia',
        'Spain',
        'Sweden',
        'Switzerland',
        'Ukraine',
        'United Kingdom'
    ],
    'Middle East'    => [
        'Israel',
        'Turkey'
    ],
    'Latin America'  => [
        'Argentina',
        'Belize',
        'Bolivia',
        'Brazil',
        'British Virgin Islands',
        'Chile',
        'Colombia',
        'Costa Rica',
        'Dominican Republic',
        'Ecuador',
        'El Salvador',
        'French Guiana',
        'Guatemala',
        'Guyana',
        'Honduras',
        'Mexico',
        'Nicaragua',
        'Panama',
        'Paraguay',
        'Peru',
        'Puerto Rico',
        'Suriname',
        'Trinidad y Tobago',
        'Uruguay',
        'US Virgin Islands'
    ],
    'United States'  => [
        'Alabama',
        'Alaska',
        'Arizona',
        'Arkansas',
        'California (Northern)',
        'California (Southern)',
        'Colorado',
        'Connecticut',
        'Delaware',
        'Florida',
        'Georgia',
        'Hawaii',
        'Idaho',
        'Illinois',
        'Indiana',
        'Iowa',
        'Kansas',
        'Kentucky',
        'Louisiana',
        'Maine',
        'Maryland',
        'Massachusetts',
        'Michigan',
        'Minnesota',
        'Mississippi',
        'Missouri',
        'Montana',
        'Nebraska',
        'Nevada (Northern)',
        'Nevada (Southern)',
        'New Hampshire',
        'New Jersey',
        'New Mexico',
        'New York',
        'North Carolina',
        'North Dakota',
        'Ohio',
        'Oklahoma',
        'Oregon',
        'Pennsylvania',
        'Rhode Island',
        'South Carolina',
        'South Dakota',
        'Tennessee',
        'Texas',
        'Utah',
        'Vermont',
        'Virginia',
        'Washington',
        'Washington D.C.',
        'West Virginia',
        'Wisconsin',
        'Wyoming',
    ]
]));
