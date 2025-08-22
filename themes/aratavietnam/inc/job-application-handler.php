<?php
/**
 * Handles the submission of the job application form.
 *
 * @package ArataVietnam
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the admin_post action for the form submission.
 */
add_action('admin_post_nopriv_arata_job_application_submit', 'arata_handle_job_application_submission');
add_action('admin_post_arata_job_application_submit', 'arata_handle_job_application_submission');

function arata_handle_job_application_submission() {
    // Verify nonce
    if (!isset($_POST['arata_job_application_nonce']) || !wp_verify_nonce($_POST['arata_job_application_nonce'], 'arata_job_application_submit')) {
        wp_die('Nonce verification failed!', 'Error');
    }

    // Sanitize and validate form data
    $job_id = isset($_POST['job_id']) ? absint($_POST['job_id']) : 0;
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $cover_letter = isset($_POST['cover_letter']) ? sanitize_textarea_field($_POST['cover_letter']) : '';

    // Basic validation
    if (empty($name) || empty($email) || empty($phone) || empty($_FILES['cv']['name']) || !$job_id) {
        wp_die('Please fill in all required fields.', 'Error');
    }

    // Handle file upload
    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }

    $uploadedfile = $_FILES['cv'];
    $upload_overrides = ['test_form' => false];
    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

    if ($movefile && !isset($movefile['error'])) {
        $cv_url = $movefile['url'];

        // Create a new job_application post
        $post_title = 'Application for ' . get_the_title($job_id) . ' by ' . $name;
        $new_application = [
            'post_title'    => $post_title,
            'post_status'   => 'publish',
            'post_type'     => 'job_application',
        ];

        $post_id = wp_insert_post($new_application);

        if ($post_id) {
            // Save custom fields
            update_post_meta($post_id, 'arata_applicant_name', $name);
            update_post_meta($post_id, 'arata_applicant_email', $email);
            update_post_meta($post_id, 'arata_applicant_phone', $phone);
            update_post_meta($post_id, 'arata_applicant_position', get_the_title($job_id));
            update_post_meta($post_id, 'arata_applicant_cv', $cv_url);
            update_post_meta($post_id, 'arata_applicant_cover_letter', $cover_letter);

            // Redirect to a thank you page
            $redirect_url = add_query_arg('application_success', 'true', get_permalink($job_id));
            wp_redirect($redirect_url);
            exit;
        } else {
            wp_die('Failed to save application.', 'Error');
        }
    } else {
        wp_die('File upload error: ' . $movefile['error'], 'Error');
    }
}

