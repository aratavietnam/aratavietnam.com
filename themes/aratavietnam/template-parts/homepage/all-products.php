<?php
/**
 * Homepage All Products Section - Horizontal Slider
 */
?>

<!-- All Products Section -->
<section id="all-products" class="py-20 bg-white scroll-animate">
    <div class="container mx-auto px-4 text-center">
        <?php
        // Get custom content for the section header
        $front_page_id = get_option('page_on_front');
        $section_title = get_post_meta($front_page_id, '_all_products_title', true);
        $section_description = get_post_meta($front_page_id, '_all_products_description', true);

        // Fallback to default text if not set
        if (empty($section_title)) {
            $section_title = 'TẤT CẢ SẢN PHẨM';
        }
        if (empty($section_description)) {
            $section_description = 'Khám phá đầy đủ các sản phẩm hóa mỹ phẩm từ các thương hiệu hàng đầu Nhật Bản';
        }
        ?>
            <?php
            // Get custom content for the section header
            $front_page_id = get_option('page_on_front');
            $title_part1 = get_post_meta($front_page_id, '_all_products_title_part1', true);
            $title_part2 = get_post_meta($front_page_id, '_all_products_title_part2', true);
            $section_description = get_post_meta($front_page_id, '_all_products_description', true);

            // Fallback to default text if not set
            if (empty($title_part1)) {
                $title_part1 = 'Tất cả';
            }
            if (empty($title_part2)) {
                $title_part2 = 'Sản phẩm';
            }
            if (empty($section_description)) {
                $section_description = 'Khám phá đầy đủ các sản phẩm hóa mỹ phẩm từ các thương hiệu hàng đầu Nhật Bản';
            }
            ?>
            <div class="mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    <span class="text-secondary"><?php echo esc_html($title_part1); ?></span>
                    <span class="text-primary"><?php echo esc_html($title_part2); ?></span>
                </h2>
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed max-w-2xl mx-auto">
                    <?php echo esc_html($section_description); ?>
                </p>
            </div>

        <!-- Products Slider -->
        <div class="products-container">
            <?php
            // Get all products (limit to 20 for slider)
            $all_products = wc_get_products([
                'limit' => 20,
                'status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC'
            ]);

            if ($all_products) :
            ?>
                <!-- Desktop Slider (5 products per view) -->
                <div class="hidden md:block relative">
                    <!-- Left Navigation Button -->
                    <button class="desktop-nav absolute top-1/2 left-0 transform -translate-y-1/2 -translate-x-[calc(100%+1rem)] z-10 bg-white/80 backdrop-blur-sm shadow-lg text-gray-700 w-12 h-12 rounded-full text-lg font-medium hover:bg-white transition-colors" data-direction="prev">
                        ←
                    </button>

                    <!-- Right Navigation Button -->
                    <button class="desktop-nav absolute top-1/2 right-0 transform -translate-y-1/2 translate-x-[calc(100%+1rem)] z-10 bg-white/80 backdrop-blur-sm shadow-lg text-gray-700 w-12 h-12 rounded-full text-lg font-medium hover:bg-white transition-colors" data-direction="next">
                        →
                    </button>

                    <div class="desktop-slider overflow-hidden">
                        <div class="flex gap-6 pb-4 px-4" id="desktop-products-slider">
                            <?php foreach ($all_products as $product) :
                                $product_id = $product->get_id();
                                $product_name = $product->get_name();
                                $product_price = $product->get_price();
                                $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'medium');
                                $product_link = get_permalink($product_id);
                                ?>
                                <div class="group flex-shrink-0 w-[calc(20%-1rem)]">
                                    <!-- Product Image -->
                                    <div class="aspect-square overflow-hidden bg-gray-50 mb-3 rounded-lg">
                                        <?php if ($product_image) : ?>
                                            <a href="<?php echo esc_url($product_link); ?>">
                                                <img src="<?php echo esc_url($product_image[0]); ?>"
                                                     alt="<?php echo esc_attr($product_name); ?>"
                                                     class="w-full h-full object-cover" />
                                            </a>
                                        <?php else : ?>
                                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                                <span data-icon="package" data-size="48" class="text-gray-400"></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="text-center min-h-[4rem] flex flex-col justify-center">
                                        <!-- Product Name -->
                                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-1 text-base leading-relaxed group-hover:text-orange-500 transition-colors">
                                            <a href="<?php echo esc_url($product_link); ?>">
                                                <?php echo esc_html($product_name); ?>
                                            </a>
                                        </h3>

                                        <!-- Product Price -->
                                        <div class="text-base font-semibold text-gray-700">
                                            <?php if ($product_price) : ?>
                                                <?php echo number_format($product_price); ?>₫
                                            <?php else : ?>
                                                Liên hệ
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Mobile Slider (2 products per view) -->
                <div class="md:hidden relative">
                    <!-- Left Navigation Button -->
                    <button class="mobile-nav absolute top-1/2 left-2 transform -translate-y-1/2 z-10 bg-white/80 backdrop-blur-sm shadow-lg text-gray-700 w-10 h-10 rounded-full text-sm font-medium hover:bg-white transition-colors" data-direction="prev">
                        ←
                    </button>

                    <!-- Right Navigation Button -->
                    <button class="mobile-nav absolute top-1/2 right-2 transform -translate-y-1/2 z-10 bg-white/80 backdrop-blur-sm shadow-lg text-gray-700 w-10 h-10 rounded-full text-sm font-medium hover:bg-white transition-colors" data-direction="next">
                        →
                    </button>
                    <div class="mobile-slider overflow-hidden">
                        <div class="flex gap-4 pb-4 px-2" id="mobile-products-slider">
                            <?php foreach ($all_products as $product) :
                                $product_id = $product->get_id();
                                $product_name = $product->get_name();
                                $product_price = $product->get_price();
                                $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'medium');
                                $product_link = get_permalink($product_id);
                                ?>
                                <div class="group flex-shrink-0 w-[calc(50%-0.5rem)]">
                                    <!-- Product Image -->
                                    <div class="aspect-square overflow-hidden bg-gray-50 mb-3 rounded-lg">
                                        <?php if ($product_image) : ?>
                                            <a href="<?php echo esc_url($product_link); ?>">
                                                <img src="<?php echo esc_url($product_image[0]); ?>"
                                                     alt="<?php echo esc_attr($product_name); ?>"
                                                     class="w-full h-full object-cover" />
                                            </a>
                                        <?php else : ?>
                                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                                <span data-icon="package" data-size="48" class="text-gray-400"></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="text-center min-h-[4rem] flex flex-col justify-center">
                                        <!-- Product Name -->
                                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-1 text-sm leading-relaxed group-hover:text-orange-500 transition-colors">
                                            <a href="<?php echo esc_url($product_link); ?>">
                                                <?php echo esc_html($product_name); ?>
                                            </a>
                                        </h3>

                                        <!-- Product Price -->
                                        <div class="text-sm font-semibold text-gray-700">
                                            <?php if ($product_price) : ?>
                                                <?php echo number_format($product_price); ?>₫
                                            <?php else : ?>
                                                Liên hệ
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <!-- No Products Found -->
                <div class="text-center py-16">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span data-icon="package" data-size="32" class="text-gray-400"></span>
                    </div>
                    <h3 class="text-lg font-medium text-gray-600 mb-2">Chưa có sản phẩm nào</h3>
                    <p class="text-gray-500">Vui lòng thêm sản phẩm trong admin panel.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- View All Products Button -->
        <div class="text-center mt-12">
            <a href="<?php echo wc_get_page_permalink('shop'); ?>"
               class="inline-flex items-center px-6 py-3 bg-orange-500 text-white font-medium rounded-lg hover:bg-orange-600 transition-all duration-300">
                Xem tất cả sản phẩm
                <span data-icon="arrow-right" data-size="16" class="ml-2"></span>
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Desktop Slider (5 products per view)
    const desktopSlider = document.getElementById('desktop-products-slider');
    const desktopNavButtons = document.querySelectorAll('.desktop-nav');

    if (desktopSlider && desktopNavButtons.length > 0) {
        let desktopCurrentIndex = 0;
        const desktopTotalProducts = desktopSlider.children.length;
        const desktopProductsPerView = 5;
        const desktopMaxIndex = Math.max(0, desktopTotalProducts - desktopProductsPerView);

        function updateDesktopSlider() {
            const translateX = -desktopCurrentIndex * (100 / desktopProductsPerView);
            desktopSlider.style.transform = `translateX(${translateX}%)`;

            // Update navigation buttons
            desktopNavButtons.forEach(btn => {
                if (btn.dataset.direction === 'prev') {
                    btn.style.opacity = desktopCurrentIndex === 0 ? '0.5' : '1';
                    btn.disabled = desktopCurrentIndex === 0;
                } else if (btn.dataset.direction === 'next') {
                    btn.style.opacity = desktopCurrentIndex >= desktopMaxIndex ? '0.5' : '1';
                    btn.disabled = desktopCurrentIndex >= desktopMaxIndex;
                }
            });
        }

        // Desktop navigation button clicks
        desktopNavButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.dataset.direction === 'prev' && desktopCurrentIndex > 0) {
                    desktopCurrentIndex--;
                } else if (this.dataset.direction === 'next' && desktopCurrentIndex < desktopMaxIndex) {
                    desktopCurrentIndex++;
                }
                updateDesktopSlider();
            });
        });

        // Initialize desktop slider
        updateDesktopSlider();

        // Auto-slider for desktop (slow)
        let desktopAutoInterval = setInterval(() => {
            if (desktopCurrentIndex >= desktopMaxIndex) {
                desktopCurrentIndex = 0;
            } else {
                desktopCurrentIndex++;
            }
            updateDesktopSlider();
        }, 5000); // 5 seconds per slide

        // Pause auto-slider on hover
        desktopSlider.addEventListener('mouseenter', () => clearInterval(desktopAutoInterval));
        desktopSlider.addEventListener('mouseleave', () => {
            desktopAutoInterval = setInterval(() => {
                if (desktopCurrentIndex >= desktopMaxIndex) {
                    desktopCurrentIndex = 0;
                } else {
                    desktopCurrentIndex++;
                }
                updateDesktopSlider();
            }, 5000);
        });
    }

    // Mobile Slider (2 products per view)
    const mobileSlider = document.getElementById('mobile-products-slider');
    const mobileNavButtons = document.querySelectorAll('.mobile-nav');

    if (mobileSlider && mobileNavButtons.length > 0) {
        let mobileCurrentIndex = 0;
        const mobileTotalProducts = mobileSlider.children.length;
        const mobileProductsPerView = 2;
        const mobileMaxIndex = Math.max(0, mobileTotalProducts - mobileProductsPerView);

        function updateMobileSlider() {
            const translateX = -mobileCurrentIndex * (100 / mobileProductsPerView);
            mobileSlider.style.transform = `translateX(${translateX}%)`;

            // Update navigation buttons
            mobileNavButtons.forEach(btn => {
                if (btn.dataset.direction === 'prev') {
                    btn.style.opacity = mobileCurrentIndex === 0 ? '0.5' : '1';
                    btn.disabled = mobileCurrentIndex === 0;
                } else if (btn.dataset.direction === 'next') {
                    btn.style.opacity = mobileCurrentIndex >= mobileMaxIndex ? '0.5' : '1';
                    btn.disabled = mobileCurrentIndex >= mobileMaxIndex;
                }
            });
        }

        // Mobile navigation button clicks
        mobileNavButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.dataset.direction === 'prev' && mobileCurrentIndex > 0) {
                    mobileCurrentIndex--;
                } else if (this.dataset.direction === 'next' && mobileCurrentIndex < mobileMaxIndex) {
                    mobileCurrentIndex++;
                }
                updateMobileSlider();
            });
        });

        // Touch/swipe support for mobile
        let startX = 0;
        let currentX = 0;

        mobileSlider.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
        });

        mobileSlider.addEventListener('touchmove', function(e) {
            currentX = e.touches[0].clientX;
        });

        mobileSlider.addEventListener('touchend', function() {
            const diff = startX - currentX;
            const threshold = 50;

            if (Math.abs(diff) > threshold) {
                if (diff > 0 && mobileCurrentIndex < mobileMaxIndex) {
                    // Swipe left - next
                    mobileCurrentIndex++;
                } else if (diff < 0 && mobileCurrentIndex > 0) {
                    // Swipe right - prev
                    mobileCurrentIndex--;
                }
                updateMobileSlider();
            }
        });

        // Initialize mobile slider
        updateMobileSlider();

        // Auto-slider for mobile (slow)
        let mobileAutoInterval = setInterval(() => {
            if (mobileCurrentIndex >= mobileMaxIndex) {
                mobileCurrentIndex = 0;
            } else {
                mobileCurrentIndex++;
            }
            updateMobileSlider();
        }, 5000); // 5 seconds per slide

        // Pause auto-slider on hover
        mobileSlider.addEventListener('mouseenter', () => clearInterval(mobileAutoInterval));
        mobileSlider.addEventListener('mouseleave', () => {
            mobileAutoInterval = setInterval(() => {
                if (mobileCurrentIndex >= mobileMaxIndex) {
                    mobileCurrentIndex = 0;
                } else {
                    mobileCurrentIndex++;
                }
                updateMobileSlider();
            }, 5000);
        });
    }
});
</script>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Flat design - minimal hover effects */
#all-products .group:hover h3 a {
    color: #f97316;
}

/* Smooth transitions for text only */
#all-products h3 a {
    transition: color 0.2s ease;
}

/* Desktop Slider Styles */
.desktop-slider {
    -webkit-overflow-scrolling: touch;
}

#desktop-products-slider {
    transition: transform 0.3s ease;
    width: 100%;
}

.desktop-nav {
    transition: all 0.2s ease;
    cursor: pointer;
}

.desktop-nav:hover:not(:disabled) {
    background-color: #ea580c;
}

.desktop-nav:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

/* Mobile Slider Styles */
.mobile-slider {
    -webkit-overflow-scrolling: touch;
}

#mobile-products-slider {
    transition: transform 0.3s ease;
    width: 100%;
}

.mobile-nav {
    transition: all 0.2s ease;
    cursor: pointer;
}

.mobile-nav:hover:not(:disabled) {
    background-color: #ea580c;
}

.mobile-nav:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

/* Color scheme - Orange and White */
.text-orange-500 {
    color: #f97316;
}

.bg-orange-500 {
    background-color: #f97316;
}

.hover\:bg-orange-600:hover {
    background-color: #ea580c;
}

/* Typography improvements */
#all-products h3 a {
    text-decoration: none;
    color: inherit;
}

/* Responsive text sizes */
@media (max-width: 640px) {
    #all-products h2 {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }

    #all-products h3 {
        font-size: 0.875rem;
        line-height: 1.25rem;
    }
}

@media (min-width: 641px) {
    #all-products h3 {
        font-size: 1rem;
        line-height: 1.5rem;
    }
}
</style>
