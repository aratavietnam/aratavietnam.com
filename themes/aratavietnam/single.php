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

get_header();
?>

<div class="container mx-auto px-4 py-8 lg:py-12">
    <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>
            <?php get_template_part('template-parts/content', 'single'); ?>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php
get_footer();
