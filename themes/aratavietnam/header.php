<?php
/**
 * Theme header template.
 *
 * @package ArataVietnam
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="overflow-x-hidden">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class('font-primary overflow-x-hidden'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'aratavietnam' ); ?></a>

	<header id="masthead" class="site-header bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
		<div class="container mx-auto px-4">
			<div class="flex items-center justify-between py-4">
				<!-- Logo -->
				<div class="site-branding flex items-center flex-shrink-0 mr-6">
					<?php
					// Display logo
					$custom_logo_id = get_theme_mod('custom_logo');
					$logo_url = get_template_directory_uri() . '/assets/images/logo.png';

					if ($custom_logo_id) {
						// Use custom logo if set
						echo '<a href="' . esc_url(home_url('/')) . '" class="custom-logo-link flex items-center" rel="home">';
						echo wp_get_attachment_image($custom_logo_id, 'full', false, array(
							'class' => 'custom-logo h-10 w-auto max-w-40',
							'alt' => get_bloginfo('name'),
						));
						echo '</a>';
					} elseif (file_exists(get_template_directory() . '/assets/images/logo.png')) {
						// Use default logo
						echo '<a href="' . esc_url(home_url('/')) . '" class="custom-logo-link flex items-center" rel="home">';
						echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="custom-logo h-10 w-auto max-w-40">';
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

				<!-- Navigation Menu - Desktop (ngay sau logo) -->
				<nav id="site-navigation" class="main-navigation hidden lg:block mr-auto">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'menu_class'     => 'flex flex-row space-x-4 items-center',
							'container'      => false,
							'fallback_cb'    => false, // Don't show all pages if no menu assigned
							'walker'         => new Arata_Dropdown_Walker(),
						)
					);
					?>
				</nav>

				<!-- Search Box & Actions -->
				<div class="header-right flex items-center space-x-3">
					<!-- Search Box -->
					<div class="search-container hidden md:flex relative">
						<div class="relative">
							<input
								type="search"
								id="header-search"
								placeholder="Tìm kiếm sản phẩm..."
								class="w-56 pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
								autocomplete="off"
							>
							<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
								<svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
									<circle cx="11" cy="11" r="8"></circle>
									<path d="m21 21-4.35-4.35"></path>
								</svg>
							</div>
						</div>

					</div>

					<!-- Action Icons -->
					<div class="action-icons flex items-center space-x-2">
						<!-- Mobile Search Toggle -->
						<button class="search-toggle-mobile md:hidden p-2 text-gray-800 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-300" aria-label="Tìm kiếm">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
								<circle cx="11" cy="11" r="8"></circle>
								<path d="m21 21-4.35-4.35"></path>
							</svg>
						</button>

						<!-- Account -->
						<?php if (is_user_logged_in()) : ?>
							<div class="relative group">
								<button class="account-toggle p-2 text-gray-800 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-300" aria-label="Tài khoản">
									<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
										<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
										<circle cx="12" cy="7" r="4"></circle>
									</svg>
								</button>
								<!-- User Dropdown -->
								<div class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
									<div class="p-3 border-b border-gray-100">
										<p class="text-sm font-medium text-gray-900"><?php echo wp_get_current_user()->display_name; ?></p>
										<p class="text-xs text-gray-500"><?php echo wp_get_current_user()->user_email; ?></p>
									</div>
									<div class="py-1">
										<a href="<?php echo esc_url(get_edit_user_link()); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Thông tin cá nhân</a>
										<a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Đăng xuất</a>
									</div>
								</div>
							</div>
						<?php else : ?>
							<button class="account-toggle p-2 text-gray-800 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-300" aria-label="Đăng nhập">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
									<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
									<circle cx="12" cy="7" r="4"></circle>
								</svg>
							</button>
						<?php endif; ?>

						<!-- Cart (WooCommerce) -->
						<?php if (class_exists('WooCommerce')) : ?>
						<button class="cart-toggle p-2 text-gray-800 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-300 relative" aria-label="Giỏ hàng">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
								<circle cx="8" cy="21" r="1"></circle>
								<circle cx="19" cy="21" r="1"></circle>
								<path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57L23 6H6"></path>
							</svg>
							<?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
								<span class="cart-count absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium">
									<?php echo WC()->cart->get_cart_contents_count(); ?>
								</span>
							<?php endif; ?>
						</button>
						<?php endif; ?>

						<!-- Mobile Menu Toggle -->
						<button class="menu-toggle lg:hidden p-2 text-gray-800 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-300 ml-2" aria-controls="primary-menu" aria-expanded="false" aria-label="Menu">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
								<line x1="4" x2="20" y1="6" y2="6"></line>
								<line x1="4" x2="20" y1="12" y2="12"></line>
								<line x1="4" x2="20" y1="18" y2="18"></line>
							</svg>
						</button>
					</div>
				</div>
			</div>

		</div>

		<!-- Mobile Navigation -->
		<nav id="primary-navigation" class="mobile-navigation lg:hidden hidden bg-white border-t border-gray-200 shadow-lg">
			<div class="px-4 py-6">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'mobile-menu',
						'menu_class'     => 'mobile-menu-list space-y-1',
						'container'      => false,
						'walker'         => new class extends Walker_Nav_Menu {
							function start_lvl(&$output, $depth = 0, $args = null) {
								// Add 'hidden' class to hide submenu by default
								$output .= '<ul class="sub-menu ml-4 mt-2 space-y-1 hidden">';
							}
							function end_lvl(&$output, $depth = 0, $args = null) {
								$output .= '</ul>';
							}
							function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
								$classes = empty($item->classes) ? array() : (array) $item->classes;
								$has_children = in_array('menu-item-has-children', $classes);

								$classes[] = 'menu-item-' . $item->ID;
								$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
								$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

								$output .= '<li' . $class_names . '>';

								// Wrap link and toggle in a div for flex layout
								$output .= '<div class="flex items-center justify-between">';

								$output .= '<a href="' . esc_url($item->url) . '" class="flex-grow block px-4 py-3 text-gray-900 hover:bg-gray-50 hover:text-primary rounded-lg transition-colors duration-200 font-medium">';
								$output .= esc_html($item->title);
								$output .= '</a>';

								// Add toggle button if item has children
								if ($has_children) {
									$output .= '<button class="mobile-submenu-toggle p-2 mr-2 text-gray-500 hover:text-primary rounded-md">';
									$output .= '<svg class="dropdown-arrow w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
									$output .= '</button>';
								}

								$output .= '</div>';
							}
							function end_el(&$output, $item, $depth = 0, $args = null) {
								$output .= '</li>';
							}
						}
					)
				);
				?>



				<!-- Mobile Actions -->
				<div class="flex items-center justify-center space-x-8 mt-6 pt-6 border-t border-gray-200">
					<?php if (is_user_logged_in()) : ?>
						<a href="<?php echo esc_url(get_edit_user_link()); ?>" class="flex flex-col items-center space-y-1 text-gray-600 hover:text-primary transition-colors duration-200">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
								<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
								<circle cx="12" cy="7" r="4"></circle>
							</svg>
							<span class="text-xs font-medium">Tài khoản</span>
						</a>
					<?php else : ?>
						<button class="account-toggle flex flex-col items-center space-y-1 text-gray-600 hover:text-primary transition-colors duration-200">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
								<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
								<circle cx="12" cy="7" r="4"></circle>
							</svg>
							<span class="text-xs font-medium">Đăng nhập</span>
						</button>
					<?php endif; ?>

					<?php if (class_exists('WooCommerce')) : ?>
					<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="flex flex-col items-center space-y-1 text-gray-600 hover:text-primary transition-colors duration-200 relative">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
							<circle cx="8" cy="21" r="1"></circle>
							<circle cx="19" cy="21" r="1"></circle>
							<path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57L23 6H6"></path>
						</svg>
						<span class="text-xs font-medium">Giỏ hàng</span>
						<?php if (WC()->cart && WC()->cart->get_cart_contents_count() > 0) : ?>
							<span class="absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium">
								<?php echo WC()->cart->get_cart_contents_count(); ?>
							</span>
						<?php endif; ?>
					</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</header>

<div id="content" class="site-content grow">
	<?php do_action('aratavietnam_content_start'); ?>
	<main id="primary" class="site-main">
