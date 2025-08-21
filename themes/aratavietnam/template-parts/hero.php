<?php
/**
 * Reusable Hero section
 */

if (!defined('ABSPATH')) { exit; }

$title = get_query_var('title');
if (!$title) { $title = get_the_title(); }
$subtitle = get_query_var('subtitle');
?>

<section class="relative bg-gradient-to-br from-primary/5 via-white to-secondary/5 border-b border-gray-200">
	<div class="absolute inset-0 bg-gradient-to-r from-primary/3 to-transparent"></div>
	<div class="relative container mx-auto px-4 py-16 sm:py-20">
		<div class="max-w-4xl">
			<div class="flex items-center mb-4">
				<div class="w-12 h-1 bg-primary rounded-full mr-4"></div>
				<span class="text-primary font-medium text-sm uppercase tracking-wider">Liên hệ với chúng tôi</span>
			</div>
			<h1 class="text-4xl sm:text-6xl font-bold text-gray-900 leading-tight mb-6">
				<?php echo esc_html($title); ?>
			</h1>
			<?php if (!empty($subtitle)) : ?>
				<p class="text-xl text-gray-600 leading-relaxed max-w-2xl">
					<?php echo wp_kses_post($subtitle); ?>
				</p>
			<?php else : ?>
				<p class="text-xl text-gray-600 leading-relaxed max-w-2xl">
					Gửi yêu cầu của bạn, chúng tôi sẽ phản hồi trong thời gian sớm nhất.
				</p>
			<?php endif; ?>
		</div>
	</div>
</section>
