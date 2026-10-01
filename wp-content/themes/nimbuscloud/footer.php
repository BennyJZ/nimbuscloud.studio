<?php
/**
 * Theme footer.
 *
 * @package Nimbuscloud
 */

defined( 'ABSPATH' ) || exit;
?>
	<footer class="site-footer">
		<div class="container footer-inner">
			<p class="footer-brand"><?php bloginfo( 'name' ); ?></p>

			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'menu_class'     => 'footer-nav',
					'container'      => false,
					'depth'          => 1,
				) );
			}
			?>

			<p class="footer-note">
				<?php
				printf(
					/* translators: %1$s: year, %2$s: site name */
					esc_html__( '&copy; %1$s %2$s. Aftermarket replacement straps. Not affiliated with any watch manufacturer.', 'nimbuscloud' ),
					esc_html( gmdate( 'Y' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
				?>
			</p>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
