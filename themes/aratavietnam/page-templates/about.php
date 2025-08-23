<?php
/**
 * Template Name: About Page
 * Template Post Type: page
 * Description: About page with modern hero and comprehensive company information
 */

if (!defined('ABSPATH')) { exit; }

get_header();

// Get page meta fields
$hero_subtitle = get_post_meta(get_the_ID(), 'arata_about_subtitle', true) ?: 'Chuyên gia hóa mỹ phẩm Nhật Bản tại Việt Nam';
$hero_description = get_post_meta(get_the_ID(), 'arata_about_description', true) ?: 'Arata Vietnam tự hào là đối tác tin cậy trong lĩnh vực hóa mỹ phẩm, mang đến những sản phẩm chất lượng cao và dịch vụ chuyên nghiệp.';

// About page content fields
$about_company_intro = get_post_meta(get_the_ID(), 'arata_about_company_intro', true);
$about_history = get_post_meta(get_the_ID(), 'arata_about_history', true);
$about_mission = get_post_meta(get_the_ID(), 'arata_about_mission', true);
$about_values = get_post_meta(get_the_ID(), 'arata_about_values', true);
$about_commitment = get_post_meta(get_the_ID(), 'arata_about_commitment', true);
$about_left_image = get_post_meta(get_the_ID(), 'arata_about_left_image', true);
$about_right_image = get_post_meta(get_the_ID(), 'arata_about_right_image', true);

// Statistics
$stats_customers = get_post_meta(get_the_ID(), 'arata_stats_customers', true) ?: '500+';
$stats_projects = get_post_meta(get_the_ID(), 'arata_stats_projects', true) ?: '50+';
$stats_years = get_post_meta(get_the_ID(), 'arata_stats_years', true) ?: '5+';
$stats_success_rate = get_post_meta(get_the_ID(), 'arata_stats_success_rate', true) ?: '98%';

// Set hero variables
set_query_var('title', get_the_title());
set_query_var('subtitle', $hero_subtitle);
set_query_var('description', $hero_description);

// Use the standard hero template
get_template_part('template-parts/hero');
?>

<main id="site-content" class="bg-white">
    <!-- About Content Section - Theo brief -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">

                                <!-- Left Side - Product Images -->
                <div class="lg:col-span-3">
                    <?php if ($about_left_image) : ?>
                        <div class="aspect-square rounded-lg overflow-hidden">
                            <?php echo wp_get_attachment_image($about_left_image, 'medium', false, ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Center - Company Content -->
                <div class="lg:col-span-6">
                    <article id="post-<?php the_ID(); ?>" <?php post_class('prose prose-lg max-w-none text-gray-800'); ?>>
                        <h1 class="text-4xl font-bold mb-6 text-center"><?php the_title(); ?></h1>

                        <div class="entry-content mb-8">
                            <?php
                            if (have_posts()) {
                                while (have_posts()) {
                                    the_post();
                                    the_content();
                                }
                            }
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
                            <section class="mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Giới thiệu công ty</h2>
                                <div class="bg-white rounded-lg p-6 shadow-sm">
                                    <div class="text-gray-700 leading-relaxed">
                                        <?php echo wp_kses_post($company_intro); ?>
                                    </div>
                                </div>
                            </section>
                        <?php endif; ?>

                        <?php if ($history) : ?>
                            <section class="mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Lịch sử & Thành tựu</h2>
                                <div class="bg-white rounded-lg p-6 shadow-sm">
                                    <div class="text-gray-700 leading-relaxed">
                                        <?php echo wp_kses_post($history); ?>
                                    </div>
                                </div>
                            </section>
                        <?php endif; ?>

                        <?php if ($mission) : ?>
                            <section class="mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Sứ mệnh & Tầm nhìn</h2>
                                <div class="bg-white rounded-lg p-6 shadow-sm">
                                    <div class="text-gray-700 leading-relaxed">
                                        <?php echo wp_kses_post($mission); ?>
                                    </div>
                                </div>
                            </section>
                        <?php endif; ?>

                        <?php if ($values) : ?>
                            <section class="mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Giá trị cốt lõi</h2>
                                <div class="bg-white rounded-lg p-6 shadow-sm">
                                    <div class="text-gray-700 leading-relaxed">
                                        <?php echo wp_kses_post($values); ?>
                                    </div>
                                </div>
                            </section>
                        <?php endif; ?>

                        <?php if ($commitment) : ?>
                            <section class="mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Cam kết chất lượng</h2>
                                <div class="bg-white rounded-lg p-6 shadow-sm">
                                    <div class="text-gray-700 leading-relaxed">
                                        <?php echo wp_kses_post($commitment); ?>
                                    </div>
                                </div>
                            </section>
                        <?php endif; ?>
                    </article>
                </div>

                                <!-- Right Side - Product Images -->
                <div class="lg:col-span-3">
                    <?php if ($about_right_image) : ?>
                        <div class="aspect-square rounded-lg overflow-hidden">
                            <?php echo wp_get_attachment_image($about_right_image, 'medium', false, ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Links Section - Theo brief -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
                        <div class="text-center">
                <?php
                // Get social media URLs from theme customizer with default values
                $facebook_url = get_theme_mod('footer_facebook_url', 'https://www.facebook.com/aratavietnam');
                $instagram_url = get_theme_mod('footer_instagram_url', 'https://www.instagram.com/aratavietnam/');
                $tiktok_url = get_theme_mod('footer_tiktok_url', '');
                $shopee_url = get_theme_mod('footer_shopee_url', '');
                $website_url = get_theme_mod('footer_website_url', 'https://aratavietnam.com');


                ?>

                <h2 class="text-2xl font-bold text-gray-900 mb-8">Kết nối với chúng tôi</h2>
                <div class="flex justify-center space-x-6">

                    <!-- Facebook -->
                    <?php if (!empty($facebook_url)) : ?>
                        <a href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 bg-secondary text-white rounded-full flex items-center justify-center hover:bg-secondary-dark transition-colors">
                            <span data-icon="facebook" data-size="24"></span>
                        </a>
                    <?php endif; ?>

                    <!-- Instagram -->
                    <?php if (!empty($instagram_url)) : ?>
                        <a href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 bg-secondary text-white rounded-full flex items-center justify-center hover:bg-secondary-dark transition-colors">
                            <span data-icon="instagram" data-size="24"></span>
                        </a>
                    <?php endif; ?>

                    <!-- TikTok -->
                    <?php if (!empty($tiktok_url)) : ?>
                        <a href="<?php echo esc_url($tiktok_url); ?>" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 bg-secondary text-white rounded-full flex items-center justify-center hover:bg-secondary-dark transition-colors">
                            <span data-icon="music" data-size="24"></span>
                        </a>
                    <?php endif; ?>

                    <!-- Shopee -->
                    <?php if (!empty($shopee_url)) : ?>
                        <a href="<?php echo esc_url($shopee_url); ?>" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 bg-secondary text-white rounded-full flex items-center justify-center hover:bg-secondary-dark transition-colors">
                            <span data-icon="shopping-bag" data-size="24"></span>
                        </a>e
                    <?php endif; ?>

                    <!-- Website -->
                    <?php if (!empty($website_url)) : ?>
                        <a href="<?php echo esc_url($website_url); ?>" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 bg-secondary text-white rounded-full flex items-center justify-center hover:bg-secondary-dark transition-colors">
                            <span data-icon="globe" data-size="24"></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
