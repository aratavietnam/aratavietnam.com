<?php
/**
 * Remove service colors from customizer
 */

// Remove service color settings from customizer
function aratavietnam_remove_service_colors($wp_customize) {
    // Remove service color settings
    $wp_customize->remove_setting('service_consultation_color');
    $wp_customize->remove_control('service_consultation_color');
    
    $wp_customize->remove_setting('service_implementation_color');
    $wp_customize->remove_control('service_implementation_color');
    
    $wp_customize->remove_setting('service_maintenance_color');
    $wp_customize->remove_control('service_maintenance_color');
    
    $wp_customize->remove_setting('service_support_color');
    $wp_customize->remove_control('service_support_color');
    
    $wp_customize->remove_setting('service_training_color');
    $wp_customize->remove_control('service_training_color');
    
    $wp_customize->remove_setting('service_custom_color');
    $wp_customize->remove_control('service_custom_color');
    
    // Remove service colors divider
    $wp_customize->remove_setting('service_colors_divider');
    $wp_customize->remove_control('service_colors_divider');
}
add_action('customize_register', 'aratavietnam_remove_service_colors', 99);