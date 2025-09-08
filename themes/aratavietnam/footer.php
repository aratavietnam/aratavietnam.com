<?php
/**
 * The template for displaying the footer
 */

// Get footer background color from customizer
$footer_background_color = get_theme_mod('theme_footer_background_color', '#0066A6');
$tertiary_color = get_theme_mod('theme_tertiary_color', '#FFAB14');
?>

<footer id="colophon" class="site-footer relative z-10" style="background-color: <?php echo esc_attr($footer_background_color); ?>;">
    <div class="container mx-auto px-4 py-12">
        <div>
            <!-- Footer Content -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 mb-12 lg:items-start">

                <!-- Company Information (Mobile: Second, Desktop: First) -->
                <div class="text-left space-y-4 order-2 lg:order-1 lg:col-span-3">
                    <!-- Company Name -->
                    <div class="mb-3">
                        <h3 class="text-lg font-bold text-white mb-2">
                            <?php echo esc_html(get_theme_mod('footer_company_name', 'Công ty TNHH Arata Việt Nam')); ?>
                        </h3>
                        <div class="w-16 h-1 rounded-full" style="background: #FFAB14;"></div>
                    </div>

                    <div class="grid gap-y-4">
                        <!-- Address -->
                        <div class="flex items-start group">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 transition-all duration-300 flex-shrink-0" style="background: #FFAB14;">
                                <span data-icon="location" data-size="20" data-stroke="2" class="text-white"></span>
                            </div>
                            <div>
                                <p class="text-white font-medium mb-1">Địa chỉ</p>
                                <p class="text-white/80 text-sm leading-relaxed">
                                    <?php echo nl2br(esc_html(get_theme_mod('footer_company_address', "Lầu 2, Tòa nhà The Landmark,\n5B Tôn Đức Thắng, Phường Bến Nghé,\nQuận 1, Thành phố Hồ Chí Minh"))); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start group">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 transition-all duration-300 flex-shrink-0" style="background: #FFAB14;">
                                <span data-icon="phone" data-size="20" data-stroke="2" class="text-white"></span>
                            </div>
                            <div>
                                <p class="text-white font-medium mb-1">Điện thoại</p>
                                <a href="tel:<?php echo esc_attr(get_theme_mod('footer_company_phone_link', '+84 28 3827 7060')); ?>" class="text-white/80 hover:text-white transition-colors duration-300 hover:underline">
                                    <?php echo esc_html(get_theme_mod('footer_company_phone', '+84 28 3827 7060')); ?>
                                </a>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start group">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 transition-all duration-300 flex-shrink-0" style="background: #FFAB14;">
                                <span data-icon="mail" data-size="20" data-stroke="2" class="text-white"></span>
                            </div>
                            <div>
                                <p class="text-white font-medium mb-1">Email</p>
                                <a href="mailto:<?php echo esc_attr(get_theme_mod('footer_company_email', 'arata-vietnam@arata-gr.jp')); ?>" class="text-white/80 hover:text-white transition-colors duration-300 hover:underline break-all">
                                    <?php echo esc_html(get_theme_mod('footer_company_email', 'arata-vietnam@arata-gr.jp')); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logo + Description + Social Media (Mobile: First, Desktop: Middle) -->
                <div class="text-left lg:text-center space-y-5 order-1 lg:order-2 lg:col-span-6">
                    <!-- Logo -->
                    <div class="mb-5">
                        <?php
                        $footer_logo_id = get_theme_mod('footer_logo');
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo_url = get_template_directory_uri() . '/assets/images/logo.png';

                        // Priority: Footer Logo > Custom Logo > Default Logo
                        if ($footer_logo_id) {
                            echo wp_get_attachment_image($footer_logo_id, 'full', false, array(
                                'class' => 'h-16 w-auto lg:mx-auto',
                                'alt' => get_bloginfo('name')
                            ));
                        } elseif ($custom_logo_id) {
                            echo wp_get_attachment_image($custom_logo_id, 'full', false, array(
                                'class' => 'h-16 w-auto lg:mx-auto',
                                'alt' => get_bloginfo('name')
                            ));
                        } elseif (file_exists(get_template_directory() . '/assets/images/logo.png')) {
                            echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="h-16 w-auto lg:mx-auto">';
                        } else {
                            echo '<div class="text-2xl font-bold text-white">' . get_bloginfo('name') . '</div>';
                        }
                        ?>
                    </div>

                    <!-- Company Description -->
                    <div class="mb-5">
                        <p class="text-white/90 text-sm leading-relaxed max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl text-left lg:text-center lg:mx-auto">
                            <?php
                            $description = get_theme_mod('footer_company_description', "Arata Việt Nam là công ty con của Tập đoàn Arata Nhật Bản.<br>Chúng tôi kinh doanh các sản phẩm Hóa Mỹ Phẩm<br>được nhập khẩu trực tiếp từ Nhật Bản.");
                            echo $description;
                            ?>
                        </p>
                    </div>

                    <!-- Social Media Icons -->
                    <div class="flex justify-start lg:justify-center gap-4">
                        <?php
                        $facebook_url = get_theme_mod('footer_facebook_url', 'https://www.facebook.com/aratavietnam');
                        $instagram_url = get_theme_mod('footer_instagram_url', 'https://www.instagram.com/aratavietnam/');
                        $website_url = get_theme_mod('footer_website_url', 'https://aratavietnam.com');
                        $tiktok_url = get_theme_mod('footer_tiktok_url', '');
                        $shopee_url = get_theme_mod('footer_shopee_url', '');

                        // Social media links array
                        $social_links = array();
                        if (!empty($facebook_url)) {
                            $social_links[] = array('url' => $facebook_url, 'icon' => 'facebook', 'label' => 'Facebook');
                        }
                        if (!empty($instagram_url)) {
                            $social_links[] = array('url' => $instagram_url, 'icon' => 'instagram', 'label' => 'Instagram');
                        }
                        if (!empty($tiktok_url)) {
                            $social_links[] = array('url' => $tiktok_url, 'icon' => 'tiktok', 'label' => 'TikTok');
                        }
                        if (!empty($shopee_url)) {
                            $social_links[] = array('url' => $shopee_url, 'icon' => 'shopee', 'label' => 'Shopee');
                        }
                        if (!empty($website_url)) {
                            $social_links[] = array('url' => $website_url, 'icon' => 'globe', 'label' => 'Website');
                        }
                        ?>

                        <?php foreach ($social_links as $social): ?>
                        <!-- <?php echo esc_html($social['label']); ?> -->
                        <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener noreferrer" class="group" aria-label="<?php echo esc_attr($social['label']); ?>">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-105" style="background: rgba(255, 255, 255, 0.15);">
                                <span class="text-white transition-transform duration-300 group-hover:scale-110" data-icon="<?php echo esc_attr($social['icon']); ?>" data-size="20" data-stroke="2"></span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Customer Service (Mobile: Third, Desktop: Third) -->
                <div class="order-3 lg:order-3 lg:col-span-3">
                    <!-- Mobile Version: Left Aligned -->
                    <div class="text-left space-y-6 lg:hidden">
                        <h4 class="text-lg font-bold text-white mb-2" lang="vi">
                            <?php echo esc_html(get_theme_mod('footer_service_title', 'Liên kết nhanh')); ?>
                        </h4>
                        <div class="w-16 h-1 rounded-full mb-6" style="background-color: <?php echo esc_attr($tertiary_color); ?>;"></div>

                        <!-- Menu columns -->
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Menu 1 -->
                            <nav class="text-left">
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'footer-menu-1',
                                    'menu_class' => 'footer-menu-links space-y-2',
                                    'container' => false,
                                    'fallback_cb' => function() {
                                        echo '<ul class="footer-menu-links space-y-2">';
                                        echo '<li><a href="' . esc_url(home_url('/')) . '">Trang chủ</a></li>';
                                        echo '<li><a href="' . esc_url(home_url('/san-pham')) . '">Sản phẩm</a></li>';
                                        echo '<li><a href="' . esc_url(home_url('/ve-arata')) . '">Về Arata</a></li>';
                                        echo '</ul>';
                                    },
                                    'link_before' => '',
                                    'link_after' => '',
                                ));
                                ?>
                            </nav>

                            <!-- Menu 2 - Only show if menu has items -->
                            <?php
                            $menu2_items = wp_get_nav_menu_items('footer-menu-2');
                            if ($menu2_items && count($menu2_items) > 0) :
                            ?>
                            <nav class="text-left">
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'footer-menu-2',
                                    'menu_class' => 'footer-menu-links space-y-2',
                                    'container' => false,
                                    'fallback_cb' => '__return_empty_string',
                                    'link_before' => '',
                                    'link_after' => '',
                                ));
                                ?>
                            </nav>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Desktop Version: Right Aligned -->
                    <div class="hidden lg:block text-right space-y-6">
                        <h4 class="text-lg font-bold text-white mb-2" lang="vi" style="text-align: right !important;">
                            <?php echo esc_html(get_theme_mod('footer_service_title', 'Liên kết nhanh')); ?>
                        </h4>
                        <div class="w-16 h-1 rounded-full mb-6" style="background-color: <?php echo esc_attr($tertiary_color); ?>; margin-left: auto; margin-right: 0;"></div>

                        <!-- Menu columns -->
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Menu 1 -->
                            <nav style="text-align: right !important;">
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'footer-menu-1',
                                    'menu_class' => 'footer-menu-links space-y-2',
                                    'container' => false,
                                    'fallback_cb' => function() {
                                        echo '<ul class="footer-menu-links space-y-2" style="text-align: right !important;">';
                                        echo '<li style="text-align: right !important;"><a href="' . esc_url(home_url('/')) . '">Trang chủ</a></li>';
                                        echo '<li style="text-align: right !important;"><a href="' . esc_url(home_url('/san-pham')) . '">Sản phẩm</a></li>';
                                        echo '<li style="text-align: right !important;"><a href="' . esc_url(home_url('/ve-arata')) . '">Về Arata</a></li>';
                                        echo '</ul>';
                                    },
                                    'link_before' => '',
                                    'link_after' => '',
                                ));
                                ?>
                            </nav>

                            <!-- Menu 2 - Only show if menu has items -->
                            <?php
                            $menu2_items = wp_get_nav_menu_items('footer-menu-2');
                            if ($menu2_items && count($menu2_items) > 0) :
                            ?>
                            <nav style="text-align: right !important;">
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'footer-menu-2',
                                    'menu_class' => 'footer-menu-links space-y-2',
                                    'container' => false,
                                    'fallback_cb' => '__return_empty_string',
                                    'link_before' => '',
                                    'link_after' => '',
                                ));
                                ?>
                            </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright Section -->
            <div class="border-t border-white/20 pt-4 text-center">
                <p class="text-white/80 text-sm">
                    © <?php echo date('Y'); ?>
                    <span class="font-medium text-white"><?php echo esc_html(get_theme_mod('footer_company_name', 'Công ty TNHH Arata Việt Nam')); ?></span>.
                    <?php echo esc_html(get_theme_mod('footer_copyright_text', 'Tất cả quyền được bảo lưu')); ?>.
                </p>
            </div>
        </div>
    </footer>
</div>

<?php
// Include floating social widget
get_template_part('template-parts/floating-social');
?>

<?php wp_footer(); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.body.classList.add('preloading');
    
    // Sticky Header Effect
    const header = document.getElementById('masthead');
    if (header) {
        let ticking = false;
        
        function updateHeader() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 50) {
                header.style.backgroundColor = 'rgba(255, 255, 255, 0.98)';
                header.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)';
                header.classList.add('scrolled');
            } else {
                header.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                header.style.boxShadow = '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)';
                header.classList.remove('scrolled');
            }
            ticking = false;
        }
        
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateHeader);
                ticking = true;
            }
        });
    }
    
    // Multi-level Menu Fix
    const dropdownItems = document.querySelectorAll('.has-submenu');
    dropdownItems.forEach(item => {
        const submenu = item.querySelector('.dropdown-menu');
        if (submenu) {
            item.addEventListener('mouseenter', function() {
                submenu.style.opacity = '1';
                submenu.style.visibility = 'visible';
            });
            
            item.addEventListener('mouseleave', function() {
                submenu.style.opacity = '0';
                submenu.style.visibility = 'hidden';
            });
        }
    });
});

window.addEventListener('load', function() {
    document.body.classList.remove('preloading');
    document.body.classList.add('loaded');
});

// Back to Top Button functionality
document.addEventListener('DOMContentLoaded', function() {
    const backToTopBtn = document.getElementById('back-to-top');
    
    if (backToTopBtn) {
        // Show/hide button based on scroll position
        function toggleBackToTop() {
            if (window.pageYOffset > 300) {
                backToTopBtn.style.display = 'flex';
                setTimeout(() => backToTopBtn.classList.add('show'), 10);
            } else {
                backToTopBtn.classList.remove('show');
                setTimeout(() => {
                    if (!backToTopBtn.classList.contains('show')) {
                        backToTopBtn.style.display = 'none';
                    }
                }, 300);
            }
        }
        
        // Throttled scroll event
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    toggleBackToTop();
                    ticking = false;
                });
                ticking = true;
            }
        });
        
        // Smooth scroll to top
        backToTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
</script>

<style>
/* Fix for multi-level menu display */
.has-submenu > .dropdown-menu {
    position: absolute !important;
    left: 100% !important;
    top: 0 !important;
    margin-left: 0.5rem !important;
    width: 12rem !important;
    background-color: white !important;
    border: 1px solid #e5e7eb !important;
    border-radius: 0.5rem !important;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    opacity: 0 !important;
    visibility: hidden !important;
    transition: all 0.3s ease !important;
    z-index: 60 !important;
}

.has-submenu:hover > .dropdown-menu {
    opacity: 1 !important;
    visibility: visible !important;
}

/* Ensure proper positioning context */
.dropdown-item.has-submenu {
    position: relative !important;
}

/* Footer alignment fixes */
@media (min-width: 1024px) {
    /* Force right alignment for Customer Service section */
    .text-right {
        text-align: right !important;
    }
    
    /* Customer Service section desktop version */
    .hidden.lg\:block .text-right,
    .hidden.lg\:block .text-right > * {
        text-align: right !important;
    }
    
    /* Specific overrides for menu items */
    .hidden.lg\:block .text-right h4 {
        text-align: right !important;
        display: block !important;
        margin-left: auto !important;
        margin-right: 0 !important;
    }
    
    .hidden.lg\:block .text-right .w-16 {
        margin-left: auto !important;
        margin-right: 0 !important;
    }
    
    /* Force right alignment for all menu containers in desktop version */
    .hidden.lg\:block .text-right nav,
    .hidden.lg\:block .text-right .footer-menu-links,
    .hidden.lg\:block .text-right .footer-menu-links ul,
    .hidden.lg\:block .text-right .footer-menu-links ol,
    .hidden.lg\:block .text-right .footer-menu-links li {
        text-align: right !important;
        direction: rtl; /* Use RTL for better right alignment */
        padding-right: 0 !important;
        margin-right: 0 !important;
    }
    
    /* Keep content LTR but aligned right */
    .hidden.lg\:block .text-right .footer-menu-links li {
        direction: ltr;
        text-align: right !important;
        display: block !important;
        width: 100%;
        padding-left: 0 !important;
        margin-left: 0 !important;
    }
    
    /* Specific link styling */
    .hidden.lg\:block .text-right .footer-menu-links li a,
    .hidden.lg\:block .text-right .menu-item a {
        text-align: right !important;
        display: block !important;
        width: 100%;
        padding-right: 0 !important;
        margin-right: 0 !important;
        text-align: right !important;
    }
    
    /* Override any inline styles from WordPress */
    .hidden.lg\:block .text-right nav[style*="text-align"] {
        text-align: right !important;
    }
    
    .hidden.lg\:block .text-right ul[style*="text-align"] {
        text-align: right !important;
    }
    
    .hidden.lg\:block .text-right li[style*="text-align"] {
        text-align: right !important;
    }
    
    /* Ensure menu items are block level */
    .hidden.lg\:block .text-right .menu-item {
        display: block !important;
        text-align: right !important;
        clear: both;
        float: none;
    }
    
    /* Remove any left spacing */
    .hidden.lg\:block .text-right .footer-menu-links,
    .hidden.lg\:block .text-right .footer-menu-links ul {
        padding-left: 0 !important;
        margin-left: 0 !important;
    }
    
    /* Specific fix for colophon order-3 section */
    #colophon .order-3 nav ul,
    #colophon .order-3 nav ul li {
        text-align: right !important;
        justify-content: flex-end !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-end !important;
    }
    
    #colophon .order-3 nav ul li a {
        text-align: right !important;
        display: block !important;
        width: 100%;
    }
}


</style>

</body>
</html>
