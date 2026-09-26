<?php
/**
 * Block Horizontal Type 2
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
		<?php csco_block_post_thumbnail( $options, $attributes ); ?>

		<div class="cs-entry__inner cs-entry__content ">
			<div class="cs-entry__content-inner">
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
