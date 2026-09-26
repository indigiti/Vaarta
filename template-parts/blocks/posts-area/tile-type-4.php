<?php
/**
 * Block Tile Type 4
 *
 * @var        $attributes - block attributes
 * @var        $options - layout options
 * @var        $posts - all available posts
 *
 * @package Caards
 */

$options['post_author_details'] = false;
$options['post_category_label'] = false;

?>

<article <?php post_class(); ?>>
	<div class="cs-entry__outer cs-entry__overlay cs-overlay-ratio">

		<div class="cs-entry__inner cs-entry__thumbnail">
			<?php csco_block_post_overlay_thumbnail( $options, $attributes ); ?>
		</div>

		<div class="cs-entry__item">

			<?php if ( 'count' !== $options['top_meta'] && 'none' !== $options['top_meta'] ) { ?>
				<div class="cs-entry__inner cs-entry__content-meta">

					<?php if ( 'author' === $options['top_meta'] ) { ?>
						<?php csco_block_post_author( $options ); ?>
					<?php } elseif ( 'category' === $options['top_meta'] ) { ?>
						<?php csco_block_post_category( $options ); ?>
					<?php } ?>

				</div>
			<?php } ?>

			<div class="cs-entry__inner cs-entry__content cs-overlay-content">
				<?php cnvs_block_post_meta( $options, array( 'category' ) ); ?>

				<?php csco_block_post_title( $options ); ?>

				<?php cnvs_block_post_meta( $options, array( 'author', 'date', 'comments' ) ); ?>

				<?php csco_block_post_excerpt( $options ); ?>
			</div>

			<?php csco_block_post_footer( $options ); ?>
		</div>

		<a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link"></a>

	</div>
</article>
