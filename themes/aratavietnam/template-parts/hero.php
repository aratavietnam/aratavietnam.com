<?php
/**
 * Reusable Hero section
 */

if (!defined('ABSPATH')) { exit; }

$page_title = get_query_var('title', get_the_title());
$hero_title = get_query_var('subtitle');
$hero_description = get_query_var('description');
?>

<section class="relative bg-gradient-to-br from-primary/5 via-white to-secondary/5 border-b border-gray-200">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/3 to-transparent"></div>
    <div class="relative container mx-auto px-4 py-16 sm:py-20">
        <div class="max-w-4xl">
            <div class="flex items-center mb-4">
                <div class="w-12 h-1 bg-primary rounded-full mr-4"></div>
                <span class="text-primary font-medium text-sm uppercase tracking-wider"><?php echo esc_html($page_title); ?></span>
            </div>

            <h1 class="text-4xl sm:text-6xl font-bold text-gray-900 leading-tight mb-6">
                <?php echo esc_html($hero_title ? $hero_title : $page_title); ?>
            </h1>

            <?php if (!empty($hero_description)) : ?>
                <p class="text-xl text-gray-600 leading-relaxed max-w-2xl">
                    <?php echo wp_kses_post($hero_description); ?>
                </p>
            <?php endif; ?>
		</div>
	</div>
</section>
