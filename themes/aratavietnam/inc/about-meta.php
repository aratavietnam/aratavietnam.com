<?php
/**
 * About Page custom meta fields (editable per-page)
 */

if (!defined('ABSPATH')) { exit; }

// Add meta box only on About Page template
add_action('add_meta_boxes', function() {
	add_meta_box(
		'arata_about_meta',
		__('About Page Settings', 'aratavietnam'),
		function($post) {
			$template = get_post_meta($post->ID, '_wp_page_template', true);
			if ($template !== 'page-templates/about.php') {
				echo '<p>' . esc_html__('Assign the "About Page" template to this page to use these settings.', 'aratavietnam') . '</p>';
				return;
			}

			wp_nonce_field('arata_about_meta_save', 'arata_about_meta_nonce');
			
			// Content fields
			$content_fields = [
				'arata_about_subtitle' => __('Hero subtitle', 'aratavietnam'),
				'arata_about_company_intro' => __('Company Introduction', 'aratavietnam'),
				'arata_about_history' => __('History & Achievements', 'aratavietnam'),
				'arata_about_mission' => __('Mission & Vision', 'aratavietnam'),
				'arata_about_values' => __('Core Values', 'aratavietnam'),
				'arata_about_commitment' => __('Quality Commitment', 'aratavietnam'),
			];

			// Social links
			$social_fields = [
				'arata_about_facebook' => __('Facebook URL', 'aratavietnam'),
				'arata_about_instagram' => __('Instagram URL', 'aratavietnam'),
				'arata_about_tiktok' => __('TikTok URL', 'aratavietnam'),
				'arata_about_shopee' => __('Shopee URL', 'aratavietnam'),
			];

			// Image fields
			$image_fields = [
				'arata_about_left_images' => __('Left Floating Images (comma-separated IDs)', 'aratavietnam'),
				'arata_about_right_images' => __('Right Floating Images (comma-separated IDs)', 'aratavietnam'),
			];

			echo '<div class="arata-about-meta-tabs">';
			echo '<nav class="nav-tab-wrapper">';
			echo '<a href="#content-tab" class="nav-tab nav-tab-active">Content</a>';
			echo '<a href="#social-tab" class="nav-tab">Social Links</a>';
			echo '<a href="#images-tab" class="nav-tab">Product Images</a>';
			echo '</nav>';

			// Content Tab
			echo '<div id="content-tab" class="tab-content active">';
			echo '<table class="form-table">';
			foreach ($content_fields as $key => $label) {
				$value = get_post_meta($post->ID, $key, true);
				echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
				if (in_array($key, ['arata_about_subtitle'])) {
					echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="large-text" value="' . esc_attr($value) . '" />';
				} else {
					echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="5" class="large-text">' . esc_textarea($value) . '</textarea>';
					echo '<p class="description">You can use HTML tags for formatting.</p>';
				}
				echo '</td></tr>';
			}
			echo '</table>';
			echo '</div>';

			// Social Tab
			echo '<div id="social-tab" class="tab-content">';
			echo '<table class="form-table">';
			foreach ($social_fields as $key => $label) {
				$value = get_post_meta($post->ID, $key, true);
				echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
				echo '<input type="url" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="regular-text" value="' . esc_attr($value) . '" placeholder="https://" />';
				echo '</td></tr>';
			}
			echo '</table>';
			echo '</div>';

			// Images Tab
			echo '<div id="images-tab" class="tab-content">';
			echo '<table class="form-table">';
			foreach ($image_fields as $key => $label) {
				$value = get_post_meta($post->ID, $key, true);
				echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
				echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="regular-text" value="' . esc_attr($value) . '" />';
				echo '<button type="button" class="button select-images" data-target="' . esc_attr($key) . '">Select Images</button>';
				echo '<p class="description">Select multiple images from Media Library. Image IDs will be saved as comma-separated values.</p>';
				
				// Preview images
				if ($value) {
					echo '<div class="image-preview" style="margin-top: 10px;">';
					$image_ids = explode(',', $value);
					foreach ($image_ids as $image_id) {
						if ($image_id) {
							$image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
							if ($image_url) {
								echo '<img src="' . esc_url($image_url) . '" style="width: 60px; height: 60px; object-fit: cover; margin-right: 10px; border: 1px solid #ddd;" />';
							}
						}
					}
					echo '</div>';
				}
				echo '</td></tr>';
			}
			echo '</table>';
			echo '</div>';

			echo '</div>'; // Close tabs container

			// Add JavaScript for tabs and image selection
			?>
			<script>
			jQuery(document).ready(function($) {
				// Tab functionality
				$('.nav-tab').click(function(e) {
					e.preventDefault();
					var target = $(this).attr('href');
					
					$('.nav-tab').removeClass('nav-tab-active');
					$(this).addClass('nav-tab-active');
					
					$('.tab-content').removeClass('active');
					$(target).addClass('active');
				});

				// Image selection
				$('.select-images').click(function(e) {
					e.preventDefault();
					var button = $(this);
					var target = button.data('target');
					var targetInput = $('#' + target);
					
					var mediaUploader = wp.media({
						title: 'Select Product Images',
						button: {
							text: 'Use these images'
						},
						multiple: true
					});

					mediaUploader.on('select', function() {
						var attachments = mediaUploader.state().get('selection').toJSON();
						var imageIds = [];
						
						attachments.forEach(function(attachment) {
							imageIds.push(attachment.id);
						});
						
						targetInput.val(imageIds.join(','));
						
						// Update preview
						var preview = targetInput.closest('td').find('.image-preview');
						preview.remove();
						
						if (imageIds.length > 0) {
							var previewHtml = '<div class="image-preview" style="margin-top: 10px;">';
							attachments.forEach(function(attachment) {
								var thumbnailUrl = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
								previewHtml += '<img src="' + thumbnailUrl + '" style="width: 60px; height: 60px; object-fit: cover; margin-right: 10px; border: 1px solid #ddd;" />';
							});
							previewHtml += '</div>';
							targetInput.closest('td').append(previewHtml);
						}
					});

					mediaUploader.open();
				});
			});
			</script>

			<style>
			.arata-about-meta-tabs .nav-tab-wrapper {
				margin-bottom: 20px;
			}
			
			.tab-content {
				display: none;
			}
			
			.tab-content.active {
				display: block;
			}
			
			.select-images {
				margin-left: 10px;
			}
			</style>
			<?php
		},
		'page',
		'normal',
		'default'
	);
});

// Save meta
add_action('save_post_page', function($post_id) {
	if (!isset($_POST['arata_about_meta_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_about_meta_nonce']), 'arata_about_meta_save')) {
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
	if (!current_user_can('edit_page', $post_id)) { return; }

	$keys = [
		'arata_about_subtitle',
		'arata_about_company_intro',
		'arata_about_history',
		'arata_about_mission',
		'arata_about_values',
		'arata_about_commitment',
		'arata_about_facebook',
		'arata_about_instagram',
		'arata_about_tiktok',
		'arata_about_shopee',
		'arata_about_left_images',
		'arata_about_right_images',
	];
	
	foreach ($keys as $key) {
		if (isset($_POST[$key])) {
			$value = is_string($_POST[$key]) ? wp_kses_post(wp_unslash($_POST[$key])) : '';
			update_post_meta($post_id, $key, $value);
		} else {
			delete_post_meta($post_id, $key);
		}
	}
});
