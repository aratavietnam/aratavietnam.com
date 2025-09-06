<?php
/**
 * Single post template file.
 *
 * @package ArataVietnam
 */

// Don't use this template for service post type
if (get_post_type() === 'service') {
    return;
}

// Get customizer color settings
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');

get_header();
?>

<main id="site-content" class="py-12 md:py-20" style="background-color: <?php echo esc_attr($background_color); ?>">
    <div class="container mx-auto px-4">
    <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>
            <?php get_template_part('template-parts/content', 'single'); ?>
        <?php endwhile; ?>
    <?php endif; ?>
    </div>
</main>

<?php
get_footer();
