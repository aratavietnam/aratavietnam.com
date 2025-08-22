<?php
/**
 * Single service template
 *
 * @package ArataVietnam
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Get service meta fields
$service_type = get_post_meta(get_the_ID(), 'arata_service_type', true);
$service_price = get_post_meta(get_the_ID(), 'arata_service_price', true);
$service_price_type = get_post_meta(get_the_ID(), 'arata_service_price_type', true);
$service_duration = get_post_meta(get_the_ID(), 'arata_service_duration', true);
$service_status = get_post_meta(get_the_ID(), 'arata_service_status', true);
$service_icon = get_post_meta(get_the_ID(), 'arata_service_icon', true) ?: 'settings';
$service_color = get_post_meta(get_the_ID(), 'arata_service_color', true) ?: 'primary';
$service_features = get_post_meta(get_the_ID(), 'arata_service_features', true);
$service_benefits = get_post_meta(get_the_ID(), 'arata_service_benefits', true);
$service_process = get_post_meta(get_the_ID(), 'arata_service_process', true);
$service_requirements = get_post_meta(get_the_ID(), 'arata_service_requirements', true);
$service_deliverables = get_post_meta(get_the_ID(), 'arata_service_deliverables', true);

// Define labels and color classes
$type_labels = [
    'consultation' => 'Tư vấn',
    'implementation' => 'Triển khai',
    'maintenance' => 'Bảo trì',
    'support' => 'Hỗ trợ',
    'training' => 'Đào tạo',
    'custom' => 'Tùy chỉnh'
];

$status_labels = [
    'active' => 'Hoạt động',
    'inactive' => 'Tạm ngưng',
    'coming_soon' => 'Sắp ra mắt',
    'deprecated' => 'Ngừng cung cấp'
];

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

$current_color_class = $color_classes[$service_color] ?? $color_classes['primary'];
$current_icon_color = $icon_color_classes[$service_color] ?? $icon_color_classes['primary'];
?>

<main id="site-content" class="bg-white">

    <!-- Service Hero Section -->
    <section class="py-16 bg-gradient-to-br from-secondary/5 to-primary/5">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="flex items-center text-sm text-gray-500 mb-8">
                    <a href="/" class="hover:text-primary transition-colors">Trang chủ</a>
                    <span data-icon="chevron-right" data-size="16" class="mx-2"></span>
                    <a href="/dich-vu" class="hover:text-primary transition-colors">Dịch vụ</a>
                    <span data-icon="chevron-right" data-size="16" class="mx-2"></span>
                    <span class="text-gray-900"><?php the_title(); ?></span>
                </nav>

                <!-- Service Header -->
                <div class="text-center mb-12">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl <?php echo $current_color_class; ?> flex items-center justify-center">
                        <span data-icon="<?php echo esc_attr($service_icon); ?>" data-size="40" class="text-white"></span>
                    </div>

                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6"><?php the_title(); ?></h1>

                    <?php if (get_the_excerpt()) : ?>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8"><?php echo get_the_excerpt(); ?></p>
                    <?php endif; ?>

                    <!-- Service Meta -->
                    <div class="flex flex-wrap items-center justify-center gap-4 mb-8">
                        <?php if ($service_type) : ?>
                            <span class="inline-flex items-center px-4 py-2 bg-white rounded-full border border-gray-200 text-sm font-medium text-gray-700">
                                <span data-icon="tag" data-size="16" class="mr-2 <?php echo $current_icon_color; ?>"></span>
                                <?php echo esc_html($type_labels[$service_type] ?? $service_type); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ($service_duration) : ?>
                            <span class="inline-flex items-center px-4 py-2 bg-white rounded-full border border-gray-200 text-sm font-medium text-gray-700">
                                <span data-icon="clock" data-size="16" class="mr-2 <?php echo $current_icon_color; ?>"></span>
                                <?php echo esc_html($service_duration); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ($service_status) : ?>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                                <?php
                                if ($service_status === 'active') echo 'bg-green-100 text-green-800';
                                elseif ($service_status === 'coming_soon') echo 'bg-orange-100 text-orange-800';
                                elseif ($service_status === 'inactive') echo 'bg-gray-100 text-gray-800';
                                else echo 'bg-red-100 text-red-800';
                                ?>">
                                <span data-icon="circle" data-size="12" class="mr-2"></span>
                                <?php echo esc_html($status_labels[$service_status]); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Price Display -->
                    <?php if ($service_price || $service_price_type) : ?>
                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 inline-block">
                            <div class="text-center">
                                <?php if ($service_price_type === 'free') : ?>
                                    <div class="text-3xl font-bold text-green-600 mb-2">Miễn phí</div>
                                    <p class="text-gray-600">Không mất phí dịch vụ</p>
                                <?php elseif ($service_price_type === 'contact') : ?>
                                    <div class="text-3xl font-bold text-blue-600 mb-2">Liên hệ</div>
                                    <p class="text-gray-600">Báo giá theo yêu cầu</p>
                                <?php elseif ($service_price) : ?>
                                    <div class="text-3xl font-bold <?php echo $current_icon_color; ?> mb-2"><?php echo esc_html($service_price); ?></div>
                                    <p class="text-gray-600">
                                        <?php
                                        if ($service_price_type === 'hourly') echo 'Theo giờ';
                                        elseif ($service_price_type === 'project') echo 'Theo dự án';
                                        else echo 'Giá cố định';
                                        ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Content -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <!-- Service Description -->
                        <div class="prose prose-lg max-w-none mb-12">
                            <?php the_content(); ?>
                        </div>

                        <!-- Service Features -->
                        <?php if ($service_features) : ?>
                            <div class="bg-gray-50 rounded-2xl p-8 mb-12">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                                    <span data-icon="check-circle" data-size="24" class="mr-3 <?php echo $current_icon_color; ?>"></span>
                                    Tính năng chính
                                </h2>
                                <div class="prose prose-gray max-w-none">
                                    <?php echo wpautop($service_features); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Service Benefits -->
                        <?php if ($service_benefits) : ?>
                            <div class="bg-gradient-to-r from-primary/5 to-secondary/5 rounded-2xl p-8 mb-12">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                                    <span data-icon="star" data-size="24" class="mr-3 <?php echo $current_icon_color; ?>"></span>
                                    Lợi ích
                                </h2>
                                <div class="prose prose-gray max-w-none">
                                    <?php echo wpautop($service_benefits); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Service Process -->
                        <?php if ($service_process) : ?>
                            <div class="bg-white border border-gray-200 rounded-2xl p-8 mb-12">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                                    <span data-icon="list-ordered" data-size="24" class="mr-3 <?php echo $current_icon_color; ?>"></span>
                                    Quy trình thực hiện
                                </h2>
                                <div class="prose prose-gray max-w-none">
                                    <?php echo wpautop($service_process); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <!-- Service Requirements -->
                        <?php if ($service_requirements) : ?>
                            <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6 sticky top-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <span data-icon="clipboard-list" data-size="20" class="mr-2 <?php echo $current_icon_color; ?>"></span>
                                    Yêu cầu khách hàng
                                </h3>
                                <div class="prose prose-sm prose-gray max-w-none">
                                    <?php echo wpautop($service_requirements); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Service Deliverables -->
                        <?php if ($service_deliverables) : ?>
                            <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <span data-icon="package" data-size="20" class="mr-2 <?php echo $current_icon_color; ?>"></span>
                                    Sản phẩm đầu ra
                                </h3>
                                <div class="prose prose-sm prose-gray max-w-none">
                                    <?php echo wpautop($service_deliverables); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- CTA Section -->
                        <div class="bg-gradient-to-br from-primary to-secondary rounded-2xl p-6 text-center text-white">
                            <h3 class="text-lg font-semibold mb-3">Sẵn sàng tư vấn</h3>
                            <p class="text-sm opacity-90 mb-4">Hãy để chúng tôi giúp bạn hiểu rõ hơn về dịch vụ này</p>
                            <a href="/lien-he" class="inline-flex items-center px-6 py-3 bg-white text-primary font-semibold rounded-lg hover:bg-gray-50 transition-colors shadow-lg">
                                <span data-icon="phone" data-size="18" class="mr-2"></span>
                                Liên hệ ngay
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Services -->
    <?php
    $related_services = new WP_Query([
        'post_type' => 'service',
        'posts_per_page' => 3,
        'post__not_in' => [get_the_ID()],
        'meta_query' => [
            [
                'key' => 'arata_service_status',
                'value' => 'active',
                'compare' => '='
            ]
        ],
        'orderby' => 'rand'
    ]);

    if ($related_services->have_posts()) : ?>
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Dịch vụ liên quan</h2>
                    <p class="text-lg text-gray-600">Khám phá thêm các dịch vụ khác của chúng tôi</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php while ($related_services->have_posts()) : $related_services->the_post(); ?>
                        <div class="bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 overflow-hidden">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="aspect-video overflow-hidden">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors"><?php the_title(); ?></a>
                                </h3>
                                <p class="text-gray-600 mb-4 line-clamp-2"><?php echo get_the_excerpt(); ?></p>
                                <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-sm font-medium text-primary hover:underline">
                                    Xem chi tiết
                                    <span data-icon="arrow-right" data-size="16" class="ml-1"></span>
                                </a>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
