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

    <!-- Footer theo Brief: Nền xanh dương #0066A6, chữ trắng -->
    <footer id="colophon" class="text-white relative overflow-hidden" style="background: linear-gradient(135deg, #0066A6 0%, #004D7A 100%);" role="contentinfo">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-32 h-32 rounded-full" style="background: #F55E25;"></div>
            <div class="absolute bottom-20 right-20 w-24 h-24 rounded-full" style="background: #FFAB14;"></div>
            <div class="absolute top-1/2 left-1/3 w-16 h-16 rounded-full" style="background: #F55E25;"></div>
        </div>

        <div class="container mx-auto py-16 px-4 relative z-10">
            <?php do_action('aratavietnam_footer'); ?>

            <!-- Footer Content - 3 cột theo Brief -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 mb-12">

                <!-- Cột 1 - Bên trái: Thông tin công ty -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-2xl font-bold mb-2 text-white">
                            <?php bloginfo('name'); ?>
                        </h3>
                        <div class="w-16 h-1 rounded-full mb-4" style="background: #FFAB14;"></div>
                        <p class="text-white/80 text-lg leading-relaxed">
                            Nhà phân phối hóa mỹ phẩm hàng đầu Nhật Bản tại Việt Nam
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start group">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 transition-all duration-300" style="background: #FFAB14;">
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-medium">Địa chỉ</p>
                                <p class="text-white/80">Việt Nam</p>
                            </div>
                        </div>

                        <div class="flex items-start group">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 transition-all duration-300" style="background: #FFAB14;">
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-medium">Email</p>
                                <a href="mailto:info@aratavietnam.com" class="text-white/80 hover:text-white transition-colors duration-300 hover:underline">info@aratavietnam.com</a>
                            </div>
                        </div>

                        <div class="flex items-start group">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 transition-all duration-300" style="background: #FFAB14;">
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.559-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.559.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-medium">Website</p>
                                <a href="https://aratavietnam.com" class="text-white/80 hover:text-white transition-colors duration-300 hover:underline">aratavietnam.com</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột 2 - Ở giữa: Logo Arata + Social Media -->
                <div class="text-center space-y-8">
                    <!-- Logo Arata ở phía trên - Không nền, text trắng -->
                    <div class="mb-8">
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo_url = get_template_directory_uri() . '/assets/images/logo.png';

                        if ($custom_logo_id) {
                            // Logo có sẵn - hiển thị trực tiếp không nền
                            echo wp_get_attachment_image($custom_logo_id, 'full', false, array(
                                'class' => 'h-20 w-auto mx-auto filter brightness-0 invert',
                                'alt' => get_bloginfo('name'),
                                'style' => 'filter: brightness(0) invert(1);' // Chuyển logo thành trắng
                            ));
                        } elseif (file_exists(get_template_directory() . '/assets/images/logo.png')) {
                            // Logo mặc định - hiển thị trực tiếp không nền
                            echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="h-20 w-auto mx-auto" style="filter: brightness(0) invert(1);">';
                        } else {
                            // Fallback text logo - màu trắng
                            echo '<div class="text-3xl font-bold text-white">' . get_bloginfo('name') . '</div>';
                        }
                        ?>
                    </div>

                    <!-- Social Media Title -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4 text-white">Kết nối với chúng tôi</h4>
                        <div class="w-16 h-1 rounded-full mx-auto mb-6" style="background: #FFAB14;"></div>
                    </div>

                    <!-- Social Media Icons - Tròn, không border, nền trắng nhạt -->
                    <div class="flex justify-center space-x-5">
                        <!-- Facebook -->
                        <a href="#" class="group relative" aria-label="Facebook">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-105" style="background: rgba(255, 255, 255, 0.15);">
                                <svg class="w-7 h-7 text-white transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </div>
                            <div class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <span class="text-xs text-white font-medium whitespace-nowrap">Facebook</span>
                            </div>
                        </a>

                        <!-- TikTok -->
                        <a href="#" class="group relative" aria-label="TikTok">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-105" style="background: rgba(255, 255, 255, 0.15);">
                                <svg class="w-7 h-7 text-white transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                            </div>
                            <div class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <span class="text-xs text-white font-medium whitespace-nowrap">TikTok</span>
                            </div>
                        </a>

                        <!-- Shopee -->
                        <a href="#" class="group relative" aria-label="Shopee">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-105" style="background: rgba(255, 255, 255, 0.15);">
                                <svg class="w-7 h-7 text-white transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.5 7h-13l-1.5 9h16l-1.5-9zm-13-2h13c.8 0 1.5.7 1.5 1.5v.5h-16v-.5c0-.8.7-1.5 1.5-1.5zm-1 13c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm12 0c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1z"/>
                                </svg>
                            </div>
                            <div class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <span class="text-xs text-white font-medium whitespace-nowrap">Shopee</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Cột 3 - Bên phải: Navigation Links -->
                <div class="space-y-6">
                    <div>
                        <h4 class="text-2xl font-bold mb-2 text-white">Menu chính</h4>
                        <div class="w-16 h-1 rounded-full mb-6" style="background: #FFAB14;"></div>
                    </div>

                    <nav>
                        <ul class="space-y-4">
                            <li>
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="group flex items-center p-3 rounded-lg transition-all duration-300 hover:bg-white/10 hover:backdrop-blur-sm">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all duration-300" style="background: rgba(245, 94, 37, 0.2);">
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" style="color: #F55E25;" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                        </svg>
                                    </div>
                                    <span class="text-white/90 group-hover:text-white font-medium transition-colors duration-300">Trang chủ</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url( home_url( '/san-pham' ) ); ?>" class="group flex items-center p-3 rounded-lg transition-all duration-300 hover:bg-white/10 hover:backdrop-blur-sm">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all duration-300" style="background: rgba(245, 94, 37, 0.2);">
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" style="color: #F55E25;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 2L3 7v11a1 1 0 001 1h12a1 1 0 001-1V7l-7-5zM8 15v-3a1 1 0 011-1h2a1 1 0 011 1v3H8z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-white/90 group-hover:text-white font-medium transition-colors duration-300">Sản phẩm</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url( home_url( '/dich-vu' ) ); ?>" class="group flex items-center p-3 rounded-lg transition-all duration-300 hover:bg-white/10 hover:backdrop-blur-sm">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all duration-300" style="background: rgba(245, 94, 37, 0.2);">
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" style="color: #F55E25;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-white/90 group-hover:text-white font-medium transition-colors duration-300">Dịch vụ</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url( home_url( '/ve-arata' ) ); ?>" class="group flex items-center p-3 rounded-lg transition-all duration-300 hover:bg-white/10 hover:backdrop-blur-sm">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all duration-300" style="background: rgba(245, 94, 37, 0.2);">
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" style="color: #F55E25;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-white/90 group-hover:text-white font-medium transition-colors duration-300">Về Arata</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url( home_url( '/tin-tuc' ) ); ?>" class="group flex items-center p-3 rounded-lg transition-all duration-300 hover:bg-white/10 hover:backdrop-blur-sm">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all duration-300" style="background: rgba(245, 94, 37, 0.2);">
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" style="color: #F55E25;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="text-white/90 group-hover:text-white font-medium transition-colors duration-300">Tin tức</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url( home_url( '/lien-he' ) ); ?>" class="group flex items-center p-3 rounded-lg transition-all duration-300 hover:bg-white/10 hover:backdrop-blur-sm">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 transition-all duration-300" style="background: rgba(245, 94, 37, 0.2);">
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" style="color: #F55E25;" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                        </svg>
                                    </div>
                                    <span class="text-white/90 group-hover:text-white font-medium transition-colors duration-300">Liên hệ</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Copyright đơn giản, không shadow -->
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
