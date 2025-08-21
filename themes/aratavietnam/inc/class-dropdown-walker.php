<?php
/**
 * Custom Walker for Dropdown Navigation Menu
 */

if (!defined('ABSPATH')) {
    exit;
}

class Arata_Dropdown_Walker extends Walker_Nav_Menu {

    /**
     * Start Level - output of sub UL
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu absolute left-0 top-full mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50\">\n";
    }

    /**
     * End Level - closing of sub UL
     */
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * Start Element - output of each LI
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Check if item has children
        $has_children = in_array('menu-item-has-children', $classes);

        if ($depth === 0) {
            // Top level items
            $class_names = 'relative group';
            if ($has_children) {
                $class_names .= ' has-dropdown menu-item-has-children';
            }
        } else {
            // Dropdown items
            $class_names = 'dropdown-item';
        }

        $class_names = apply_filters('nav_menu_css_class', array_filter(explode(' ', $class_names)), $item, $args);
        $class_names = $class_names ? ' class="' . esc_attr(implode(' ', $class_names)) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';

        if ($depth === 0) {
            // Top level link styling
            $link_class = 'block px-4 py-2 text-gray-900 hover:text-primary transition-colors duration-200 font-medium';
        } else {
            // Dropdown link styling
            $link_class = 'block px-4 py-3 text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200 text-sm';
        }

        $item_output = isset($args->before) ? $args->before : '';

        // Add responsive inline style for dropdown items
        $inline_style = '';
        if ($depth === 0 && $has_children) {
            // Use responsive flex layout that works on both desktop and mobile
            $inline_style = ' style="display: flex !important; align-items: center !important; justify-content: space-between !important; width: 100% !important;"';
        }

        $item_output .= '<a class="' . $link_class . '"' . $attributes . $inline_style . '>';

        // Add text content
        $item_output .= '<span style="flex: 1;">' . (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '') . '</span>';

        // Add dropdown arrow for parent items (responsive)
        if ($depth === 0 && $has_children) {
            $item_output .= '<svg style="width: 16px; height: 16px; transition: transform 0.2s ease; flex-shrink: 0; margin-left: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>';
        }

        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * End Element - closing of each LI
     */
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}
