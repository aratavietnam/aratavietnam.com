<?php
/**
 * Theme header template.
 *
 * @package TailPress
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
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'tailpress' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container mx-auto px-4">
			<div class="flex items-center justify-between py-6">
				<div class="site-branding">
					<?php
					the_custom_logo();
					if ( is_front_page() && is_home() ) :
						?>
						<h1 class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?>
							</a>
						</h1>
						<?php
					else :
						?>
						<p class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?>
							</a>
						</p>
						<?php
					endif;
					$tailpress_description = get_bloginfo( 'description', 'display' );
					if ( $tailpress_description || is_customize_preview() ) :
						?>
						<p class="site-description"><?php echo $tailpress_description; ?></p>
					<?php endif; ?>
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
		<?php if (is_front_page()): ?>
			<section class="container mx-auto py-12">
				<div class="max-w-(--breakpoint-md)">
					<div class="[&_a]:text-primary">
						<h1 class="leading-tight text-3xl md:text-5xl font-medium tracking-tight text-balance text-zinc-950">
							Rapidly build your next WordPress theme with Tailwind CSS
						</h1>
						<p class="my-6 text-lg md:text-xl text-zinc-600 leading-8">
							<a href="https://tailpress.io">TailPress</a> is a <a href="https://tailwindcss.com">Tailwind CSS</a> flavoured <a href="https://wordpress.org">WordPress</a>
							boilerplate theme. It's your go-to starting point for building custom WordPress themes with modern tools and practices.
						</p>
					</div>
					<div>
						<a href="https://tailpress.io" class="inline-flex rounded-full px-4 py-1.5 text-sm font-semibold transition bg-dark text-white hover:bg-dark/90 !no-underline">
							Documentation
						</a>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php do_action('tailpress_content_start'); ?>
		<main>
