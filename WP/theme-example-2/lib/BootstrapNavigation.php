<?php
/*
 * Class BootstrapNavigation
 */

namespace App\Controllers;

class BootstrapNavigation extends \Walker_Nav_Menu

{

    private $current_item;
    private $dropdown_menu_alignment_values = [
        'dropdown-menu-start',
        'dropdown-menu-end',
        'dropdown-menu-sm-start',
        'dropdown-menu-sm-end',
        'dropdown-menu-md-start',
        'dropdown-menu-md-end',
        'dropdown-menu-lg-start',
        'dropdown-menu-lg-end',
        'dropdown-menu-xl-start',
        'dropdown-menu-xl-end',
        'dropdown-menu-xxl-start',
        'dropdown-menu-xxl-end',
    ];

    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        // ACF fields begin
        $bottom_text = get_field('type_view_2', $this->current_item->ID);
        // ACF fields end

        $dropdown_menu_class[] = 'dropdown-menu-ls';

        if ($bottom_text) {
            $dropdown_menu_class[] = 'type-1';
        }

        foreach ($this->current_item->classes as $class) {
            if (in_array($class, $this->dropdown_menu_alignment_values)) {
                $dropdown_menu_class[] = $class;
            }
        }
        $indent = str_repeat("\t", $depth);
        $submenu = ($depth > 0) ? ' sub-menu' : '';

        $link_overview = '<li class="dropdown-menu-ls__arrow"></li>';
        $link_overview .= '<li class="dropdown-item-ls mw-100 w-100"><a href="' . $this->current_item->url . '" class="dropdown-item-ls__overview">' . __('Overview') . '</a></li>';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ", $dropdown_menu_class)) . " depth_$depth\">'. $link_overview .'\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $this->current_item = $item;

        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $li_attributes = '';
        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;

        // ACF fields begin
        $bottom_text = get_field('bottom_text', $item->ID);
        $link_icon = get_field('icon', $item->ID);
        $link_descr = get_field('description', $item->ID);
        // ACF fields end

        $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
        $classes[] = 'nav-item';
        $classes[] = 'dropdown-item-ls';
        if ($bottom_text) {
            $classes[] = 'dropdown-item-ls__footer';
        }
        $classes[] = 'nav-item-' . $item->ID;
        if ($depth && $args->walker->has_children) {
            $classes[] = 'dropdown-menu dropdown-menu-end';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = ' class="' . esc_attr($class_names) . '"';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        $active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? 'active' : '';
        $nav_link_class = '';
        if (!$bottom_text) {
            $nav_link_class = ($depth > 0) ? 'dropdown-item-ls__link ' : 'nav-link ';
        }

        $attributes .= ($args->walker->has_children) ? ' class="' . $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="' . $nav_link_class . $active_class . '"';

        $link_title = '';

        if ($depth > 0 && $bottom_text == '0') {
            if ($link_icon) {
                $link_title .= '<span class="dropdown-item-ls__icon"><img src="' . $link_icon['url'] . '" alt="' . apply_filters('the_title', $item->title, $item->ID) . '"></span>';
            }
            $link_title .= '<span class="dropdown-item-ls__text">';
            $link_title .= '<span class="dropdown-item-ls__title">' . $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after . '</span>';
            $link_title .= '<span class="dropdown-item-ls__descr">' . $link_descr . '</span>';
            $link_title .= '</span>';
        } else {
            $link_title = $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        }

        $item_output = $args->before;
        if ($depth > 0 && $bottom_text == '1') {
            $item_output .= $link_descr . ' ';
        }
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $link_title;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
