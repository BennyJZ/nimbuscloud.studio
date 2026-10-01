<?php
/**
 * Nimbuscloud theme functions.
 *
 * WooCommerce compatibility notes:
 * - declare_woocommerce_support() is REQUIRED. Without add_theme_support('woocommerce')
 *   WooCommerce treats the theme as unsupported and forces its own wrappers.
 * - We remove WooCommerce's default sidebar + wrappers and supply our own so the
 *   markup matches this theme's grid, then re-add hooks in the right order.
 * - Gallery zoom/lightbox/slider support is opt-in per theme; declared below.
 *
 * @package Nimbuscloud
 */

defined( 'ABSPATH' ) || exit;

define( 'NIMBUSCLOUD_VERSION', '1.0.0' );

/**
 * Theme setup.
 */
function nimbuscloud_setup() {
	load_theme_textdomain( 'nimbuscloud', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	// WooCommerce: core support + gallery features (all three are opt-in).
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 400,
		'single_image_width'    => 800,
		'product_grid'          => array(
			'default_rows'    => 3,
			'min_rows'        => 1,
			'default_columns' => 3,
			'min_columns'     => 1,
			'max_columns'     => 4,
		),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'nimbuscloud' ),
		'footer'  => __( 'Footer Menu', 'nimbuscloud' ),
	) );
}
add_action( 'after_setup_theme', 'nimbuscloud_setup' );

/**
 * Assets.
 */
function nimbuscloud_scripts() {
	$css = get_template_directory() . '/assets/css/main.css';
	wp_enqueue_style(
		'nimbuscloud-main',
		get_template_directory_uri() . '/assets/css/main.css',
		array(),
		file_exists( $css ) ? (string) filemtime( $css ) : NIMBUSCLOUD_VERSION
	);

	if ( function_exists( 'is_product' ) && is_product() ) {
		$js = get_template_directory() . '/assets/js/product.js';
		wp_enqueue_script(
			'nimbuscloud-product',
			get_template_directory_uri() . '/assets/js/product.js',
			array( 'jquery' ),
			file_exists( $js ) ? (string) filemtime( $js ) : NIMBUSCLOUD_VERSION,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'nimbuscloud_scripts' );

/**
 * Widget areas.
 */
function nimbuscloud_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Shop Sidebar', 'nimbuscloud' ),
		'id'            => 'shop-sidebar',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'nimbuscloud_widgets_init' );

/* -------------------------------------------------------------------------
 * WooCommerce layout
 * ---------------------------------------------------------------------- */

// Replace Woo's default wrappers with ours.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

function nimbuscloud_wrapper_start() {
	echo '<main id="primary" class="site-main wc-main"><div class="container">';
}
add_action( 'woocommerce_before_main_content', 'nimbuscloud_wrapper_start', 10 );

function nimbuscloud_wrapper_end() {
	echo '</div></main>';
}
add_action( 'woocommerce_after_main_content', 'nimbuscloud_wrapper_end', 10 );

// Shop pages use a full-width grid in this theme.
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Products per row.
 */
function nimbuscloud_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'nimbuscloud_loop_columns' );

/**
 * Related products: 3 across, 3 total.
 *
 * @param array $args Related product args.
 * @return array
 */
function nimbuscloud_related_args( $args ) {
	$args['posts_per_page'] = 3;
	$args['columns']        = 3;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'nimbuscloud_related_args' );

/**
 * Strap-relevant trust badges under add-to-cart.
 */
function nimbuscloud_product_trust_badges() {
	$badges = array(
		__( 'Quick-release pins included', 'nimbuscloud' ),
		__( 'Measure your lug width before ordering', 'nimbuscloud' ),
		__( '30-day returns', 'nimbuscloud' ),
	);
	echo '<ul class="product-trust">';
	foreach ( $badges as $badge ) {
		echo '<li>' . esc_html( $badge ) . '</li>';
	}
	echo '</ul>';
}
add_action( 'woocommerce_after_add_to_cart_form', 'nimbuscloud_product_trust_badges', 15 );

/**
 * Cart count for the header bubble. Safe when Woo is inactive.
 *
 * @return int
 */
function nimbuscloud_cart_count() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return 0;
	}
	return (int) WC()->cart->get_cart_contents_count();
}

/**
 * Keep the header bubble in sync with AJAX add-to-cart.
 *
 * @param array $fragments Woo fragments.
 * @return array
 */
function nimbuscloud_cart_fragment( $fragments ) {
	$count = nimbuscloud_cart_count();
	$fragments['span.cart-count'] = '<span class="cart-count"' .
		( $count ? '' : ' hidden' ) . '>' . esc_html( $count ) . '</span>';
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'nimbuscloud_cart_fragment' );

/**
 * Graceful degradation: if WooCommerce is not active, tell the admin instead of
 * fataling on undefined Woo functions.
 */
function nimbuscloud_woo_notice() {
	if ( class_exists( 'WooCommerce' ) || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>' .
		esc_html__( 'The Nimbuscloud theme expects WooCommerce to be active. Shop templates fall back to blog layouts until it is.', 'nimbuscloud' ) .
		'</p></div>';
}
add_action( 'admin_notices', 'nimbuscloud_woo_notice' );
