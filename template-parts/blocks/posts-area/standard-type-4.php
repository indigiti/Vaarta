<?php
/**
 * Block Standard Type 4
 *
 * @var        $attributes - block attributes
 * @var        $options - layout options
 * @var        $posts - all available posts
 *
 * @package Caards
 */

?>

<article <?php post_class(); ?>>
	<div class="cs-entry__outer">

		<?php if ( 'count' !== $options['top_meta'] && 'none' !== $options['top_meta'] ) { ?>
			<div class="cs-entry__inner cs-entry__content">

				<?php if ( 'author' === $options['top_meta'] ) { ?>
					<?php csco_block_post_author( $options ); ?>
				<?php } elseif ( 'category' === $options['top_meta'] ) { ?>
					<?php csco_block_post_category( $options ); ?>
				<?php } ?>

			</div>
		<?php } ?>

		<div class="cs-entry__inner cs-entry__content">
			<?php cnvs_block_post_meta( $options, array( 'category' ) ); ?>

			<?php csco_block_post_title( $options ); ?>

			<?php cnvs_block_post_meta( $options, array( 'author', 'date', 'comments' ) ); ?>

			<?php csco_block_post_excerpt( $options ); ?>
		</div>

		<?php csco_block_post_footer( $options ); ?>

		<a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link"></a>
	</div>
</article>
