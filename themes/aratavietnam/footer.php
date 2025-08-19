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

    <footer id="colophon" class="bg-gradient-to-r from-dark to-dark-light text-white mt-12" role="contentinfo">
        <div class="container mx-auto py-12">
            <?php do_action('aratavietnam_footer'); ?>

            <!-- Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- Brand Section -->
                <div>
                    <h3 class="text-xl font-bold mb-4">
                        <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                            <?php bloginfo('name'); ?>
                        </span>
                    </h3>
                    <p class="text-gray-300 mb-4"><?php bloginfo('description'); ?></p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-primary/20 hover:bg-primary rounded-full flex items-center justify-center transition-colors duration-300">
                            <span class="text-sm font-bold">FB</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-secondary/20 hover:bg-secondary rounded-full flex items-center justify-center transition-colors duration-300">
                            <span class="text-sm font-bold">T</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-tertiary/20 hover:bg-tertiary rounded-full flex items-center justify-center transition-colors duration-300">
                            <span class="text-sm font-bold">F</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-primary">Liên kết nhanh</h4>
                    <ul class="space-y-2">
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-300 hover:text-primary transition-colors duration-300 no-underline">Trang chủ</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/?post_type=post' ) ); ?>" class="text-gray-300 hover:text-primary transition-colors duration-300 no-underline">Bài viết</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/wp-admin' ) ); ?>" class="text-gray-300 hover:text-primary transition-colors duration-300 no-underline">Quản trị</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-secondary">Liên hệ</h4>
                    <div class="space-y-2 text-gray-300">
                        <p class="flex items-center">
                            <span class="mr-2 font-bold">-</span>
                            Việt Nam
                        </p>
                        <p class="flex items-center">
                            <span class="mr-2 font-bold">-</span>
                            info@aratavietnam.com
                        </p>
                        <p class="flex items-center">
                            <span class="mr-2 font-bold">-</span>
                            aratavietnam.com
                        </p>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-700 pt-6 text-center">
                <div class="text-sm text-gray-400">
                    &copy; <?php echo esc_html(date_i18n('Y')); ?> -
                    <span class="text-primary font-semibold"><?php bloginfo('name'); ?></span>.
                    Tất cả quyền được bảo lưu.
                </div>
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
