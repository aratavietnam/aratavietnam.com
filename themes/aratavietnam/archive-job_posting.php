<?php
/**
 * Archive template for job_posting custom post type
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Get global colors
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');

// Hero
$hero_title = 'Tuyển dụng';
$hero_subtitle = 'Cơ hội nghề nghiệp tại Arata Vietnam'; // Default subtitle
$hero_description = ''; // Default description

// Find the Careers settings page to get the hero settings
$careers_page = get_pages(['meta_key' => '_wp_page_template', 'meta_value' => 'page-templates/careers.php', 'number' => 1]);
if (!empty($careers_page)) {
    $careers_page_id = $careers_page[0]->ID;

    $saved_subtitle = get_post_meta($careers_page_id, 'arata_careers_subtitle', true);
    if (!empty($saved_subtitle)) {
        $hero_subtitle = $saved_subtitle;
    }

    $saved_description = get_post_meta($careers_page_id, 'arata_careers_intro', true);
    if (!empty($saved_description)) {
        $hero_description = $saved_description;
    }
}

set_query_var('title', $hero_title);
set_query_var('subtitle', $hero_subtitle);
set_query_var('description', $hero_description);
get_template_part('template-parts/hero');
?>

<main id="site-content" class="bg-white">
    <?php
    $archive_description = get_the_archive_description();
    if ($archive_description) :
    ?>
    <!-- Page Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="prose max-w-none mb-12">
            <?php echo $archive_description; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Careers Section -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-1 rounded-full mr-4" style="background-color: <?php echo esc_attr($primary_color); ?>;"></div>
                    <span class="font-medium text-sm uppercase tracking-wider" style="color: <?php echo esc_attr($primary_color); ?>;">Cơ hội nghề nghiệp</span>
                    <div class="w-12 h-1 rounded-full ml-4" style="background-color: <?php echo esc_attr($primary_color); ?>;"></div>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Vị trí tuyển dụng hiện tại</h2>
            </div>

            <!-- Job Listings -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        // Get meta fields from news-meta-fields.php
                        $department = get_post_meta(get_the_ID(), 'arata_job_department', true);
                        $location = get_post_meta(get_the_ID(), 'arata_job_location', true);
                        $job_type = get_post_meta(get_the_ID(), 'arata_job_type', true);
                        $level = get_post_meta(get_the_ID(), 'arata_job_level', true);
                        $salary = get_post_meta(get_the_ID(), 'arata_job_salary', true);
                        $deadline = get_post_meta(get_the_ID(), 'arata_job_deadline', true);
                        $requirements = get_post_meta(get_the_ID(), 'arata_job_requirements', true);
                        $benefits = get_post_meta(get_the_ID(), 'arata_job_benefits', true);
                        $contact = get_post_meta(get_the_ID(), 'arata_job_contact', true);

                        $type_labels = [
                            'full_time' => 'Toàn thời gian',
                            'part_time' => 'Bán thời gian',
                            'contract' => 'Hợp đồng',
                            'internship' => 'Thực tập',
                            'freelance' => 'Freelance'
                        ];

                        $level_labels = [
                            'intern' => 'Thực tập sinh',
                            'fresher' => 'Nhân viên mới',
                            'junior' => 'Nhân viên',
                            'senior' => 'Nhân viên cao cấp',
                            'lead' => 'Trưởng nhóm',
                            'manager' => 'Quản lý',
                            'director' => 'Giám đốc'
                        ];
                        ?>
                        <div class="bg-white rounded-lg border border-gray-200 transition-colors duration-300 flex flex-col" style="border-color: #E5E7EB;" onmouseover="this.style.borderColor='<?php echo esc_attr($secondary_color); ?>'" onmouseout="this.style.borderColor='#E5E7EB'">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>" class="block aspect-video">
                                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                                </a>
                            <?php else : ?>
                                <div class="aspect-video bg-gray-100 flex items-center justify-center">
                                    <span data-icon="briefcase" data-size="32" class="text-gray-400"></span>
                                </div>
                            <?php endif; ?>

                            <div class="p-6 flex-grow flex flex-col">
                                <div class="mb-4">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                        <a href="<?php the_permalink(); ?>" class="transition-colors" style="color: inherit;" onmouseover="this.style.color='<?php echo esc_attr($secondary_color); ?>'" onmouseout="this.style.color='inherit'">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    <?php if ($department): ?>
                                        <p class="font-medium text-sm mb-1" style="color: <?php echo esc_attr($secondary_color); ?>;"><?php echo esc_html($department); ?></p>
                                    <?php endif; ?>
                                </div>

                                <div class="space-y-3 mb-6">
                                    <?php if ($location): ?>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span data-icon="map-pin" data-size="16" class="text-gray-400 mr-2"></span>
                                            <?php echo esc_html($location); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($job_type && isset($type_labels[$job_type])): ?>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span data-icon="clock" data-size="16" class="text-gray-400 mr-2"></span>
                                            <?php echo esc_html($type_labels[$job_type]); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($level && isset($level_labels[$level])): ?>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span data-icon="user" data-size="16" class="text-gray-400 mr-2"></span>
                                            <?php echo esc_html($level_labels[$level]); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($salary): ?>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span data-icon="dollar-sign" data-size="16" class="text-gray-400 mr-2"></span>
                                            <?php echo esc_html($salary); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($deadline): ?>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span data-icon="calendar" data-size="16" class="text-gray-400 mr-2"></span>
                                            Hạn nộp: <?php echo date('d/m/Y', strtotime($deadline)); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if ($requirements): ?>
                                    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                        <h4 class="font-semibold text-blue-800 mb-2 text-sm">Yêu cầu:</h4>
                                        <p class="text-xs text-blue-700 line-clamp-3"><?php echo esc_html($requirements); ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php if ($benefits): ?>
                                    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                                        <h4 class="font-semibold text-green-800 mb-2 text-sm">Quyền lợi:</h4>
                                        <p class="text-xs text-green-700 line-clamp-3"><?php echo esc_html($benefits); ?></p>
                                    </div>
                                <?php endif; ?>

                                <div class="pt-4 border-t border-gray-200 mt-auto">
                                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center font-medium text-sm transition-colors" style="color: <?php echo esc_attr($secondary_color); ?>;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                        Xem chi tiết
                                        <span data-icon="arrow-right" data-size="16" class="ml-1"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                else:
                    ?>
                    <div class="lg:col-span-3 text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span data-icon="briefcase" data-size="32" class="text-gray-400"></span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Hiện tại chưa có vị trí tuyển dụng nào</h3>
                        <p class="text-gray-600 mb-6">Chúng tôi sẽ cập nhật thông tin tuyển dụng mới nhất tại đây.</p>
                        <a href="<?php echo home_url('/tin-tuc'); ?>" class="inline-flex items-center text-white px-6 py-3 rounded-lg transition-colors" style="background-color: <?php echo esc_attr($secondary_color); ?>;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            <span data-icon="arrow-left" data-size="16" class="mr-2"></span>
                            Quay lại trang tin tức
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if (get_next_posts_link() || get_previous_posts_link()): ?>
                <div class="flex justify-center">
                    <nav class="flex space-x-2">
                        <?php
                        echo paginate_links([
                            'prev_text' => '<span data-icon="chevron-left" data-size="16"></span> Trước',
                            'next_text' => 'Sau <span data-icon="chevron-right" data-size="16"></span>',
                            'class' => 'px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'
                        ]);
                        ?>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Newsletter Signup -->
    <div class="py-16" style="background-color: <?php echo esc_attr($primary_color); ?>10;">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto text-center">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: <?php echo esc_attr($primary_color); ?>10;">
                    <span data-icon="megaphone" data-size="32" style="color: <?php echo esc_attr($primary_color); ?>;"></span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Đăng ký nhận thông báo tuyển dụng</h3>
                <p class="text-gray-600 mb-8">
                    Nhận thông tin về các vị trí tuyển dụng mới nhất từ Arata Vietnam.
                </p>

                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="max-w-md mx-auto space-y-4">
                    <input type="hidden" name="action" value="arata_newsletter_submit" />
                    <?php wp_nonce_field('arata_newsletter_submit', 'arata_newsletter_nonce'); ?>

                    <div>
                        <input name="name" type="text" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:border-transparent transition-all duration-300"
                               style="--tw-ring-color: <?php echo esc_attr($primary_color); ?>;"
                               placeholder="Họ và tên *" />
                    </div>

                    <div>
                        <input name="email" type="email" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:border-transparent transition-all duration-300"
                               style="--tw-ring-color: <?php echo esc_attr($primary_color); ?>;"
                               placeholder="Email *" />
                    </div>

                    <button type="submit" class="w-full text-white py-3 rounded-lg transition-colors font-medium" style="background-color: <?php echo esc_attr($primary_color); ?>;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        Đăng ký ngay
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
