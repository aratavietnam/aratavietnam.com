<?php
/**
 * Homepage Partners Section
 */
?>

<!-- Partners Section -->
<section class="py-16 bg-white scroll-animate">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">

            <?php
            // Get custom content for the section header
            $front_page_id = get_option('page_on_front');
            $title_part1 = get_post_meta($front_page_id, '_partners_title_part1', true);
            $title_part2 = get_post_meta($front_page_id, '_partners_title_part2', true);
            $section_description = get_post_meta($front_page_id, '_partners_description', true);

            // Fallback to default text if not set
            if (empty($title_part1)) {
                $title_part1 = 'Đối tác';
            }
            if (empty($title_part2)) {
                $title_part2 = '& Thương hiệu';
            }
            if (empty($section_description)) {
                $section_description = 'Chúng tôi tự hào hợp tác với các thương hiệu hóa mỹ phẩm hàng đầu từ Nhật Bản';
            }
            ?>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                <span class="text-secondary"><?php echo esc_html($title_part1); ?></span>
                <span class="text-primary"><?php echo esc_html($title_part2); ?></span>
            </h2>
            <p class="text-base sm:text-lg text-gray-600 mx-auto">
                <?php echo esc_html($section_description); ?>
            </p>
        </div>

        <?php
        $args = array(
            'post_type' => 'partner',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        );
        $partners_query = new WP_Query($args);

        if ($partners_query->have_posts()) :
            $all_partners = $partners_query->posts;
            $half_point = ceil(count($all_partners) / 2);
            $partners_row1 = array_slice($all_partners, 0, $half_point);
            $partners_row2 = array_slice($all_partners, $half_point);
        ?>
            <!-- Partners Carousel - Row 1 -->
            <?php if (!empty($partners_row1)) : ?>
            <div class="mb-8">
                <div class="overflow-hidden">
                    <div class="partners-carousel-1 flex animate-scroll-left">
                        <!-- First set of partners -->
                        <div class="flex space-x-8 flex-shrink-0">
                            <?php foreach ($partners_row1 as $partner_post) : ?>
                                <div class="flex-shrink-0 w-32 h-20 bg-white rounded-lg transition-colors duration-300 flex items-center justify-center group">
                                    <?php if (has_post_thumbnail($partner_post->ID)) : ?>
                                        <img src="<?php echo get_the_post_thumbnail_url($partner_post->ID, 'medium'); ?>"
                                             alt="<?php echo esc_attr(get_the_title($partner_post->ID)); ?>"
                                             class="max-w-full max-h-full object-contain opacity-60 group-hover:opacity-100 transition-opacity duration-300" />
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Duplicate set for seamless loop -->
                        <div class="flex space-x-8 flex-shrink-0 ml-8">
                            <?php foreach ($partners_row1 as $partner_post) : ?>
                                <div class="flex-shrink-0 w-32 h-20 bg-white rounded-lg transition-colors duration-300 flex items-center justify-center group">
                                    <?php if (has_post_thumbnail($partner_post->ID)) : ?>
                                        <img src="<?php echo get_the_post_thumbnail_url($partner_post->ID, 'medium'); ?>"
                                             alt="<?php echo esc_attr(get_the_title($partner_post->ID)); ?>"
                                             class="max-w-full max-h-full object-contain opacity-60 group-hover:opacity-100 transition-opacity duration-300" />
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Partners Carousel - Row 2 (Reverse direction) -->
            <?php if (!empty($partners_row2)) : ?>
            <div class="mb-12">
                <div class="overflow-hidden">
                    <div class="partners-carousel-2 flex animate-scroll-right">
                        <!-- First set of partners -->
                        <div class="flex space-x-8 flex-shrink-0">
                            <?php foreach ($partners_row2 as $partner_post) : ?>
                                <div class="flex-shrink-0 w-32 h-20 bg-white rounded-lg transition-colors duration-300 flex items-center justify-center group">
                                    <?php if (has_post_thumbnail($partner_post->ID)) : ?>
                                        <img src="<?php echo get_the_post_thumbnail_url($partner_post->ID, 'medium'); ?>"
                                             alt="<?php echo esc_attr(get_the_title($partner_post->ID)); ?>"
                                             class="max-w-full max-h-full object-contain opacity-60 group-hover:opacity-100 transition-opacity duration-300" />
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Duplicate set for seamless loop -->
                        <div class="flex space-x-8 flex-shrink-0 ml-8">
                            <?php foreach ($partners_row2 as $partner_post) : ?>
                                <div class="flex-shrink-0 w-32 h-20 bg-white rounded-lg transition-colors duration-300 flex items-center justify-center group">
                                    <?php if (has_post_thumbnail($partner_post->ID)) : ?>
                                        <img src="<?php echo get_the_post_thumbnail_url($partner_post->ID, 'medium'); ?>"
                                             alt="<?php echo esc_attr(get_the_title($partner_post->ID)); ?>"
                                             class="max-w-full max-h-full object-contain opacity-60 group-hover:opacity-100 transition-opacity duration-300" />
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php
        endif;
        wp_reset_postdata();
        ?>
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
