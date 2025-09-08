<?php
/**
 * Template Name: Services Page
 *
 * Template for displaying company services with flexible sections
 *
 * @package ArataVietnam
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Get customizer color settings
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');

// Get page meta fields for hero customization
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_services_subtitle', true) ?: 'Dịch vụ';
$hero_intro = get_post_meta(get_the_ID(), 'arata_services_intro', true) ?: 'Chúng tôi cung cấp các dịch vụ chất lượng cao với đội ngũ chuyên nghiệp và kinh nghiệm nhiều năm trong lĩnh vực hóa mỹ phẩm Nhật Bản.';

// Section visibility controls
$show_hero = get_post_meta(get_the_ID(), 'arata_show_hero', true) !== '0'; // Default to true if not set
$use_compact_hero = get_post_meta(get_the_ID(), 'arata_compact_hero', true) === '1'; // New compact option
$show_services = get_post_meta(get_the_ID(), 'arata_show_services', true) !== '0';
$show_stats = get_post_meta(get_the_ID(), 'arata_show_stats', true) !== '0';
$show_why_choose = get_post_meta(get_the_ID(), 'arata_show_why_choose', true) !== '0';
$show_testimonials = get_post_meta(get_the_ID(), 'arata_show_testimonials', true) !== '0';
$show_cta = get_post_meta(get_the_ID(), 'arata_show_cta', true) !== '0';

// Section content settings
$stats_title = get_post_meta(get_the_ID(), 'arata_stats_title', true) ?: 'Những con số biết nói';
$why_choose_title = get_post_meta(get_the_ID(), 'arata_why_choose_title', true) ?: 'Tại sao chọn Arata Vietnam?';
$testimonials_title = get_post_meta(get_the_ID(), 'arata_testimonials_title', true) ?: 'Khách hàng nói gì về chúng tôi';
$cta_title = get_post_meta(get_the_ID(), 'arata_cta_title', true) ?: 'Sẵn sàng hợp tác?';
$cta_description = get_post_meta(get_the_ID(), 'arata_cta_description', true) ?: 'Hãy liên hệ với chúng tôi để được tư vấn giải pháp phù hợp nhất.';
$cta_button_text = get_post_meta(get_the_ID(), 'arata_cta_button_text', true) ?: 'Liên hệ ngay';
$cta_button_link = get_post_meta(get_the_ID(), 'arata_cta_button_link', true) ?: '/lien-he';

// Set hero variables
set_query_var('title', get_the_title());
set_query_var('subtitle', $hero_subtitle);
set_query_var('description', $hero_intro);
set_query_var('compact_mode', $use_compact_hero);

if ($show_hero) {
    if ($use_compact_hero) {
        // Use compact hero inline
        ?>
        <section class="relative border-b border-gray-100" style="background-color: <?php echo esc_attr($background_color); ?>; margin-top: -5px;">
            <div class="relative container mx-auto px-4 py-8 sm:py-12">
                <div class="max-w-3xl mx-auto text-center">
                    <!-- Compact title indicator -->
                    <div class="inline-flex items-center mb-3">
                        <div class="w-8 h-0.5 rounded-full mr-3" style="background-color: <?php echo esc_attr($primary_color); ?>;"></div>
                        <span class="font-medium text-xs uppercase tracking-widest" style="color: <?php echo esc_attr($primary_color); ?>;"><?php echo esc_html($hero_subtitle); ?></span>
                        <div class="w-8 h-0.5 rounded-full ml-3" style="background-color: <?php echo esc_attr($primary_color); ?>;"></div>
                    </div>

                    <!-- Smaller, more elegant title -->
                    <h1 class="text-2xl sm:text-4xl font-bold text-gray-900 leading-tight mb-4">
                        <?php echo esc_html(get_the_title()); ?>
                    </h1>

                    <!-- Compact description -->
                    <p class="text-base sm:text-lg text-gray-600 leading-relaxed max-w-xl mx-auto">
                        <?php echo esc_html($hero_intro); ?>
                    </p>
                </div>
            </div>
        </section>
        <?php
    } else {
        // Use full hero template part
        get_template_part('template-parts/hero');
    }
}
?>

<main id="site-content" class="bg-white" style="background-color: <?php echo esc_attr($background_color); ?>; <?php echo $show_hero && !$use_compact_hero ? '' : 'margin-top: -5px;'; ?>">

    <?php if ($show_services) : ?>
    <!-- Services Section -->
    <section class="py-16" style="background-color: <?php echo esc_attr($background_color); ?>">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <?php if (get_post_meta(get_the_ID(), 'arata_show_service_header', true) === '1') : ?>
            <div class="text-center mb-12">
                <div class="inline-flex items-center mb-4">
                    <div class="w-12 h-0.5 rounded-full mr-4" style="background-color: <?php echo esc_attr($primary_color); ?>;"></div>
                    <span class="font-medium text-sm uppercase tracking-widest" style="color: <?php echo esc_attr($primary_color); ?>">Dịch vụ của chúng tôi</span>
                    <div class="w-12 h-0.5 rounded-full ml-4" style="background-color: <?php echo esc_attr($primary_color); ?>;"></div>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">
                    Giải pháp <span style="color: <?php echo esc_attr($primary_color); ?>">chuyên nghiệp</span>
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Chúng tôi mang đến các dịch vụ chất lượng cao, đáp ứng mọi nhu cầu của khách hàng
                </p>
            </div>
            <?php endif; ?>

            <!-- Search and Filter -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <input type="text" id="service-search" placeholder="Tìm kiếm dịch vụ..." class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span data-icon="search" data-size="20" class="text-gray-400"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex flex-wrap gap-2">
                        <button class="filter-btn px-4 py-2 rounded-lg font-medium transition-colors active" data-filter="all" style="background-color: <?php echo esc_attr($primary_color); ?>; color: white;">
                            Tất cả
                        </button>
                        <?php
                        $service_categories = get_terms([
                            'taxonomy' => 'service_category',
                            'hide_empty' => true,
                        ]);

                        if (!empty($service_categories) && !is_wp_error($service_categories)) :
                            foreach ($service_categories as $index => $category) :
                                // Assign system colors based on index
                                $system_colors = [$primary_color, $secondary_color, $tertiary_color];
                                $color = $system_colors[$index % count($system_colors)];
                        ?>
                                <button class="filter-btn px-4 py-2 rounded-lg font-medium transition-colors border-2" data-filter="<?php echo esc_attr($category->slug); ?>" style="border-color: <?php echo esc_attr($color); ?>; color: <?php echo esc_attr($color); ?>;">
                                    <?php echo esc_html($category->name); ?>
                                </button>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>

            <!-- Services Grid -->
            <div class="services-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $args = [
                    'post_type' => 'service',
                    'posts_per_page' => -1,
                    'orderby' => 'menu_order title',
                    'order' => 'ASC',
                ];

                $services_query = new WP_Query($args);

                if ($services_query->have_posts()) :
                    while ($services_query->have_posts()) : $services_query->the_post();
                        $service_type = get_post_meta(get_the_ID(), 'arata_service_type', true);
                        $service_price = get_post_meta(get_the_ID(), 'arata_service_price', true);
                        $service_icon = get_post_meta(get_the_ID(), 'arata_service_icon', true);
                        // Map service types to system colors
$type_colors = [
    'consultation' => $primary_color,
    'implementation' => $secondary_color,
    'maintenance' => $tertiary_color,
    'support' => $primary_color,
    'training' => $secondary_color,
    'custom' => $tertiary_color
];
$service_color = $type_colors[$service_type] ?? $primary_color;
                        $categories = get_the_terms(get_the_ID(), 'service_category');
                        $category_slugs = $categories ? wp_list_pluck($categories, 'slug') : [];
                ?>
                        <div class="service-card group rounded-xl border overflow-hidden" data-categories="<?php echo esc_attr(implode(' ', $category_slugs)); ?>" data-service-type="<?php echo esc_attr($service_type); ?>" style="background-color: <?php echo esc_attr($background_color); ?>;">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                                </div>
                            <?php endif; ?>
                            <div class="p-6">
                                <!-- Icon and Type -->
                                <div class="flex items-center justify-between mb-4">
                                    <?php if ($service_icon) : ?>
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: <?php echo esc_attr($service_color); ?>20;">
                                            <span data-icon="<?php echo esc_attr($service_icon); ?>" data-size="24" style="color: <?php echo esc_attr($service_color); ?>;"></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($service_type) : ?>
                                        <span class="text-xs font-medium px-2 py-1 rounded-full" style="background-color: <?php echo esc_attr($service_color); ?>20; color: <?php echo esc_attr($service_color); ?>;">
                                            <?php echo esc_html(get_term($service_type)->name); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Title -->
                                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>

                                <!-- Excerpt -->
                                <div class="text-gray-600 mb-4 leading-relaxed text-sm">
                                    <?php the_excerpt(); ?>
                                </div>

                                <!-- Price and CTA -->
                                <div class="flex items-center justify-between">
                                    <?php if ($service_price) : ?>
                                        <div class="text-lg font-bold" style="color: <?php echo esc_attr($primary_color); ?>">
                                            <?php echo esc_html($service_price); ?>
                                        </div>
                                    <?php endif; ?>
                                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm group-hover:translate-x-1 transition-all duration-300" style="color: <?php echo esc_attr($primary_color); ?>">
                                        Chi tiết
                                        <span data-icon="arrow-right" data-size="16" class="ml-1"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <div class="col-span-full text-center py-16">
                        <div class="text-gray-400 mb-4">
                            <span data-icon="settings" data-size="64"></span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Chưa có dịch vụ nào</h3>
                        <p class="text-gray-600">Các dịch vụ sẽ được cập nhật sớm nhất có thể.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($show_stats) : ?>
    <!-- Stats Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">
                    <?php echo esc_html($stats_title); ?>
                </h2>
            </div>

            <?php
            $stats_items = get_post_meta(get_the_ID(), 'arata_stats_items', true);
            if (!empty($stats_items) && is_array($stats_items)) :
            ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <?php foreach ($stats_items as $index => $item) : 
                        $number = isset($item['number']) ? esc_html($item['number']) : '';
                        $label = isset($item['label']) ? esc_html($item['label']) : '';
                        $color = isset($item['color']) ? esc_attr($item['color']) : $primary_color;
                        
                        // Determine which color to use based on selection
                        $color_value = $primary_color;
                        if ($color === 'secondary') {
                            $color_value = $secondary_color;
                        } elseif ($color === 'tertiary') {
                            $color_value = $tertiary_color;
                        }
                    ?>
                        <div class="text-center">
                            <div class="text-4xl md:text-5xl font-bold mb-2" style="color: <?php echo $color_value; ?>">
                                <?php echo $number; ?>
                            </div>
                            <div class="text-gray-600"><?php echo $label; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <!-- Default stats if none are set -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2" style="color: <?php echo esc_attr($primary_color); ?>">10+</div>
                        <div class="text-gray-600">Năm kinh nghiệm</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2" style="color: <?php echo esc_attr($secondary_color); ?>">5000+</div>
                        <div class="text-gray-600">Khách hàng tin tưởng</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2" style="color: <?php echo esc_attr($tertiary_color); ?>">100+</div>
                        <div class="text-gray-600">Sản phẩm chất lượng</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold mb-2" style="color: <?php echo esc_attr($primary_color); ?>">24/7</div>
                        <div class="text-gray-600">Hỗ trợ khách hàng</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($show_why_choose) : ?>
    <!-- Why Choose Section -->
    <section class="py-16" style="background-color: <?php echo esc_attr($background_color); ?>">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">
                    <?php echo esc_html($why_choose_title); ?>
                </h2>
            </div>

            <?php
            $why_choose_items = get_post_meta(get_the_ID(), 'arata_why_choose_items', true);
            if (!empty($why_choose_items) && is_array($why_choose_items)) :
            ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($why_choose_items as $index => $item) : 
                        $icon = isset($item['icon']) ? esc_attr($item['icon']) : 'check';
                        $title = isset($item['title']) ? esc_html($item['title']) : '';
                        $description = isset($item['description']) ? esc_html($item['description']) : '';
                        
                        // Determine which color to use based on index or selection
                        $color_value = $primary_color;
                        if ($index % 3 === 1) {
                            $color_value = $secondary_color;
                        } elseif ($index % 3 === 2) {
                            $color_value = $tertiary_color;
                        }
                        
                        // Map icon names to actual icons
                        $icon_map = [
                            'check' => 'check',
                            'users' => 'users',
                            'truck' => 'truck',
                            'star' => 'star',
                            'heart' => 'heart',
                            'shield' => 'shield',
                            'award' => 'award'
                        ];
                        $display_icon = isset($icon_map[$icon]) ? $icon_map[$icon] : 'check';
                    ?>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: <?php echo $color_value; ?>20;">
                                    <span data-icon="<?php echo $display_icon; ?>" data-size="24" style="color: <?php echo $color_value; ?>;"></span>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo $title; ?></h3>
                                <p class="text-gray-600"><?php echo $description; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <!-- Default why choose items if none are set -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: <?php echo esc_attr($primary_color); ?>20;">
                                <span data-icon="check" data-size="24" style="color: <?php echo esc_attr($primary_color); ?>;"></span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Chất lượng đảm bảo</h3>
                            <p class="text-gray-600">Sản phẩm nhập khẩu chính hãng từ Nhật Bản, đảm bảo chất lượng và an toàn.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: <?php echo esc_attr($secondary_color); ?>20;">
                                <span data-icon="users" data-size="24" style="color: <?php echo esc_attr($secondary_color); ?>;"></span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Đội ngũ chuyên gia</h3>
                            <p class="text-gray-600">Đội ngũ nhân viên giàu kinh nghiệm, được đào tạo bài bản về sản phẩm.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: <?php echo esc_attr($tertiary_color); ?>20;">
                                <span data-icon="truck" data-size="24" style="color: <?php echo esc_attr($tertiary_color); ?>;"></span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Giao hàng nhanh</h3>
                            <p class="text-gray-600">Hệ thống giao hàng nhanh chóng, tiện lợi trên toàn quốc.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($show_testimonials) : ?>
    <!-- Testimonials Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">
                    <?php echo esc_html($testimonials_title); ?>
                </h2>
            </div>

            <?php
            $testimonial_items = get_post_meta(get_the_ID(), 'arata_testimonials', true);
            if (!empty($testimonial_items) && is_array($testimonial_items)) :
            ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($testimonial_items as $index => $item) : 
                        $name = isset($item['name']) ? esc_html($item['name']) : '';
                        $content = isset($item['content']) ? esc_html($item['content']) : '';
                        $rating = isset($item['rating']) ? intval($item['rating']) : 5;
                        $avatar_id = isset($item['avatar_id']) ? intval($item['avatar_id']) : 0;
                        $avatar_url = $avatar_id ? wp_get_attachment_url($avatar_id) : '';
                    ?>
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full mr-4 overflow-hidden bg-gray-200 flex items-center justify-center">
                                    <?php if ($avatar_url) : ?>
                                        <img src="<?php echo esc_url($avatar_url); ?>" alt="<?php echo esc_attr($name); ?>" class="w-full h-full object-cover" />
                                    <?php else : ?>
                                        <span data-icon="user" data-size="24" class="text-gray-500"></span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900"><?php echo $name; ?></h4>
                                    <div class="flex text-yellow-400">
                                        <?php for($i=0; $i<$rating; $i++) : ?>
                                            <span data-icon="star" data-size="16" fill="currentColor"></span>
                                        <?php endfor; ?>
                                        <?php for($i=$rating; $i<5; $i++) : ?>
                                            <span data-icon="star" data-size="16" class="text-gray-300"></span>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600 italic">"<?php echo $content; ?>"</p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <!-- Default testimonials if none are set -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full mr-4 overflow-hidden bg-gray-200">
                                <img src="<?php echo wp_get_attachment_url(596); ?>" alt="Nguyễn Văn A" class="w-full h-full object-cover" />
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Nguyễn Văn A</h4>
                                <div class="flex text-yellow-400">
                                    <?php for($i=0; $i<5; $i++) : ?>
                                        <span data-icon="star" data-size="16" fill="currentColor"></span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">"Sản phẩm chất lượng, dịch vụ tận tình. Tôi rất hài lòng khi mua hàng tại Arata Vietnam."</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full mr-4 overflow-hidden bg-gray-200">
                                <img src="<?php echo wp_get_attachment_url(597); ?>" alt="Trần Thị B" class="w-full h-full object-cover" />
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Trần Thị B</h4>
                                <div class="flex text-yellow-400">
                                    <?php for($i=0; $i<5; $i++) : ?>
                                        <span data-icon="star" data-size="16" fill="currentColor"></span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">"Đã sử dụng nhiều sản phẩm và đều rất tốt. Mình sẽ tiếp tục ủng hộ Arata Vietnam."</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full mr-4 overflow-hidden bg-gray-200">
                                <img src="<?php echo wp_get_attachment_url(598); ?>" alt="Lê Văn C" class="w-full h-full object-cover" />
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Lê Văn C</h4>
                                <div class="flex text-yellow-400">
                                    <?php for($i=0; $i<5; $i++) : ?>
                                        <span data-icon="star" data-size="16" fill="currentColor"></span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic">"Nhân viên tư vấn rất nhiệt tình, sản phẩm chính hãng từ Nhật. Rất đáng tin cậy!"</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($show_cta) : ?>
    <!-- CTA Section -->
    <section class="py-16" style="background-color: <?php echo esc_attr($primary_color); ?>">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-4">
                <?php echo esc_html($cta_title); ?>
            </h2>
            <p class="text-xl text-white opacity-90 mb-8 max-w-2xl mx-auto">
                <?php echo esc_html($cta_description); ?>
            </p>
            <a href="<?php echo esc_url($cta_button_link); ?>" class="inline-flex items-center px-8 py-4 bg-white text-primary font-semibold rounded-lg hover:bg-gray-100 transition-colors shadow-lg">
                <?php echo esc_html($cta_button_text); ?>
                <span data-icon="arrow-right" data-size="20" class="ml-2"></span>
            </a>
        </div>
    </section>
    <?php endif; ?>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('service-search');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const serviceCards = document.querySelectorAll('.service-card');

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            serviceCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const excerpt = card.querySelector('.text-gray-600').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            filterButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.style.backgroundColor = '';
                btn.style.color = '';
            });
            
            this.classList.add('active');
            if (this.dataset.filter === 'all') {
                this.style.backgroundColor = '<?php echo esc_js($primary_color); ?>';
                this.style.color = 'white';
            } else {
                this.style.backgroundColor = '';
                this.style.color = this.getAttribute('data-original-color') || '<?php echo esc_js($primary_color); ?>';
            }

            // Filter cards
            const filter = this.dataset.filter;
            
            serviceCards.forEach(card => {
                if (filter === 'all' || card.dataset.categories.includes(filter)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Initialize first button as active and store original colors
    filterButtons.forEach(button => {
        if (button.dataset.filter !== 'all') {
            button.setAttribute('data-original-color', button.style.color || window.getComputedStyle(button).color);
        }
    });
    
    if (filterButtons.length > 0) {
        filterButtons[0].style.backgroundColor = '<?php echo esc_js($primary_color); ?>';
        filterButtons[0].style.color = 'white';
    }
});
</script>

<?php get_footer(); ?>