<?php
/**
 * fixes missing description in menu
 */
add_filter('wp_get_nav_menu_items', 'my_wp_get_nav_menu_items', 10, 3);
function my_wp_get_nav_menu_items($items, $menu, $args) {
    foreach($items as $key => $item)
        $items[$key]->description = '';

    return $items;
}
