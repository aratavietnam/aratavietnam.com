<?php
/**
 * Template Name: Careers Page
 * Template Post Type: page
 * Description: Careers page with job listings and application form
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Hero
$hero_title = get_the_title();
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_news_subtitle', true) ?: 'Cơ hội nghề nghiệp tại Arata Vietnam';
set_query_var('title', $hero_title);
set_query_var('subtitle', $hero_subtitle);
get_template_part('template-parts/hero');
?>

<main id="site-content" class="bg-white">
    <!-- Page Content -->
    <div class="container mx-auto px-4 py-10">
        <div class="max-w-4xl mx-auto">
            <article id="post-<?php the_ID(); ?>" <?php post_class('prose max-w-none mb-12'); ?>>
                <div class="entry-content">
                    <?php
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                    ?>
                </div>
            </article>
        </div>
    </div>

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
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Vị trí tuyển dụng</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Gia nhập đội ngũ Arata Vietnam và phát triển sự nghiệp trong lĩnh vực hóa mỹ phẩm hàng đầu.
                </p>
            </div>

            <!-- Job Listings -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
                <?php
                $jobs = new WP_Query([
                    'post_type' => 'job_posting',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'meta_query' => [
                        'relation' => 'OR',
                        [
                            'key' => 'arata_job_deadline',
                            'value' => date('Y-m-d'),
                            'compare' => '>=',
                            'type' => 'DATE'
                        ],
                        [
                            'key' => 'arata_job_deadline',
                            'compare' => 'NOT EXISTS'
                        ]
                    ]
                ]);

                if ($jobs->have_posts()) :
                    while ($jobs->have_posts()) : $jobs->the_post();
                        $department = get_post_meta(get_the_ID(), 'arata_job_department', true);
                        $location = get_post_meta(get_the_ID(), 'arata_job_location', true);
                        $type = get_post_meta(get_the_ID(), 'arata_job_type', true);
                        $level = get_post_meta(get_the_ID(), 'arata_job_level', true);
                        $salary = get_post_meta(get_the_ID(), 'arata_job_salary', true);
                        $deadline = get_post_meta(get_the_ID(), 'arata_job_deadline', true);

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
                        <div class="bg-white rounded-lg p-6 border border-gray-200 hover:border-secondary transition-colors duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="text-xl font-semibold text-gray-900 flex-1">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <?php if ($type): ?>
                                    <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-medium ml-4">
                                        <?php echo esc_html($type_labels[$type] ?? $type); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="space-y-3 mb-4 text-sm text-gray-600">
                                <?php if ($department): ?>
                                    <div class="flex items-center">
                                        <span data-icon="building" data-size="16" class="mr-2 text-gray-400"></span>
                                        <span class="font-medium">Phòng ban:</span>
                                        <span class="ml-1"><?php echo esc_html($department); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($location): ?>
                                    <div class="flex items-center">
                                        <span data-icon="map-pin" data-size="16" class="mr-2 text-gray-400"></span>
                                        <span class="font-medium">Địa điểm:</span>
                                        <span class="ml-1"><?php echo esc_html($location); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($level): ?>
                                    <div class="flex items-center">
                                        <span data-icon="trending-up" data-size="16" class="mr-2 text-gray-400"></span>
                                        <span class="font-medium">Cấp bậc:</span>
                                        <span class="ml-1"><?php echo esc_html($level_labels[$level] ?? $level); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($salary): ?>
                                    <div class="flex items-center">
                                        <span data-icon="dollar-sign" data-size="16" class="mr-2 text-gray-400"></span>
                                        <span class="font-medium">Mức lương:</span>
                                        <span class="ml-1"><?php echo esc_html($salary); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ($deadline): ?>
                                    <div class="flex items-center text-red-600">
                                        <span data-icon="calendar" data-size="16" class="mr-2"></span>
                                        <span class="font-medium">Hạn nộp:</span>
                                        <span class="ml-1"><?php echo date('d/m/Y', strtotime($deadline)); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-3"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>

                            <div class="flex items-center justify-between">
                                <a href="<?php the_permalink(); ?>" class="text-primary hover:text-primary-dark font-medium text-sm">
                                    Xem chi tiết →
                                </a>
                                <button onclick="openApplicationModal('<?php echo esc_js(get_the_title()); ?>')" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-dark transition-colors">
                                    Ứng tuyển ngay
                                </button>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else:
                    ?>
                    <div class="col-span-3 text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <span data-icon="briefcase" data-size="48"></span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Hiện tại chưa có vị trí tuyển dụng</h3>
                        <p class="text-gray-600 mb-6">Chúng tôi sẽ cập nhật các vị trí tuyển dụng mới trong thời gian tới.</p>
                        <button onclick="openApplicationModal('Ứng tuyển tự do')" class="bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-dark transition-colors">
                            Gửi hồ sơ tự do
                        </button>
                    </div>
                    <?php
                endif;
                ?>
            </div>

            <!-- Why Join Us Section -->
            <div class="bg-white rounded-lg p-8 shadow-sm border border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Tại sao chọn Arata Vietnam?</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span data-icon="users" data-size="32" class="text-primary"></span>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Môi trường chuyên nghiệp</h4>
                        <p class="text-gray-600 text-sm">Làm việc cùng đội ngũ chuyên gia giàu kinh nghiệm trong lĩnh vực hóa mỹ phẩm.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span data-icon="trending-up" data-size="32" class="text-secondary"></span>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Cơ hội phát triển</h4>
                        <p class="text-gray-600 text-sm">Nhiều cơ hội thăng tiến và phát triển kỹ năng trong môi trường năng động.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-tertiary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span data-icon="heart" data-size="32" class="text-tertiary"></span>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Phúc lợi hấp dẫn</h4>
                        <p class="text-gray-600 text-sm">Chế độ đãi ngộ cạnh tranh và các phúc lợi đặc biệt cho nhân viên.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Application Modal -->
<div id="applicationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Ứng tuyển vị trí</h3>
                <button onclick="closeApplicationModal()" class="text-gray-400 hover:text-gray-600">
                    <span data-icon="x" data-size="24"></span>
                </button>
            </div>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="action" value="arata_job_application_submit" />
                <?php wp_nonce_field('arata_job_application_submit', 'arata_job_application_nonce'); ?>
                <input type="hidden" id="applicationPosition" name="position" value="" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="applicant_name" class="block text-sm font-medium text-gray-700 mb-1">Họ và tên *</label>
                        <input id="applicant_name" name="name" type="text" required class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>

                    <div>
                        <label for="applicant_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input id="applicant_email" name="email" type="email" required class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                    </div>
                </div>

                <div>
                    <label for="applicant_phone" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại *</label>
                    <input id="applicant_phone" name="phone" type="tel" required class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                </div>

                <div>
                    <label for="applicant_cv" class="block text-sm font-medium text-gray-700 mb-1">CV (PDF, DOC, DOCX) *</label>
                    <input id="applicant_cv" name="cv" type="file" accept=".pdf,.doc,.docx" required class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                </div>

                <div>
                    <label for="applicant_cover_letter" class="block text-sm font-medium text-gray-700 mb-1">Thư xin việc</label>
                    <textarea id="applicant_cover_letter" name="cover_letter" rows="4" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Chia sẻ về bản thân và lý do bạn muốn gia nhập Arata Vietnam..."></textarea>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-4">
                    <button type="button" onclick="closeApplicationModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Hủy
                    </button>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                        Gửi hồ sơ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openApplicationModal(position) {
    document.getElementById('applicationPosition').value = position;
    document.getElementById('applicationModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeApplicationModal() {
    document.getElementById('applicationModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('applicationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeApplicationModal();
    }
});
</script>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<?php get_footer(); ?>
