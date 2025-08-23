<?php
/**
 * Template Name: Services Page
 *
 * Template for displaying company services
 *
 * @package ArataVietnam
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Get page meta fields
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_services_subtitle', true) ?: 'Giải pháp toàn diện cho doanh nghiệp';
$hero_intro = get_post_meta(get_the_ID(), 'arata_services_intro', true) ?: 'Chúng tôi cung cấp các dịch vụ chất lượng cao với đội ngũ chuyên nghiệp và kinh nghiệm nhiều năm trong lĩnh vực hóa mỹ phẩm Nhật Bản.';
$featured_text = get_post_meta(get_the_ID(), 'arata_services_featured_text', true) ?: 'Cam kết chất lượng - Uy tín hàng đầu';
$cta_text = get_post_meta(get_the_ID(), 'arata_services_cta_text', true) ?: 'Liên hệ tư vấn';
$cta_link = get_post_meta(get_the_ID(), 'arata_services_cta_link', true) ?: '/lien-he';

// Section visibility controls
$show_hero = get_post_meta(get_the_ID(), 'arata_show_hero', true) === '1';
$show_services = get_post_meta(get_the_ID(), 'arata_show_services', true) === '1';
$show_stats = get_post_meta(get_the_ID(), 'arata_show_stats', true) === '1';
$show_why_choose = get_post_meta(get_the_ID(), 'arata_show_why_choose', true) === '1';
$show_testimonials = get_post_meta(get_the_ID(), 'arata_show_testimonials', true) === '1';

// Statistics section fields
$stats_title = get_post_meta(get_the_ID(), 'arata_stats_title', true) ?: 'Thống kê ấn tượng';
$stats_subtitle = get_post_meta(get_the_ID(), 'arata_stats_subtitle', true) ?: 'Những con số thể hiện sự tin tưởng và hài lòng của khách hàng đối với dịch vụ của chúng tôi.';
$stats_customers = get_post_meta(get_the_ID(), 'arata_stats_customers', true) ?: '500';
$stats_projects = get_post_meta(get_the_ID(), 'arata_stats_projects', true) ?: '50';
$stats_years = get_post_meta(get_the_ID(), 'arata_stats_years', true) ?: '5';
$stats_success_rate = get_post_meta(get_the_ID(), 'arata_stats_success_rate', true) ?: '98';

// Why Choose Us section fields
$why_choose_title = get_post_meta(get_the_ID(), 'arata_why_choose_title', true) ?: 'Tại sao chọn Arata Vietnam?';
$why_choose_subtitle = get_post_meta(get_the_ID(), 'arata_why_choose_subtitle', true) ?: 'Chúng tôi cam kết mang đến những giá trị tốt nhất cho khách hàng thông qua chất lượng dịch vụ và sự tận tâm.';
$why_choose_quality_title = get_post_meta(get_the_ID(), 'arata_why_choose_quality_title', true) ?: 'Chất lượng hàng đầu';
$why_choose_quality_desc = get_post_meta(get_the_ID(), 'arata_why_choose_quality_desc', true) ?: 'Cam kết cung cấp dịch vụ chất lượng cao với tiêu chuẩn Nhật Bản.';
$why_choose_team_title = get_post_meta(get_the_ID(), 'arata_why_choose_team_title', true) ?: 'Đội ngũ chuyên nghiệp';
$why_choose_team_desc = get_post_meta(get_the_ID(), 'arata_why_choose_team_desc', true) ?: 'Đội ngũ nhân viên giàu kinh nghiệm, được đào tạo bài bản.';
$why_choose_service_title = get_post_meta(get_the_ID(), 'arata_why_choose_service_title', true) ?: 'Dịch vụ 24/7';
$why_choose_service_desc = get_post_meta(get_the_ID(), 'arata_why_choose_service_desc', true) ?: 'Hỗ trợ khách hàng mọi lúc, mọi nơi với tinh thần phục vụ tận tâm.';

// Testimonials section fields
$testimonials_title = get_post_meta(get_the_ID(), 'arata_testimonials_title', true) ?: 'Khách hàng nói gì về chúng tôi';
$testimonials_subtitle = get_post_meta(get_the_ID(), 'arata_testimonials_subtitle', true) ?: 'Những đánh giá chân thực từ khách hàng đã sử dụng dịch vụ của Arata Vietnam.';

// Set hero variables
set_query_var('title', get_the_title());
set_query_var('subtitle', $hero_subtitle);
set_query_var('description', $hero_intro);
if ($show_hero) {
    get_template_part('template-parts/hero');
}
?>

<main id="site-content" class="bg-white">

    <!-- Search and Filter Section -->
    <section class="py-8 bg-gray-50 border-b">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-6 items-center justify-between">
                <div class="flex-1">
                    <div class="relative max-w-md">
                        <input type="text" id="service-search" placeholder="Tìm kiếm dịch vụ..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <span data-icon="search" data-size="20" class="absolute left-3 top-2.5 text-gray-400"></span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <button class="filter-btn active px-4 py-2 rounded-lg bg-primary text-white font-medium hover:bg-primary/90 transition-colors" data-filter="all">
                        Tất cả
                    </button>
                    <?php
                    $service_categories = get_terms([
                        'taxonomy' => 'service_category',
                        'hide_empty' => true,
                        'parent' => 0
                    ]);

                    if ($service_categories && !is_wp_error($service_categories)) :
                        foreach ($service_categories as $category) : ?>
                            <button class="filter-btn px-4 py-2 rounded-lg bg-white border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors" data-filter="<?php echo esc_attr($category->slug); ?>">
                                <?php echo esc_html($category->name); ?>
                            </button>
                        <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Services Section -->
    <?php if ($show_services) : ?>
    <section class="py-16 bg-gradient-to-br from-secondary/5 to-primary/5 scroll-animate">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-1 bg-primary rounded-full mr-4"></div>
                    <span class="text-primary font-medium text-sm uppercase tracking-wider">Dịch vụ chính</span>
                    <div class="w-12 h-1 bg-primary rounded-full ml-4"></div>
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6"><?php echo esc_html($featured_text); ?></h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Chúng tôi tự hào mang đến những giải pháp tối ưu nhất cho khách hàng, đảm bảo chất lượng và hiệu quả trong mọi dự án.</p>
            </div>

            <!-- Services Grid -->
            <div id="services-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                <?php
                // Get featured services (active services with menu_order)
                $featured_services = new WP_Query([
                    'post_type' => 'service',
                    'posts_per_page' => 6,
                    'meta_query' => [
                        [
                            'key' => 'arata_service_status',
                            'value' => 'active',
                            'compare' => '='
                        ]
                    ],
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ]);

                if ($featured_services->have_posts()) :
                    while ($featured_services->have_posts()) : $featured_services->the_post();
                        $service_type = get_post_meta(get_the_ID(), 'arata_service_type', true);
                        $service_price = get_post_meta(get_the_ID(), 'arata_service_price', true);
                        $service_price_type = get_post_meta(get_the_ID(), 'arata_service_price_type', true);
                        $service_duration = get_post_meta(get_the_ID(), 'arata_service_duration', true);
                        $service_icon = get_post_meta(get_the_ID(), 'arata_service_icon', true) ?: 'settings';
                        $service_color = get_post_meta(get_the_ID(), 'arata_service_color', true) ?: 'primary';

                        // Get service categories for filtering
                        $service_cats = get_the_terms(get_the_ID(), 'service_category');
                        $category_slugs = '';
                        if ($service_cats && !is_wp_error($service_cats)) {
                            $category_slugs = implode(' ', array_map(function($cat) { return $cat->slug; }, $service_cats));
                        }

                        // Define color classes
                        $color_classes = [
                            'primary' => 'bg-primary text-white',
                            'secondary' => 'bg-secondary text-white',
                            'tertiary' => 'bg-tertiary text-white',
                            'success' => 'bg-success text-white',
                            'info' => 'bg-info text-white'
                        ];

                        $icon_color_classes = [
                            'primary' => 'text-primary',
                            'secondary' => 'text-secondary',
                            'tertiary' => 'text-tertiary',
                            'success' => 'text-success',
                            'info' => 'text-info'
                        ];

                        $border_color_classes = [
                            'primary' => 'border-primary hover:border-primary/80',
                            'secondary' => 'border-secondary hover:border-secondary/80',
                            'tertiary' => 'border-tertiary hover:border-tertiary/80',
                            'success' => 'border-success hover:border-success/80',
                            'info' => 'border-info hover:border-info/80'
                        ];

                        $current_color_class = $color_classes[$service_color] ?? $color_classes['primary'];
                        $current_icon_color = $icon_color_classes[$service_color] ?? $icon_color_classes['primary'];
                        $current_border_color = $border_color_classes[$service_color] ?? $border_color_classes['primary'];
                        ?>

                        <div class="service-card group bg-white rounded-xl border-2 border-gray-200 hover:shadow-xl transition-all duration-300 overflow-hidden <?php echo $current_border_color; ?>"
                             data-categories="<?php echo esc_attr($category_slugs); ?>"
                             data-title="<?php echo esc_attr(get_the_title()); ?>">

                            <!-- Service Featured Image -->
                            <?php if (has_post_thumbnail()) : ?>
                            <div class="w-full h-48 overflow-hidden">
                                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                            </div>
                            <?php endif; ?>

                            <!-- Service Header -->
                            <div class="p-6 border-b border-gray-100">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12 rounded-lg <?php echo $current_color_class; ?> flex items-center justify-center flex-shrink-0">
                                        <span data-icon="<?php echo esc_attr($service_icon); ?>" data-size="24" class="text-white"></span>
                                    </div>
                                    <div class="text-right">
                                        <?php if ($service_price_type === 'free') : ?>
                                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Miễn phí</span>
                                        <?php elseif ($service_price_type === 'contact') : ?>
                                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">Liên hệ</span>
                                        <?php elseif ($service_price) : ?>
                                            <span class="text-lg font-bold <?php echo $current_icon_color; ?>"><?php echo esc_html($service_price); ?></span>
                                        <?php else : ?>
                                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">Liên hệ</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:<?php echo $current_icon_color; ?> transition-colors">
                                    <a href="<?php the_permalink(); ?>" class="hover:underline"><?php the_title(); ?></a>
                                </h3>

                                <div class="text-sm text-gray-500 mb-3">
                                    <?php if ($service_duration) : ?>
                                        <span class="inline-flex items-center mr-4">
                                            <span data-icon="clock" data-size="16" class="mr-1"></span>
                                            <?php echo esc_html($service_duration); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($service_type) : ?>
                                        <span class="inline-flex items-center">
                                            <span data-icon="tag" data-size="16" class="mr-1"></span>
                                            <?php
                                            $type_labels = [
                                                'consultation' => 'Tư vấn',
                                                'implementation' => 'Triển khai',
                                                'maintenance' => 'Bảo trì',
                                                'support' => 'Hỗ trợ',
                                                'training' => 'Đào tạo',
                                                'custom' => 'Tùy chỉnh'
                                            ];
                                            echo esc_html($type_labels[$service_type] ?? $service_type);
                                            ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Service Content -->
                            <div class="p-6">
                                <div class="text-gray-600 mb-4 line-clamp-3">
                                    <?php
                                    $excerpt = get_the_excerpt();
                                    if (empty($excerpt)) {
                                        $excerpt = wp_trim_words(get_the_content(), 20, '...');
                                    }
                                    echo $excerpt;
                                    ?>
                                </div>

                                <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-sm font-medium <?php echo $current_icon_color; ?> hover:underline group-hover:scale-105 transition-transform">
                                    Xem chi tiết
                                    <span data-icon="arrow-right" data-size="16" class="ml-1 group-hover:translate-x-1 transition-transform"></span>
                                </a>
                            </div>
                        </div>

                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <div class="col-span-full text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span data-icon="package" data-size="32" class="text-gray-400"></span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có dịch vụ nào</h3>
                        <p class="text-gray-500">Vui lòng thêm các dịch vụ trong admin panel.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- CTA Button -->
            <div class="text-center">
                <a href="<?php echo esc_url($cta_link); ?>" class="inline-flex items-center px-8 py-4 bg-primary text-white font-semibold rounded-lg hover:bg-primary/90 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <span data-icon="phone" data-size="20" class="mr-2"></span>
                    <?php echo esc_html($cta_text); ?>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>


    <!-- Statistics Section -->
    <?php if ($show_stats) : ?>
    <section class="py-16 bg-gradient-to-r from-primary/5 to-secondary/5 scroll-animate">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6"><?php echo esc_html($stats_title); ?></h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto"><?php echo esc_html($stats_subtitle); ?></p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-primary mb-2" data-count="<?php echo esc_attr($stats_customers); ?>"><?php echo esc_html($stats_customers); ?></div>
                    <p class="text-gray-600 font-medium">+ Khách hàng hài lòng</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-secondary mb-2" data-count="<?php echo esc_attr($stats_projects); ?>"><?php echo esc_html($stats_projects); ?></div>
                    <p class="text-gray-600 font-medium">+ Dự án thành công</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-tertiary mb-2" data-count="<?php echo esc_attr($stats_years); ?>"><?php echo esc_html($stats_years); ?></div>
                    <p class="text-gray-600 font-medium">+ Năm kinh nghiệm</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-success mb-2" data-count="<?php echo esc_attr($stats_success_rate); ?>"><?php echo esc_html($stats_success_rate); ?></div>
                    <p class="text-gray-600 font-medium">% Tỷ lệ thành công</p>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Why Choose Us Section -->
    <?php if ($show_why_choose) : ?>
    <section class="py-16 bg-gray-50 scroll-animate">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6"><?php echo esc_html($why_choose_title); ?></h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto"><?php echo esc_html($why_choose_subtitle); ?></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span data-icon="award" data-size="32" class="text-primary"></span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3"><?php echo esc_html($why_choose_quality_title); ?></h3>
                    <p class="text-gray-600"><?php echo esc_html($why_choose_quality_desc); ?></p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span data-icon="users" data-size="32" class="text-secondary"></span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3"><?php echo esc_html($why_choose_team_title); ?></h3>
                    <p class="text-gray-600"><?php echo esc_html($why_choose_team_desc); ?></p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 bg-tertiary/10 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span data-icon="clock" data-size="32" class="text-tertiary"></span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3"><?php echo esc_html($why_choose_service_title); ?></h3>
                    <p class="text-gray-600"><?php echo esc_html($why_choose_service_desc); ?></p>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Testimonials Section -->
    <?php if ($show_testimonials) : ?>
    <section class="py-16 bg-white scroll-animate">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6"><?php echo esc_html($testimonials_title); ?></h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto"><?php echo esc_html($testimonials_subtitle); ?></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $testimonial_colors = ['primary', 'secondary', 'tertiary'];
                for ($i = 1; $i <= 3; $i++) {
                    $name = get_post_meta(get_the_ID(), 'arata_testimonial_' . $i . '_name', true) ?: 'Khách hàng ' . $i;
                    $position = get_post_meta(get_the_ID(), 'arata_testimonial_' . $i . '_position', true) ?: 'Chức vụ';
                    $content = get_post_meta(get_the_ID(), 'arata_testimonial_' . $i . '_content', true) ?: 'Nội dung đánh giá';
                    $color = $testimonial_colors[$i - 1];
                ?>
                <div class="bg-gray-50 p-6 rounded-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-<?php echo $color; ?>/10 rounded-full flex items-center justify-center mr-4">
                            <span data-icon="user" data-size="24" class="text-<?php echo $color; ?>"></span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900"><?php echo esc_html($name); ?></h4>
                            <p class="text-sm text-gray-600"><?php echo esc_html($position); ?></p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic">"<?php echo esc_html($content); ?>"</p>
                    <div class="flex text-yellow-400 mt-3">
                        <span data-icon="star" data-size="16"></span>
                        <span data-icon="star" data-size="16"></span>
                        <span data-icon="star" data-size="16"></span>
                        <span data-icon="star" data-size="16"></span>
                        <span data-icon="star" data-size="16"></span>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php endif; ?>


</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('service-search');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const serviceCards = document.querySelectorAll('.service-card');

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        serviceCards.forEach(card => {
            const title = card.dataset.title.toLowerCase();
            const categories = card.dataset.categories;

            if (title.includes(searchTerm) || categories.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Filter functionality
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active', 'bg-primary', 'text-white'));
            filterBtns.forEach(b => b.classList.add('bg-white', 'border', 'border-gray-300', 'text-gray-700'));

            // Add active class to clicked button
            this.classList.add('active', 'bg-primary', 'text-white');
            this.classList.remove('bg-white', 'border', 'border-gray-300', 'text-gray-700');

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

    // Animated counters
    const counters = document.querySelectorAll('[data-count]');

    const animateCounter = (counter) => {
        const target = parseInt(counter.dataset.count);
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60fps
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current);
        }, 16);
    };

    // Intersection Observer for counters
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
});
</script>

<?php get_footer(); ?>
