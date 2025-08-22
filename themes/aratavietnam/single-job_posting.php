<?php
/**
 * The template for displaying single job postings
 *
 * @package ArataVietnam
 */

get_header();
?>

<div class="container mx-auto px-4 py-8 lg:py-12">
    <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>
            <?php get_template_part('template-parts/content', 'single-job_posting'); ?>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php
get_footer();
