<?php
/**
 * Single Job Posting Template - New UI Design
 * Layout: Blog-style with system icons, consistent with single-promotion.php
 */

get_header();

// Get customizer color settings
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
$background_color = get_theme_mod('theme_background_color', '#ffffff');

if (have_posts()) : while (have_posts()) : the_post();

// Get job meta data
$job_type = get_post_meta(get_the_ID(), 'job_type', true);
$job_location = get_post_meta(get_the_ID(), 'job_location', true);
$job_salary = get_post_meta(get_the_ID(), 'job_salary', true);
$job_deadline = get_post_meta(get_the_ID(), 'job_deadline', true);
$job_experience = get_post_meta(get_the_ID(), 'job_experience', true);
$job_requirements = get_post_meta(get_the_ID(), 'job_requirements', true);
$job_benefits = get_post_meta(get_the_ID(), 'job_benefits', true);
$job_contact = get_post_meta(get_the_ID(), 'job_contact', true);

?>

<main id="site-content" style="background-color: <?php echo esc_attr($background_color); ?>;">
    <!-- Hero Section -->
    <section class="py-16 text-center" style="background-color: <?php echo esc_attr($background_color); ?>;">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-6">
                    <div class="flex items-center justify-center text-sm text-gray-500 space-x-2">
                        <a href="<?php echo home_url(); ?>" class="hover:text-primary">Trang chủ</a>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="<?php echo home_url('/tuyen-dung'); ?>" class="hover:text-primary">Tuyển dụng</a>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-gray-700"><?php the_title(); ?></span>
                    </div>
                </nav>

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?php the_title(); ?></h1>

                <!-- Meta Info -->
                <div class="flex items-center justify-center space-x-6 text-sm text-gray-600 mb-6">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Ngày đăng: <?php echo get_the_date('d/m/Y'); ?>
                    </div>
                    <?php if ($job_deadline): ?>
                        <div class="flex items-center text-red-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Hạn ứng tuyển: <?php echo date('d/m/Y', strtotime($job_deadline)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Job Type Badge -->
                <?php if ($job_type): ?>
                    <div class="inline-flex items-center bg-primary text-white px-6 py-3 rounded-full text-lg font-bold shadow-lg mb-6">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6"></path>
                        </svg>
                        <?php echo esc_html($job_type); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Left Side: Main Content (2/3) -->
                <div class="lg:col-span-2">
                    <!-- Featured Image -->
                    <?php if (has_post_thumbnail()): ?>
                        <div class="aspect-video overflow-hidden rounded-xl mb-8 shadow-sm">
                            <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Job Details Highlight -->
                    <div class="bg-gradient-to-r from-primary/10 to-secondary/10 rounded-xl p-6 mb-8 border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php if ($job_location): ?>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-600">Địa điểm</p>
                                        <p class="font-medium text-gray-900"><?php echo esc_html($job_location); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($job_salary): ?>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-600">Mức lương</p>
                                        <p class="font-medium text-green-600"><?php echo esc_html($job_salary); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($job_experience): ?>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-600">Kinh nghiệm</p>
                                        <p class="font-medium text-blue-600"><?php echo esc_html($job_experience); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($job_type): ?>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-600">Loại hình</p>
                                        <p class="font-medium text-purple-600"><?php echo esc_html($job_type); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="prose prose-lg max-w-none">
                        <?php the_content(); ?>
                    </div>

                    <!-- Job Requirements -->
                    <?php if ($job_requirements): ?>
                        <div class="mt-8 p-6 bg-blue-50 rounded-xl border border-blue-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                Yêu cầu công việc
                            </h3>
                            <div class="text-gray-700 leading-relaxed"><?php echo wp_kses_post(wpautop($job_requirements)); ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Job Benefits -->
                    <?php if ($job_benefits): ?>
                        <div class="mt-8 p-6 bg-green-50 rounded-xl border border-green-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                Quyền lợi được hưởng
                            </h3>
                            <div class="text-gray-700 leading-relaxed"><?php echo wp_kses_post(wpautop($job_benefits)); ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Contact Information -->
                    <?php if ($job_contact): ?>
                        <div class="mt-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Thông tin liên hệ
                            </h3>
                            <div class="text-gray-700 leading-relaxed"><?php echo wp_kses_post(wpautop($job_contact)); ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Share Section -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Chia sẻ tin tuyển dụng</h3>
                        <div class="flex items-center space-x-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-800 text-white rounded-lg hover:bg-blue-900 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                                LinkedIn
                            </a>
                            <button onclick="copyToClipboard('<?php echo esc_js(get_permalink()); ?>')" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Sao chép link
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Sidebar (1/3) -->
                <div class="lg:col-span-1">
                    <!-- Job Details Card -->
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Thông tin tuyển dụng
                        </h3>

                        <div class="space-y-4">
                            <?php if ($job_type): ?>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Loại hình:</span>
                                    <span class="font-bold text-primary"><?php echo esc_html($job_type); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($job_location): ?>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Địa điểm:</span>
                                    <span class="font-medium"><?php echo esc_html($job_location); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($job_salary): ?>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Mức lương:</span>
                                    <span class="font-medium text-green-600"><?php echo esc_html($job_salary); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($job_experience): ?>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Kinh nghiệm:</span>
                                    <span class="font-medium"><?php echo esc_html($job_experience); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($job_deadline): ?>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Hạn ứng tuyển:</span>
                                    <span class="font-medium text-red-600"><?php echo date('d/m/Y', strtotime($job_deadline)); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- CTA Button -->
                        <div class="mt-6">
                            <button onclick="toggleApplicationForm()" class="inline-flex items-center justify-center w-full py-3 px-4 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Ứng tuyển ngay
                            </button>
                        </div>

                        <!-- Application Form -->
                        <div id="applicationForm" class="hidden mt-6 p-6 bg-gray-50 rounded-xl border border-gray-200">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">Ứng tuyển vị trí này</h4>
                            
                            <?php if (isset($_GET['application_success'])): ?>
                                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                                    <strong>Cảm ơn bạn!</strong> Chúng tôi đã nhận được hồ sơ ứng tuyển của bạn và sẽ liên hệ sớm.
                                </div>
                            <?php endif; ?>
                            
                            <?php if (isset($_GET['application_error'])): ?>
                                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
                                    <strong>Lỗi!</strong> Vui lòng điền đầy đủ thông tin và thử lại.
                                </div>
                            <?php endif; ?>

                            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data" class="space-y-4">
                                <input type="hidden" name="action" value="arata_job_application_submit" />
                                <input type="hidden" name="job_id" value="<?php echo get_the_ID(); ?>" />
                                <?php wp_nonce_field('arata_job_application_submit', 'arata_job_application_nonce'); ?>

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Họ và tên *</label>
                                    <input type="text" id="name" name="name" required 
                                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="Nhập họ và tên của bạn" />
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" id="email" name="email" required 
                                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="nhập@email.com" />
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại *</label>
                                    <input type="tel" id="phone" name="phone" required 
                                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                           placeholder="090x xxx xxx" />
                                </div>

                                <div>
                                    <label for="cv" class="block text-sm font-medium text-gray-700 mb-2">CV (Hồ sơ) *</label>
                                    <input type="file" id="cv" name="cv" required 
                                           accept=".pdf,.doc,.docx"
                                           class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                    <p class="text-xs text-gray-500 mt-1">Chấp nhận file: PDF, DOC, DOCX (Tối đa 5MB)</p>
                                </div>

                                <div>
                                    <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-2">Thư xin việc (không bắt buộc)</label>
                                    <textarea id="cover_letter" name="cover_letter" rows="4" 
                                              class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                              placeholder="Giới thiệu ngắn về bản thân và tại sao bạn muốn làm việc tại Arata Vietnam..."></textarea>
                                </div>

                                <div class="flex space-x-3">
                                    <button type="submit" class="flex-1 bg-primary text-white py-2 px-4 rounded-lg hover:bg-primary-dark transition-colors font-medium">
                                        Gửi hồ sơ
                                    </button>
                                    <button type="button" onclick="toggleApplicationForm()" class="flex-1 bg-gray-200 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                                        Hủy
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Related Jobs -->
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <div class="flex items-center mb-6 pb-3 border-b border-gray-200">
                            <svg class="w-5 h-5 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-gray-900">Việc làm khác</h3>
                        </div>

                        <div class="space-y-4">
                            <?php
                            $related_jobs = new WP_Query([
                                'post_type' => 'job_posting',
                                'posts_per_page' => 3,
                                'post_status' => 'publish',
                                'post__not_in' => [get_the_ID()],
                                'meta_query' => [
                                    'relation' => 'OR',
                                    [
                                        'key' => 'job_deadline',
                                        'value' => date('Y-m-d'),
                                        'compare' => '>=',
                                        'type' => 'DATE'
                                    ],
                                    [
                                        'key' => 'job_deadline',
                                        'compare' => 'NOT EXISTS'
                                    ]
                                ]
                            ]);

                            if ($related_jobs->have_posts()) :
                                while ($related_jobs->have_posts()) : $related_jobs->the_post();
                                    $related_job_type = get_post_meta(get_the_ID(), 'job_type', true);
                                    $related_job_location = get_post_meta(get_the_ID(), 'job_location', true);
                                    ?>
                                    <div class="group">
                                        <a href="<?php the_permalink(); ?>" class="block hover:bg-gray-50 p-3 rounded-lg transition-colors duration-200">
                                            <div class="flex items-start space-x-3">
                                                <?php if (has_post_thumbnail()): ?>
                                                    <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                                        <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover']); ?>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6"></path>
                                                        </svg>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="flex-1 min-w-0">
                                                    <h4 class="font-medium text-gray-900 text-sm line-clamp-2 group-hover:text-primary transition-colors">
                                                        <?php the_title(); ?>
                                                    </h4>
                                                    <?php if ($related_job_type): ?>
                                                        <div class="flex items-center text-xs text-primary font-bold mt-1">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6"></path>
                                                            </svg>
                                                            <?php echo esc_html($related_job_type); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($related_job_location): ?>
                                                        <div class="flex items-center text-xs text-gray-500 mt-1">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            </svg>
                                                            <?php echo esc_html($related_job_location); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            else:
                                ?>
                                <div class="text-center py-8">
                                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6"></path>
                                    </svg>
                                    <p class="text-gray-500 text-sm">Không có việc làm khác</p>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>

                        <!-- View all jobs link -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <a href="<?php echo home_url('/tuyen-dung'); ?>" class="inline-flex items-center text-primary hover:text-primary-dark font-medium text-sm w-full justify-center py-2 px-4 border border-primary/20 rounded-lg hover:bg-primary/5 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0V6a2 2 0 00-2 2v6"></path>
                                </svg>
                                Xem tất cả việc làm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
function toggleApplicationForm() {
    const form = document.getElementById('applicationForm');
    form.classList.toggle('hidden');
    
    // Scroll to form if opening
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        toast.textContent = 'Đã sao chép!';
        document.body.appendChild(toast);

        setTimeout(() => {
            document.body.removeChild(toast);
        }, 2000);
    });
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prose {
    color: #374151;
    line-height: 1.75;
}

.prose h2 {
    font-size: 1.5em;
    font-weight: 700;
    margin-top: 2em;
    margin-bottom: 1em;
    color: #111827;
}

.prose h3 {
    font-size: 1.25em;
    font-weight: 600;
    margin-top: 1.6em;
    margin-bottom: 0.6em;
    color: #111827;
}

.prose p {
    margin-top: 1.25em;
    margin-bottom: 1.25em;
}

.prose ul, .prose ol {
    margin-top: 1.25em;
    margin-bottom: 1.25em;
    padding-left: 1.625em;
}

.prose li {
    margin-top: 0.5em;
    margin-bottom: 0.5em;
}
</style>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
