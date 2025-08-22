<?php
/**
 * Compact Hero section - Optimized for smaller, elegant appearance
 */

if (!defined('ABSPATH')) { exit; }

$page_title = get_query_var('title', get_the_title());
$hero_title = get_query_var('subtitle');
$hero_description = get_query_var('description');
?>

<section class="relative bg-gradient-to-r from-primary/3 via-white to-secondary/3 border-b border-gray-100">
    <div class="absolute inset-0 bg-white/80 backdrop-blur-sm"></div>
    <div class="relative container mx-auto px-4 py-8 sm:py-12">
        <div class="max-w-3xl mx-auto text-center">
            <!-- Compact title indicator -->
            <div class="inline-flex items-center mb-3">
                <div class="w-8 h-0.5 bg-primary rounded-full mr-3"></div>
                <span class="text-primary font-medium text-xs uppercase tracking-widest"><?php echo esc_html($page_title); ?></span>
                <div class="w-8 h-0.5 bg-primary rounded-full ml-3"></div>
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
