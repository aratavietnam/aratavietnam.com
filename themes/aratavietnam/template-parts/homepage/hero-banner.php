<?php
/**
 * Homepage Hero Banner Section
 */
?>

<!-- Hero Banner Section -->
<section class="relative h-[600px] overflow-hidden hero-banner-container">
    <!-- Background Slider -->
    <div class="hero-slider absolute inset-0">
        <?php
        $front_page_id = get_option('page_on_front');
        for ($i = 1; $i <= 3; $i++) {
            $slide_type = get_post_meta($front_page_id, '_slide' . $i . '_type', true) ?: 'image';
            $slide_image_id = get_post_meta($front_page_id, '_slide' . $i . '_image', true);
            $slide_video = get_post_meta($front_page_id, '_slide' . $i . '_video', true);
            $default_slide_ids = [277, 278, 279];
            $slide_image = $slide_image_id ? wp_get_attachment_image_url($slide_image_id, 'full') : wp_get_attachment_image_url($default_slide_ids[$i - 1], 'full');
            $active_class = ($i === 1) ? 'active' : '';
            ?>
            <div class="slide <?php echo $active_class; ?> absolute inset-0" data-slide="<?php echo $i; ?>">
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-black/10"></div>
                <?php if ($slide_type === 'video' && !empty($slide_video)) : ?>
                    <video class="w-full h-full object-cover" autoplay loop muted playsinline>
                        <source src="<?php echo esc_url($slide_video); ?>" type="video/mp4">
                    </video>
                <?php else : ?>
                    <img src="<?php echo esc_url($slide_image); ?>"
                         alt="Arata Vietnam Slide <?php echo $i; ?>"
                         class="w-full h-full object-cover" />
                <?php endif; ?>
            </div>
            <?php
        }
        ?>
    </div>

    <!-- Slider Indicators -->
    <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-20 flex space-x-3">
        <?php for ($i = 1; $i <= 3; $i++) : ?>
            <button class="slider-indicator w-3 h-3 rounded-full bg-white/40 hover:bg-white/70 transition-all duration-300 <?php echo $i === 1 ? 'active' : ''; ?>" data-slide="<?php echo $i - 1; ?>"></button>
        <?php endfor; ?>
    </div>

    <!-- Slider Controls -->
    <button class="slider-control absolute left-4 top-1/2 transform -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-white/30 transition-all duration-300 hover:scale-105" id="prevSlide">
        <span data-icon="chevron-left" data-size="24"></span>
    </button>
    <button class="slider-control absolute right-4 top-1/2 transform -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-white/30 transition-all duration-300 hover:scale-105" id="nextSlide">
        <span data-icon="chevron-right" data-size="24"></span>
    </button>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    const indicators = document.querySelectorAll('.slider-indicator');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    let currentSlide = 0;
    let slideInterval;
    let isTransitioning = false;

    function showSlide(index, direction = 'next') {
        if (isTransitioning) return;
        isTransitioning = true;

        const currentSlideEl = slides[currentSlide];
        const nextSlideEl = slides[index];

        // Update indicators
        indicators.forEach((indicator, i) => {
            indicator.classList.toggle('active', i === index);
        });

        // Determine slide direction
        const slideDirection = direction === 'next' ? 'slide-left' : 'slide-right';

        // Prepare next slide
        nextSlideEl.style.transform = direction === 'next' ? 'translateX(100%)' : 'translateX(-100%)';
        nextSlideEl.classList.add('active');

        // Force reflow
        nextSlideEl.offsetHeight;

        // Animate slides
        currentSlideEl.style.transform = direction === 'next' ? 'translateX(-100%)' : 'translateX(100%)';
        nextSlideEl.style.transform = 'translateX(0)';

        // Clean up after transition
        setTimeout(() => {
            currentSlideEl.classList.remove('active');
            currentSlideEl.style.transform = '';
            nextSlideEl.style.transform = '';
            isTransitioning = false;
        }, 600);

        currentSlide = index;
    }

    function nextSlide() {
        const nextIndex = (currentSlide + 1) % slides.length;
        showSlide(nextIndex, 'next');
    }

    function prevSlide() {
        const prevIndex = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(prevIndex, 'prev');
    }

    function goToSlide(index) {
        if (index !== currentSlide) {
            const direction = index > currentSlide ? 'next' : 'prev';
            showSlide(index, direction);
        }
    }

    function startSlideshow() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    function stopSlideshow() {
        clearInterval(slideInterval);
    }

    // Event listeners
    nextBtn.addEventListener('click', () => {
        stopSlideshow();
        nextSlide();
        startSlideshow();
    });

    prevBtn.addEventListener('click', () => {
        stopSlideshow();
        prevSlide();
        startSlideshow();
    });

    // Indicator click events
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            stopSlideshow();
            goToSlide(index);
            startSlideshow();
        });
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            stopSlideshow();
            prevSlide();
            startSlideshow();
        } else if (e.key === 'ArrowRight') {
            stopSlideshow();
            nextSlide();
            startSlideshow();
        }
    });

    // Touch/swipe support
    let touchStartX = 0;
    let touchEndX = 0;

    const heroSection = document.querySelector('.hero-slider');

    heroSection.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    heroSection.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                stopSlideshow();
                nextSlide();
                startSlideshow();
            } else {
                stopSlideshow();
                prevSlide();
                startSlideshow();
            }
        }
    }

    // Pause on hover
    heroSection.addEventListener('mouseenter', stopSlideshow);
    heroSection.addEventListener('mouseleave', startSlideshow);

    // Start slideshow
    startSlideshow();
});
</script>

<style>
.slide {
    opacity: 0;
    visibility: hidden;
    transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    transform: translateX(100%);
}

.slide.active {
    opacity: 1;
    visibility: visible;
    transform: translateX(0);
}

/* Active slide image animation - subtle Ken Burns effect */
.slide.active img {
    animation: kenburns 20s ease-in-out infinite;
}

@keyframes kenburns {
    0%, 100% {
        transform: scale(1) translate(0, 0);
    }
    50% {
        transform: scale(1.05) translate(-2px, 2px);
    }
}

/* Slider Indicators */
.slider-indicator {
    position: relative;
    transition: all 0.3s ease;
}

.slider-indicator.active {
    background-color: white !important;
    transform: scale(1.2);
}

/* Slider Controls */
.hero-banner-container .slider-control {
    opacity: 0;
    transform: scale(0.9);
    transition: all 0.3s ease;
}

.hero-banner-container:hover .slider-control {
    opacity: 1;
    transform: scale(1);
}

.slider-control:hover {
    background-color: rgba(255, 255, 255, 0.35) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .slider-control {
        width: 40px !important;
        height: 40px !important;
    }

    .slider-indicator {
        width: 8px !important;
        height: 8px !important;
    }

    .hero-banner-container .slider-control {
        opacity: 0.7;
        transform: scale(1);
    }
}

/* Smooth performance optimizations */
.slide,
.slide img,
.slide video {
    will-change: transform;
    backface-visibility: hidden;
    perspective: 1000px;
}
</style>
