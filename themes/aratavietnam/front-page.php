<?php
/**
 * Front Page Template - Dynamic Content from WordPress Admin
 */

get_header();
?>

<main id="site-content" class="min-h-screen bg-white">
    <div class="container mx-auto px-4 py-8">
        <?php
        // Get the front page content
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('prose prose-lg max-w-none'); ?>>
                    <?php if ( get_the_title() ) : ?>
                        <header class="entry-header mb-8 text-center">
                            <h1 class="entry-title text-4xl sm:text-6xl font-bold text-gray-800 mb-4">
                                <?php the_title(); ?>
                            </h1>
                        </header>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages([
                            'before' => '<div class="page-links mt-8 p-4 bg-gray-100 rounded-lg">',
                            'after'  => '</div>',
                            'link_before' => '<span class="inline-block px-3 py-1 mx-1 bg-primary text-white rounded">',
                            'link_after'  => '</span>',
                        ]);
                        ?>
                    </div>

                    <?php if ( get_edit_post_link() ) : ?>
                        <footer class="entry-footer mt-8 pt-4 border-t border-gray-200">
                            <div class="text-center">
                                <a href="<?php echo esc_url( get_edit_post_link() ); ?>" class="btn-primary !no-underline">
                                    <?php _e( 'Chỉnh sửa trang này', 'aratavietnam' ); ?>
                                </a>
                            </div>
                        </footer>
                    <?php endif; ?>
                </article>
                <?php
            endwhile;
        else :
            ?>
            <div class="text-center py-16">
                <h1 class="text-4xl sm:text-6xl font-bold text-gray-800 mb-4">
                    <?php _e( 'Chưa có nội dung', 'aratavietnam' ); ?>
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    <?php _e( 'Trang chủ chưa được thiết lập. Hãy tạo nội dung trong WordPress Admin.', 'aratavietnam' ); ?>
                </p>
                <?php if ( current_user_can( 'edit_pages' ) ) : ?>
                    <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=page' ) ); ?>" class="btn-primary !no-underline">
                        <?php _e( 'Tạo trang chủ', 'aratavietnam' ); ?>
                    </a>
                <?php endif; ?>
            </div>
            <?php
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
