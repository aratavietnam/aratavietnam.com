<?php
/**
 * Homepage About Arata Section
 */
?>

<!-- About Arata Section -->
<section class="py-16 scroll-animate" style="background-color: oklch(0.55 0.16 254.65);">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <!-- Left Side: Image Slider -->
            <div class="relative">
                <div class="about-slider-container overflow-hidden">
                    <div class="about-slider-track flex">
                    <?php
                    $front_page_id = get_option('page_on_front');
                    for ($i = 1; $i <= 5; $i++) {
                        $image_id = get_post_meta($front_page_id, '_about_image_' . $i, true);
                        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';
                        ?>
                        <div class="about-slide">
                            <div class="about-slide-content">
                                <?php if ($image_url) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="Về Arata <?php echo $i; ?>">
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
                    <h2 class="text-4xl font-bold text-white mb-6">
                        <span class="font-light"><?php echo esc_html($title_part1); ?></span>
                        <span><?php echo esc_html($title_part2); ?></span>
                    </h2>
                </div>

                <!-- Company Description -->
                <div class="prose prose-lg max-w-none prose-invert">
                    <p class="text-blue-100 text-lg leading-relaxed mb-6">
                        <strong class="text-white">Arata Việt Nam</strong> là công ty con của Tập đoàn Arata Nhật Bản,
                        được thành lập với sứ mệnh mang đến những sản phẩm hóa mỹ phẩm chất lượng cao từ Nhật Bản
                        cho thị trường Việt Nam.
                    </p>

                </div>

                <!-- CTA Button -->
                <div class="pt-4">
                    <a href="<?php echo home_url('/ve-arata-vietnam'); ?>"
                       class="inline-flex items-center px-6 py-3 border border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-500 transition-all duration-300">
                        Tìm hiểu thêm
                        <span data-icon="arrow-right" data-size="16" class="ml-2"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

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
.about-slider-nav:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}
</style>
