<?php
/**
 * Archive template for job_posting custom post type
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Hero
$hero_title = 'Tuyển dụng';
// Find the main News page to get the hero subtitle setting
$news_page = get_pages(['meta_key' => '_wp_page_template', 'meta_value' => 'page-templates/news.php']);
$hero_subtitle = 'Cơ hội nghề nghiệp tại Arata Vietnam'; // Default value
if (!empty($news_page)) {
    $news_page_id = $news_page[0]->ID;
    $saved_subtitle = get_post_meta($news_page_id, 'arata_news_subtitle', true);
    if (!empty($saved_subtitle)) {
        $hero_subtitle = $saved_subtitle;
    }
}
set_query_var('title', $hero_title);
set_query_var('subtitle', $hero_subtitle);
get_template_part('template-parts/hero');
?>

<main id="site-content" class="bg-white">
    <?php
    $archive_description = get_the_archive_description();
    if ($archive_description) :
    ?>
    <!-- Page Content -->
    <div class="container mx-auto px-4 py-10">
        <div class="max-w-4xl mx-auto">
            <div class="prose max-w-none mb-12">
                <?php echo $archive_description; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Careers Section -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-1 bg-primary rounded-full mr-4"></div>
                    <span class="text-primary font-medium text-sm uppercase tracking-wider">Cơ hội nghề nghiệp</span>
                    <div class="w-12 h-1 bg-primary rounded-full ml-4"></div>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Vị trí tuyển dụng hiện tại</h2>
            </div>

            <!-- Job Listings -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        // Lấy meta fields từ news-meta-fields.php
                        $department = get_post_meta(get_the_ID(), 'arata_job_department', true);
                        $location = get_post_meta(get_the_ID(), 'arata_job_location', true);
                        $type = get_post_meta(get_the_ID(), 'arata_job_type', true);
                        $level = get_post_meta(get_the_ID(), 'arata_job_level', true);
                        $salary = get_post_meta(get_the_ID(), 'arata_job_salary', true);
                        $deadline = get_post_meta(get_the_ID(), 'arata_job_deadline', true);
                        $requirements = get_post_meta(get_the_ID(), 'arata_job_requirements', true);
                        $benefits = get_post_meta(get_the_ID(), 'arata_job_benefits', true);
                        $contact = get_post_meta(get_the_ID(), 'arata_job_contact', true);

                        // Định nghĩa label cho loại hình công việc
                        $type_labels = [
                            'full_time' => 'Toàn thời gian',
                            'part_time' => 'Bán thời gian',
                            'contract' => 'Hợp đồng',
                            'internship' => 'Thực tập',
                            'freelance' => 'Freelance'
                        ];

                        // Định nghĩa label cho cấp bậc
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
                        <div class="bg-white rounded-lg p-6 border border-gray-200 hover:border-secondary transition-colors duration-300">
                            <div class="mb-4">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-secondary transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <?php if ($department): ?>
                                    <p class="text-secondary font-medium text-sm mb-1"><?php echo esc_html($department); ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="space-y-3 mb-6">
                                <?php if ($location): ?>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <span data-icon="map-pin" data-size="16" class="text-gray-400 mr-2"></span>
                                        <?php echo esc_html($location); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($type && isset($type_labels[$type])): ?>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <span data-icon="clock" data-size="16" class="text-gray-400 mr-2"></span>
                                        <?php echo esc_html($type_labels[$type]); ?>
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

                            <div class="pt-4 border-t border-gray-200">
                                <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-secondary hover:text-secondary-dark font-medium text-sm">
                                    Xem chi tiết
                                    <span data-icon="arrow-right" data-size="16" class="ml-1"></span>
                                </a>
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
                        <a href="<?php echo home_url('/tin-tuc'); ?>" class="inline-flex items-center bg-secondary text-white px-6 py-3 rounded-lg hover:bg-secondary-dark transition-colors">
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
    <div class="bg-primary/5 py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto text-center">
                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span data-icon="bell" data-size="32" class="text-primary"></span>
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
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                               placeholder="Họ và tên *" />
                    </div>

                    <div>
                        <input name="email" type="email" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                               placeholder="Email *" />
                    </div>

                    <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg hover:bg-primary-dark transition-colors font-medium">
                        Đăng ký ngay
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
