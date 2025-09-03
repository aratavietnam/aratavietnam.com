<?php
/**
 * 404 Template - Styled like the Contact Page
 * This template provides a user-friendly and professional error page.
 */

get_header();
?>

<main id="site-content" class="bg-white">
    <div class="container mx-auto px-4 py-24 text-center">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4"><?php _e('Lỗi không tìm thấy trang', 'aratavietnam'); ?></h2>
            <p class="text-gray-600 leading-relaxed">
                <?php _e('Chúng tôi xin lỗi, trang bạn yêu cầu không thể tìm thấy. Vui lòng kiểm tra lại URL hoặc quay về trang chủ.', 'aratavietnam'); ?>
            </p>

            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center justify-center rounded-lg bg-primary px-6 py-3 text-white font-medium hover:bg-primary-dark transition-colors duration-200">
                    <?php _e('Quay về trang chủ', 'aratavietnam'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/lien-he/')); ?>" class="inline-flex items-center justify-center rounded-lg bg-gray-100 px-6 py-3 text-gray-800 font-medium hover:bg-gray-200 transition-colors duration-200">
                    <?php _e('Liên hệ hỗ trợ', 'aratavietnam'); ?>
                </a>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
