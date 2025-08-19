<?php
/**
 * Theme header template.
 *
 * @package ArataVietnam
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class('font-primary'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'aratavietnam' ); ?></a>

	<header id="masthead" class="site-header bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
		<div class="container mx-auto px-4">
			<div class="flex items-center py-4">
				<!-- Logo bên trái -->
				<div class="site-branding flex items-center flex-shrink-0 mr-8">
					<?php
					// Display logo
					$custom_logo_id = get_theme_mod('custom_logo');
					$logo_url = get_template_directory_uri() . '/assets/images/logo.png';

					if ($custom_logo_id) {
						// Use custom logo if set
						echo '<a href="' . esc_url(home_url('/')) . '" class="custom-logo-link flex items-center" rel="home">';
						echo wp_get_attachment_image($custom_logo_id, 'full', false, array(
							'class' => 'custom-logo h-10 w-auto max-w-48',
							'alt' => get_bloginfo('name'),
						));
						echo '</a>';
					} elseif (file_exists(get_template_directory() . '/assets/images/logo.png')) {
						// Use default logo
						echo '<a href="' . esc_url(home_url('/')) . '" class="custom-logo-link flex items-center" rel="home">';
						echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="custom-logo h-10 w-auto max-w-48">';
						echo '</a>';
					} else {
						// Fallback to text logo
						if ( is_front_page() && is_home() ) : ?>
							<h1 class="site-title text-xl font-bold m-0">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="no-underline text-gray-900 hover:text-primary transition-colors">
									<?php bloginfo( 'name' ); ?>
								</a>
							</h1>
						<?php else : ?>
							<p class="site-title text-xl font-bold m-0">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="no-underline text-gray-900 hover:text-primary transition-colors">
									<?php bloginfo( 'name' ); ?>
								</a>
							</p>
						<?php endif;
					}
					?>
				</div>

				<!-- Navigation Menu - Desktop (sát logo bên trái) -->
				<nav id="site-navigation" class="main-navigation hidden lg:flex flex-1">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'menu_class'     => 'flex space-x-6 items-center text-sm font-medium',
							'container'      => false,
						)
					);
					?>
				</nav>

				<!-- Search Box & Actions bên phải -->
				<div class="header-right flex items-center space-x-3 ml-auto">
					<!-- Search Box -->
					<div class="search-container hidden md:flex relative">
						<div class="relative">
							<input
								type="search"
								id="header-search"
								placeholder="Tìm kiếm sản phẩm..."
								class="w-64 pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
								autocomplete="off"
							>
							<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
								<span data-icon="search" data-size="16" data-class="w-4 h-4 text-gray-400"></span>
							</div>
						</div>
						<!-- Search Results Dropdown -->
						<div id="search-results" class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50 max-h-96 overflow-y-auto">
							<div class="p-4 text-center text-gray-500">
								<span data-icon="search" data-size="24" data-class="w-6 h-6 mx-auto mb-2 text-gray-300"></span>
								<p class="text-sm">Nhập từ khóa để tìm kiếm...</p>
							</div>
						</div>
					</div>

					<!-- Action Icons -->
					<div class="action-icons flex items-center space-x-2">
						<!-- Mobile Search Toggle -->
						<button class="search-toggle-mobile md:hidden p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-300" aria-label="Tìm kiếm">
							<span data-icon="search" data-size="20" data-class="w-5 h-5"></span>
						</button>

						<!-- Account -->
						<a href="<?php echo esc_url(wp_login_url()); ?>" class="account-toggle p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-300" aria-label="Tài khoản">
							<span data-icon="user" data-size="20" data-class="w-5 h-5"></span>
						</a>

						<!-- Cart (WooCommerce) -->
						<?php if (class_exists('WooCommerce')) : ?>
						<div class="cart-container relative">
							<button class="cart-toggle p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-300 relative" aria-label="Giỏ hàng">
								<span data-icon="cart" data-size="20" data-class="w-5 h-5"></span>
								<?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
									<span class="cart-count absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium">
										<?php echo WC()->cart->get_cart_contents_count(); ?>
									</span>
								<?php endif; ?>
							</button>
							<!-- Cart Dropdown -->
							<div id="cart-dropdown" class="absolute top-full right-0 mt-1 w-80 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50">
								<div class="p-4 text-center text-gray-500">
									<span data-icon="cart" data-size="24" data-class="w-6 h-6 mx-auto mb-2 text-gray-300"></span>
									<p class="text-sm">Giỏ hàng trống</p>
								</div>
							</div>
						</div>
						<?php endif; ?>

						<!-- Mobile Menu Toggle -->
						<button class="menu-toggle lg:hidden p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-300 ml-2" aria-controls="primary-menu" aria-expanded="false" aria-label="Menu">
							<span data-icon="menu" data-size="24" data-class="w-6 h-6"></span>
						</button>
					</div>
				</div>
			</div>

			<!-- Mobile Navigation -->
			<nav id="primary-navigation" class="mobile-navigation lg:hidden hidden">
				<div class="border-t border-gray-100 py-4">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'mobile-menu',
							'menu_class'     => 'flex flex-col space-y-2',
							'container'      => false,
						)
					);
					?>

					<!-- Mobile Search, Account, Cart -->
					<div class="flex items-center justify-center space-x-6 mt-4 pt-4 border-t border-gray-100">
						<button class="p-2 text-gray-600 hover:text-primary transition-colors duration-300" aria-label="Tìm kiếm">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
							</svg>
						</button>

						<a href="<?php echo esc_url(wp_login_url()); ?>" class="p-2 text-gray-600 hover:text-primary transition-colors duration-300" aria-label="Tài khoản">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
							</svg>
						</a>

						<?php if (class_exists('WooCommerce')) : ?>
						<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="p-2 text-gray-600 hover:text-primary transition-colors duration-300 relative" aria-label="Giỏ hàng">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
							</svg>
							<?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
								<span class="absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
									<?php echo WC()->cart->get_cart_contents_count(); ?>
								</span>
							<?php endif; ?>
						</a>
						<?php endif; ?>
					</div>
				</div>
			</nav>
		</div>
	</header>

	<div id="content" class="site-content grow">
		<?php do_action('aratavietnam_content_start'); ?>
		<main>
