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
