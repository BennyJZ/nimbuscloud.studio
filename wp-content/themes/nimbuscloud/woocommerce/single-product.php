<?php
/**
 * Single product template.
 *
 * IMPORTANT: this intentionally drives everything through WooCommerce hooks
 * (woocommerce_before_single_product, woocommerce_single_product_summary, etc.)
 * instead of printing title/price/cart markup directly. Hard-coding that markup
 * is the usual reason custom themes break variations, AJAX cart and extensions.
 *
 * Overrides woocommerce/single-product.php via the theme's /woocommerce/ dir.
 *
 * @package Nimbuscloud
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * woocommerce_before_main_content hook.
 */
do_action( 'woocommerce_before_main_content' );

while ( have_posts() ) :
	the_post();
	wc_get_template_part( 'content', 'single-product' );
endwhile;

/**
 * woocommerce_after_main_content hook.
 */
do_action( 'woocommerce_after_main_content' );

/**
 * woocommerce_sidebar hook.
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
