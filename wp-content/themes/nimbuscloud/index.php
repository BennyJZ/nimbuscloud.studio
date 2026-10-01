<?php
/**
 * Fallback template. WordPress requires index.php in every theme.
 *
 * Note: singular views use the_content(), not the_excerpt(). An excerpt-only
 * fallback silently blanks any page that relies on shortcodes or blocks, which
 * is exactly how the Cart page came up empty before page.php existed.
 *
 * @package Nimbuscloud
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">
	<div class="container">
		<?php if ( have_posts() ) : ?>

			<?php if ( is_singular() ) : ?>

				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>
						<header class="page-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</header>
						<div class="entry-content"><?php the_content(); ?></div>
					</article>
				<?php endwhile; ?>

			<?php else : ?>

				<div class="post-list">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							<div class="entry-summary"><?php the_excerpt(); ?></div>
						</article>
					<?php endwhile; ?>
				</div>
				<?php the_posts_pagination(); ?>

			<?php endif; ?>

		<?php else : ?>
			<p><?php esc_html_e( 'Nothing here yet.', 'nimbuscloud' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
