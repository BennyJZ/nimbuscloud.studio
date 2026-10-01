<?php
/**
 * Theme header.
 *
 * @package Nimbuscloud
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'nimbuscloud' ); ?></a>

<div id="page" class="site">
	<header class="site-header">
		<div class="container header-inner">
			<div class="site-branding">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				<?php endif; ?>
			</div>

			<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'nimbuscloud' ); ?>">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'     => 'nav-list',
						'container'      => false,
						'depth'          => 2,
					) );
				}
				?>
			</nav>

			<div class="header-actions">
				<?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
					<?php $nimbuscloud_count = nimbuscloud_cart_count(); ?>
					<a class="cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
						<?php esc_html_e( 'Cart', 'nimbuscloud' ); ?>
						<span class="cart-count"<?php echo $nimbuscloud_count ? '' : ' hidden'; ?>><?php echo esc_html( $nimbuscloud_count ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</header>
