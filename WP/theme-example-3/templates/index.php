<?php

// The variables inside this file will be available in every template

$object = get_queried_object();



$container = 'container-lg';
$columns   = 'col-xl-8 offset-xl-2 col-md-10 offset-md-1';

return [
    'json'               => [
        'post_id'   => $object instanceof WP_Post ? $object->ID : null,
        'container' => $container,
        'columns'   => $columns
    ],
    'is_using_divi'      => function_exists('et_pb_is_pagebuilder_used') && et_pb_is_pagebuilder_used(get_the_ID()),
    'include_title'      => true,
    // The default container definition
    'container'          => $container,
    'columns'            => $columns,
];
