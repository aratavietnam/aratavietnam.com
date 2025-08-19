<?php
/**
 * Vietnamese font optimization and language support
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Preload fonts for better performance
 */
function aratavietnam_preload_fonts() {
    // Preload Google Fonts for Vietnamese support
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";

    // Preload Inter font (primary choice for Vietnamese)
    echo '<link rel="preload" href="https://fonts.gstatic.com/s/inter/v12/UcCO3FwrK3iLTeHuS_fvQtMwCp50KnMw2boKoduKmMEVuLyfAZ9hiA.woff2" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
}
add_action('wp_head', 'aratavietnam_preload_fonts', 1);

/**
 * Add critical CSS for Vietnamese font optimization
 */
function aratavietnam_critical_font_css() {
    echo '<style>
        /* Critical font CSS - inline for immediate rendering */
        body {
            font-family: "Inter", "Source Sans Pro", "Noto Sans", "Segoe UI", -apple-system, BlinkMacSystemFont, sans-serif;
            font-display: swap;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Vietnamese text optimization */
        :lang(vi) {
            font-family: "Inter", "Source Sans Pro", "Noto Sans", "Segoe UI", -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.7;
            letter-spacing: 0.01em;
        }

        /* Ensure proper rendering of Vietnamese diacritics */
        * {
            font-feature-settings: "kern" 1, "liga" 1;
            text-rendering: optimizeLegibility;
        }
    </style>' . "\n";
}
add_action('wp_head', 'aratavietnam_critical_font_css', 2);

/**
 * Add Vietnamese language support
 */
function aratavietnam_vietnamese_support() {
    // Set proper charset for Vietnamese
    add_filter('wp_charset_collate', function($charset_collate) {
        return 'utf8mb4_unicode_ci';
    });

    // Ensure proper text rendering
    add_action('wp_head', function() {
        echo '<meta name="format-detection" content="telephone=no">' . "\n";
        echo '<meta name="language" content="vi">' . "\n";
    });
}
add_action('init', 'aratavietnam_vietnamese_support');
