<?php
/**
 * Floating Social Media Widget
 *
 * @package ArataVietnam
 */

// Get settings from customizer
$show_floating_social = get_theme_mod('footer_show_floating_social', true);
$facebook_url = get_theme_mod('footer_facebook_url', 'https://www.facebook.com/aratavietnam');
$instagram_url = get_theme_mod('footer_instagram_url', 'https://www.instagram.com/aratavietnam/');
$website_url = get_theme_mod('footer_website_url', 'https://aratavietnam.com');
$tiktok_url = get_theme_mod('footer_tiktok_url', '');
$shopee_url = get_theme_mod('footer_shopee_url', '');
$phone_number = get_theme_mod('footer_company_phone_link', '0283357100');
$email = get_theme_mod('footer_company_email', 'arata-vietnam@arata-gr.jp');

// Don't show if disabled
if (!$show_floating_social) {
    return;
}

// Collect available social links
$social_links = array();

if (!empty($facebook_url) && $facebook_url !== '#') {
    $social_links[] = array(
        'url' => $facebook_url,
        'icon' => 'facebook',
        'label' => 'Facebook',
        'color' => '#1877F2'
    );
}

if (!empty($instagram_url) && $instagram_url !== '#') {
    $social_links[] = array(
        'url' => $instagram_url,
        'icon' => 'instagram',
        'label' => 'Instagram',
        'color' => '#E4405F'
    );
}

if (!empty($tiktok_url) && $tiktok_url !== '#') {
    $social_links[] = array(
        'url' => $tiktok_url,
        'icon' => 'tiktok',
        'label' => 'TikTok',
        'color' => '#000000'
    );
}

if (!empty($shopee_url) && $shopee_url !== '#') {
    $social_links[] = array(
        'url' => $shopee_url,
        'icon' => 'shopee',
        'label' => 'Shopee',
        'color' => '#EE4D2D'
    );
}

if (!empty($website_url) && $website_url !== '#') {
    $social_links[] = array(
        'url' => $website_url,
        'icon' => 'website',
        'label' => 'Website',
        'color' => '#0066A6'
    );
}

// Contact links
if (!empty($phone_number)) {
    $social_links[] = array(
        'url' => 'tel:' . $phone_number,
        'icon' => 'phone',
        'label' => 'Gọi điện',
        'color' => '#25D366'
    );
}

if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $social_links[] = array(
        'url' => 'mailto:' . $email,
        'icon' => 'email',
        'label' => 'Email',
        'color' => '#EA4335'
    );
}

// Don't show if no links available
if (empty($social_links)) {
    return;
}
?>

<div id="floating-social-widget" class="floating-social-widget">
    <!-- Toggle Button -->
    <button id="floating-social-toggle" class="floating-social-toggle" aria-label="Mở/Đóng mạng xã hội">
        <span class="icon-open" data-icon="message-circle" data-size="24" data-stroke="2.5"></span>
        <span class="icon-close" data-icon="close" data-size="24" data-stroke="2.5"></span>
    </button>

    <!-- Social Links Container -->
    <div id="floating-social-links" class="floating-social-links">
        <?php foreach ($social_links as $index => $link): ?>
            <a href="<?php echo esc_url($link['url']); ?>"
               target="<?php echo ($link['icon'] === 'phone' || $link['icon'] === 'email') ? '_self' : '_blank'; ?>"
               rel="<?php echo ($link['icon'] === 'phone' || $link['icon'] === 'email') ? '' : 'noopener noreferrer'; ?>"
               class="floating-social-link"
               data-tooltip="<?php echo esc_attr($link['label']); ?>"
               style="--link-color: <?php echo esc_attr($link['color']); ?>; --delay: <?php echo $index * 0.1; ?>s;">

                <?php
                // Map icon names to correct icon names for the library
                $icon_map = array(
                    'facebook' => 'facebook',
                    'instagram' => 'instagram',
                    'tiktok' => 'tiktok',
                    'shopee' => 'shopee',
                    'website' => 'globe',
                    'phone' => 'phone',
                    'email' => 'mail'
                );
                $icon_name = isset($icon_map[$link['icon']]) ? $icon_map[$link['icon']] : $link['icon'];
                ?>
                <span data-icon="<?php echo esc_attr($icon_name); ?>" data-size="20" data-stroke="2.5"></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
