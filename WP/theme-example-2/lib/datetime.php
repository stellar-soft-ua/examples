<?php

function display_datetime($datetime) {
    $format = 'm/d/Y h:i A e';
    $formattedDate = date($format);
    try {
        $date = new DateTime($datetime);
        $date->setTimezone(new DateTimeZone('EST'));
        $formattedDate = $date->format($format);
    } catch (Exception $error) {
        // @todo log errors
    }

    return $formattedDate;
}