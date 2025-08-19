<?php
/**
 * Theme footer template.
 *
 * @package ArataVietnam
 */
?>
        </main>

        <?php do_action('aratavietnam_content_end'); ?>
    </div>

    <?php do_action('aratavietnam_content_after'); ?>

    <!-- Footer -->
    <footer id="colophon" class="text-white" style="background: #0066A6;" role="contentinfo">
        <div class="container mx-auto py-16 px-4">
            <?php do_action('aratavietnam_footer'); ?>

            <!-- Footer Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 mb-12">

                <!-- Company Information (Mobile: Second, Desktop: First) -->
                <div class="space-y-4 order-2 lg:order-1">
                    <!-- Company Name -->
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-white mb-2">
                            Công ty TNHH Arata Việt Nam
                        </h3>
                        <div class="w-16 h-1 rounded-full" style="background: #FFAB14;"></div>
                    </div>

                    <div class="space-y-4 text-white/90">
                        <!-- Address -->
                        <div class="flex items-start group">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 transition-all duration-300 flex-shrink-0" style="background: #FFAB14;">
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-medium mb-1">Địa chỉ</p>
                                <p class="text-white/80 text-sm leading-relaxed">
                                    Lầu 2, Tòa nhà The Landmark,<br>
                                    5B Tôn Đức Thắng, Phường Bến Nghé,<br>
                                    Quận 1, Thành phố Hồ Chí Minh
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start group">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 transition-all duration-300 flex-shrink-0" style="background: #FFAB14;">
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-medium mb-1">Điện thoại</p>
                                <a href="tel:0283357100" class="text-white/80 hover:text-white transition-colors duration-300 hover:underline">
                                    028 3357 100
                                </a>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start group">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 transition-all duration-300 flex-shrink-0" style="background: #FFAB14;">
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-medium mb-1">Email</p>
                                <a href="mailto:arata-vietnam@arata-gr.jp" class="text-white/80 hover:text-white transition-colors duration-300 hover:underline break-all">
                                    arata-vietnam@arata-gr.jp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logo + Description + Social Media (Mobile: First, Desktop: Middle) -->
                <div class="text-center space-y-5 order-1 lg:order-2">
                    <!-- Logo -->
                    <div class="mb-5">
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo_url = get_template_directory_uri() . '/assets/images/logo.png';

                        if ($custom_logo_id) {
                            echo wp_get_attachment_image($custom_logo_id, 'full', false, array(
                                'class' => 'h-16 w-auto mx-auto',
                                'alt' => get_bloginfo('name'),
                                'style' => 'filter: brightness(0) invert(1);'
                            ));
                        } elseif (file_exists(get_template_directory() . '/assets/images/logo.png')) {
                            echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="h-16 w-auto mx-auto" style="filter: brightness(0) invert(1);">';
                        } else {
                            echo '<div class="text-2xl font-bold text-white">' . get_bloginfo('name') . '</div>';
                        }
                        ?>
                    </div>

                    <!-- Company Description -->
                    <div class="mb-5">
                        <p class="text-white/90 text-sm leading-relaxed max-w-sm mx-auto">
                            Arata Việt Nam là công ty con của Tập đoàn Arata Nhật Bản.<br>
                            Chúng tôi kinh doanh các sản phẩm Hóa Mỹ Phẩm<br>
                            được nhập khẩu trực tiếp từ Nhật Bản.
                        </p>
                    </div>

                    <!-- Social Media Icons - Facebook, Instagram, Website -->
                    <div class="flex justify-center space-x-4">
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/aratavietnam" target="_blank" rel="noopener noreferrer" class="group" aria-label="Facebook">
                            <div class="w-11 h-11 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-105" style="background: rgba(255, 255, 255, 0.15);">
                                <svg class="w-5 h-5 text-white transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 3.667h-3.533v7.98H9.101z"/>
                                </svg>
                            </div>
                        </a>

                        <!-- Instagram -->
                        <a href="https://www.instagram.com/aratavietnam/" target="_blank" rel="noopener noreferrer" class="group" aria-label="Instagram">
                            <div class="w-11 h-11 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-105" style="background: rgba(255, 255, 255, 0.15);">
                                <svg class="w-5 h-5 text-white transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </div>
                        </a>

                        <!-- Website -->
                        <a href="https://aratavietnam.com" target="_blank" rel="noopener noreferrer" class="group" aria-label="Website">
                            <div class="w-11 h-11 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-105" style="background: rgba(255, 255, 255, 0.15);">
                                <svg class="w-5 h-5 text-white transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Customer Service (Mobile: Third, Desktop: Third) -->
                <div class="space-y-6 order-3 lg:order-3">
                    <div>
                        <h4 class="text-2xl font-bold mb-2 text-white">Dịch vụ khách hàng</h4>
                        <div class="w-16 h-1 rounded-full mb-6" style="background: #FFAB14;"></div>
                    </div>

                    <!-- Menu columns -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Menu 1 -->
                        <nav>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer-menu-1',
                                'menu_class' => 'space-y-2',
                                'container' => false,
                                'fallback_cb' => function() {
                                    echo '<ul class="space-y-2">';
                                    echo '<li><a href="' . esc_url(home_url('/')) . '" class="block text-white/90 hover:text-white transition-colors duration-300 text-sm">Trang chủ</a></li>';
                                    echo '<li><a href="' . esc_url(home_url('/san-pham')) . '" class="block text-white/90 hover:text-white transition-colors duration-300 text-sm">Sản phẩm</a></li>';
                                    echo '<li><a href="' . esc_url(home_url('/ve-arata')) . '" class="block text-white/90 hover:text-white transition-colors duration-300 text-sm">Về Arata</a></li>';
                                    echo '</ul>';
                                },
                                'link_before' => '',
                                'link_after' => '',
                                'walker' => new class extends Walker_Nav_Menu {
                                    function start_lvl(&$output, $depth = 0, $args = null) {
                                        $output .= '<ul class="space-y-2">';
                                    }
                                    function end_lvl(&$output, $depth = 0, $args = null) {
                                        $output .= '</ul>';
                                    }
                                    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                                        $output .= '<li>';
                                        $output .= '<a href="' . esc_url($item->url) . '" class="block text-white/90 hover:text-white transition-colors duration-300 text-sm">';
                                        $output .= esc_html($item->title);
                                        $output .= '</a>';
                                    }
                                    function end_el(&$output, $item, $depth = 0, $args = null) {
                                        $output .= '</li>';
                                    }
                                }
                            ));
                            ?>
                        </nav>

                        <!-- Menu 2 -->
                        <nav>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer-menu-2',
                                'menu_class' => 'space-y-2',
                                'container' => false,
                                'fallback_cb' => function() {
                                    echo '<ul class="space-y-2">';
                                    echo '<li><a href="' . esc_url(home_url('/dich-vu')) . '" class="block text-white/90 hover:text-white transition-colors duration-300 text-sm">Dịch vụ</a></li>';
                                    echo '<li><a href="' . esc_url(home_url('/tin-tuc')) . '" class="block text-white/90 hover:text-white transition-colors duration-300 text-sm">Tin tức</a></li>';
                                    echo '<li><a href="' . esc_url(home_url('/lien-he')) . '" class="block text-white/90 hover:text-white transition-colors duration-300 text-sm">Liên hệ</a></li>';
                                    echo '</ul>';
                                },
                                'link_before' => '',
                                'link_after' => '',
                                'walker' => new class extends Walker_Nav_Menu {
                                    function start_lvl(&$output, $depth = 0, $args = null) {
                                        $output .= '<ul class="space-y-2">';
                                    }
                                    function end_lvl(&$output, $depth = 0, $args = null) {
                                        $output .= '</ul>';
                                    }
                                    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                                        $output .= '<li>';
                                        $output .= '<a href="' . esc_url($item->url) . '" class="block text-white/90 hover:text-white transition-colors duration-300 text-sm">';
                                        $output .= esc_html($item->title);
                                        $output .= '</a>';
                                    }
                                    function end_el(&$output, $item, $depth = 0, $args = null) {
                                        $output .= '</li>';
                                    }
                                }
                            ));
                            ?>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-12 pt-8 border-t border-white/20">
                <div class="text-center">
                    <div class="text-sm text-white">
                        &copy; <?php echo esc_html(date_i18n('Y')); ?>
                        <span class="font-bold mx-1" style="color: #FFAB14;"><?php bloginfo('name'); ?></span>
                        - Tất cả quyền được bảo lưu
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
