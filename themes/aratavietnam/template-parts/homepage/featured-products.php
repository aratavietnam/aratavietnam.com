<?php
/**
 * Homepage Featured Products Section
 */
?>

<!-- Featured Products Section -->
<section id="featured-products" class="py-20 bg-blue-600">
    <div class="container mx-auto px-4 text-center">
        <!-- Section Header -->
        <div class="mb-16">
            <!-- Single title -->
            <h2 class="text-3xl sm:text-4xl font-bold text-white leading-tight mb-4">
                SẢN PHẨM NỔI BẬT
            </h2>

            <!-- Compact description -->
            <p class="text-base sm:text-lg text-blue-100 leading-relaxed max-w-2xl mx-auto">
                Khám phá những sản phẩm hóa mỹ phẩm chất lượng cao được nhập khẩu trực tiếp từ Nhật Bản
            </p>
        </div>

        <!-- Products Grid (4 columns x 2 rows = 8 products) -->
        <div class="products-container">
            <?php
            // Get featured products (8 products for 4x2 grid)
            $featured_products = wc_get_products([
                'limit' => 8,
                'status' => 'publish',
                'featured' => true,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ]);

            if (empty($featured_products)) {
                // Fallback to latest products if no featured products
                $featured_products = wc_get_products([
                    'limit' => 8,
                    'status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ]);
            }

            if ($featured_products) :
            ?>
                <!-- Desktop Grid -->
                <div class="hidden md:grid md:grid-cols-4 gap-6 max-w-6xl mx-auto">
                    <?php foreach ($featured_products as $product) :
                        $product_id = $product->get_id();
                        $product_name = $product->get_name();
                        $product_price = $product->get_price();
                        $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'medium');
                        $product_link = get_permalink($product_id);
                        ?>
                        <div class="group">
                            <!-- Product Image - No shadow, flat design -->
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

                            <!-- Product Info - Outside image box, flat design -->
                            <div class="text-center min-h-[4rem] flex flex-col justify-center">
                                <!-- Product Name -->
                                <h3 class="font-semibold text-white mb-2 line-clamp-1 text-base leading-relaxed group-hover:text-orange-500 transition-colors">
                                    <a href="<?php echo esc_url($product_link); ?>">
                                        <?php echo esc_html($product_name); ?>
                                    </a>
                                </h3>

                                <!-- Product Price -->
                                <div class="text-base font-semibold text-white">
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

                <!-- Mobile Slider -->
                <div class="md:hidden">
                    <div class="products-slider overflow-hidden">
                        <div class="flex gap-4 pb-4" id="products-slider">
                            <?php foreach ($featured_products as $product) :
                                $product_id = $product->get_id();
                                $product_name = $product->get_name();
                                $product_price = $product->get_price();
                                $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'medium');
                                $product_link = get_permalink($product_id);
                                ?>
                                <div class="group flex-shrink-0 w-[calc(50%-0.5rem)]">
                                    <!-- Product Image - No shadow, flat design -->
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

                                    <!-- Product Info - Outside image box, flat design -->
                                    <div class="text-center min-h-[4rem] flex flex-col justify-center">
                                        <!-- Product Name -->
                                        <h3 class="font-semibold text-white mb-2 line-clamp-1 text-sm leading-relaxed group-hover:text-orange-500 transition-colors">
                                            <a href="<?php echo esc_url($product_link); ?>">
                                                <?php echo esc_html($product_name); ?>
                                            </a>
                                        </h3>

                                        <!-- Product Price -->
                                        <div class="text-sm font-semibold text-white">
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

                    <!-- Slider Navigation -->
                    <div class="flex justify-center mt-4 space-x-2">
                        <button class="slider-nav bg-white/20 text-white px-3 py-1 rounded-full text-sm" data-direction="prev">
                            ←
                        </button>
                        <button class="slider-nav bg-white/20 text-white px-3 py-1 rounded-full text-sm" data-direction="next">
                            →
                        </button>
                    </div>
                </div>
            <?php else : ?>
                <!-- No Products Found -->
                <div class="text-center py-16">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span data-icon="package" data-size="32" class="text-blue-400"></span>
                    </div>
                    <h3 class="text-lg font-medium text-white mb-2">Chưa có sản phẩm nào</h3>
                    <p class="text-blue-100">Vui lòng thêm sản phẩm trong admin panel.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
// Mobile Products Slider
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('products-slider');
    const navButtons = document.querySelectorAll('.slider-nav');

    if (slider && navButtons.length > 0) {
        let currentIndex = 0;
        const totalProducts = slider.children.length;
        const productsPerView = 2; // 2 products per view on mobile
        const maxIndex = Math.max(0, totalProducts - productsPerView);

        function updateSlider() {
            const translateX = -currentIndex * (100 / productsPerView);
            slider.style.transform = `translateX(${translateX}%)`;

            // Update navigation buttons
            navButtons.forEach(btn => {
                if (btn.dataset.direction === 'prev') {
                    btn.style.opacity = currentIndex === 0 ? '0.5' : '1';
                    btn.disabled = currentIndex === 0;
                } else if (btn.dataset.direction === 'next') {
                    btn.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';
                    btn.disabled = currentIndex >= maxIndex;
                }
            });
        }

        // Navigation button clicks
        navButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.dataset.direction === 'prev' && currentIndex > 0) {
                    currentIndex--;
                } else if (this.dataset.direction === 'next' && currentIndex < maxIndex) {
                    currentIndex++;
                }
                updateSlider();
            });
        });

        // Touch/swipe support
        let startX = 0;
        let currentX = 0;

        slider.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
        });

        slider.addEventListener('touchmove', function(e) {
            currentX = e.touches[0].clientX;
        });

        slider.addEventListener('touchend', function() {
            const diff = startX - currentX;
            const threshold = 50;

            if (Math.abs(diff) > threshold) {
                if (diff > 0 && currentIndex < maxIndex) {
                    // Swipe left - next
                    currentIndex++;
                } else if (diff < 0 && currentIndex > 0) {
                    // Swipe right - prev
                    currentIndex--;
                }
                updateSlider();
            }
        });

        // Initialize slider
        updateSlider();
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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Flat design - minimal hover effects */
#featured-products .group:hover h3 a {
    color: #f97316;
}

/* Smooth transitions for text only */
#featured-products h3 a {
    transition: color 0.2s ease;
}

/* Mobile Slider Styles */
.products-slider {
    -webkit-overflow-scrolling: touch;
}

#products-slider {
    transition: transform 0.3s ease;
    width: 100%;
}

.slider-nav {
    transition: all 0.2s ease;
    cursor: pointer;
}

.slider-nav:hover:not(:disabled) {
    background-color: rgba(255, 255, 255, 0.3);
}

.slider-nav:disabled {
    cursor: not-allowed;
}

/* Featured products responsive grid improvements */
@media (max-width: 640px) {
    #featured-products .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

@media (min-width: 641px) and (max-width: 768px) {
    #featured-products .grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
}

@media (min-width: 769px) {
    #featured-products .grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }
}

/* Color scheme - Orange and Blue */
.text-orange-500 {
    color: #f97316;
}

.bg-orange-500 {
    background-color: #f97316;
}

.hover\:bg-orange-600:hover {
    background-color: #ea580c;
}

.bg-blue-600 {
    background-color: #2563eb;
}

.text-blue-100 {
    color: #dbeafe;
}

.bg-blue-100 {
    background-color: #dbeafe;
}

.text-blue-400 {
    color: #60a5fa;
}

/* Typography improvements */
#featured-products h3 a {
    text-decoration: none;
    color: inherit;
}

/* Responsive text sizes */
@media (max-width: 640px) {
    #featured-products h2 {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }

    #featured-products h3 {
        font-size: 0.875rem;
        line-height: 1.25rem;
    }
}

@media (min-width: 641px) {
    #featured-products h3 {
        font-size: 1rem;
        line-height: 1.5rem;
    }
}
</style>
