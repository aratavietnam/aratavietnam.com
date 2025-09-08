<?php
/**
 * Homepage About Arata Section
 */

// Get homepage settings
$front_page_id = get_option('page_on_front');
$show_about = get_post_meta($front_page_id, 'arata_about_show', true);
$about_title = get_post_meta($front_page_id, 'arata_about_title', true) ?: 'Về Arata Vietnam';
$about_description = get_post_meta($front_page_id, 'arata_about_description', true);
$about_image_id = get_post_meta($front_page_id, 'arata_about_image', true);

// Only hide if explicitly set to '0'
if ($show_about === '0') {
    return;
}

// Get global colors
$primary_color = get_theme_mod('arata_primary_color', '#0066A6');
$secondary_color = get_theme_mod('arata_secondary_color', '#F55E25');
$background_color = get_theme_mod('theme_background_color', '#ffffff');
?>

<!-- About Arata Section -->
<section class="py-16 scroll-animate" style="background-color: <?php echo esc_attr($background_color); ?>;">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <!-- Left Side: Image Slider -->
            <div class="relative">
                <?php 
                // Get all images first
                $image_data = wp_get_attachment_image_src($about_image_id, 'full');
                $image_url = $image_data ? $image_data[0] : '';
                $image_width = $image_data ? $image_data[1] : 0;
                $image_height = $image_data ? $image_data[2] : 0;
                
                // Get images from admin or use defaults
                $about_images = get_post_meta($front_page_id, '_about_images', true);
                $all_about_images = array();
                
                // Default placeholder images
                $default_images = array(
                    'https://picsum.photos/seed/arata-about-1/800/600.jpg',
                    'https://picsum.photos/seed/arata-about-2/800/600.jpg',
                    'https://picsum.photos/seed/arata-about-3/800/600.jpg'
                );
                
                // If admin configured additional images
                if (!empty($about_images) && is_array($about_images)) {
                    foreach ($about_images as $img) {
                        if (isset($img['image_id'])) {
                            $img_data = wp_get_attachment_image_src($img['image_id'], 'full');
                            if ($img_data) {
                                $all_about_images[] = array(
                                    'image_id' => $img['image_id'],
                                    'url' => $img_data[0],
                                    'width' => $img_data[1],
                                    'height' => $img_data[2]
                                );
                            }
                        }
                    }
                }
                
                // Add main image if available
                if ($about_image_id) {
                    $main_img_data = wp_get_attachment_image_src($about_image_id, 'full');
                    if ($main_img_data) {
                        // Insert at beginning
                        array_unshift($all_about_images, array(
                            'image_id' => $about_image_id,
                            'url' => $main_img_data[0],
                            'width' => $main_img_data[1],
                            'height' => $main_img_data[2]
                        ));
                    }
                }
                
                // If no images configured, use defaults
                if (empty($all_about_images)) {
                    foreach ($default_images as $url) {
                        $all_about_images[] = array(
                            'image_id' => 0,
                            'url' => $url,
                            'width' => 800,
                            'height' => 600
                        );
                    }
                }
                
                // Always show slider if we have images
                if (!empty($all_about_images)) : 
                ?>
                    <!-- Image Slider -->
                    <div class="about-slider relative rounded-lg overflow-hidden shadow-lg">
                        <?php foreach ($all_about_images as $index => $img) : ?>
                            <div class="slide <?php echo $index === 0 ? 'active' : ''; ?> absolute inset-0">
                                <img src="<?php echo esc_url($img['url']); ?>" 
                                     alt="<?php echo esc_attr($about_title . ' - Image ' . ($index + 1)); ?>"
                                     class="w-full h-full object-cover">
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- Slider Controls -->
                        <button class="slider-control absolute left-2 top-1/2 transform -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-gray-600 hover:bg-white hover:text-orange-500 transition-all duration-300" id="aboutPrev">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button class="slider-control absolute right-2 top-1/2 transform -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-gray-600 hover:bg-white hover:text-orange-500 transition-all duration-300" id="aboutNext">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        
                        <!-- Slider Indicators -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2" id="aboutDots">
                            <?php foreach ($all_about_images as $index => $img) : ?>
                                <button class="w-2 h-2 rounded-full transition-all duration-300 <?php echo $index === 0 ? 'bg-white w-8' : 'bg-white/50'; ?>" data-slide="<?php echo $index; ?>"></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <style>
                    .about-slider {
                        height: 400px;
                    }
                    .about-slider .slide {
                        opacity: 0;
                        transition: opacity 0.5s ease-in-out;
                    }
                    .about-slider .slide.active {
                        opacity: 1;
                    }
                    @media (max-width: 768px) {
                        .about-slider {
                            height: 300px;
                        }
                    }
                    </style>
                    
                    <script>
                    (function() {
                        document.addEventListener('DOMContentLoaded', function() {
                            const slider = document.querySelector('.about-slider');
                            if (!slider) return;
                            
                            const slides = slider.querySelectorAll('.slide');
                            const prevBtn = document.getElementById('aboutPrev');
                            const nextBtn = document.getElementById('aboutNext');
                            const dots = slider.querySelectorAll('#aboutDots button');
                            
                            if (slides.length <= 1) return;
                            
                            let currentSlide = 0;
                            let slideInterval;
                            
                            function showSlide(index) {
                                slides.forEach(slide => slide.classList.remove('active'));
                                dots.forEach(dot => {
                                    dot.classList.remove('bg-white', 'w-8');
                                    dot.classList.add('bg-white/50');
                                });
                                
                                slides[index].classList.add('active');
                                dots[index].classList.remove('bg-white/50');
                                dots[index].classList.add('bg-white', 'w-8');
                                
                                currentSlide = index;
                            }
                            
                            function nextSlide() {
                                const next = (currentSlide + 1) % slides.length;
                                showSlide(next);
                            }
                            
                            function prevSlide() {
                                const prev = (currentSlide - 1 + slides.length) % slides.length;
                                showSlide(prev);
                            }
                            
                            // Event listeners
                            if (nextBtn) nextBtn.addEventListener('click', nextSlide);
                            if (prevBtn) prevBtn.addEventListener('click', prevSlide);
                            
                            dots.forEach((dot, index) => {
                                dot.addEventListener('click', () => showSlide(index));
                            });
                            
                            // Auto-play
                            function startAutoSlide() {
                                slideInterval = setInterval(nextSlide, 4000);
                            }
                            
                            function stopAutoSlide() {
                                clearInterval(slideInterval);
                            }
                            
                            startAutoSlide();
                            
                            // Pause on hover
                            slider.addEventListener('mouseenter', stopAutoSlide);
                            slider.addEventListener('mouseleave', startAutoSlide);
                        });
                    })();
                    </script>
                <?php else : ?>
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span data-icon="image" data-size="64" class="text-gray-400"></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Side: Content -->
            <div class="space-y-6">
                <!-- Section Header -->
                <div>
                    <h2 class="text-4xl font-bold mb-6">
                        <span style="color: <?php echo esc_attr($secondary_color); ?>;"><?php echo esc_html($about_title); ?></span>
                    </h2>
                </div>

                <!-- Company Description -->
                <div class="prose prose-lg max-w-none">
                    <?php if ($about_description) : ?>
                        <p class="text-gray-600 text-lg leading-relaxed mb-6">
                            <?php echo esc_html($about_description); ?>
                        </p>
                    <?php else : ?>
                        <p class="text-gray-600 text-lg leading-relaxed mb-6">
                            <strong class="text-gray-800">Arata Việt Nam</strong> là công ty con của Tập đoàn Arata Nhật Bản,
                            được thành lập với sứ mệnh mang đến những sản phẩm hóa mỹ phẩm chất lượng cao từ Nhật Bản
                            cho thị trường Việt Nam.
                        </p>
                    <?php endif; ?>
                </div>

                <!-- CTA Button -->
                <div class="pt-4">
                    <a href="<?php echo home_url('/ve-arata-vietnam'); ?>"
                       class="inline-flex items-center px-6 py-3 border font-semibold rounded-lg transition-all duration-300 hover:bg-orange-500 hover:text-white" style="border-color: <?php echo esc_attr($secondary_color); ?>; color: <?php echo esc_attr($secondary_color); ?>;">
                        Tìm hiểu thêm
                        <span data-icon="arrow-right" data-size="16" class="ml-2"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
