<?php
/**
 * Compact Hero section - Optimized for smaller, elegant appearance
 */

if (!defined('ABSPATH')) { exit; }

// Get global colors from theme customizer
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFB800');
$background_color = get_theme_mod('theme_background_color', '#FFFFFF');

$page_title = get_query_var('title', get_the_title());
$hero_title = get_query_var('subtitle');
$hero_description = get_query_var('description');
?>

<section class="relative border-b border-gray-100" style="background: linear-gradient(to right, <?php echo esc_attr($primary_color); ?>0d, white, <?php echo esc_attr($secondary_color); ?>0d);">
    <div class="absolute inset-0 backdrop-blur-sm" style="background-color: rgba(255, 255, 255, 0.8);"></div>
    <div class="relative container mx-auto px-4 py-8 sm:py-12">
        <div class="max-w-3xl mx-auto text-center">
            <!-- Compact title indicator -->
            <div class="inline-flex items-center mb-3">
                <div class="w-8 h-0.5 rounded-full mr-3" style="background-color: <?php echo esc_attr($primary_color); ?>;"></div>
                <span class="font-medium text-xs uppercase tracking-widest" style="color: <?php echo esc_attr($primary_color); ?>;"><?php echo esc_html($page_title); ?></span>
                <div class="w-8 h-0.5 rounded-full ml-3" style="background-color: <?php echo esc_attr($primary_color); ?>;"></div>
            </div>

            <!-- Smaller, more elegant title -->
            <h1 class="text-2xl sm:text-4xl font-bold text-gray-900 leading-tight mb-4">
                <?php echo esc_html($hero_title); ?>
            </h1>

            <?php if (!empty($hero_description)) : ?>
                <!-- Compact description -->
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed max-w-xl mx-auto">
                    <?php echo wp_kses_post($hero_description); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>
