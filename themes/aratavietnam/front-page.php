<?php
/**
 * Front Page Template - Arata Vietnam Homepage
 */

get_header();
?>

<main id="site-content">
    <?php
    // Hero Banner Section
    get_template_part('template-parts/homepage/hero-banner');

    // Featured Products Section
    get_template_part('template-parts/homepage/featured-products');

    // All Products Section
    get_template_part('template-parts/homepage/all-products');

    // About Arata Section
    get_template_part('template-parts/homepage/about-section');

    // Partners Section
    get_template_part('template-parts/homepage/partners-section');
    ?>
</main>

<?php get_footer(); ?>
