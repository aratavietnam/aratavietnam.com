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
        <svg class="icon-open w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M12 1v6m0 6v6m11-7h-6m-6 0H1"></path>
        </svg>
        <svg class="icon-close w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
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

                <?php if ($link['icon'] === 'facebook'): ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 3.667h-3.533v7.98H9.101z"/>
                    </svg>
                <?php elseif ($link['icon'] === 'instagram'): ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                <?php elseif ($link['icon'] === 'tiktok'): ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-.88-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                    </svg>
                <?php elseif ($link['icon'] === 'shopee'): ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.5 12c0 1.5-1.5 3-3 3s-3-1.5-3-3 1.5-3 3-3 3 1.5 3 3zm-9 0c0 1.5-1.5 3-3 3s-3-1.5-3-3 1.5-3 3-3 3 1.5 3 3zm4.5-9c-5 0-9 4-9 9s4 9 9 9 9-4 9-9-4-9-9-9zm0 16c-3.9 0-7-3.1-7-7s3.1-7 7-7 7 3.1 7 7-3.1 7-7 7z"/>
                    </svg>
                <?php elseif ($link['icon'] === 'website'): ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="2" y1="12" x2="22" y2="12"></line>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                    </svg>
                <?php elseif ($link['icon'] === 'phone'): ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                    </svg>
                <?php elseif ($link['icon'] === 'email'): ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
