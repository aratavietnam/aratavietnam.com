<?php
/**
 * Template part for displaying single service posts
 *
 * @package ArataVietnam
 */

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
$service_color = get_post_meta(get_the_ID(), 'arata_service_color', true) ?: 'primary';

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

$color_classes = [
    'primary' => 'text-primary border-primary',
    'secondary' => 'text-secondary border-secondary',
    'tertiary' => 'text-tertiary border-tertiary',
    'success' => 'text-success border-success',
    'info' => 'text-info border-info'
];
$current_color_class = $color_classes[$service_color] ?? $color_classes['primary'];
?>

<div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-x-12">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white p-6 md:p-8 rounded-lg border border-gray-200'); ?>>
            <header class="entry-header mb-6">
                <?php the_title('<h1 class="entry-title text-3xl md:text-4xl font-bold text-gray-900">', '</h1>'); ?>
                <?php if (!empty($service_categories) && !is_wp_error($service_categories)) : ?>
                    <div class="text-secondary text-lg font-semibold mt-2">
                        <?php echo esc_html($service_categories[0]->name); ?>
                    </div>
                <?php endif; ?>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                    <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover']); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content prose max-w-none border-t border-gray-200 pt-6">
                <?php the_content(); ?>

                <?php if ($service_features) : ?>
                    <h3 class="font-bold text-xl mt-8 mb-4">Tính năng chính</h3>
                    <div class="prose-sm text-gray-700"><?php echo wpautop(esc_html($service_features)); ?></div>
                <?php endif; ?>

                <?php if ($service_benefits) : ?>
                    <h3 class="font-bold text-xl mt-8 mb-4">Lợi ích khách hàng</h3>
                    <div class="prose-sm text-gray-700"><?php echo wpautop(esc_html($service_benefits)); ?></div>
                <?php endif; ?>

                <?php if ($service_process) : ?>
                    <h3 class="font-bold text-xl mt-8 mb-4">Quy trình thực hiện</h3>
                    <div class="prose-sm text-gray-700"><?php echo wpautop(esc_html($service_process)); ?></div>
                <?php endif; ?>

                <?php if ($service_requirements) : ?>
                    <h3 class="font-bold text-xl mt-8 mb-4">Yêu cầu cần thiết</h3>
                    <div class="prose-sm text-gray-700"><?php echo wpautop(esc_html($service_requirements)); ?></div>
                <?php endif; ?>

                <?php if ($service_deliverables) : ?>
                    <h3 class="font-bold text-xl mt-8 mb-4">Sản phẩm đầu ra</h3>
                    <div class="prose-sm text-gray-700"><?php echo wpautop(esc_html($service_deliverables)); ?></div>
                <?php endif; ?>
            </div>
        </article>
    </div>

    <!-- Sidebar -->
    <aside class="lg:col-span-1 mt-12 lg:mt-0">
        <div class="sticky top-24">
            <div class="bg-white p-6 rounded-lg border border-gray-200 mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Thông tin dịch vụ</h3>
                <ul class="space-y-3 text-sm">
                    <?php if ($service_type && isset($type_labels[$service_type])) : ?>
                        <li class="flex justify-between"><strong>Loại hình:</strong><span class="text-right"><?php echo esc_html($type_labels[$service_type]); ?></span></li>
                    <?php endif; ?>
                    <?php if ($service_duration) : ?>
                        <li class="flex justify-between"><strong>Thời gian:</strong><span class="text-right"><?php echo esc_html($service_duration); ?></span></li>
                    <?php endif; ?>
                    <?php if ($service_price_type) : ?>
                        <li class="flex justify-between"><strong>Chi phí:</strong>
                            <span class="text-right font-medium <?php echo $current_color_class; ?>">
                                <?php
                                if ($service_price_type === 'free') {
                                    echo 'Miễn phí';
                                } elseif ($service_price_type === 'contact') {
                                    echo 'Liên hệ';
                                } else {
                                    echo esc_html($service_price);
                                }
                                ?>
                            </span>
                        </li>
                    <?php endif; ?>
                    <?php if ($service_status && isset($status_labels[$service_status])) : ?>
                        <li class="flex justify-between"><strong>Trạng thái:</strong><span class="text-right font-medium text-green-600"><?php echo esc_html($status_labels[$service_status]); ?></span></li>
                    <?php endif; ?>
                    <?php if (!empty($service_categories) && !is_wp_error($service_categories)) : ?>
                        <li class="flex justify-between"><strong>Danh mục:</strong>
                            <span class="text-right">
                                <?php
                                $cat_links = [];
                                foreach ($service_categories as $cat) {
                                    $cat_links[] = '<a href="' . esc_url(get_term_link($cat)) . '" class="hover:underline">' . esc_html($cat->name) . '</a>';
                                }
                                echo implode(', ', $cat_links);
                                ?>
                            </span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="bg-white p-6 rounded-lg border border-gray-200">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Yêu cầu tư vấn</h3>
                <p class="text-sm text-gray-600 mb-4">Để lại thông tin của bạn, chúng tôi sẽ liên hệ lại ngay để tư vấn chi tiết về dịch vụ này.</p>
                <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="w-full inline-block text-center bg-secondary text-white py-3 rounded-lg hover:bg-secondary-dark transition-colors font-medium">
                    Liên hệ ngay
                </a>
            </div>
        </div>
    </aside>
</div>
