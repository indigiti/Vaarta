<?php
/**
 * Block Horizontal Type 4
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

		<div class="cs-entry__inner cs-entry__content ">
			<div class="cs-entry__content-inner">
				<?php cnvs_block_post_meta( $options, array( 'category', 'author', 'date', 'comments', 'views', 'reading_time', 'shares' ) ); ?>

				<?php csco_block_post_title( $options ); ?>

				<?php csco_block_post_excerpt( $options ); ?>
			</div>
		</div>
	</div>
</article>
