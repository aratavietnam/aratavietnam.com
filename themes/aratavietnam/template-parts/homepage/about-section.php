<?php
/**
 * Homepage About Arata Section
 */

// Get global colors
$primary_color = get_theme_mod('arata_primary_color', '#0066A6');
$secondary_color = get_theme_mod('arata_secondary_color', '#F55E25');
?>

<!-- About Arata Section -->
<section class="py-16 scroll-animate" style="background-color: <?php echo esc_attr($primary_color); ?>10;">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <!-- Left Side: Image Slider -->
            <div class="relative about-slider-wrapper">
                <div class="about-slider-container overflow-hidden">
                    <div class="about-slider-track flex" id="about-gallery">
                    <?php
                    $front_page_id = get_option('page_on_front');
                    for ($i = 1; $i <= 5; $i++) {
                        $image_id = get_post_meta($front_page_id, '_about_image_' . $i, true);
                        $image_data = $image_id ? wp_get_attachment_image_src($image_id, 'full') : null;
                        $image_url = $image_data ? $image_data[0] : '';
                        $image_width = $image_data ? $image_data[1] : 0;
                        $image_height = $image_data ? $image_data[2] : 0;
                        ?>
                        <div class="about-slide">
                            <div class="about-slide-content">
                                <?php if ($image_url) : ?>
                                    <a href="<?php echo esc_url($image_url); ?>"
                                       data-pswp-width="<?php echo esc_attr($image_width); ?>"
                                       data-pswp-height="<?php echo esc_attr($image_height); ?>"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="about-gallery-item">
                                        <img src="<?php echo esc_url($image_url); ?>" alt="Về Arata <?php echo $i; ?>">
                                    </a>
                                <?php else : ?>
                                    <div class="w-full h-full bg-gray-200"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
                <!-- Slider Navigation -->
                <button class="about-slider-nav absolute top-1/2 left-0 transform -translate-y-1/2 -translate-x-4 z-10 bg-white/80 backdrop-blur-sm shadow-lg text-gray-700 w-12 h-12 rounded-full text-lg font-medium hover:bg-white transition-colors" data-direction="prev">
                    ←
                </button>
                <button class="about-slider-nav absolute top-1/2 right-0 transform -translate-y-1/2 translate-x-4 z-10 bg-white/80 backdrop-blur-sm shadow-lg text-gray-700 w-12 h-12 rounded-full text-lg font-medium hover:bg-white transition-colors" data-direction="next">
                    →
                </button>
            </div>

            <!-- Right Side: Content -->
            <div class="space-y-6">
                <!-- Section Header -->
                <div>

                    <?php
                    // Get custom content for the section header
                    $front_page_id = get_option('page_on_front');
                    $title_part1 = get_post_meta($front_page_id, '_about_title_part1', true);
                    $title_part2 = get_post_meta($front_page_id, '_about_title_part2', true);

                    // Fallback to default text if not set
                    if (empty($title_part1)) {
                        $title_part1 = 'Về';
                    }
                    if (empty($title_part2)) {
                        $title_part2 = 'Arata';
                    }
                    ?>
                    <h2 class="text-4xl font-bold mb-6">
                        <span class="text-gray-700"><?php echo esc_html($title_part1); ?></span>
                        <span style="color: <?php echo esc_attr($primary_color); ?>;"><?php echo esc_html($title_part2); ?></span>
                    </h2>
                </div>

                <!-- Company Description -->
                <div class="prose prose-lg max-w-none prose-invert">
                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        <strong class="text-gray-800">Arata Việt Nam</strong> là công ty con của Tập đoàn Arata Nhật Bản,
                        được thành lập với sứ mệnh mang đến những sản phẩm hóa mỹ phẩm chất lượng cao từ Nhật Bản
                        cho thị trường Việt Nam.
                    </p>

                </div>

                <!-- CTA Button -->
                <div class="pt-4">
                    <a href="<?php echo home_url('/ve-arata-vietnam'); ?>"
                       class="inline-flex items-center px-6 py-3 border font-semibold rounded-lg transition-all duration-300 hover:bg-blue-500 hover:text-white" style="border-color: <?php echo esc_attr($primary_color); ?>; color: <?php echo esc_attr($primary_color); ?>;">
                        Tìm hiểu thêm
                        <span data-icon="arrow-right" data-size="16" class="ml-2"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const aboutSlider = document.querySelector('#about-gallery');
    const navButtons = document.querySelectorAll('.about-slider-nav');
    
    if (!aboutSlider || navButtons.length !== 2) return;
    
    const slides = aboutSlider.querySelectorAll('.about-slide');
    const slideWidth = slides[0]?.offsetWidth + 16; // width + gap
    let currentIndex = 0;
    let autoSlideInterval;
    
    function updateSlider() {
        const maxIndex = Math.max(0, slides.length - 2); // Show 2 slides at a time
        currentIndex = Math.max(0, Math.min(currentIndex, maxIndex));
        aboutSlider.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
        
        // Update button states
        navButtons.forEach(btn => {
            const direction = btn.dataset.direction;
            if (direction === 'prev') {
                btn.disabled = currentIndex === 0;
            } else {
                btn.disabled = currentIndex >= maxIndex;
            }
        });
    }
    
    function nextSlide() {
        currentIndex++;
        updateSlider();
    }
    
    function prevSlide() {
        currentIndex--;
        updateSlider();
    }
    
    function startAutoSlide() {
        autoSlideInterval = setInterval(nextSlide, 3000);
    }
    
    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }
    
    // Navigation button events
    navButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const direction = btn.dataset.direction;
            if (direction === 'next') {
                nextSlide();
            } else {
                prevSlide();
            }
            stopAutoSlide();
            startAutoSlide();
        });
    });
    
    // Initialize
    updateSlider();
    startAutoSlide();
    
    // Pause on hover
    const sliderWrapper = document.querySelector('.about-slider-wrapper');
    sliderWrapper.addEventListener('mouseenter', stopAutoSlide);
    sliderWrapper.addEventListener('mouseleave', startAutoSlide);
    
    // Handle window resize
    window.addEventListener('resize', () => {
        const newSlideWidth = slides[0]?.offsetWidth + 16;
        if (newSlideWidth !== slideWidth) {
            updateSlider();
        }
    });
});
</script>

<style>
.about-slider-track {
    display: flex;
    gap: 1rem; /* Creates space between slides */
    transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.about-slide {
    flex: 0 0 calc(40% - 0.6rem); /* 40% width minus some gap compensation */
    min-width: 0;
}
.about-slide-content {
    aspect-ratio: 3 / 4; /* Enforces a 3:4 aspect ratio */
    width: 100%;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.about-slide-content img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures image covers the area, cropping if necessary */
}
.about-slider-nav {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}
.about-slider-wrapper:hover .about-slider-nav {
    opacity: 1;
}
.about-slider-nav:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}
</style>
