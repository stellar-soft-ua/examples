<?php
/**
 * Template Name: Update locations
 */
$my_posts = get_posts( ['post_type' => 'location', 'numberposts' => -1 ] );
foreach ( $my_posts as $my_post ):
    $search_key = @get_post_custom_values('location_key_words',$my_post->ID)[0];
    if($search_key==''){
        update_post_meta($my_post->ID,'location_key_words','');
        echo "Updated post:";
        echo "ID: " . $my_post->ID . "  title: " . $my_post->post_title;
        echo "</br>";
    }
endforeach;