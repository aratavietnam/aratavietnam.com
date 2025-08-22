<?php get_header(); ?>

<main class="main-content">
<div class="container mx-auto py-12 px-4">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('max-w-6xl mx-auto'); ?>>

                <!-- Page Content -->
                <div class="entry-content max-w-none">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links mt-8 p-4 bg-zinc-50 rounded-lg text-center">',
                        'after'  => '</div>',
                        'link_before' => '<span class="inline-block bg-primary text-white px-3 py-1 mx-1 rounded text-sm font-medium hover:bg-primary-dark transition-colors duration-200">',
                        'link_after' => '</span>',
                    ));
                    ?>
                </div>

                <!-- Page Footer -->
                <footer class="entry-footer mt-8 pt-6 border-t border-zinc-200">
                    <?php
                    // Display page meta information if needed
                    if (get_the_modified_time() !== get_the_time()) {
                        echo '<p class="text-sm text-zinc-600">';
                        printf(
                            esc_html__('Last updated: %s', 'aratavietnam'),
                            '<time datetime="' . esc_attr(get_the_modified_date('c')) . '">' . esc_html(get_the_modified_date()) . '</time>'
                        );
                        echo '</p>';
                    }
                    ?>
                </footer>

            </article>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php endwhile; ?>

    <?php else : ?>

        <!-- No content found -->
        <div class="no-content text-center py-16">
            <h1 class="text-3xl font-bold text-dark mb-4">
                <?php esc_html_e('Page Not Found', 'aratavietnam'); ?>
            </h1>
            <p class="text-lg text-zinc-600 mb-8">
                <?php esc_html_e('Sorry, the page you are looking for could not be found.', 'aratavietnam'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">
                <?php esc_html_e('Return to Homepage', 'aratavietnam'); ?>
            </a>
        </div>

    <?php endif; ?>
</div>
</main>

<?php get_footer(); ?>
