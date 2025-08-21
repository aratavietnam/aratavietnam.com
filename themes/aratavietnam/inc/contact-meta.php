<?php
/**
 * Contact Page custom meta fields (editable per-page)
 */

if (!defined('ABSPATH')) { exit; }

// Add meta box only on Contact Page template
add_action('add_meta_boxes', function() {
	add_meta_box(
		'arata_contact_meta',
		__('Contact Page Settings', 'aratavietnam'),
		function($post) {
			$fields = [
				'arata_contact_intro' => __('Intro (short description)', 'aratavietnam'),
				'arata_contact_address' => __('Address', 'aratavietnam'),
				'arata_contact_phone' => __('Phone', 'aratavietnam'),
				'arata_contact_email' => __('Email', 'aratavietnam'),
				'arata_contact_hours' => __('Working hours', 'aratavietnam'),
				'arata_contact_map' => __('Map embed URL (iframe src)', 'aratavietnam'),
				'arata_contact_subtitle' => __('Hero subtitle', 'aratavietnam'),
			];

			$template = get_post_meta($post->ID, '_wp_page_template', true);
			if ($template !== 'page-templates/contact.php') {
				echo '<p>' . esc_html__('Assign the "Contact Page" template to this page to use these settings.', 'aratavietnam') . '</p>';
				return;
			}

			wp_nonce_field('arata_contact_meta_save', 'arata_contact_meta_nonce');
			echo '<table class="form-table">';
			foreach ($fields as $key => $label) {
				$value = get_post_meta($post->ID, $key, true);
				echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
				if ($key === 'arata_contact_intro' || $key === 'arata_contact_address' || $key === 'arata_contact_hours') {
					echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
				} else {
					echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="regular-text" value="' . esc_attr($value) . '" />';
				}
				echo '</td></tr>';
			}
			echo '</table>';
		},
		'page',
		'normal',
		'default'
	);
});

// Save meta
add_action('save_post_page', function($post_id) {
	if (!isset($_POST['arata_contact_meta_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_contact_meta_nonce']), 'arata_contact_meta_save')) {
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }
	if (!current_user_can('edit_page', $post_id)) { return; }

	$keys = [
		'arata_contact_intro',
		'arata_contact_address',
		'arata_contact_phone',
		'arata_contact_email',
		'arata_contact_hours',
		'arata_contact_map',
		'arata_contact_subtitle',
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
