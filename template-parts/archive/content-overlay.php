<?php
/**
 * Template part for entry overlay
 *
 * @package Caards
 */

$options = get_query_var( 'options' );

$options = csco_block_normalize_meta( $options, $options['meta'] );
?>

<article <?php post_class( 'cs-entry-layout-overlay' ); ?>>
	<div class="cs-entry__outer cs-entry__overlay cs-overlay-ratio cs-ratio-<?php echo esc_attr( $options['image_orientation'] ); ?>" data-scheme="inverse">

		<div class="cs-entry__inner cs-entry__thumbnail">
			<div class="cs-overlay-background">
				<?php the_post_thumbnail( $options['image_size'] ); ?>
			</div>
		</div>

		<div class="cs-entry__item">
			<?php if ( 'post' === get_post_type() ) { ?>
				<div class="cs-entry__inner cs-entry__content">
					<?php csco_block_post_category( $options ); ?>
				</div>
			<?php } ?>

			<div class="cs-entry__inner cs-entry__content cs-overlay-content">
				<?php if ( 'post' === get_post_type() ) { ?>
					<?php csco_get_post_meta( array( 'category' ), false, true, $options['meta'] ); ?>
				<?php } ?>

				<?php the_title( '<h2 class="cs-entry__title">', '</h2>' ); ?>

				<?php if ( 'post' === get_post_type() ) { ?>
					<?php csco_get_post_meta( array( 'author', 'date', 'comments' ), false, true, $options['meta'] ); ?>
				<?php } ?>

				<?php
				$post_excerpt = get_the_excerpt();
				if ( isset( $options['excerpt'] ) && $options['excerpt'] && $post_excerpt ) {
					?>
					<div class="cs-entry__excerpt">
						<?php echo wp_kses_post( $post_excerpt ); ?>
					</div>
					<?php
				}
				?>
			</div>

			<?php
			if ( 'post' === get_post_type() ) {
				csco_block_post_footer( $options, null, $options['more_button'], null, array() );
			}
			?>
		</div>

		<a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link"></a>
	</div>
</article>
