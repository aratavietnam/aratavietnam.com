<?php
/**
 * Template part for displaying single service posts
 *
 * @package ArataVietnam
 */

// Get customizer color settings
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');

// Get all meta fields for the service
$service_type = get_post_meta(get_the_ID(), 'arata_service_type', true);
$service_price = get_post_meta(get_the_ID(), 'arata_service_price', true);
$service_price_type = get_post_meta(get_the_ID(), 'arata_service_price_type', true);
$service_duration = get_post_meta(get_the_ID(), 'arata_service_duration', true);
$service_features = get_post_meta(get_the_ID(), 'arata_service_features', true);
$service_benefits = get_post_meta(get_the_ID(), 'arata_service_benefits', true);
$service_process = get_post_meta(get_the_ID(), 'arata_service_process', true);
$service_requirements = get_post_meta(get_the_ID(), 'arata_service_requirements', true);
$service_deliverables = get_post_meta(get_the_ID(), 'arata_service_deliverables', true);
$service_status = get_post_meta(get_the_ID(), 'arata_service_status', true);
$service_icon = get_post_meta(get_the_ID(), 'arata_service_icon', true) ?: 'settings';
$service_color = get_post_meta(get_the_ID(), 'arata_service_color', true) ?: $primary_color;

// Get service categories
$service_categories = get_the_terms(get_the_ID(), 'service_category');

// Labels for meta fields
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

$price_type_labels = [
    'fixed' => 'Giá cố định',
    'hourly' => 'Theo giờ',
    'project' => 'Theo dự án',
    'free' => 'Miễn phí',
    'contact' => 'Liên hệ báo giá'
];

// Determine color based on service type or category
$color_value = $service_color;
if ($service_type && !$service_color) {
    // Map service types to theme colors (simplified system)
    $type_colors = [
        'consultation' => $primary_color,
        'implementation' => $secondary_color,
        'maintenance' => $tertiary_color,
        'support' => $primary_color,
        'training' => $secondary_color,
        'custom' => $tertiary_color
    ];
    $color_value = $type_colors[$service_type] ?? $primary_color;
}
?>

<!-- Breadcrumb -->
<section class="mb-8" style="background-color: <?php echo esc_attr($background_color); ?>">
    <div class="container mx-auto px-4">
        <div class="py-1 overflow-x-auto whitespace-nowrap">
            <nav class="text-sm text-gray-600">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary">Trang chủ</a>
                <span class="text-gray-400 mx-2">/</span>
                <a href="<?php echo home_url('/dich-vu'); ?>" class="hover:text-primary">Dịch vụ</a>
                <span class="text-gray-400 mx-2">/</span>
                <span class="text-gray-700"><?php the_title(); ?></span>
            </nav>
        </div>
    </div>
</section>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <!-- Service Header Card -->
        <div class="rounded-xl border border-gray-200 overflow-hidden mb-8" data-service-type="<?php echo esc_attr($service_type); ?>" style="background-color: <?php echo esc_attr($background_color); ?>;">
            <!-- Header with solid color -->
            <div class="p-8" style="background-color: <?php echo esc_attr($color_value); ?>;">
                <h1 class="text-3xl font-bold mb-4 text-black"><?php the_title(); ?></h1>
                <?php if (!empty($service_categories) && !is_wp_error($service_categories)) : ?>
                    <div class="text-lg text-gray-700">
                        <?php echo esc_html($service_categories[0]->name); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="p-8">
                <!-- Featured Image -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="aspect-w-16 aspect-h-9 overflow-hidden rounded-lg mb-8">
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-96 object-cover']); ?>
                    </div>
                <?php endif; ?>

                <!-- Service Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <?php if ($service_duration) : ?>
                        <div class="flex items-center p-4 rounded-lg" style="background-color: <?php echo esc_attr($background_color); ?>;">
                            <span data-icon="clock" data-size="20" class="mr-3" style="color: <?php echo esc_attr($color_value); ?>;"></span>
                            <div>
                                <p class="text-sm text-gray-600">Thời gian</p>
                                <p class="font-medium"><?php echo esc_html($service_duration); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($service_price) : ?>
                        <div class="flex items-center p-4 rounded-lg" style="background-color: <?php echo esc_attr($background_color); ?>;">
                            <span data-icon="dollar-sign" data-size="20" class="mr-3 text-green-600"></span>
                            <div>
                                <p class="text-sm text-gray-600">Chi phí</p>
                                <p class="font-medium text-green-600"><?php echo esc_html($service_price); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Content -->
                <div class="prose prose-lg max-w-none">
                    <?php the_content(); ?>
                </div>

                <!-- Service Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <?php if ($service_features) : ?>
                        <div class="p-6 rounded-xl border" style="background-color: <?php echo esc_attr($background_color); ?>;">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                <span data-icon="check-circle" data-size="20" class="mr-2" style="color: <?php echo esc_attr($color_value); ?>;"></span>
                                Tính năng chính
                            </h3>
                            <div class="text-gray-700"><?php echo wp_kses_post(wpautop($service_features)); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($service_benefits) : ?>
                        <div class="p-6 rounded-xl border" style="background-color: <?php echo esc_attr($background_color); ?>;">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                <span data-icon="heart" data-size="20" class="mr-2" style="color: <?php echo esc_attr($color_value); ?>;"></span>
                                Lợi ích khách hàng
                            </h3>
                            <div class="text-gray-700"><?php echo wp_kses_post(wpautop($service_benefits)); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($service_process) : ?>
                        <div class="p-6 rounded-xl border" style="background-color: <?php echo esc_attr($background_color); ?>;">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                <span data-icon="git-branch" data-size="20" class="mr-2" style="color: <?php echo esc_attr($color_value); ?>;"></span>
                                Quy trình thực hiện
                            </h3>
                            <div class="text-gray-700"><?php echo wp_kses_post(wpautop($service_process)); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($service_requirements) : ?>
                        <div class="p-6 rounded-xl border" style="background-color: <?php echo esc_attr($background_color); ?>;">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                <span data-icon="alert-circle" data-size="20" class="mr-2" style="color: <?php echo esc_attr($color_value); ?>;"></span>
                                Yêu cầu cần thiết
                            </h3>
                            <div class="text-gray-700"><?php echo wp_kses_post(wpautop($service_requirements)); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Related Services -->
        <div class="rounded-xl p-8" style="background-color: <?php echo esc_attr($background_color); ?>;">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Dịch vụ liên quan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php
                $related_services = new WP_Query([
                    'post_type' => 'service',
                    'posts_per_page' => 4,
                    'post__not_in' => [get_the_ID()],
                    'tax_query' => [
                        [
                            'taxonomy' => 'service_category',
                            'field' => 'term_id',
                            'terms' => $service_categories ? wp_list_pluck($service_categories, 'term_id') : [],
                            'operator' => 'IN'
                        ]
                    ]
                ]);

                if ($related_services->have_posts()) :
                    while ($related_services->have_posts()) : $related_services->the_post();
                        $related_service_icon = get_post_meta(get_the_ID(), 'arata_service_icon', true) ?: 'settings';
                        $related_service_type = get_post_meta(get_the_ID(), 'arata_service_type', true);
                        $related_service_price = get_post_meta(get_the_ID(), 'arata_service_price', true);
                        $related_service_color = get_post_meta(get_the_ID(), 'arata_service_color', true) ?: $primary_color;
                        ?>
                        <div class="rounded-lg p-6 border" style="background-color: <?php echo esc_attr($background_color); ?>;">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3" style="background-color: <?php echo esc_attr($related_service_color); ?>20;">
                                    <span data-icon="<?php echo esc_attr($related_service_icon); ?>" data-size="20" style="color: <?php echo esc_attr($related_service_color); ?>;"></span>
                                </div>
                                <h4 class="font-semibold text-gray-900">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors"><?php the_title(); ?></a>
                                </h4>
                            </div>
                            <?php if ($related_service_price) : ?>
                                <p class="text-sm font-medium text-green-600"><?php echo esc_html($related_service_price); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p class="text-gray-500 col-span-2 text-center">Không có dịch vụ liên quan.</p>';
                endif;
                ?>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <aside class="lg:col-span-1">
        <div class="sticky top-24 space-y-6">
            <!-- Service Details Card -->
            <div class="rounded-xl p-6 border" style="background-color: <?php echo esc_attr($background_color); ?>;">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <span data-icon="info" data-size="20" class="mr-2" style="color: <?php echo esc_attr($color_value); ?>;"></span>
                    Thông tin dịch vụ
                </h3>

                <div class="space-y-4">
                    <?php if ($service_type) : ?>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Loại hình:</span>
                            <span class="font-bold" style="color: <?php echo esc_attr($color_value); ?>;"><?php echo esc_html($type_labels[$service_type]); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($service_duration) : ?>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Thời gian:</span>
                            <span class="font-medium"><?php echo esc_html($service_duration); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($service_price) : ?>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Chi phí:</span>
                            <span class="font-medium text-green-600"><?php echo esc_html($service_price); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($service_status && isset($status_labels[$service_status])) : ?>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Trạng thái:</span>
                            <span class="font-medium <?php echo $service_status === 'active' ? 'text-green-600' : 'text-orange-600'; ?>">
                                <?php echo esc_html($status_labels[$service_status]); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- CTA Button -->
                <div class="mt-6">
                    <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="block w-full py-3 rounded-lg font-medium transition-all duration-300 text-center" style="background-color: <?php echo esc_attr($color_value); ?>; color: white;">
                        Yêu cầu tư vấn
                    </a>
                </div>
            </div>

            <!-- Quick Contact -->
            <div class="rounded-xl p-6 border" style="background-color: <?php echo esc_attr($background_color); ?>;">
                <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                    <span data-icon="phone" data-size="20" class="mr-2" style="color: <?php echo esc_attr($primary_color); ?>;"></span>
                    Liên hệ nhanh
                </h3>
                <p class="text-sm text-gray-600 mb-4">Gọi ngay để được tư vấn miễn phí</p>
                <div class="space-y-2">
                    <a href="tel:<?php echo esc_attr(get_theme_mod('footer_company_phone_link', '+842838277060')); ?>" class="flex items-center text-primary hover:text-primary-dark font-medium">
                        <span data-icon="phone" data-size="16" class="mr-2"></span>
                        <?php echo esc_html(get_theme_mod('footer_company_phone', '+84 28 3827 7060')); ?>
                    </a>
                    <a href="mailto:<?php echo esc_attr(get_theme_mod('footer_company_email', 'arata-vietnam@arata-gr.jp')); ?>" class="flex items-center text-primary hover:text-primary-dark font-medium">
                        <span data-icon="mail" data-size="16" class="mr-2"></span>
                        <?php echo esc_html(get_theme_mod('footer_company_email', 'arata-vietnam@arata-gr.jp')); ?>
                    </a>
                </div>
            </div>
        </div>
    </aside>
</div>
