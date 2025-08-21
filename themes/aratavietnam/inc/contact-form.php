<?php
/**
 * Contact form handling and admin submissions listing
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Register custom post type for contact submissions
 */
add_action('init', function () {
	$labels = [
		'name' => __('Contact Submissions', 'aratavietnam'),
		'singular_name' => __('Contact Submission', 'aratavietnam'),
		'menu_name' => __('Liên hệ', 'aratavietnam'),
		'add_new_item' => __('Add New Submission', 'aratavietnam'),
		'edit_item' => __('View Submission', 'aratavietnam'),
		'view_item' => __('View Submission', 'aratavietnam'),
		'search_items' => __('Search Submissions', 'aratavietnam'),
	];

	register_post_type('contact_submission', [
		'labels' => $labels,
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_icon' => 'dashicons-email',
		'supports' => ['title'],
		'capability_type' => 'post',
		'has_archive' => false,
		'show_in_rest' => false,
	]);
});

/**
 * Customize admin columns for submissions
 */
add_filter('manage_contact_submission_posts_columns', function ($columns) {
	$new = [];
	$new['cb'] = $columns['cb'] ?? '';
	$new['title'] = __('Name', 'aratavietnam');
	$new['email'] = __('Email', 'aratavietnam');
	$new['phone'] = __('Phone', 'aratavietnam');
	$new['date'] = __('Date', 'aratavietnam');
	return $new;
});

add_action('manage_contact_submission_posts_custom_column', function ($column, $post_id) {
	switch ($column) {
		case 'email':
			$email = get_post_meta($post_id, 'arata_email', true);
			echo esc_html($email);
			break;
		case 'phone':
			$phone = get_post_meta($post_id, 'arata_phone', true);
			echo esc_html($phone);
			break;
	}
}, 10, 2);

/**
 * Add a meta box to view submission details
 */
add_action('add_meta_boxes', function () {
	add_meta_box(
		'contact_submission_details',
		__('Submission Details', 'aratavietnam'),
		function ($post) {
			$name = get_post_meta($post->ID, 'arata_name', true);
			$email = get_post_meta($post->ID, 'arata_email', true);
			$phone = get_post_meta($post->ID, 'arata_phone', true);
			$subject = get_post_meta($post->ID, 'arata_subject', true);
			$message = get_post_meta($post->ID, 'arata_message', true);
			?>
			<table class="form-table">
				<tr><th><?php _e('Name', 'aratavietnam'); ?></th><td><?php echo esc_html($name); ?></td></tr>
				<tr><th><?php _e('Email', 'aratavietnam'); ?></th><td><?php echo esc_html($email); ?></td></tr>
				<tr><th><?php _e('Phone', 'aratavietnam'); ?></th><td><?php echo esc_html($phone); ?></td></tr>
				<tr><th><?php _e('Subject', 'aratavietnam'); ?></th><td><?php echo esc_html($subject); ?></td></tr>
				<tr><th><?php _e('Message', 'aratavietnam'); ?></th><td><pre style="white-space:pre-wrap;word-break:break-word;"><?php echo esc_html($message); ?></pre></td></tr>
			</table>
			<?php
		},
		'contact_submission',
		'normal',
		'high'
	);
});

/**
 * Handle contact form submission (logged-in and guests)
 */
function arata_handle_contact_submission() {
	if (!isset($_POST['arata_contact_nonce']) || !wp_verify_nonce(sanitize_text_field($_POST['arata_contact_nonce']), 'arata_contact_submit')) {
		wp_die(__('Security check failed.', 'aratavietnam'));
	}

	$referer = isset($_POST['_wp_http_referer']) ? esc_url_raw(wp_unslash($_POST['_wp_http_referer'])) : home_url('/');

	// Honeypot field (should be empty)
	if (!empty($_POST['website'])) {
		wp_safe_redirect(add_query_arg('contact', 'error', $referer));
		exit;
	}

	$name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
	$email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
	$phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
	$subject = isset($_POST['subject']) ? sanitize_text_field(wp_unslash($_POST['subject'])) : '';
	$message = isset($_POST['message']) ? wp_kses_post(wp_unslash($_POST['message'])) : '';

	if (empty($name) || empty($email) || empty($message)) {
		wp_safe_redirect(add_query_arg('contact', 'error', $referer));
		exit;
	}

	$post_id = wp_insert_post([
		'post_type' => 'contact_submission',
		'post_status' => 'publish',
		'post_title' => sprintf(__('Contact from %s (%s)', 'aratavietnam'), $name, $email),
	]);

	if (is_wp_error($post_id) || !$post_id) {
		wp_safe_redirect(add_query_arg('contact', 'error', $referer));
		exit;
	}

	update_post_meta($post_id, 'arata_name', $name);
	update_post_meta($post_id, 'arata_email', $email);
	update_post_meta($post_id, 'arata_phone', $phone);
	update_post_meta($post_id, 'arata_subject', $subject);
	update_post_meta($post_id, 'arata_message', $message);

	// Optional: send notification email to admin
	$admin_email = get_option('admin_email');
	$subject_line = sprintf(__('New contact submission: %s', 'aratavietnam'), $subject ?: $name);
	$body = sprintf("Name: %s\nEmail: %s\nPhone: %s\nSubject: %s\n\nMessage:\n%s", $name, $email, $phone, $subject, wp_strip_all_tags($message));
	wp_mail($admin_email, $subject_line, $body);

	wp_safe_redirect(add_query_arg('contact', 'success', $referer));
	exit;
}

add_action('admin_post_nopriv_arata_contact_submit', 'arata_handle_contact_submission');
add_action('admin_post_arata_contact_submit', 'arata_handle_contact_submission');
