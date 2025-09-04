<?php
/**
 * 404 Template - Styled like the Contact Page
 * This template provides a user-friendly and professional error page.
 */

get_header();

// Get customizer color settings
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');
?>

<main id="site-content" class="min-h-[60vh] flex items-center" style="background-color: <?php echo esc_attr($background_color); ?>;">
    <div class="container mx-auto px-4 py-28 text-center">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4"><?php _e('Lỗi không tìm thấy trang', 'aratavietnam'); ?></h2>
            <p class="text-gray-600 leading-relaxed">
                <?php _e('Chúng tôi xin lỗi, trang bạn yêu cầu không thể tìm thấy. Vui lòng kiểm tra lại URL hoặc quay về trang chủ.', 'aratavietnam'); ?>
            </p>

            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center justify-center rounded-lg px-6 py-3 text-white font-medium transition-colors duration-200" style="background-color: <?php echo esc_attr($primary_color); ?>;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    <?php _e('Quay về trang chủ', 'aratavietnam'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/lien-he/')); ?>" class="inline-flex items-center justify-center rounded-lg bg-gray-100 px-6 py-3 font-medium hover:bg-gray-200 transition-colors duration-200" style="color: <?php echo esc_attr($secondary_color); ?>;">
                    <?php _e('Liên hệ hỗ trợ', 'aratavietnam'); ?>
                </a>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
