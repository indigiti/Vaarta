<?php
/**
 * The template part for displaying post prev next section.
 *
 * @package Caards
 */

$prev_post = get_previous_post();
$next_post = get_next_post();

if ( $prev_post || $next_post ) {
	?>
	<div class="cs-entry__prev-next">
		<?php
		// Prev post.
		if ( $prev_post ) {
			$post = $prev_post;

			setup_postdata( $post );
			?>

			<a href="<?php the_permalink(); ?>" class="cs-entry__prev-next-item cs-entry__prev">
				<div class="cs-entry__prev-next-inner">
					<div class="cs-entry__prev-next-label">
						<?php echo esc_html__( 'Prev Post', 'caards' ); ?>
					</div>

					<div class="cs-entry__prev-next-wrap">
						<div class="cs-entry__prev-next-arrow">
							<span class="cs-icon cs-icon-arrow-left"></span>
						</div>
						<div class="cs-entry">
							<div class="cs-entry__outer">
								<div class="cs-entry__inner cs-entry__content">
									<?php the_title( '<h2 class="cs-entry__title"><span>', '</span></h2>' ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</a>

			<?php
			wp_reset_postdata();
		}

		// Next post.
		if ( $next_post ) {
			$post = $next_post;

			setup_postdata( $post );
			?>
			<a href="<?php the_permalink(); ?>" class="cs-entry__prev-next-item cs-entry__next">
				<div class="cs-entry__prev-next-inner">
					<div class="cs-entry__prev-next-label">
						<?php echo esc_html__( 'Next Post', 'caards' ); ?>
					</div>
					<div class="cs-entry__prev-next-wrap">
						<div class="cs-entry">
							<div class="cs-entry__outer">
								<div class="cs-entry__inner cs-entry__content">
									<?php the_title( '<h2 class="cs-entry__title"><span>', '</span></h2>' ); ?>
								</div>
							</div>
						</div>
						<div class="cs-entry__prev-next-arrow">
							<span class="cs-icon cs-icon-arrow-right"></span>
						</div>
					</div>
				</div>
			</a>
			<?php
			wp_reset_postdata();
		}
		?>
	</div>
	<?php
}
