<?php
/**
 * Front page.
 *
 * Uses WooCommerce's own loop functions so products render with every
 * standard hook (badges, prices, AJAX add-to-cart) rather than hand-rolled
 * markup that would bypass extensions.
 *
 * @package Nimbuscloud
 */

defined( 'ABSPATH' ) || exit;

get_header();

$nimbuscloud_has_woo = class_exists( 'WooCommerce' );
?>

<main id="primary" class="site-main">

	<section class="hero">
		<div class="container hero-inner">
			<div class="hero-copy">
				<h1 class="hero-title">
					<?php esc_html_e( 'Straps that fit the watch you already own', 'nimbuscloud' ); ?>
				</h1>
				<p class="hero-sub">
					<?php esc_html_e( 'Quick-release nylon, mesh and parachute bands in every lug width from 16mm to 24mm, including the odd sizes nobody else stocks.', 'nimbuscloud' ); ?>
				</p>
				<div class="hero-actions">
					<?php if ( $nimbuscloud_has_woo && function_exists( 'wc_get_page_id' ) ) : ?>
						<a class="btn btn-primary" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
							<?php esc_html_e( 'Shop all straps', 'nimbuscloud' ); ?>
						</a>
					<?php endif; ?>
					<a class="btn btn-ghost" href="#size-guide">
						<?php esc_html_e( 'Find my size', 'nimbuscloud' ); ?>
					</a>
				</div>
				<ul class="hero-points">
					<li><?php esc_html_e( 'Quick-release pins included', 'nimbuscloud' ); ?></li>
					<li><?php esc_html_e( 'Fits standard spring-bar watches', 'nimbuscloud' ); ?></li>
					<li><?php esc_html_e( '30-day returns', 'nimbuscloud' ); ?></li>
				</ul>
			</div>
		</div>
	</section>

	<?php if ( $nimbuscloud_has_woo ) : ?>

		<section class="section">
			<div class="container">
				<h2 class="section-title"><?php esc_html_e( 'Shop by width', 'nimbuscloud' ); ?></h2>
				<p class="section-sub"><?php esc_html_e( 'Measure the gap between your watch lugs, then pick that number.', 'nimbuscloud' ); ?></p>
				<div class="width-grid">
					<?php
					$nimbuscloud_widths = array( '16mm', '17mm', '18mm', '19mm', '20mm', '21mm', '22mm', '23mm', '24mm' );
					foreach ( $nimbuscloud_widths as $nimbuscloud_width ) {
						$nimbuscloud_url = add_query_arg(
							'filter_width',
							sanitize_title( $nimbuscloud_width ),
							get_permalink( wc_get_page_id( 'shop' ) )
						);
						printf(
							'<a class="width-chip" href="%1$s">%2$s</a>',
							esc_url( $nimbuscloud_url ),
							esc_html( $nimbuscloud_width )
						);
					}
					?>
				</div>
			</div>
		</section>

		<section class="section">
			<div class="container">
				<h2 class="section-title"><?php esc_html_e( 'Latest straps', 'nimbuscloud' ); ?></h2>
				<?php
				// Shortcode keeps us on Woo's own loop + hooks, so plugins behave.
				echo do_shortcode( '[products limit="6" columns="3" orderby="date" order="DESC" visibility="visible"]' );
				?>
			</div>
		</section>

		<?php
		/*
		 * Deliberately no second product grid here.
		 *
		 * An earlier revision rendered a "featured" grid below "Latest straps",
		 * but with a small catalogue every product is featured, so the same
		 * three straps appeared twice. With a 3-product catalogue one honest
		 * grid is correct; re-introduce a featured row only once the catalogue
		 * is large enough for the two sets to differ.
		 */
		?>

	<?php else : ?>

		<section class="section">
			<div class="container">
				<p class="notice-inline">
					<?php esc_html_e( 'Activate WooCommerce to show products here.', 'nimbuscloud' ); ?>
				</p>
			</div>
		</section>

	<?php endif; ?>

	<section class="section" id="size-guide">
		<div class="container size-guide">
			<h2 class="section-title"><?php esc_html_e( 'How to find your size', 'nimbuscloud' ); ?></h2>
			<ol class="steps">
				<li>
					<strong><?php esc_html_e( 'Measure the lug gap', 'nimbuscloud' ); ?></strong>
					<span><?php esc_html_e( 'The distance in millimetres between the two horns where the strap meets the case.', 'nimbuscloud' ); ?></span>
				</li>
				<li>
					<strong><?php esc_html_e( 'Measure at the case end', 'nimbuscloud' ); ?></strong>
					<span><?php esc_html_e( 'Straps often taper, so the middle reads narrower than the true fitting width.', 'nimbuscloud' ); ?></span>
				</li>
				<li>
					<strong><?php esc_html_e( 'Check for spring bars', 'nimbuscloud' ); ?></strong>
					<span><?php esc_html_e( 'A few smartwatches use proprietary connectors and need an adapter instead.', 'nimbuscloud' ); ?></span>
				</li>
			</ol>
		</div>
	</section>

</main>
<?php
get_footer();
