<?php
/**
 * Featured Products Section Template
 * 
 * Layout inspiration from Cocoon Vietnam
 * Left side: Title and description
 * Right side: Horizontal product slider
 */

// Get featured products settings
$front_page_id = get_option('page_on_front');
$show_featured = get_post_meta($front_page_id, 'arata_featured_show', true);
$featured_title = get_post_meta($front_page_id, 'arata_featured_title', true);
$featured_desc = get_post_meta($front_page_id, 'arata_featured_description', true);

// Only show if featured products is enabled
if ($show_featured !== '0') :
    // Default values
    $featured_title = $featured_title ?: __('Sản Phẩm <span class="font-semibold">Nổi Bật</span>', 'aratavietnam');
    $featured_desc = $featured_desc ?: __('Arata Vietnam tự hào mang đến những sản phẩm chất lượng cao, được nghiên cứu và phát triển dành riêng cho người Việt.', 'aratavietnam');
    
    // Get featured products using WC function
    $featured_products = wc_get_products(array(
        'limit' => 8,
        'orderby' => 'date',
        'order' => 'DESC',
        'featured' => true,
        'status' => 'publish',
    ));
    
    // Fallback to latest products if no featured products
    if (empty($featured_products)) {
        $featured_products = wc_get_products(array(
            'limit' => 8,
            'orderby' => 'date',
            'order' => 'DESC',
            'status' => 'publish',
        ));
    }
    
    // Convert to WP_Query for compatibility with template
    $product_ids = array_map(function($product) {
        return $product->get_id();
    }, $featured_products);
    
    $featured_query = new WP_Query(array(
        'post_type' => 'product',
        'post__in' => $product_ids,
        'orderby' => 'post__in',
        'posts_per_page' => 8,
    ));
    
    // Debug: Check if products found
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Featured products found: ' . $featured_query->found_posts);
    }
    
    if ($featured_query->have_posts()) :
?>
<!-- Featured Products Section -->
<section class="featured-products-section py-12 lg:py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row lg:items-end gap-8">
            <!-- Left Content -->
            <div class="lg:w-2/5 lg:pr-12">
                <div class="text-center lg:text-left">
                    <h2 class="text-4xl lg:text-5xl font-vollkorn text-gray-900 mb-6">
                        <?php echo $featured_title; ?>
                    </h2>
                    <p class="text-gray-600 text-lg lg:text-xl leading-relaxed">
                        <?php echo $featured_desc; ?>
                    </p>
                </div>
            </div>
            
            <!-- Right Content - Product Slider -->
            <div class="lg:w-3/5">
                <div class="featured-products-slider relative">
                    <div class="overflow-hidden px-4">
                        <div class="flex transition-transform duration-500 ease-out" id="featuredSlider">
                            <?php
                            while ($featured_query->have_posts()) :
                                $featured_query->the_post();
                                global $product;
                                
                                $product_id = $product->get_id();
                                
                                // Get product image with proper URL
                                $image_id = $product->get_image_id();
                                if ($image_id) {
                                    $image_src = wp_get_attachment_image_src($image_id, 'full');
                                    $image = $image_src ? $image_src[0] : wc_placeholder_img_src('full');
                                } else {
                                    $image = wc_placeholder_img_src('full');
                                }
                                
                                $hover_image = get_post_meta($product_id, '_hover_image', true);
                                $hover_image_url = $hover_image ? wp_get_attachment_image_url($hover_image, 'full') : $image;
                                
                                // Get product attributes
                                $categories = wc_get_product_category_list($product_id, ', ');
                                $price = $product->get_price_html();
                                $sale_price = $product->get_sale_price();
                                $regular_price = $product->get_regular_price();
                                $stock_quantity = $product->get_stock_quantity();
                            ?>
                            <div class="product-slide w-full sm:w-1/2 md:w-1/2 lg:w-2/5 flex-shrink-0 px-3">
                                <div class="product-card group">
                                    <!-- Product Image -->
                                    <div class="relative overflow-hidden rounded-lg mb-4 aspect-[3/4] bg-white">
                                        <div class="absolute inset-0 transition-opacity duration-300">
                                            <img src="<?php echo esc_url($image[0]); ?>" 
                                                 alt="<?php echo esc_attr(get_the_title()); ?>"
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <img src="<?php echo esc_url($hover_image_url); ?>" 
                                                 alt="<?php echo esc_attr(get_the_title()); ?>"
                                                 class="w-full h-full object-cover">
                                        </div>
                                        
                                        <!-- Stock Badge -->
                                        <?php if ($stock_quantity && $stock_quantity > 0 && $stock_quantity < 20) : ?>
                                        <div class="absolute top-3 left-3 bg-orange-500 text-white text-xs px-2 py-1 rounded">
                                            Chỉ còn<br><?php echo $stock_quantity; ?> sản phẩm
                                        </div>
                                        <?php endif; ?>
                                        
                                        <!-- Quick Add Button -->
                                        <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <button class="add-to-cart-btn w-10 h-10 bg-orange-500 hover:bg-orange-600 text-white rounded-full flex items-center justify-center shadow-lg transform hover:scale-110 transition-all duration-200"
                                                    data-product-id="<?php echo $product_id; ?>">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Product Info -->
                                    <div class="space-y-2">
                                        <h3 class="font-vollkorn text-lg text-gray-900">
                                            <a href="<?php the_permalink(); ?>" class="hover:text-orange-500 transition-colors">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                        
                                        <?php if ($categories) : ?>
                                        <p class="text-sm text-orange-500 font-medium">
                                            <?php echo $categories; ?>
                                        </p>
                                        <?php endif; ?>
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="price">
                                                <?php if ($sale_price) : ?>
                                                <span class="text-lg font-semibold text-orange-500">
                                                    <?php echo wc_price($sale_price); ?>
                                                </span>
                                                <span class="text-sm text-gray-400 line-through ml-2">
                                                    <?php echo wc_price($regular_price); ?>
                                                </span>
                                                <?php else : ?>
                                                <span class="text-lg font-semibold text-gray-900">
                                                    <?php echo $price; ?>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Add to Cart Icon -->
                                            <button class="add-to-cart-icon text-gray-400 hover:text-orange-500 transition-colors"
                                                    data-product-id="<?php echo $product_id; ?>">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                    
                    <!-- Navigation Buttons -->
                    <button id="featuredPrev" class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 z-10 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 hover:text-orange-500 hover:shadow-xl transition-all duration-300 hidden lg:flex">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button id="featuredNext" class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 z-10 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 hover:text-orange-500 hover:shadow-xl transition-all duration-300 hidden lg:flex">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    
                    <!-- Pagination -->
                    <div id="featuredPagination" class="flex justify-center mt-6 space-x-2"></div>
                    
                    <?php else : ?>
                    <!-- No Products Found -->
                    <div class="text-center py-12">
                        <p class="text-gray-500">Chưa có sản phẩm nào được thiết lập.</p>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.featured-products-section {
    font-family: 'Inter', sans-serif;
}

.product-card {
    transition: transform 0.3s ease;
}

.product-card:hover {
    transform: translateY(-4px);
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@media (max-width: 1023px) {
    .featured-products-slider .slider-nav {
        display: none;
    }
}
</style>

<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.getElementById('featuredSlider');
        const prevBtn = document.getElementById('featuredPrev');
        const nextBtn = document.getElementById('featuredNext');
        const pagination = document.getElementById('featuredPagination');
        
        if (!slider) return;
        
        const slides = slider.children;
        const totalSlides = slides.length;
        
        // Calculate slides per view based on screen size
        function getSlidesPerView() {
            if (window.innerWidth >= 1024) return 2.5;  // lg - show 2.5 products
            if (window.innerWidth >= 768) return 2;   // md
            if (window.innerWidth >= 640) return 2;   // sm
            return 1; // mobile
        }
        
        let slidesPerView = getSlidesPerView();
        let currentIndex = 0;
        let slideWidth = 100 / slidesPerView;
        
        // Update slider width
        function updateSliderWidth() {
            slideWidth = 100 / slidesPerView;
            slider.style.width = `${totalSlides * slideWidth}%`;
            
            for (let slide of slides) {
                slide.style.width = `${100 / totalSlides}%`;
            }
        }
        
        // Create pagination dots
        function createPagination() {
            pagination.innerHTML = '';
            const totalPages = Math.ceil(totalSlides / slidesPerView);
            
            for (let i = 0; i < totalPages; i++) {
                const dot = document.createElement('button');
                dot.className = 'w-2 h-2 rounded-full transition-all duration-300 ' + 
                               (i === 0 ? 'bg-orange-500' : 'bg-gray-300');
                dot.addEventListener('click', () => goToSlide(i * slidesPerView));
                pagination.appendChild(dot);
            }
        }
        
        // Update pagination
        function updatePagination() {
            const dots = pagination.children;
            const currentPage = Math.floor(currentIndex / slidesPerView);
            
            for (let i = 0; i < dots.length; i++) {
                if (i === currentPage) {
                    dots[i].className = 'w-8 h-2 rounded-full bg-orange-500 transition-all duration-300';
                } else {
                    dots[i].className = 'w-2 h-2 rounded-full bg-gray-300 transition-all duration-300';
                }
            }
        }
        
        // Go to specific slide
        function goToSlide(index) {
            const maxIndex = Math.max(0, totalSlides - slidesPerView);
            currentIndex = Math.max(0, Math.min(index, maxIndex));
            
            slider.style.transform = `translateX(-${currentIndex * slideWidth}%)`;
            updatePagination();
        }
        
        // Next slide
        function nextSlide() {
            // If we're at the end, loop back to start
            if (currentIndex + slidesPerView >= totalSlides) {
                goToSlide(0);
            } else {
                goToSlide(currentIndex + slidesPerView);
            }
        }
        
        // Previous slide
        function prevSlide() {
            // If we're at the start, loop to end
            if (currentIndex - slidesPerView < 0) {
                const maxIndex = Math.max(0, totalSlides - slidesPerView);
                goToSlide(maxIndex);
            } else {
                goToSlide(currentIndex - slidesPerView);
            }
        }
        
        // Event listeners
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        
        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                const newSlidesPerView = getSlidesPerView();
                if (newSlidesPerView !== slidesPerView) {
                    slidesPerView = newSlidesPerView;
                    updateSliderWidth();
                    createPagination();
                    goToSlide(0);
                }
            }, 250);
        });
        
        // Touch support
        let touchStartX = 0;
        let touchEndX = 0;
        
        slider.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        
        slider.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });
        
        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        }
        
        // Initialize
        updateSliderWidth();
        createPagination();
        
        // Auto-play
        let autoplayInterval = setInterval(nextSlide, 5000);
        
        // Pause on hover
        const sliderContainer = slider.closest('.featured-products-slider');
        sliderContainer.addEventListener('mouseenter', () => {
            clearInterval(autoplayInterval);
        });
        sliderContainer.addEventListener('mouseleave', () => {
            autoplayInterval = setInterval(nextSlide, 5000);
        });
    });
})();
</script>
<?php
endif;
?>