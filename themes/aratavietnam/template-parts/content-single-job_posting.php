<?php
/**
 * Template part for displaying single job postings
 *
 * @package ArataVietnam
 */

// Get all meta fields
$department = get_post_meta(get_the_ID(), 'arata_job_department', true);
$location = get_post_meta(get_the_ID(), 'arata_job_location', true);
$type = get_post_meta(get_the_ID(), 'arata_job_type', true);
$level = get_post_meta(get_the_ID(), 'arata_job_level', true);
$salary = get_post_meta(get_the_ID(), 'arata_job_salary', true);
$deadline = get_post_meta(get_the_ID(), 'arata_job_deadline', true);
$requirements = get_post_meta(get_the_ID(), 'arata_job_requirements', true);
$benefits = get_post_meta(get_the_ID(), 'arata_job_benefits', true);
$contact = get_post_meta(get_the_ID(), 'arata_job_contact', true);

// Labels for meta fields
$type_labels = ['full_time' => 'Toàn thời gian', 'part_time' => 'Bán thời gian', 'contract' => 'Hợp đồng', 'internship' => 'Thực tập', 'freelance' => 'Freelance'];
$level_labels = ['intern' => 'Thực tập sinh', 'fresher' => 'Nhân viên mới', 'junior' => 'Nhân viên', 'senior' => 'Nhân viên cao cấp', 'lead' => 'Trưởng nhóm', 'manager' => 'Quản lý', 'director' => 'Giám đốc'];
?>

<div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-x-12">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white p-6 md:p-8 rounded-lg border border-gray-200'); ?>>
            <?php if (isset($_GET['application_success']) && $_GET['application_success'] == 'true') : ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Nộp hồ sơ thành công!</p>
                    <p>Cảm ơn bạn đã ứng tuyển. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
                </div>
            <?php endif; ?>

            <header class="entry-header mb-6">
                <?php the_title('<h1 class="entry-title text-3xl md:text-4xl font-bold text-gray-900">', '</h1>'); ?>
                <?php if ($department) : ?>
                    <p class="text-secondary text-lg font-semibold mt-2"><?php echo esc_html($department); ?></p>
                <?php endif; ?>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                    <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover']); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content prose max-w-none border-t border-gray-200 pt-6">
                <?php the_content(); ?>

                <?php if ($requirements) : ?>
                    <h3 class="font-bold text-xl mt-8 mb-4">Yêu cầu công việc</h3>
                    <div class="prose-sm text-gray-700"><?php echo wpautop(esc_html($requirements)); ?></div>
                <?php endif; ?>

                <?php if ($benefits) : ?>
                    <h3 class="font-bold text-xl mt-8 mb-4">Quyền lợi được hưởng</h3>
                    <div class="prose-sm text-gray-700"><?php echo wpautop(esc_html($benefits)); ?></div>
                <?php endif; ?>

                <?php if ($contact) : ?>
                    <h3 class="font-bold text-xl mt-8 mb-4">Thông tin liên hệ</h3>
                    <div class="prose-sm text-gray-700"><?php echo wpautop(esc_html($contact)); ?></div>
                <?php endif; ?>
            </div>
        </article>
    </div>

    <!-- Sidebar -->
    <aside class="lg:col-span-1 mt-12 lg:mt-0">
        <div class="sticky top-24">
            <!-- Job Summary -->
            <div class="bg-white p-6 rounded-lg border border-gray-200 mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Thông tin chung</h3>
                <ul class="space-y-3 text-sm">
                    <?php if ($location): ?>
                        <li class="flex items-center"><span data-icon="map-pin" class="mr-3 text-gray-400"></span><strong>Địa điểm:</strong><span class="ml-auto text-right"><?php echo esc_html($location); ?></span></li>
                    <?php endif; ?>
                    <?php if ($salary): ?>
                        <li class="flex items-center"><span data-icon="dollar-sign" class="mr-3 text-gray-400"></span><strong>Mức lương:</strong><span class="ml-auto text-right"><?php echo esc_html($salary); ?></span></li>
                    <?php endif; ?>
                    <?php if ($type && isset($type_labels[$type])): ?>
                        <li class="flex items-center"><span data-icon="clock" class="mr-3 text-gray-400"></span><strong>Loại hình:</strong><span class="ml-auto text-right"><?php echo esc_html($type_labels[$type]); ?></span></li>
                    <?php endif; ?>
                    <?php if ($level && isset($level_labels[$level])): ?>
                        <li class="flex items-center"><span data-icon="bar-chart-2" class="mr-3 text-gray-400"></span><strong>Cấp bậc:</strong><span class="ml-auto text-right"><?php echo esc_html($level_labels[$level]); ?></span></li>
                    <?php endif; ?>
                    <?php if ($deadline): ?>
                        <li class="flex items-center"><span data-icon="calendar" class="mr-3 text-gray-400"></span><strong>Hạn nộp:</strong><span class="ml-auto text-right font-medium text-red-600"><?php echo date('d/m/Y', strtotime($deadline)); ?></span></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Application Form -->
            <div class="bg-white p-6 rounded-lg border border-gray-200">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Ứng tuyển ngay</h3>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data" class="space-y-4">
                    <input type="hidden" name="action" value="arata_job_application_submit" />
                    <input type="hidden" name="job_id" value="<?php echo get_the_ID(); ?>" />
                    <?php wp_nonce_field('arata_job_application_submit', 'arata_job_application_nonce'); ?>

                    <div>
                        <label for="applicant_name" class="block text-sm font-medium text-gray-700 mb-1">Họ và tên *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </span>
                            <input id="applicant_name" name="name" type="text" required placeholder="Nhập họ và tên của bạn" class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent" />
                        </div>
                    </div>
                    <div>
                        <label for="applicant_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </span>
                            <input id="applicant_email" name="email" type="email" required placeholder="example@email.com" class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent" />
                        </div>
                    </div>
                    <div>
                        <label for="applicant_phone" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </span>
                            <input id="applicant_phone" name="phone" type="tel" required placeholder="0123 456 789" class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent" />
                        </div>
                    </div>
                    <div>
                        <label for="applicant_cv" class="block text-sm font-medium text-gray-700 mb-1">Tải lên CV *</label>
                        <input id="applicant_cv" name="cv" type="file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border file:border-gray-300 file:text-sm file:font-medium file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100" />
                    </div>
                    <div>
                        <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-1">Thư giới thiệu</label>
                        <textarea id="cover_letter" name="cover_letter" rows="4" placeholder="Nhập thư giới thiệu của bạn..." class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-secondary text-white py-3 rounded-lg hover:bg-secondary-dark transition-colors font-medium">Gửi hồ sơ</button>
                </form>
            </div>
        </div>
    </aside>
</div>
