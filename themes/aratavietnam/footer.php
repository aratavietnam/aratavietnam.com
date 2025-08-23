<?php
/**
 * The template for displaying the footer
 */
?>

<footer id="colophon" class="site-footer relative z-10" style="background: linear-gradient(135deg, #0066A6 0%, #004d7a 100%);">
    <div class="container mx-auto px-4 py-12">
        <div>
            <!-- Footer Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 mb-12 lg:items-start">

                <!-- Company Information (Mobile: Second, Desktop: First) -->
                <div class="text-left space-y-4 order-2 lg:order-1">
                    <!-- Company Name -->
                    <div class="mb-3">
                        <h3 class="text-xl font-bold text-white mb-2">
                            <?php echo esc_html(get_theme_mod('footer_company_name', 'Công ty TNHH Arata Việt Nam')); ?>
                        </h3>
                        <div class="w-16 h-1 rounded-full" style="background: #FFAB14;"></div>
                    </div>

                    <div class="grid gap-y-4">
                        <!-- Address -->
                        <div class="flex items-start group">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 transition-all duration-300 flex-shrink-0" style="background: #FFAB14;">
                                <span data-icon="location" data-size="20" data-stroke="2" class="text-white"></span>
                            </div>
                            <div>
                                <p class="text-white font-medium mb-1">Địa chỉ</p>
                                <p class="text-white/80 text-sm leading-relaxed">
                                    <?php echo nl2br(esc_html(get_theme_mod('footer_company_address', "Lầu 2, Tòa nhà The Landmark,\n5B Tôn Đức Thắng, Phường Bến Nghé,\nQuận 1, Thành phố Hồ Chí Minh"))); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start group">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 transition-all duration-300 flex-shrink-0" style="background: #FFAB14;">
                                <span data-icon="phone" data-size="20" data-stroke="2" class="text-white"></span>
                            </div>
                            <div>
                                <p class="text-white font-medium mb-1">Điện thoại</p>
                                <a href="tel:<?php echo esc_attr(get_theme_mod('footer_company_phone_link', '+84 28 3827 7060')); ?>" class="text-white/80 hover:text-white transition-colors duration-300 hover:underline">
                                    <?php echo esc_html(get_theme_mod('footer_company_phone', '+84 28 3827 7060')); ?>
                                </a>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start group">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 transition-all duration-300 flex-shrink-0" style="background: #FFAB14;">
                                <span data-icon="mail" data-size="20" data-stroke="2" class="text-white"></span>
                            </div>
                            <div>
                                <p class="text-white font-medium mb-1">Email</p>
                                <a href="mailto:<?php echo esc_attr(get_theme_mod('footer_company_email', 'arata-vietnam@arata-gr.jp')); ?>" class="text-white/80 hover:text-white transition-colors duration-300 hover:underline break-all">
                                    <?php echo esc_html(get_theme_mod('footer_company_email', 'arata-vietnam@arata-gr.jp')); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logo + Description + Social Media (Mobile: First, Desktop: Middle) -->
                <div class="text-left lg:text-center space-y-5 order-1 lg:order-2">
                    <!-- Logo -->
                    <div class="mb-5">
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo_url = get_template_directory_uri() . '/assets/images/logo.png';

                        if ($custom_logo_id) {
                            echo wp_get_attachment_image($custom_logo_id, 'full', false, array(
                                'class' => 'h-16 w-auto lg:mx-auto',
                                'alt' => get_bloginfo('name'),
                                'style' => 'filter: brightness(0) invert(1);'
                            ));
                        } elseif (file_exists(get_template_directory() . '/assets/images/logo.png')) {
                            echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="h-16 w-auto lg:mx-auto" style="filter: brightness(0) invert(1);">';
                        } else {
                            echo '<div class="text-2xl font-bold text-white">' . get_bloginfo('name') . '</div>';
                        }
                        ?>
                    </div>

                    <!-- Company Description -->
                    <div class="mb-5">
                        <p class="text-white/90 text-sm leading-relaxed max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl text-left lg:text-center lg:mx-auto">
                            <?php
                            $description = get_theme_mod('footer_company_description', "Arata Việt Nam là công ty con của Tập đoàn Arata Nhật Bản.<br>Chúng tôi kinh doanh các sản phẩm Hóa Mỹ Phẩm<br>được nhập khẩu trực tiếp từ Nhật Bản.");
                            echo $description;
                            ?>
                        </p>
                    </div>

                    <!-- Social Media Icons -->
                    <div class="flex justify-start lg:justify-center gap-4">
                        <?php
                        $facebook_url = get_theme_mod('footer_facebook_url', 'https://www.facebook.com/aratavietnam');
                        $instagram_url = get_theme_mod('footer_instagram_url', 'https://www.instagram.com/aratavietnam/');
                        $website_url = get_theme_mod('footer_website_url', 'https://aratavietnam.com');
                        $tiktok_url = get_theme_mod('footer_tiktok_url', '');
                        $shopee_url = get_theme_mod('footer_shopee_url', '');

                        // Social media links array
                        $social_links = array();
                        if (!empty($facebook_url)) {
                            $social_links[] = array('url' => $facebook_url, 'icon' => 'facebook', 'label' => 'Facebook');
                        }
                        if (!empty($instagram_url)) {
                            $social_links[] = array('url' => $instagram_url, 'icon' => 'instagram', 'label' => 'Instagram');
                        }
                        if (!empty($tiktok_url)) {
                            $social_links[] = array('url' => $tiktok_url, 'icon' => 'tiktok', 'label' => 'TikTok');
                        }
                        if (!empty($shopee_url)) {
                            $social_links[] = array('url' => $shopee_url, 'icon' => 'shopee', 'label' => 'Shopee');
                        }
                        if (!empty($website_url)) {
                            $social_links[] = array('url' => $website_url, 'icon' => 'globe', 'label' => 'Website');
                        }
                        ?>

                        <?php foreach ($social_links as $social): ?>
                        <!-- <?php echo esc_html($social['label']); ?> -->
                        <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener noreferrer" class="group" aria-label="<?php echo esc_attr($social['label']); ?>">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-105" style="background: rgba(255, 255, 255, 0.15);">
                                <span class="text-white transition-transform duration-300 group-hover:scale-110" data-icon="<?php echo esc_attr($social['icon']); ?>" data-size="20" data-stroke="2"></span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Customer Service (Mobile: Third, Desktop: Third) -->
                <div class="text-left space-y-6 order-3 lg:order-3">
                    <div>
                        <h4 class="text-xl font-bold mb-2 text-white"><?php echo esc_html(get_theme_mod('footer_service_title', 'Dịch vụ khách hàng')); ?></h4>
                        <div class="w-16 h-1 rounded-full mb-6" style="background: #FFAB14;"></div>
                    </div>

                    <!-- Menu columns -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Menu 1 -->
                        <nav>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer-menu-1',
                                'menu_class' => 'footer-menu-links space-y-2',
                                'container' => false,
                                'fallback_cb' => function() {
                                    echo '<ul class="footer-menu-links space-y-2">';
                                    echo '<li><a href="' . esc_url(home_url('/')) . '">Trang chủ</a></li>';
                                    echo '<li><a href="' . esc_url(home_url('/san-pham')) . '">Sản phẩm</a></li>';
                                    echo '<li><a href="' . esc_url(home_url('/ve-arata')) . '">Về Arata</a></li>';
                                    echo '</ul>';
                                },
                                'link_before' => '',
                                'link_after' => '',
                            ));
                            ?>
                        </nav>

                        <!-- Menu 2 -->
                        <nav>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer-menu-2',
                                'menu_class' => 'footer-menu-links space-y-2',
                                'container' => false,
                                'fallback_cb' => function() {
                                    echo '<ul class="footer-menu-links space-y-2">';
                                    echo '<li><a href="' . esc_url(home_url('/chinh-sach-doi-tra')) . '">Chính sách đổi trả</a></li>';
                                    echo '<li><a href="' . esc_url(home_url('/chinh-sach-bao-mat')) . '">Chính sách bảo mật</a></li>';
                                    echo '<li><a href="' . esc_url(home_url('/dieu-khoan-dich-vu')) . '">Điều khoản dịch vụ</a></li>';
                                    echo '</ul>';
                                },
                                'link_before' => '',
                                'link_after' => '',
                            ));
                            ?>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Copyright Section -->
            <div class="border-t border-white/20 pt-4 text-center">
                <p class="text-white/80 text-sm">
                    © <?php echo date('Y'); ?>
                    <span class="font-medium text-white"><?php echo esc_html(get_theme_mod('footer_company_name', 'Công ty TNHH Arata Việt Nam')); ?></span>.
                    <?php echo esc_html(get_theme_mod('footer_copyright_text', 'Tất cả quyền được bảo lưu')); ?>.
                </p>
            </div>
        </div>
    </footer>
</div>

<?php
// Include floating social widget
get_template_part('template-parts/floating-social');
?>

<?php wp_footer(); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.body.classList.add('preloading');
});

window.addEventListener('load', function() {
    document.body.classList.remove('preloading');
    document.body.classList.add('loaded');
});
</script>

</body>
</html>
