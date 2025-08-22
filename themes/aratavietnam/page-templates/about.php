<?php
/**
 * Template Name: About Page
 * Description: About Us page for Arata Vietnam with floating product images and company information.
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Hero
$hero_title = get_the_title();
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_about_subtitle', true) ?: 'Đối tác tin cậy trong lĩnh vực hóa mỹ phẩm Nhật Bản tại Việt Nam';
set_query_var('title', $hero_title);
set_query_var('subtitle', $hero_subtitle);
get_template_part('template-parts/hero');
?>

<main id="site-content" class="bg-white">
	<!-- Main About Section with Blue Background -->
	<section class="bg-secondary py-16 lg:py-24 relative overflow-hidden">
		<div class="container mx-auto px-4 relative">
			<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
				
				<!-- Left Floating Images -->
				<div class="hidden lg:block lg:col-span-2 relative">
					<div class="floating-images-left space-y-8">
						<?php
						$left_images = get_post_meta(get_the_ID(), 'arata_about_left_images', true);
						if ($left_images) {
							$images = explode(',', $left_images);
							foreach ($images as $index => $image_id) {
								if ($image_id) {
									$image_url = wp_get_attachment_image_url($image_id, 'medium');
									$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
									$delay = $index * 0.2;
									echo '<div class="floating-image" style="animation-delay: ' . $delay . 's;">';
									echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '" class="w-24 h-24 lg:w-32 lg:h-32 object-contain drop-shadow-lg">';
									echo '</div>';
								}
							}
						}
						?>
					</div>
				</div>

				<!-- Main Content -->
				<div class="lg:col-span-8">
					<article id="post-<?php the_ID(); ?>" <?php post_class('prose prose-lg max-w-none text-white'); ?>>
						<div class="entry-content">
							<?php
							while (have_posts()) : the_post();
								the_content();
							endwhile;
							?>
						</div>

						<?php
						// Get custom meta fields
						$company_intro = get_post_meta(get_the_ID(), 'arata_about_company_intro', true);
						$history = get_post_meta(get_the_ID(), 'arata_about_history', true);
						$mission = get_post_meta(get_the_ID(), 'arata_about_mission', true);
						$values = get_post_meta(get_the_ID(), 'arata_about_values', true);
						$commitment = get_post_meta(get_the_ID(), 'arata_about_commitment', true);
						?>

						<?php if ($company_intro) : ?>
							<section class="mt-12">
								<h2 class="text-2xl lg:text-3xl font-bold text-white mb-6 flex items-center">
									<span class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center mr-4">
										<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h6"></path>
										</svg>
									</span>
									Giới thiệu công ty
								</h2>
								<div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 lg:p-8">
									<div class="text-white/90 leading-relaxed">
										<?php echo wp_kses_post($company_intro); ?>
									</div>
								</div>
							</section>
						<?php endif; ?>

						<?php if ($history) : ?>
							<section class="mt-12">
								<h2 class="text-2xl lg:text-3xl font-bold text-white mb-6 flex items-center">
									<span class="w-12 h-12 bg-tertiary rounded-lg flex items-center justify-center mr-4">
										<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
										</svg>
									</span>
									Lịch sử & Thành tựu
								</h2>
								<div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 lg:p-8">
									<div class="text-white/90 leading-relaxed">
										<?php echo wp_kses_post($history); ?>
									</div>
								</div>
							</section>
						<?php endif; ?>

						<?php if ($mission) : ?>
							<section class="mt-12">
								<h2 class="text-2xl lg:text-3xl font-bold text-white mb-6 flex items-center">
									<span class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center mr-4">
										<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
										</svg>
									</span>
									Sứ mệnh & Tầm nhìn
								</h2>
								<div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 lg:p-8">
									<div class="text-white/90 leading-relaxed">
										<?php echo wp_kses_post($mission); ?>
									</div>
								</div>
							</section>
						<?php endif; ?>

						<?php if ($values) : ?>
							<section class="mt-12">
								<h2 class="text-2xl lg:text-3xl font-bold text-white mb-6 flex items-center">
									<span class="w-12 h-12 bg-tertiary rounded-lg flex items-center justify-center mr-4">
										<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
										</svg>
									</span>
									Giá trị cốt lõi
								</h2>
								<div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 lg:p-8">
									<div class="text-white/90 leading-relaxed">
										<?php echo wp_kses_post($values); ?>
									</div>
								</div>
							</section>
						<?php endif; ?>

						<?php if ($commitment) : ?>
							<section class="mt-12">
								<h2 class="text-2xl lg:text-3xl font-bold text-white mb-6 flex items-center">
									<span class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center mr-4">
										<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
										</svg>
									</span>
									Cam kết chất lượng
								</h2>
								<div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 lg:p-8">
									<div class="text-white/90 leading-relaxed">
										<?php echo wp_kses_post($commitment); ?>
									</div>
								</div>
							</section>
						<?php endif; ?>
					</article>
				</div>

				<!-- Right Floating Images -->
				<div class="hidden lg:block lg:col-span-2 relative">
					<div class="floating-images-right space-y-8">
						<?php
						$right_images = get_post_meta(get_the_ID(), 'arata_about_right_images', true);
						if ($right_images) {
							$images = explode(',', $right_images);
							foreach ($images as $index => $image_id) {
								if ($image_id) {
									$image_url = wp_get_attachment_image_url($image_id, 'medium');
									$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
									$delay = ($index + 2) * 0.2;
									echo '<div class="floating-image" style="animation-delay: ' . $delay . 's;">';
									echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '" class="w-24 h-24 lg:w-32 lg:h-32 object-contain drop-shadow-lg">';
									echo '</div>';
								}
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>

		<!-- Background Pattern -->
		<div class="absolute inset-0 opacity-5">
			<div class="absolute top-10 left-10 w-20 h-20 border border-white/20 rounded-full"></div>
			<div class="absolute top-32 right-20 w-16 h-16 border border-white/20 rounded-full"></div>
			<div class="absolute bottom-20 left-1/4 w-12 h-12 border border-white/20 rounded-full"></div>
			<div class="absolute bottom-32 right-1/3 w-24 h-24 border border-white/20 rounded-full"></div>
		</div>
	</section>

	<!-- Mobile Product Images Carousel -->
	<section class="lg:hidden bg-gray-50 py-8">
		<div class="container mx-auto px-4">
			<h3 class="text-xl font-semibold text-gray-900 mb-6 text-center">Sản phẩm của chúng tôi</h3>
			<div class="flex space-x-4 overflow-x-auto pb-4">
				<?php
				$all_images = array_merge(
					$left_images ? explode(',', $left_images) : [],
					$right_images ? explode(',', $right_images) : []
				);
				foreach ($all_images as $image_id) {
					if ($image_id) {
						$image_url = wp_get_attachment_image_url($image_id, 'medium');
						$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
						echo '<div class="flex-shrink-0">';
						echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '" class="w-24 h-24 object-contain bg-white rounded-lg shadow-md p-2">';
						echo '</div>';
					}
				}
				?>
			</div>
		</div>
	</section>

	<!-- Social Links Section -->
	<section class="bg-white py-16">
		<div class="container mx-auto px-4 text-center">
			<h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">Kết nối với chúng tôi</h3>
			<p class="text-gray-600 mb-8 max-w-2xl mx-auto">Theo dõi Arata Vietnam trên các nền tảng mạng xã hội để cập nhật thông tin mới nhất về sản phẩm và chương trình khuyến mãi.</p>
			
			<div class="flex justify-center items-center space-x-6 lg:space-x-8">
				<?php
				$facebook_url = get_post_meta(get_the_ID(), 'arata_about_facebook', true);
				$instagram_url = get_post_meta(get_the_ID(), 'arata_about_instagram', true);
				$tiktok_url = get_post_meta(get_the_ID(), 'arata_about_tiktok', true);
				$shopee_url = get_post_meta(get_the_ID(), 'arata_about_shopee', true);
				?>

				<?php if ($facebook_url) : ?>
					<a href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener noreferrer" class="group">
						<div class="w-16 h-16 lg:w-20 lg:h-20 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition-colors duration-300 group-hover:scale-110 transform transition-transform">
							<svg class="w-8 h-8 lg:w-10 lg:h-10" fill="currentColor" viewBox="0 0 24 24">
								<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
							</svg>
						</div>
						<span class="block mt-2 text-sm font-medium text-gray-700 group-hover:text-blue-600">Facebook</span>
					</a>
				<?php endif; ?>

				<?php if ($instagram_url) : ?>
					<a href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener noreferrer" class="group">
						<div class="w-16 h-16 lg:w-20 lg:h-20 bg-gradient-to-br from-purple-600 to-pink-500 rounded-full flex items-center justify-center text-white hover:from-purple-700 hover:to-pink-600 transition-colors duration-300 group-hover:scale-110 transform transition-transform">
							<svg class="w-8 h-8 lg:w-10 lg:h-10" fill="currentColor" viewBox="0 0 24 24">
								<path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.864 3.708 13.713 3.708 12.416s.49-2.448 1.418-3.323c.875-.875 2.026-1.297 3.323-1.297s2.448.422 3.323 1.297c.928.875 1.418 2.026 1.418 3.323s-.49 2.448-1.418 3.275c-.875.807-2.026 1.297-3.323 1.297zm7.83-9.404c-.49 0-.875-.385-.875-.875s.385-.875.875-.875.875.385.875.875-.385.875-.875.875zm-4.262 1.297c-1.297 0-2.346 1.049-2.346 2.346s1.049 2.346 2.346 2.346 2.346-1.049 2.346-2.346-1.049-2.346-2.346-2.346z"/>
							</svg>
						</div>
						<span class="block mt-2 text-sm font-medium text-gray-700 group-hover:text-pink-600">Instagram</span>
					</a>
				<?php endif; ?>

				<?php if ($tiktok_url) : ?>
					<a href="<?php echo esc_url($tiktok_url); ?>" target="_blank" rel="noopener noreferrer" class="group">
						<div class="w-16 h-16 lg:w-20 lg:h-20 bg-black rounded-full flex items-center justify-center text-white hover:bg-gray-800 transition-colors duration-300 group-hover:scale-110 transform transition-transform">
							<svg class="w-8 h-8 lg:w-10 lg:h-10" fill="currentColor" viewBox="0 0 24 24">
								<path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
							</svg>
						</div>
						<span class="block mt-2 text-sm font-medium text-gray-700 group-hover:text-gray-900">TikTok</span>
					</a>
				<?php endif; ?>

				<?php if ($shopee_url) : ?>
					<a href="<?php echo esc_url($shopee_url); ?>" target="_blank" rel="noopener noreferrer" class="group">
						<div class="w-16 h-16 lg:w-20 lg:h-20 bg-orange-500 rounded-full flex items-center justify-center text-white hover:bg-orange-600 transition-colors duration-300 group-hover:scale-110 transform transition-transform">
							<svg class="w-8 h-8 lg:w-10 lg:h-10" fill="currentColor" viewBox="0 0 24 24">
								<path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21H4a1 1 0 01-1-1v-6c0-2.206 1.794-4 4-4h10c2.206 0 4 1.794 4 4v6a1 1 0 01-1 1z"/>
							</svg>
						</div>
						<span class="block mt-2 text-sm font-medium text-gray-700 group-hover:text-orange-600">Shopee</span>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>

<style>
/* Floating Animation */
@keyframes float {
	0%, 100% { transform: translateY(0px); }
	50% { transform: translateY(-20px); }
}

@keyframes floatReverse {
	0%, 100% { transform: translateY(0px); }
	50% { transform: translateY(20px); }
}

.floating-image {
	animation: float 6s ease-in-out infinite;
}

.floating-images-right .floating-image:nth-child(even) {
	animation: floatReverse 6s ease-in-out infinite;
}

.floating-images-left .floating-image:nth-child(odd) {
	animation: floatReverse 6s ease-in-out infinite;
}

/* Prose styling for white text */
.prose.text-white h1,
.prose.text-white h2,
.prose.text-white h3,
.prose.text-white h4,
.prose.text-white h5,
.prose.text-white h6 {
	color: white;
}

.prose.text-white p,
.prose.text-white li {
	color: rgba(255, 255, 255, 0.9);
}

.prose.text-white strong {
	color: white;
}
</style>

<?php get_footer(); ?>
