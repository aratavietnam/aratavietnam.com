<?php
/**
 * Template Name: Contact Page
 * Template Post Type: page
 * Description: Simple, modern contact page with editable content and submissions storage.
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Hero
$hero_title = get_the_title();
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_contact_subtitle', true) ?: '';
set_query_var('title', $hero_title);
set_query_var('subtitle', $hero_subtitle);
get_template_part('template-parts/hero');
?>

<main id="site-content" class="bg-white">
	<div class="container mx-auto px-4 py-8">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
			<!-- Editable page content -->
			<div>
				<article id="post-<?php the_ID(); ?>" <?php post_class('prose max-w-none'); ?>>
					<div class="entry-content">
						<?php
						while (have_posts()) : the_post();
							the_content();
						endwhile;
						?>
					</div>

					<?php
					$intro = get_post_meta(get_the_ID(), 'arata_contact_intro', true);
					$address = get_post_meta(get_the_ID(), 'arata_contact_address', true);
					$phone = get_post_meta(get_the_ID(), 'arata_contact_phone', true);
					$email = get_post_meta(get_the_ID(), 'arata_contact_email', true);
					$hours = get_post_meta(get_the_ID(), 'arata_contact_hours', true);
					$map = get_post_meta(get_the_ID(), 'arata_contact_map', true);
					?>

					<?php if ($intro || $address || $phone || $email || $hours) : ?>
						<section class="mt-8 space-y-6">
							<?php if ($intro) : ?>
								<div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
									<p class="text-gray-700 text-base leading-relaxed"><?php echo wp_kses_post($intro); ?></p>
								</div>
							<?php endif; ?>

							<div class="space-y-4">
								<?php if ($address) : ?>
									<div class="bg-white rounded-lg p-4 border border-gray-200">
										<div class="flex items-start space-x-3">
											<div class="flex-shrink-0 w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center mt-1">
												<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
												</svg>
											</div>
											<div class="flex-1 min-w-0">
												<h3 class="text-base font-semibold text-gray-900 mb-1"><?php _e('Địa chỉ', 'aratavietnam'); ?></h3>
												<p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line"><?php echo wp_kses_post($address); ?></p>
											</div>
										</div>
									</div>
								<?php endif; ?>

								<?php if ($phone) : ?>
									<div class="bg-white rounded-lg p-4 border border-gray-200">
										<div class="flex items-start space-x-3">
											<div class="flex-shrink-0 w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center mt-1">
												<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
												</svg>
											</div>
											<div class="flex-1 min-w-0">
												<h3 class="text-base font-semibold text-gray-900 mb-1"><?php _e('Điện thoại', 'aratavietnam'); ?></h3>
												<p class="text-sm">
													<a href="tel:<?php echo esc_attr($phone); ?>" class="text-gray-900 hover:text-gray-700 font-medium hover:underline">
														<?php echo esc_html($phone); ?>
													</a>
												</p>
											</div>
										</div>
									</div>
								<?php endif; ?>

								<?php if ($email) : ?>
									<div class="bg-white rounded-lg p-4 border border-gray-200">
										<div class="flex items-start space-x-3">
											<div class="flex-shrink-0 w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center mt-1">
												<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
												</svg>
											</div>
											<div class="flex-1 min-w-0">
												<h3 class="text-base font-semibold text-gray-900 mb-1"><?php _e('Email', 'aratavietnam'); ?></h3>
												<p class="text-sm">
													<a href="mailto:<?php echo esc_attr($email); ?>" class="text-gray-900 hover:text-gray-700 font-medium hover:underline break-all">
														<?php echo esc_html($email); ?>
													</a>
												</p>
											</div>
										</div>
									</div>
								<?php endif; ?>

								<?php if ($hours) : ?>
									<div class="bg-white rounded-lg p-4 border border-gray-200">
										<div class="flex items-start space-x-3">
											<div class="flex-shrink-0 w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center mt-1">
												<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
												</svg>
											</div>
											<div class="flex-1 min-w-0">
												<h3 class="text-base font-semibold text-gray-900 mb-1"><?php _e('Giờ làm việc', 'aratavietnam'); ?></h3>
												<p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line"><?php echo wp_kses_post($hours); ?></p>
											</div>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</section>
					<?php endif; ?>

					<?php if (!empty($map)) : ?>
						<section class="mt-8">
							<div class="bg-white rounded-lg p-4 border border-gray-200">
								<div class="flex items-center space-x-3 mb-4">
									<div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
										<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
										</svg>
									</div>
									<h3 class="text-base font-semibold text-gray-900"><?php _e('Vị trí trên bản đồ', 'aratavietnam'); ?></h3>
								</div>
								<div class="aspect-video w-full overflow-hidden rounded-lg border border-gray-200">
									<iframe src="<?php echo esc_url($map); ?>" width="100%" height="100%" style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen class="w-full h-full"></iframe>
								</div>
							</div>
						</section>
					<?php endif; ?>
				</article>
			</div>

			<!-- Contact form -->
			<div class="mt-8 lg:mt-0">
				<div class="bg-white rounded-lg p-4 lg:p-6 border border-gray-200">
					<h2 class="text-lg lg:text-xl font-semibold text-gray-900 mb-2"><?php _e('Liên hệ', 'aratavietnam'); ?></h2>
					<p class="text-sm text-gray-600 mb-4"><?php _e('Vui lòng điền thông tin. Các trường có * là bắt buộc.', 'aratavietnam'); ?></p>
					<?php if (isset($_GET['contact']) && $_GET['contact'] === 'success') : ?>
						<div class="mb-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg p-3"><?php _e('Gửi liên hệ thành công. Chúng tôi sẽ phản hồi sớm nhất.', 'aratavietnam'); ?></div>
					<?php elseif (isset($_GET['contact']) && $_GET['contact'] === 'error') : ?>
						<div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg p-3"><?php _e('Có lỗi xảy ra. Vui lòng kiểm tra và thử lại.', 'aratavietnam'); ?></div>
					<?php endif; ?>

					<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="space-y-4" id="contact-form">
						<input type="hidden" name="action" value="arata_contact_submit" />
						<?php wp_nonce_field('arata_contact_submit', 'arata_contact_nonce'); ?>
						<!-- Honeypot -->
						<input type="text" name="website" value="" class="hidden" tabindex="-1" autocomplete="off" />

						<div class="space-y-4">
							<div>
								<label for="name" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Họ và tên', 'aratavietnam'); ?> *</label>
								<div class="relative">
									<span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
										<svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
									</span>
									<input id="name" name="name" type="text" required placeholder="Nhập họ và tên của bạn" class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
								</div>
								<div class="mt-1 text-xs text-red-600 hidden" id="name-error">Vui lòng nhập họ và tên</div>
							</div>

							<div>
								<label for="email" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Email', 'aratavietnam'); ?> *</label>
								<div class="relative">
									<span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
										<svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
									</span>
									<input id="email" name="email" type="email" required placeholder="example@email.com" class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
								</div>
								<div class="mt-1 text-xs text-red-600 hidden" id="email-error">Vui lòng nhập email hợp lệ</div>
							</div>

							<div>
								<label for="phone" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Số điện thoại', 'aratavietnam'); ?></label>
								<div class="relative">
									<span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
										<svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
									</span>
									<input id="phone" name="phone" type="tel" placeholder="0123 456 789" class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
								</div>
								<div class="mt-1 text-xs text-red-600 hidden" id="phone-error">Số điện thoại không hợp lệ</div>
							</div>

							<div>
								<label for="subject" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Chủ đề', 'aratavietnam'); ?></label>
								<div class="relative">
									<span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
										<svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
									</span>
									<input id="subject" name="subject" type="text" placeholder="Chủ đề liên hệ" class="block w-full rounded-lg border border-gray-300 pl-10 pr-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
								</div>
							</div>
						</div>

						<div>
							<label for="message" class="block text-sm font-medium text-gray-700 mb-1"><?php _e('Nội dung', 'aratavietnam'); ?> *</label>
							<div class="relative">
								<textarea id="message" name="message" rows="4" required placeholder="Nhập nội dung tin nhắn của bạn..." class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none"></textarea>
							</div>
							<div class="mt-1 text-xs text-red-600 hidden" id="message-error">Vui lòng nhập nội dung tin nhắn</div>
						</div>

						<div class="pt-2">
							<button type="submit" id="submit-btn" class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg bg-primary px-6 py-2.5 text-white font-medium hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
								<span class="submit-text"><?php _e('Gửi liên hệ', 'aratavietnam'); ?></span>
								<svg class="animate-spin -mr-1 ml-2 h-4 w-4 text-white hidden loading-spinner" fill="none" viewBox="0 0 24 24">
									<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
									<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
								</svg>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    if (!form) return;

    // Basic form validation (simplified)
    form.addEventListener('submit', function(e) {
        // Let the main app.js handle the form submission
        // This is just a fallback
    });
});
</script>

<?php get_footer(); ?>
