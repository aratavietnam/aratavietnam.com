<?php
/**
 * Template Name: About Page - New Layout
 * Template Post Type: page
 * Description: About page with alternating text-image sections
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Get global colors
$primary_color = get_theme_mod('theme_primary_color', '#F55E25');
$secondary_color = get_theme_mod('theme_secondary_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');

// Get the main background color from Customizer
$background_color = get_theme_mod('theme_background_color', '#ffffff');


// Get page meta fields
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_about_subtitle', true) ?: 'Chuyên gia hóa mỹ phẩm Nhật Bản tại Việt Nam';
$hero_description = get_post_meta(get_the_ID(), 'arata_about_description', true) ?: 'Arata Vietnam tự hào là đối tác tin cậy trong lĩnh vực hóa mỹ phẩm, mang đến những sản phẩm chất lượng cao và dịch vụ chuyên nghiệp.';

// About page content fields
$about_company_intro = get_post_meta(get_the_ID(), 'arata_about_company_intro', true);
$about_history = get_post_meta(get_the_ID(), 'arata_about_history', true);
$about_mission = get_post_meta(get_the_ID(), 'arata_about_mission', true);
$about_values = get_post_meta(get_the_ID(), 'arata_about_values', true);
$about_commitment = get_post_meta(get_the_ID(), 'arata_about_commitment', true);

// Section images
$section1_image = get_post_meta(get_the_ID(), 'arata_section1_image', true);
$section2_image = get_post_meta(get_the_ID(), 'arata_section2_image', true);
$section3_image = get_post_meta(get_the_ID(), 'arata_section3_image', true);
$section4_image = get_post_meta(get_the_ID(), 'arata_section4_image', true);

// Section visibility
$show_hero = get_post_meta(get_the_ID(), 'arata_show_hero', true) !== '0';
$use_compact_hero = get_post_meta(get_the_ID(), 'arata_compact_hero', true) === '1';
$show_company_intro = get_post_meta(get_the_ID(), 'arata_show_company_intro', true) !== '0';
$show_history = get_post_meta(get_the_ID(), 'arata_show_history', true) !== '0';
$show_mission = get_post_meta(get_the_ID(), 'arata_show_mission', true) !== '0';
$show_values = get_post_meta(get_the_ID(), 'arata_show_values', true) !== '0';
$show_commitment = get_post_meta(get_the_ID(), 'arata_show_commitment', true) !== '0';
$show_social_links = get_post_meta(get_the_ID(), 'arata_show_social_links', true) !== '0';

// Set hero variables
set_query_var('title', get_the_title());
set_query_var('subtitle', $hero_subtitle);
set_query_var('description', $hero_description);
set_query_var('compact_mode', $use_compact_hero);

// Show hero section if enabled
if ($show_hero) {
    get_template_part('template-parts/hero');
}
?>

<main id="site-content" style="background-color: <?php echo esc_attr($background_color); ?>;">
    
    <!-- Text - Image Section (Company Intro) -->
    <?php if ($about_company_intro && $show_company_intro) : ?>
    <section class="py-16 lg:py-24" style="background-color: <?php echo esc_attr($background_color); ?>;">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Column -->
                <div class="order-2 lg:order-1">
                    <div class="max-w-xl">
                        <div class="text-gray-700 leading-relaxed text-lg">
                            <?php echo wp_kses_post($about_company_intro); ?>
                        </div>
                    </div>
                </div>
                <!-- Image Column -->
                <div class="order-1 lg:order-2">
                    <?php if ($section1_image) : ?>
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden">
                            <?php echo wp_get_attachment_image($section1_image, 'large', false, ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                    <?php else : ?>
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-gradient-to-br from-secondary to-secondary-light flex items-center justify-center">
                            <div class="text-white text-center p-8">
                                <div class="text-6xl mb-4">🏢</div>
                                <p class="text-xl">Arata Vietnam</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Image - Text Section (History) -->
    <?php if ($about_history && $show_history) : ?>
    <section class="py-16 lg:py-24" style="background-color: <?php echo esc_attr($background_color); ?>;">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Image Column -->
                <div class="order-1 lg:order-1">
                    <?php if ($section2_image) : ?>
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden">
                            <?php echo wp_get_attachment_image($section2_image, 'large', false, ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                    <?php else : ?>
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-gradient-to-br from-primary to-primary-light flex items-center justify-center">
                            <div class="text-white text-center p-8">
                                <div class="text-6xl mb-4">📅</div>
                                <p class="text-xl">Lịch sử hình thành</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Text Column -->
                <div class="order-2 lg:order-2">
                    <div class="max-w-xl">
                        <div class="text-gray-700 leading-relaxed text-lg">
                            <?php echo wp_kses_post($about_history); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Text - Image Section (Mission) -->
    <?php if ($about_mission && $show_mission) : ?>
    <section class="py-16 lg:py-24" style="background-color: <?php echo esc_attr($background_color); ?>;">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Column -->
                <div class="order-2 lg:order-1">
                    <div class="max-w-xl">
                        <div class="text-gray-700 leading-relaxed text-lg">
                            <?php echo wp_kses_post($about_mission); ?>
                        </div>
                    </div>
                </div>
                <!-- Image Column -->
                <div class="order-1 lg:order-2">
                    <?php if ($section3_image) : ?>
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden">
                            <?php echo wp_get_attachment_image($section3_image, 'large', false, ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                    <?php else : ?>
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-gradient-to-br from-tertiary to-tertiary-light flex items-center justify-center">
                            <div class="text-white text-center p-8">
                                <div class="text-6xl mb-4">🎯</div>
                                <p class="text-xl">Sứ mệnh của chúng tôi</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Image - Text Section (Values & Commitment) -->
    <?php if (($about_values && $show_values) || ($about_commitment && $show_commitment)) : ?>
    <section class="py-16 lg:py-24" style="background-color: <?php echo esc_attr($background_color); ?>;">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Image Column -->
                <div class="order-1 lg:order-1">
                    <?php if ($section4_image) : ?>
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden">
                            <?php echo wp_get_attachment_image($section4_image, 'large', false, ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                    <?php else : ?>
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-gradient-to-br from-secondary-dark to-secondary flex items-center justify-center">
                            <div class="text-white text-center p-8">
                                <div class="text-6xl mb-4">💎</div>
                                <p class="text-xl">Giá trị cốt lõi</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Text Column -->
                <div class="order-2 lg:order-2">
                    <div class="max-w-xl space-y-8">
                        <?php if ($about_values && $show_values) : ?>
                        <div>
                            <div class="text-gray-700 leading-relaxed text-lg">
                                <?php echo wp_kses_post($about_values); ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($about_commitment && $show_commitment) : ?>
                        <div>
                            <div class="text-gray-700 leading-relaxed text-lg">
                                <?php echo wp_kses_post($about_commitment); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <!-- Social Links Section -->
    <?php if ($show_social_links) : ?>
    <section class="py-16 lg:py-24" style="background-color: <?php echo esc_attr($background_color); ?>;">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-12">Kết nối với chúng tôi</h2>
                <div class="flex justify-center space-x-8">
                    <?php
                    $facebook_url = get_theme_mod('footer_facebook_url', 'https://www.facebook.com/aratavietnam');
                    $instagram_url = get_theme_mod('footer_instagram_url', 'https://www.instagram.com/aratavietnam/');
                    $tiktok_url = get_theme_mod('footer_tiktok_url', '');
                    $shopee_url = get_theme_mod('footer_shopee_url', '');
                    $website_url = get_theme_mod('footer_website_url', 'https://aratavietnam.com');
                    ?>

                    <!-- Facebook -->
                    <?php if (!empty($facebook_url)) : ?>
                        <a href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener noreferrer"
                           class="w-16 h-16 bg-secondary text-white rounded-full flex items-center justify-center hover:bg-secondary-dark transition-all duration-300 hover:scale-110">
                            <span data-icon="facebook" data-size="28"></span>
                        </a>
                    <?php endif; ?>

                    <!-- Instagram -->
                    <?php if (!empty($instagram_url)) : ?>
                        <a href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener noreferrer"
                           class="w-16 h-16 bg-secondary text-white rounded-full flex items-center justify-center hover:bg-secondary-dark transition-all duration-300 hover:scale-110">
                            <span data-icon="instagram" data-size="28"></span>
                        </a>
                    <?php endif; ?>

                    <!-- TikTok -->
                    <?php if (!empty($tiktok_url)) : ?>
                        <a href="<?php echo esc_url($tiktok_url); ?>" target="_blank" rel="noopener noreferrer"
                           class="w-16 h-16 bg-secondary text-white rounded-full flex items-center justify-center hover:bg-secondary-dark transition-all duration-300 hover:scale-110">
                            <span data-icon="tiktok" data-size="28"></span>
                        </a>
                    <?php endif; ?>

                    <!-- Shopee -->
                    <?php if (!empty($shopee_url)) : ?>
                        <a href="<?php echo esc_url($shopee_url); ?>" target="_blank" rel="noopener noreferrer"
                           class="w-16 h-16 bg-secondary text-white rounded-full flex items-center justify-center hover:bg-secondary-dark transition-all duration-300 hover:scale-110">
                            <span data-icon="shopee" data-size="28"></span>
                        </a>
                    <?php endif; ?>

                    <!-- Website -->
                    <?php if (!empty($website_url)) : ?>
                        <a href="<?php echo esc_url($website_url); ?>" target="_blank" rel="noopener noreferrer"
                           class="w-16 h-16 bg-secondary text-white rounded-full flex items-center justify-center hover:bg-secondary-dark transition-all duration-300 hover:scale-110">
                            <span data-icon="globe" data-size="28"></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>