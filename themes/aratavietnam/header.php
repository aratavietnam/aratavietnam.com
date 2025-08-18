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

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'aratavietnam' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container mx-auto px-4">
			<div class="flex items-center justify-between py-6">
				<div class="site-branding flex items-center">
					<?php
					// Display logo
					$custom_logo_id = get_theme_mod('custom_logo');
					$logo_url = get_template_directory_uri() . '/assets/images/logo.png';

					if ($custom_logo_id) {
						// Use custom logo if set
						the_custom_logo();
					} elseif (file_exists(get_template_directory() . '/assets/images/logo.png')) {
						// Use default logo
						echo '<a href="' . esc_url(home_url('/')) . '" class="custom-logo-link" rel="home">';
						echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="custom-logo" style="max-height: 60px; width: auto; margin-right: 1rem;">';
						echo '</a>';
					}
					?>

					<div class="site-text">
						<?php if ( is_front_page() && is_home() ) : ?>
							<h1 class="site-title text-lg font-semibold">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-gray-900 hover:text-primary">
									<?php bloginfo( 'name' ); ?>
								</a>
							</h1>
						<?php else : ?>
							<p class="site-title text-lg font-semibold">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-gray-900 hover:text-primary">
									<?php bloginfo( 'name' ); ?>
								</a>
							</p>
						<?php endif; ?>

						<?php
						$aratavietnam_description = get_bloginfo( 'description', 'display' );
						if ( $aratavietnam_description || is_customize_preview() ) :
							?>
							<p class="site-description text-sm text-gray-600"><?php echo $aratavietnam_description; ?></p>
						<?php endif; ?>
					</div>
				</div>

				<nav id="site-navigation" class="main-navigation">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						Menu
					</button>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
						)
					);
					?>
				</nav>
			</div>
		</div>
	</header>

	<div id="content" class="site-content grow">
		<?php if (is_front_page() && !is_page()): ?>
			<section class="bg-gradient-to-br from-primary/5 via-secondary/5 to-tertiary/5 py-16">
				<div class="container mx-auto px-4">
					<div class="max-w-4xl mx-auto text-center">
						<div class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium mb-6">
							<span class="w-2 h-2 bg-primary rounded-full mr-2 animate-pulse"></span>
							Nền tảng công nghệ Việt Nam
						</div>
						<h1 class="leading-tight text-4xl md:text-6xl font-bold tracking-tight text-balance text-dark mb-6">
							Chào mừng đến với <span class="text-brand-gradient bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">Arata Vietnam</span>
						</h1>
						<p class="my-6 text-lg md:text-xl text-gray-600 leading-8 max-w-3xl mx-auto">
							<span class="text-primary font-semibold">Arata Vietnam</span> - Nền tảng chia sẻ kiến thức và kinh nghiệm về công nghệ,
							phát triển phần mềm và các xu hướng công nghệ mới nhất tại Việt Nam.
						</p>
						<div class="flex flex-col sm:flex-row gap-4 justify-center">
							<a href="https://aratavietnam.com" class="btn-primary !no-underline">
								<span class="mr-2">🚀</span>
								Khám phá ngay
							</a>
							<a href="<?php echo esc_url( home_url( '/wp-admin' ) ); ?>" class="btn-outline-primary !no-underline">
								<span class="mr-2">⚙️</span>
								Quản trị
							</a>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php do_action('aratavietnam_content_start'); ?>
		<main>
