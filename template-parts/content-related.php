<?php
/**
 * Template part for displaying related posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Caards
 */

// Thumbnail size.
$thumbnail_size = $args['image_size'];

$args = csco_block_normalize_meta( $options, $args['meta'] );
?>

<article <?php post_class(); ?>>
	<div class="cs-entry__outer">
		<div class="cs-entry__inner cs-entry__content">
			<?php csco_get_post_meta( 'category', false, true, $args['meta'] ); ?>

			<?php the_title( '<h2 class="cs-entry__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>

			<?php csco_get_post_meta( array( 'author', 'date', 'comments' ), false, true, $args['meta'] ); ?>

			<?php if ( csco_get_the_excerpt() && $args['excerpt'] ) { ?>
				<div class="cs-entry__excerpt"><?php echo esc_html( csco_get_post_excerpt() ); ?></div>
			<?php } ?>
		</div>

		<?php if ( has_post_thumbnail() ) { ?>
			<div class="cs-entry__inner cs-entry__thumbnail cs-entry__overlay cs-overlay-ratio cs-ratio-<?php echo esc_attr( $args['image_orientation'] ); ?>">
				<div class="cs-overlay-background cs-overlay-transparent">
					<?php the_post_thumbnail( $thumbnail_size ); ?>
				</div>

				<?php csco_the_post_format_icon(); ?>

				<a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link"></a>
			</div>
		<?php } ?>

		<?php csco_block_post_footer( $args, null, $args['more_button'], null, array() ); ?>
	</div>
</article>
