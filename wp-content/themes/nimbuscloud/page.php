<?php
/**
 * Single page template.
 *
 * REQUIRED for WooCommerce: the Cart, Checkout and My Account pages are ordinary
 * WordPress pages whose shortcodes/blocks live in the_content(). Without page.php,
 * WordPress falls back to index.php, which only prints the_excerpt() - so those
 * pages render completely empty. This template calls the_content() so Woo's own
 * cart/checkout markup is emitted.
 *
 * @package Nimbuscloud
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">
	<div class="container page-content">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>
				<?php if ( ! is_front_page() ) : ?>
					<header class="page-header">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</header>
				<?php endif; ?>

				<div class="entry-content">
					<?php
					// the_content() is what renders the WooCommerce cart/checkout
					// shortcodes and blocks. Never replace this with the_excerpt().
					the_content();

					wp_link_pages( array(
						'before' => '<nav class="page-links">',
						'after'  => '</nav>',
					) );
					?>
				</div>
			</article>
			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		endwhile;
		?>
	</div>
</main>
<?php
get_footer();
