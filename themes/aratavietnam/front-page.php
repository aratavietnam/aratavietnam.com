<?php
/**
 * Front Page Template - Arata Vietnam Homepage
 */

// Get front page ID and section settings
$front_page_id = get_option('page_on_front');
$show_marquee = get_post_meta($front_page_id, 'arata_show_marquee', true);
$show_featured_products = get_post_meta($front_page_id, 'arata_show_featured_products', true);
$show_all_products = get_post_meta($front_page_id, 'arata_show_all_products', true);
$show_about = get_post_meta($front_page_id, 'arata_show_about', true);
$show_partners = get_post_meta($front_page_id, 'arata_show_partners', true);

get_header();
?>

<main id="site-content">
    <?php
    // Hero Banner Section
    get_template_part('template-parts/homepage/hero-banner');
    ?>
    <?php
    // Marquee Section - Running Text
    if ($show_marquee !== '0') {
        get_template_part('template-parts/homepage/marquee-section');
    }

    // Featured Products Section
    if ($show_featured_products !== '0') {
        get_template_part('template-parts/homepage/featured-products');
    }

    // All Products Section
    if ($show_all_products !== '0') {
        get_template_part('template-parts/homepage/all-products');
    }

    // About Arata Section
    if ($show_about !== '0') {
        get_template_part('template-parts/homepage/about-section');
    }

    // Partners Section
    if ($show_partners !== '0') {
        get_template_part('template-parts/homepage/partners-section');
    }

    ?>
</main>

<?php get_footer(); ?>
