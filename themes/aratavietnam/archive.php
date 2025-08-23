<?php
/**
 * The template for displaying archive pages
 *
 * @package ArataVietnam
 */

get_header();
?>

<main id="site-content" class="bg-gray-50 py-12 md:py-20">
    <div class="container mx-auto px-4">

        <header class="archive-header mb-12 text-center">
            <?php
            the_archive_title('<h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">', '</h1>');
            the_archive_description('<div class="text-lg text-gray-600 max-w-2xl mx-auto">', '</div>');
            ?>
        </header>

        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                while (have_posts()) : the_post();
                    get_template_part('template-parts/content', 'archive-card');
                endwhile;
                ?>
            </div>

            <div class="mt-12">
                <?php
                the_posts_pagination(array(
                    'prev_text' => '<span class="mr-2">&laquo;</span> Trang trước',
                    'next_text' => 'Trang sau <span class="ml-2">&raquo;</span>',
                    'screen_reader_text' => ' ',
                    'before_page_number' => '<span class="inline-flex items-center justify-center w-10 h-10">',
                    'after_page_number'  => '</span>',
                ));
                ?>
            </div>

        <?php else : ?>
            <div class="text-center py-16">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Không tìm thấy bài viết</h2>
                <p class="text-gray-600">Rất tiếc, không có bài viết nào phù hợp với yêu cầu của bạn.</p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="mt-6 inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-dark transition-colors">Quay về trang chủ</a>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
