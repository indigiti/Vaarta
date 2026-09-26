<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Caards
 */

get_header(); ?>

<div id="primary" class="cs-content-area">

	<?php do_action( 'csco_main_before' ); ?>

	<?php
	if ( is_home() ) {
		csco_layout_heading( esc_html__( 'Latest News', 'caards' ), 'h1' );
	}

	if ( have_posts() ) {
		// Set options.
		$options = csco_get_archive_options();
		?>

		<div class="cs-posts-area cs-posts-area-posts">
			<div class="cs-posts-area__outer">
				<div <?php csco_posts_main_class(); ?>>
					<?php
					$current = 0;

					// Start the Loop.
					while ( have_posts() ) {
						the_post();

						$current++;

						set_query_var( 'options', $options );

						if ( 'masonry' === $options['layout'] ) {
							?>
							<div class="cs-posts-area-card">
							<?php
						}

						if ( 'full' === $options['layout'] ) {

							get_template_part( 'template-parts/archive/content' );

						} else {
							get_template_part( 'template-parts/archive/content' );
						}

						if ( 'masonry' === $options['layout'] ) {
							?>
							</div>
							<?php
						}

						if ( 'masonry' === $options['layout'] ) {
							csco_the_widget_archive_loop( $current );
						}
					}
					?>
				</div>
			</div>

			<?php
			/* Posts Pagination */
			if ( 'standard' === get_theme_mod( csco_get_archive_option( 'pagination_type' ), 'load-more' ) ) {
				?>
				<div class="cs-posts-area__pagination">
					<?php
						the_posts_pagination(
							array(
								'prev_text' => esc_html__( 'Previous', 'caards' ),
								'next_text' => esc_html__( 'Next', 'caards' ),
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		?>
		<div class="entry-content cs-content-not-found">
			<p><?php esc_html_e( 'It seems we cannot find what you are looking for. Perhaps searching can help.', 'caards' ); ?></p>

			<?php get_search_form(); ?>
		</div>
		<?php
	}
	?>

	<?php do_action( 'csco_main_after' ); ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
