<?php
/**
 * User Profile Meta Fields
 *
 * Adds custom meta fields to user profiles for additional information
 *
 * @package ArataVietnam
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add custom user meta fields
 */
add_action('show_user_profile', 'arata_add_custom_user_profile_fields');
add_action('edit_user_profile', 'arata_add_custom_user_profile_fields');

function arata_add_custom_user_profile_fields($user) {
    ?>
    <h3><?php _e('Thông tin cá nhân bổ sung', 'aratavietnam'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="arata_phone"><?php _e('Số điện thoại', 'aratavietnam'); ?></label></th>
            <td>
                <input type="tel" name="arata_phone" id="arata_phone" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'arata_phone', true)); ?>" 
                       class="regular-text" />
                <p class="description"><?php _e('Số điện thoại liên hệ của bạn', 'aratavietnam'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_address"><?php _e('Địa chỉ', 'aratavietnam'); ?></label></th>
            <td>
                <textarea name="arata_address" id="arata_address" rows="3" 
                          class="regular-text"><?php echo esc_textarea(get_user_meta($user->ID, 'arata_address', true)); ?></textarea>
                <p class="description"><?php _e('Địa chỉ cư trú của bạn', 'aratavietnam'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_city"><?php _e('Thành phố', 'aratavietnam'); ?></label></th>
            <td>
                <input type="text" name="arata_city" id="arata_city" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'arata_city', true)); ?>" 
                       class="regular-text" />
                <p class="description"><?php _e('Thành phố/Tỉnh nơi bạn sinh sống', 'aratavietnam'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_company"><?php _e('Công ty', 'aratavietnam'); ?></label></th>
            <td>
                <input type="text" name="arata_company" id="arata_company" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'arata_company', true)); ?>" 
                       class="regular-text" />
                <p class="description"><?php _e('Tên công ty nơi bạn làm việc', 'aratavietnam'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_position"><?php _e('Chức vụ', 'aratavietnam'); ?></label></th>
            <td>
                <input type="text" name="arata_position" id="arata_position" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'arata_position', true)); ?>" 
                       class="regular-text" />
                <p class="description"><?php _e('Chức vụ của bạn tại công ty', 'aratavietnam'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_bio"><?php _e('Giới thiệu bản thân', 'aratavietnam'); ?></label></th>
            <td>
                <?php 
                $content = get_user_meta($user->ID, 'arata_bio', true);
                $editor_id = 'arata_bio';
                $settings = array(
                    'textarea_name' => 'arata_bio',
                    'media_buttons' => false,
                    'textarea_rows' => 5,
                    'teeny' => true,
                );
                wp_editor($content, $editor_id, $settings);
                ?>
                <p class="description"><?php _e('Giới thiệu ngắn gọn về bản thân bạn', 'aratavietnam'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_birth_date"><?php _e('Ngày sinh', 'aratavietnam'); ?></label></th>
            <td>
                <input type="date" name="arata_birth_date" id="arata_birth_date" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'arata_birth_date', true)); ?>" 
                       class="regular-text" />
                <p class="description"><?php _e('Ngày sinh của bạn (YYYY-MM-DD)', 'aratavietnam'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_gender"><?php _e('Giới tính', 'aratavietnam'); ?></label></th>
            <td>
                <select name="arata_gender" id="arata_gender">
                    <option value=""><?php _e('-- Chọn --', 'aratavietnam'); ?></option>
                    <option value="male" <?php selected(get_user_meta($user->ID, 'arata_gender', true), 'male'); ?>>
                        <?php _e('Nam', 'aratavietnam'); ?>
                    </option>
                    <option value="female" <?php selected(get_user_meta($user->ID, 'arata_gender', true), 'female'); ?>>
                        <?php _e('Nữ', 'aratavietnam'); ?>
                    </option>
                    <option value="other" <?php selected(get_user_meta($user->ID, 'arata_gender', true), 'other'); ?>>
                        <?php _e('Khác', 'aratavietnam'); ?>
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="arata_interests"><?php _e('Sở thích', 'aratavietnam'); ?></label></th>
            <td>
                <input type="text" name="arata_interests" id="arata_interests" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'arata_interests', true)); ?>" 
                       class="regular-text" />
                <p class="description"><?php _e('Sở thích cá nhân (cách nhau bằng dấu phẩy)', 'aratavietnam'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_website"><?php _e('Website', 'aratavietnam'); ?></label></th>
            <td>
                <input type="url" name="arata_website" id="arata_website" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'arata_website', true)); ?>" 
                       class="regular-text" />
                <p class="description"><?php _e('Website cá nhân hoặc portfolio', 'aratavietnam'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_facebook"><?php _e('Facebook', 'aratavietnam'); ?></label></th>
            <td>
                <input type="url" name="arata_facebook" id="arata_facebook" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'arata_facebook', true)); ?>" 
                       class="regular-text" />
                <p class="description"><?php _e('Link profile Facebook', 'aratavietnam'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="arata_linkedin"><?php _e('LinkedIn', 'aratavietnam'); ?></label></th>
            <td>
                <input type="url" name="arata_linkedin" id="arata_linkedin" 
                       value="<?php echo esc_attr(get_user_meta($user->ID, 'arata_linkedin', true)); ?>" 
                       class="regular-text" />
                <p class="description"><?php _e('Link profile LinkedIn', 'aratavietnam'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save custom user meta fields
 */
add_action('personal_options_update', 'arata_save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'arata_save_custom_user_profile_fields');

function arata_save_custom_user_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    // Sanitize and save each field
    $fields = array(
        'arata_phone' => 'sanitize_text_field',
        'arata_address' => 'sanitize_textarea_field',
        'arata_city' => 'sanitize_text_field',
        'arata_company' => 'sanitize_text_field',
        'arata_position' => 'sanitize_text_field',
        'arata_birth_date' => 'sanitize_text_field',
        'arata_gender' => 'sanitize_text_field',
        'arata_interests' => 'sanitize_text_field',
        'arata_website' => 'sanitize_url',
        'arata_facebook' => 'sanitize_url',
        'arata_linkedin' => 'sanitize_url',
    );

    foreach ($fields as $field => $sanitize_callback) {
        if (isset($_POST[$field])) {
            update_user_meta($user_id, $field, call_user_func($sanitize_callback, $_POST[$field]));
        }
    }

    // Handle bio field separately
    if (isset($_POST['arata_bio'])) {
        update_user_meta($user_id, 'arata_bio', wp_kses_post($_POST['arata_bio']));
    }
}

/**
 * Add user meta fields to registration
 */
add_action('arata_user_register_meta', 'arata_add_user_register_meta_fields', 10, 2);

function arata_add_user_register_meta_fields($user_id, $user_data) {
    // Add default values for new users
    update_user_meta($user_id, 'arata_member_since', current_time('mysql'));
    update_user_meta($user_id, 'arata_last_login', current_time('mysql'));
}

/**
 * Update last login time
 */
add_action('wp_login', 'arata_update_last_login', 10, 2);

function arata_update_last_login($user_login, $user) {
    update_user_meta($user->ID, 'arata_last_login', current_time('mysql'));
}