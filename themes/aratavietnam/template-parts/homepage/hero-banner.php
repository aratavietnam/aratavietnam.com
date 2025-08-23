<?php
/**
 * Homepage Hero Banner Section
 */
?>

<!-- Hero Banner Section -->
<section class="relative h-screen overflow-hidden">
    <!-- Background Slider -->
    <div class="hero-slider absolute inset-0">
        <!-- Slide 1 -->
        <div class="slide active absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20">
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-black/20"></div>
            <?php
            $banner_image = wp_get_attachment_image_url(275, 'full');
            if (!$banner_image) {
                $banner_image = get_template_directory_uri() . '/assets/images/hero-slide-1.jpg';
            }
            ?>
            <img src="<?php echo esc_url($banner_image); ?>"
                 alt="Arata Vietnam - Hóa mỹ phẩm Nhật Bản"
                 class="w-full h-full object-cover" />
        </div>

        <!-- Slide 2 -->
        <div class="slide absolute inset-0 bg-gradient-to-r from-secondary/20 to-tertiary/20">
            <div class="absolute inset-0 bg-black/30"></div>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-slide-2.jpg"
                 alt="Sản phẩm chất lượng cao"
                 class="w-full h-full object-cover" />
        </div>

        <!-- Slide 3 -->
        <div class="slide absolute inset-0 bg-gradient-to-r from-tertiary/20 to-primary/20">
            <div class="absolute inset-0 bg-black/30"></div>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-slide-3.jpg"
                 alt="Đối tác tin cậy"
                 class="w-full h-full object-cover" />
        </div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 h-full flex items-center justify-center">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-4xl mx-auto">
                <!-- Main Heading -->
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                    <span class="block text-tertiary">ARATA</span>
                    <span class="block text-2xl md:text-4xl lg:text-5xl mt-2">
                        NHÀ PHÂN PHỐI HÓA MỸ PHẨM<br>
                        <span class="text-primary">HÀNG ĐẦU NHẬT BẢN</span>
                    </span>
                </h1>

                <!-- Subtitle -->
                <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-2xl mx-auto">
                    Mang đến những sản phẩm chất lượng cao từ Nhật Bản với dịch vụ tận tâm
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                    <a href="<?php echo wc_get_page_permalink('shop'); ?>"
                       class="inline-flex items-center px-8 py-4 bg-primary text-white font-semibold rounded-lg hover:bg-primary-dark transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <span data-icon="shopping-bag" data-size="20" class="mr-2"></span>
                        Khám phá sản phẩm
                    </a>
                    <a href="<?php echo home_url('/ve-arata-vietnam'); ?>"
                       class="inline-flex items-center px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-lg border-2 border-white/30 hover:bg-white/20 transition-all duration-300">
                        <span data-icon="info" data-size="20" class="mr-2"></span>
                        Tìm hiểu thêm
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Down Arrow -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10">
        <div class="animate-bounce">
            <a href="#featured-products" class="block w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-white/30 transition-colors">
                <span data-icon="chevron-down" data-size="24"></span>
            </a>
        </div>
    </div>

    <!-- Slider Navigation -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 flex space-x-2">
        <button class="slider-dot active w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors" data-slide="0"></button>
        <button class="slider-dot w-3 h-3 rounded-full bg-white/30 hover:bg-white transition-colors" data-slide="1"></button>
        <button class="slider-dot w-3 h-3 rounded-full bg-white/30 hover:bg-white transition-colors" data-slide="2"></button>
    </div>

    <!-- Slider Controls -->
    <button class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-white/30 transition-colors" id="prevSlide">
        <span data-icon="chevron-left" data-size="24"></span>
    </button>
    <button class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-white/30 transition-colors" id="nextSlide">
        <span data-icon="chevron-right" data-size="24"></span>
    </button>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    let currentSlide = 0;
    let slideInterval;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
            dot.classList.toggle('bg-white', i === index);
            dot.classList.toggle('bg-white/30', i !== index);
        });
        currentSlide = index;
    }

    function nextSlide() {
        showSlide((currentSlide + 1) % slides.length);
    }

    function prevSlide() {
        showSlide((currentSlide - 1 + slides.length) % slides.length);
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

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            stopSlideshow();
            showSlide(index);
            startSlideshow();
        });
    });

    // Pause on hover
    const heroSection = document.querySelector('.hero-slider');
    heroSection.addEventListener('mouseenter', stopSlideshow);
    heroSection.addEventListener('mouseleave', startSlideshow);

    // Start slideshow
    startSlideshow();

    // Smooth scroll for arrow
    document.querySelector('a[href="#featured-products"]').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('featured-products').scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>

<style>
.slide {
    opacity: 0;
    transition: opacity 1s ease-in-out;
}

.slide.active {
    opacity: 1;
}

.slide.active img {
    animation: kenburns 20s ease-in-out infinite;
}

@keyframes kenburns {
    0% {
        transform: scale(1) translate(0, 0);
    }
    50% {
        transform: scale(1.1) translate(-5px, 5px);
    }
    100% {
        transform: scale(1) translate(0, 0);
    }
}

.slider-dot.active {
    background-color: white !important;
}
</style>
