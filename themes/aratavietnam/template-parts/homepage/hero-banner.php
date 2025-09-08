<?php
/**
 * Homepage Hero Banner Section
 */

// Get hero settings
$front_page_id = get_option('page_on_front');
$show_hero = get_post_meta($front_page_id, 'arata_show_hero', true);
$compact_hero = get_post_meta($front_page_id, 'arata_compact_hero', true);
$hero_subtitle = get_post_meta($front_page_id, 'arata_homepage_subtitle', true) ?: 'Trang chủ';
$hero_intro = get_post_meta($front_page_id, 'arata_homepage_intro', true) ?: 'Chào mừng bạn đến với Arata Vietnam - Nhà phân phối hóa mỹ phẩm hàng đầu Nhật Bản';

// Get global colors
$primary_color = get_theme_mod('arata_primary_color', '#0066A6');
$secondary_color = get_theme_mod('arata_secondary_color', '#F55E25');

// Only show if hero is enabled
if ($show_hero !== '0') :
?>
<!-- Hero Banner Section -->
<section class="relative overflow-hidden hero-banner-container <?php echo $compact_hero === '1' ? 'h-[400px]' : 'h-[600px]'; ?>">
    <!-- Background Slider -->
    <div class="hero-slider absolute inset-0">
        <?php
        for ($i = 1; $i <= 3; $i++) {
            $slide_type = get_post_meta($front_page_id, '_slide' . $i . '_type', true) ?: 'image';
            $slide_image_id = get_post_meta($front_page_id, '_slide' . $i . '_image', true);
            $slide_video = get_post_meta($front_page_id, '_slide' . $i . '_video', true);
            $default_slide_ids = [277, 278, 279];
            $slide_image = $slide_image_id ? wp_get_attachment_image_url($slide_image_id, 'full') : wp_get_attachment_image_url($default_slide_ids[$i - 1], 'full');
            $active_class = ($i === 1) ? 'active' : '';
            ?>
            <div class="slide <?php echo $active_class; ?> absolute inset-0" data-slide="<?php echo $i; ?>" style="<?php echo $i === 1 ? '' : 'transform: translateX(100%);'; ?>">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
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
        const next = (currentSlide + 1) % slides.length;
        showSlide(next, 'next');
    }

    function prevSlide() {
        const prev = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(prev, 'prev');
    }

    function startAutoSlide() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    function stopAutoSlide() {
        clearInterval(slideInterval);
    }

    // Event listeners
    nextBtn.addEventListener('click', () => {
        stopAutoSlide();
        nextSlide();
        startAutoSlide();
    });

    prevBtn.addEventListener('click', () => {
        stopAutoSlide();
        prevSlide();
        startAutoSlide();
    });

    // Add transition styles
    const style = document.createElement('style');
    style.textContent = `
        .slide {
            transition: transform 0.6s ease-in-out;
            will-change: transform;
        }
        .slider-control:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }
        .slider-control {
            cursor: pointer;
        }
    `;
    document.head.appendChild(style);

    // Start auto-slide
    startAutoSlide();

    // Pause on hover
    const heroContainer = document.querySelector('.hero-banner-container');
    heroContainer.addEventListener('mouseenter', stopAutoSlide);
    heroContainer.addEventListener('mouseleave', startAutoSlide);
});
</script>
<?php endif; ?>