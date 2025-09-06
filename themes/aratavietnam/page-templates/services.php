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

// Get customizer color settings
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');

// Get page meta fields for hero customization
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_services_subtitle', true) ?: 'Dịch vụ';
$hero_intro = get_post_meta(get_the_ID(), 'arata_services_intro', true) ?: 'Chúng tôi cung cấp các dịch vụ chất lượng cao với đội ngũ chuyên nghiệp và kinh nghiệm nhiều năm trong lĩnh vực hóa mỹ phẩm Nhật Bản.';
$featured_text = get_post_meta(get_the_ID(), 'arata_services_featured_text', true) ?: 'Cam kết chất lượng - Uy tín hàng đầu';
$cta_text = get_post_meta(get_the_ID(), 'arata_services_cta_text', true) ?: 'Liên hệ tư vấn';
$cta_link = get_post_meta(get_the_ID(), 'arata_services_cta_link', true) ?: '/lien-he';

// Section visibility controls
$show_hero = get_post_meta(get_the_ID(), 'arata_show_hero', true) !== '0'; // Default to true if not set
$use_compact_hero = get_post_meta(get_the_ID(), 'arata_compact_hero', true) === '1'; // New compact option
$show_services = get_post_meta(get_the_ID(), 'arata_show_services', true) !== '0';

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

    <!-- Search and Filter Section -->
    <section class="py-8 bg-gray-50 border-b" style="background-color: <?php echo esc_attr($background_color); ?>">
        <div class="container mx-auto px-4">
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
                        foreach ($service_categories as $category) :
                            ?>
                            <button class="filter-btn px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors" data-filter="<?php echo esc_attr($category->slug); ?>">
                                <?php echo esc_html($category->name); ?>
                            </button>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Grid Section -->
    <?php if ($show_services) : ?>
    <section class="py-16" style="background-color: <?php echo esc_attr($background_color); ?>">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Dịch vụ của chúng tôi</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Khám phá các dịch vụ chuyên nghiệp được thiết kế để đáp ứng mọi nhu cầu của bạn</p>
            </div>

            <?php
            $services_query = new WP_Query([
                'post_type' => 'service',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ]);

            if ($services_query->have_posts()) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="services-grid">
                    <?php while ($services_query->have_posts()) : $services_query->the_post();
                        $service_type = get_post_meta(get_the_ID(), 'arata_service_type', true);
                        $service_price = get_post_meta(get_the_ID(), 'arata_service_price', true);
                        $service_icon = get_post_meta(get_the_ID(), 'arata_service_icon', true) ?: 'settings';
                        $service_color = get_post_meta(get_the_ID(), 'arata_service_color', true) ?: $primary_color;

                        // Get service categories for filtering
                        $service_cats = get_the_terms(get_the_ID(), 'service_category');
                        $cat_slugs = [];
                        if ($service_cats && !is_wp_error($service_cats)) {
                            foreach ($service_cats as $cat) {
                                $cat_slugs[] = $cat->slug;
                            }
                        }
                        ?>
                        <div class="service-card bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 overflow-hidden group"
                             data-title="<?php echo esc_attr(get_the_title()); ?>"
                             data-categories="<?php echo esc_attr(implode(' ', $cat_slugs)); ?>">

                            <!-- Service Image -->
                            <div class="relative overflow-hidden h-48">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                                <?php else : ?>
                                    <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, <?php echo esc_attr($service_color); ?>20, <?php echo esc_attr($service_color); ?>10);">
                                        <span data-icon="<?php echo esc_attr($service_icon); ?>" data-size="48" style="color: <?php echo esc_attr($service_color); ?>;"></span>
                                    </div>
                                <?php endif; ?>

                                <!-- Service Type Badge -->
                                <?php if ($service_type) : ?>
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-flex items-center px-3 py-1 text-white text-xs font-medium rounded-full" style="background-color: <?php echo esc_attr($service_color); ?>;">
                                            <?php
                                            $type_labels = [
                                                'consultation' => 'Tư vấn',
                                                'implementation' => 'Triển khai',
                                                'maintenance' => 'Bảo trì',
                                                'support' => 'Hỗ trợ',
                                                'training' => 'Đào tạo',
                                                'custom' => 'Tùy chỉnh'
                                            ];
                                            echo esc_html($type_labels[$service_type] ?? ucfirst($service_type));
                                            ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Service Content -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>

                                <div class="text-gray-600 mb-4 leading-relaxed">
                                    <?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 20, '...'); ?>
                                </div>

                                <div class="flex items-center justify-between">
                                    <?php if ($service_price) : ?>
                                        <div class="text-lg font-semibold" style="color: <?php echo esc_attr($service_color); ?>;">
                                            <?php echo esc_html($service_price); ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="text-lg font-semibold text-gray-500">
                                            Liên hệ
                                        </div>
                                    <?php endif; ?>

                                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm group-hover:translate-x-1 transition-all duration-300">
                                        Chi tiết
                                        <span data-icon="arrow-right" data-size="16" class="ml-1"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="text-center py-16">
                    <div class="text-gray-400 mb-4">
                        <span data-icon="settings" data-size="64"></span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Chưa có dịch vụ nào</h3>
                    <p class="text-gray-600">Các dịch vụ sẽ được cập nhật sớm nhất có thể.</p>
                </div>
            <?php endif; ?>

            <!-- Featured Text -->
            <?php if (!empty($featured_text)) : ?>
                <div class="text-center mt-16">
                    <div class="inline-flex items-center px-6 py-3 rounded-full border-2" style="border-color: <?php echo esc_attr($primary_color); ?>; color: <?php echo esc_attr($primary_color); ?>;">
                        <span data-icon="star" data-size="20" class="mr-2"></span>
                        <span class="font-semibold"><?php echo esc_html($featured_text); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- CTA Button -->
            <div class="text-center">
                <a href="<?php echo esc_url($cta_link); ?>" class="inline-flex items-center px-8 py-4 text-white font-semibold rounded-lg hover:opacity-90 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300" style="background-color: <?php echo esc_attr($primary_color); ?>">
                    <span data-icon="phone" data-size="20" class="mr-2"></span>
                    <?php echo esc_html($cta_text); ?>
                </a>
            </div>
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
            filterServices(searchTerm, getActiveFilter());
        });
    }

    // Filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            filterButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.style.backgroundColor = '';
                btn.style.color = '';
                btn.classList.add('bg-white', 'border', 'border-gray-300', 'text-gray-700');
            });

            this.classList.add('active');
            this.style.backgroundColor = '<?php echo esc_js($primary_color); ?>';
            this.style.color = 'white';
            this.classList.remove('bg-white', 'border', 'border-gray-300', 'text-gray-700');

            const filter = this.getAttribute('data-filter');
            const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
            filterServices(searchTerm, filter);
        });
    });

    function getActiveFilter() {
        const activeButton = document.querySelector('.filter-btn.active');
        return activeButton ? activeButton.getAttribute('data-filter') : 'all';
    }

    function filterServices(searchTerm, filter) {
        serviceCards.forEach(card => {
            const title = card.getAttribute('data-title').toLowerCase();
            const categories = card.getAttribute('data-categories');

            const matchesSearch = !searchTerm || title.includes(searchTerm);
            const matchesFilter = filter === 'all' || categories.includes(filter);

            if (matchesSearch && matchesFilter) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
});
</script>

<?php get_footer(); ?>
