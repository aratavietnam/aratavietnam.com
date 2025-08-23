<?php
/**
 * Homepage Partners Section
 */
?>

<!-- Partners Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="flex items-center justify-center mb-4">
                <div class="w-12 h-1 bg-primary rounded-full mr-4"></div>
                <span class="text-primary font-medium text-sm uppercase tracking-wider">Đối tác tin cậy</span>
                <div class="w-12 h-1 bg-primary rounded-full ml-4"></div>
            </div>
            <h2 class="text-4xl font-bold text-gray-900 mb-6">
                <span class="text-secondary">Đối tác</span> 
                <span class="text-primary">& Thương hiệu</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Chúng tôi tự hào hợp tác với các thương hiệu hóa mỹ phẩm hàng đầu từ Nhật Bản
            </p>
        </div>

        <!-- Partners Carousel - Row 1 -->
        <div class="mb-8">
            <div class="overflow-hidden">
                <div class="partners-carousel-1 flex animate-scroll-left">
                    <!-- First set of partners -->
                    <div class="flex space-x-8 flex-shrink-0">
                        <?php
                        // Sample partner logos - in real implementation, these would come from a custom field or database
                        $partners_row1 = [
                            ['name' => 'Shiseido', 'logo' => 'partner-shiseido.png'],
                            ['name' => 'Kao', 'logo' => 'partner-kao.png'],
                            ['name' => 'DHC', 'logo' => 'partner-dhc.png'],
                            ['name' => 'Rohto', 'logo' => 'partner-rohto.png'],
                            ['name' => 'Kose', 'logo' => 'partner-kose.png'],
                            ['name' => 'Kanebo', 'logo' => 'partner-kanebo.png'],
                            ['name' => 'Pola', 'logo' => 'partner-pola.png'],
                            ['name' => 'Fancl', 'logo' => 'partner-fancl.png']
                        ];

                        foreach ($partners_row1 as $partner) : ?>
                            <div class="flex-shrink-0 w-32 h-20 bg-white rounded-lg border border-gray-200 hover:border-primary/30 transition-colors duration-300 flex items-center justify-center group hover:shadow-md">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/partners/<?php echo $partner['logo']; ?>" 
                                     alt="<?php echo esc_attr($partner['name']); ?>"
                                     class="max-w-full max-h-full object-contain opacity-60 group-hover:opacity-100 transition-opacity duration-300" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Duplicate set for seamless loop -->
                    <div class="flex space-x-8 flex-shrink-0 ml-8">
                        <?php foreach ($partners_row1 as $partner) : ?>
                            <div class="flex-shrink-0 w-32 h-20 bg-white rounded-lg border border-gray-200 hover:border-primary/30 transition-colors duration-300 flex items-center justify-center group hover:shadow-md">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/partners/<?php echo $partner['logo']; ?>" 
                                     alt="<?php echo esc_attr($partner['name']); ?>"
                                     class="max-w-full max-h-full object-contain opacity-60 group-hover:opacity-100 transition-opacity duration-300" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partners Carousel - Row 2 (Reverse direction) -->
        <div class="mb-12">
            <div class="overflow-hidden">
                <div class="partners-carousel-2 flex animate-scroll-right">
                    <!-- First set of partners -->
                    <div class="flex space-x-8 flex-shrink-0">
                        <?php
                        $partners_row2 = [
                            ['name' => 'Shu Uemura', 'logo' => 'partner-shu-uemura.png'],
                            ['name' => 'SK-II', 'logo' => 'partner-sk2.png'],
                            ['name' => 'Hada Labo', 'logo' => 'partner-hada-labo.png'],
                            ['name' => 'Biore', 'logo' => 'partner-biore.png'],
                            ['name' => 'Senka', 'logo' => 'partner-senka.png'],
                            ['name' => 'Curel', 'logo' => 'partner-curel.png'],
                            ['name' => 'Mentholatum', 'logo' => 'partner-mentholatum.png'],
                            ['name' => 'Nivea', 'logo' => 'partner-nivea.png']
                        ];

                        foreach ($partners_row2 as $partner) : ?>
                            <div class="flex-shrink-0 w-32 h-20 bg-white rounded-lg border border-gray-200 hover:border-secondary/30 transition-colors duration-300 flex items-center justify-center group hover:shadow-md">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/partners/<?php echo $partner['logo']; ?>" 
                                     alt="<?php echo esc_attr($partner['name']); ?>"
                                     class="max-w-full max-h-full object-contain opacity-60 group-hover:opacity-100 transition-opacity duration-300" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Duplicate set for seamless loop -->
                    <div class="flex space-x-8 flex-shrink-0 ml-8">
                        <?php foreach ($partners_row2 as $partner) : ?>
                            <div class="flex-shrink-0 w-32 h-20 bg-white rounded-lg border border-gray-200 hover:border-secondary/30 transition-colors duration-300 flex items-center justify-center group hover:shadow-md">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/partners/<?php echo $partner['logo']; ?>" 
                                     alt="<?php echo esc_attr($partner['name']); ?>"
                                     class="max-w-full max-h-full object-contain opacity-60 group-hover:opacity-100 transition-opacity duration-300" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partnership Benefits -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-8">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Lợi ích từ đối tác chiến lược</h3>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Mối quan hệ đối tác bền vững giúp chúng tôi mang đến những sản phẩm tốt nhất với giá cả hợp lý
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary/20 transition-colors duration-300">
                        <span data-icon="shield-check" data-size="32" class="text-primary"></span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Sản phẩm chính hãng</h4>
                    <p class="text-gray-600 text-sm">100% sản phẩm được nhập khẩu trực tiếp từ các thương hiệu uy tín</p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-secondary/20 transition-colors duration-300">
                        <span data-icon="trending-down" data-size="32" class="text-secondary"></span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Giá cả cạnh tranh</h4>
                    <p class="text-gray-600 text-sm">Mối quan hệ đối tác trực tiếp giúp tối ưu hóa chi phí cho khách hàng</p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 bg-tertiary/10 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-tertiary/20 transition-colors duration-300">
                        <span data-icon="zap" data-size="32" class="text-tertiary"></span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Cập nhật nhanh chóng</h4>
                    <p class="text-gray-600 text-sm">Luôn có sẵn những sản phẩm mới nhất từ các thương hiệu hàng đầu</p>
                </div>
            </div>
        </div>

        <!-- Become Partner CTA -->
        <div class="text-center mt-12">
            <div class="bg-gradient-to-r from-primary/5 to-secondary/5 rounded-xl p-8 border border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Trở thành đối tác của Arata Vietnam</h3>
                <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                    Bạn là nhà phân phối, cửa hàng bán lẻ hoặc có nhu cầu hợp tác kinh doanh? 
                    Hãy liên hệ với chúng tôi để thảo luận về cơ hội hợp tác.
                </p>
                <a href="<?php echo home_url('/lien-he'); ?>" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-semibold rounded-lg hover:from-primary-dark hover:to-secondary-dark transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <span data-icon="handshake" data-size="20" class="mr-2"></span>
                    Liên hệ hợp tác
                    <span data-icon="arrow-right" data-size="20" class="ml-2"></span>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Continuous scrolling animations */
@keyframes scroll-left {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

@keyframes scroll-right {
    0% { transform: translateX(-50%); }
    100% { transform: translateX(0); }
}

.animate-scroll-left {
    animation: scroll-left 30s linear infinite;
}

.animate-scroll-right {
    animation: scroll-right 30s linear infinite;
}

/* Pause animation on hover */
.partners-carousel-1:hover,
.partners-carousel-2:hover {
    animation-play-state: paused;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .animate-scroll-left,
    .animate-scroll-right {
        animation-duration: 20s;
    }
}
</style>
