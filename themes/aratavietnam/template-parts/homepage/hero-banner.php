<?php
/**
 * Homepage Hero Banner Section - Clean Version
 */

// Get hero settings
$front_page_id = get_option('page_on_front');
$show_hero = get_post_meta($front_page_id, 'arata_hero_show', true);
$hero_slides = get_post_meta($front_page_id, 'arata_hero_slides', true);

// Only show if hero is enabled
if ($show_hero !== '0') :
?>
<!-- Hero Banner Section -->
<section class="relative overflow-hidden hero-banner" style="height: 600px;">
    <!-- Background Slider -->
    <div class="hero-slider absolute inset-0">
        <?php
        if (!empty($hero_slides)) {
            foreach ($hero_slides as $index => $slide) {
                $slide_type = isset($slide['slide_type']) ? $slide['slide_type'] : 'image';
                $slide_image_id = isset($slide['slide_image_id']) ? $slide['slide_image_id'] : '';
                $slide_mobile_image_id = isset($slide['slide_mobile_image_id']) ? $slide['slide_mobile_image_id'] : '';
                $slide_video = isset($slide['slide_video']) ? $slide['slide_video'] : '';
                $slide_mobile_video = isset($slide['slide_mobile_video']) ? $slide['slide_mobile_video'] : '';
                $default_slide_ids = [277, 278, 279];
                $default_mobile_slide_ids = [280, 281, 282];
                $slide_image = $slide_image_id ? wp_get_attachment_image_url($slide_image_id, 'full') : wp_get_attachment_image_url($default_slide_ids[$index % 3], 'full');
                $slide_mobile_image = $slide_mobile_image_id ? wp_get_attachment_image_url($slide_mobile_image_id, 'full') : wp_get_attachment_image_url($default_mobile_slide_ids[$index % 3], 'full');
                $active_class = ($index === 0) ? 'active' : '';
                ?>
                <div class="slide <?php echo $active_class; ?> absolute inset-0" data-slide="<?php echo $index + 1; ?>">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-black/10"></div>
                    <?php if ($slide_type === 'video' && !empty($slide_video)) : ?>
                        <!-- Desktop Video -->
                        <video class="hidden md:block w-full h-full object-cover" autoplay loop muted playsinline>
                            <source src="<?php echo esc_url($slide_video); ?>" type="video/mp4">
                        </video>
                        <!-- Mobile Video -->
                        <?php if (!empty($slide_mobile_video)) : ?>
                            <video class="md:hidden w-full h-full object-cover" autoplay loop muted playsinline>
                                <source src="<?php echo esc_url($slide_mobile_video); ?>" type="video/mp4">
                            </video>
                        <?php else : ?>
                            <video class="md:hidden w-full h-full object-cover" autoplay loop muted playsinline>
                                <source src="<?php echo esc_url($slide_video); ?>" type="video/mp4">
                            </video>
                        <?php endif; ?>
                    <?php else : ?>
                        <!-- Desktop Image -->
                        <img src="<?php echo esc_url($slide_image); ?>"
                             alt="Arata Vietnam Slide <?php echo $index + 1; ?>"
                             class="hidden md:block w-full h-full object-cover"
                             loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"
                             fetchpriority="<?php echo $index === 0 ? 'high' : 'auto'; ?>" />
                        <!-- Mobile Image -->
                        <img src="<?php echo esc_url($slide_mobile_image); ?>"
                             alt="Arata Vietnam Slide Mobile <?php echo $index + 1; ?>"
                             class="md:hidden w-full h-full object-cover"
                             loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"
                             fetchpriority="<?php echo $index === 0 ? 'high' : 'auto'; ?>" />
                    <?php endif; ?>
                </div>
                <?php
            }
        } else {
            // Default slides if none configured
            $default_slide_ids = [277, 278, 279];
            $default_mobile_slide_ids = [280, 281, 282];
            for ($i = 0; $i < 3; $i++) {
                $active_class = ($i === 0) ? 'active' : '';
                ?>
                <div class="slide <?php echo $active_class; ?> absolute inset-0" data-slide="<?php echo $i + 1; ?>">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-black/10"></div>
                    <!-- Desktop Image -->
                    <img src="<?php echo esc_url(wp_get_attachment_image_url($default_slide_ids[$i], 'full')); ?>"
                         alt="Arata Vietnam Slide <?php echo $i + 1; ?>"
                         class="hidden md:block w-full h-full object-cover"
                         loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>"
                         fetchpriority="<?php echo $i === 0 ? 'high' : 'auto'; ?>" />
                    <!-- Mobile Image -->
                    <img src="<?php echo esc_url(wp_get_attachment_image_url($default_mobile_slide_ids[$i], 'full')); ?>"
                         alt="Arata Vietnam Slide Mobile <?php echo $i + 1; ?>"
                         class="md:hidden w-full h-full object-cover"
                         loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>"
                         fetchpriority="<?php echo $i === 0 ? 'high' : 'auto'; ?>" />
                </div>
                <?php
            }
        }
        ?>
    </div>

    <!-- Slider Controls -->
    <button class="slider-control absolute left-4 top-1/2 transform -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-white/30 transition-all duration-300 hover:scale-105" id="prevSlide">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
    </button>
    <button class="slider-control absolute right-4 top-1/2 transform -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-white/30 transition-all duration-300 hover:scale-105" id="nextSlide">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
    </button>
</section>

<style>
.hero-banner {
    position: relative;
    overflow: hidden;
}
.hero-slider {
    position: relative;
    width: 100%;
    height: 100%;
}
.hero-slider .slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transform: translateX(100%);
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1;
}
.hero-slider .slide.active {
    opacity: 1;
    transform: translateX(0);
    z-index: 2;
}
.hero-slider .slide.prev {
    transform: translateX(-100%);
    z-index: 1;
}
.slider-control {
    cursor: pointer;
    z-index: 10;
}
@media (max-width: 768px) {
    .hero-banner {
        height: 500px !important;
    }
    .slider-control {
        width: 36px;
        height: 36px;
        display: flex !important;
        align-items: center;
        justify-content: center;
    }
    .slider-control svg {
        width: 20px;
        height: 20px;
    }
}
</style>

<script>
(function() {
    // Simple sliding hero slider
    document.addEventListener('DOMContentLoaded', function() {
        const heroContainer = document.querySelector('.hero-banner');
        if (!heroContainer) return;
        
        const slides = heroContainer.querySelectorAll('.slide');
        const prevBtn = document.getElementById('prevSlide');
        const nextBtn = document.getElementById('nextSlide');
        
        if (slides.length === 0) return;
        
        let currentSlide = 0;
        let slideInterval;
        
        function showSlide(index) {
            // Remove active class from all slides
            slides.forEach(slide => {
                slide.classList.remove('active');
            });
            
            // Add active class to current slide
            slides[index].classList.add('active');
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
        
        function startAutoSlide() {
            stopAutoSlide();
            if (slides.length > 1) {
                slideInterval = setInterval(nextSlide, 5000);
            }
        }
        
        function stopAutoSlide() {
            if (slideInterval) {
                clearInterval(slideInterval);
            }
        }
        
        // Event listeners
        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                stopAutoSlide();
                nextSlide();
                startAutoSlide();
            });
        }
        
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                stopAutoSlide();
                prevSlide();
                startAutoSlide();
            });
        }
        
        // Pause on hover
        heroContainer.addEventListener('mouseenter', stopAutoSlide);
        heroContainer.addEventListener('mouseleave', startAutoSlide);
        
        // Touch support
        let touchStartX = 0;
        let touchEndX = 0;
        
        heroContainer.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        
        heroContainer.addEventListener('touchend', function(e) {
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
                startAutoSlide();
            }
        }
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                stopAutoSlide();
                prevSlide();
                startAutoSlide();
            } else if (e.key === 'ArrowRight') {
                stopAutoSlide();
                nextSlide();
                startAutoSlide();
            }
        });
        
        // Start auto-slide
        startAutoSlide();
    });
})();
</script>
<?php endif; ?>