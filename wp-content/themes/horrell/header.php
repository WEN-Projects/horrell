<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package horrell
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- Google Font ~ PT Sans -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'horrell' ); ?></a>

		<header id="masthead" class="site-header">
			<div class="header-top">
				<div class="container d-flex justify-content-sm-between justify-content-center align-items-sm-end align-items-center flex-sm-row flex-column">
					<div class="site-branding">
						<?php
						the_custom_logo();
						?>
					</div><!-- .site-branding -->
					<div class="header-right">
						<?php
						global $Horrell_Saved_Listings;
						$listing_count = count( $Horrell_Saved_Listings->horrell_get_saved_listings() );
						?>
						<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'cart' ) ) ); ?>" class="link underlined">
							<span class="listing-count"><?php echo esc_html( $listing_count ); ?></span>
							<?php esc_html_e( 'Saved Listings', 'horrell' ); ?>
						</a>
					</div>
				</div>
			</div>

			<div class="header-bottom">
				<div class="container">
					<nav id="site-navigation" class="main-navigation">
						<button class="menu-toggle" aria-label="Menu Toggle Button" aria-controls="primary-menu" aria-expanded="false">
							<span class="line-1"></span>
							<span class="line-2"></span>
							<span class="line-3"></span>
						</button>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
						?>
					</nav><!-- #site-navigation -->
				</div>
			</div>
		</header><!-- #masthead -->
