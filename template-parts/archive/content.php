<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Caards
 */

$options = get_query_var( 'options' );

$options = csco_block_normalize_meta( $options, $options['meta'] );

// Thumbnail size.
$thumbnail_size = $options['image_size'];

if ( 'full' === $options['layout'] ) {
	$thumbnail_size = 'csco-large';
	if ( 'uncropped' === csco_get_page_preview() ) {
		$thumbnail_size = sprintf( '%s-uncropped', $thumbnail_size );
	}
}

// Summary type.
if ( 'full' === $options['layout'] && 'content' === $options['summary_type'] ) {
	$post_excerpt = get_the_content();
} else {
	$post_excerpt            = get_the_excerpt();
	$options['summary_type'] = 'excerpt';
}

if ( 'post' !== get_post_type() ) {
	$options['excerpt'] = false;
}
?>

<article <?php post_class(); ?>>
	<div class="cs-entry__outer">

		<?php if ( has_post_thumbnail() ) { ?>
			<div class="cs-entry__inner cs-entry__thumbnail cs-entry__overlay cs-overlay-ratio cs-ratio-<?php echo esc_attr( $options['image_orientation'] ); ?>">
				<div class="cs-overlay-background cs-overlay-transparent">
					<?php the_post_thumbnail( $thumbnail_size ); ?>
				</div>

				<?php csco_get_video_background( 'archive' ); ?>

				<?php csco_the_post_format_icon(); ?>

				<a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link"></a>
			</div>
		<?php } ?>

		<div class="cs-entry__inner cs-entry__content">
			<div class="cs-entry__content-inner">

				<?php csco_get_post_meta( 'category', false, true, $options['meta'] ); ?>

				<?php the_title( '<h2 class="cs-entry__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>

				<?php if ( csco_get_the_excerpt() && 'content' !== $options['summary_type'] && $options['excerpt'] ) { ?>
					<div class="cs-entry__excerpt"><?php echo esc_html( csco_get_post_excerpt() ); ?></div>
				<?php } ?>

				<?php if ( get_the_content() && 'content' === $options['summary_type'] && $options['excerpt'] ) { ?>
					<div class="cs-entry__excerpt">
						<?php the_content(); ?>
					</div>
				<?php } ?>

				<?php if ( 'post' === get_post_type() ) { ?>
					<?php csco_get_post_meta( array( 'author', 'date', 'comments' ), false, true, $options['meta'] ); ?>
				<?php } ?>
			</div>

			<?php
			if ( 'post' === get_post_type() ) {
				csco_block_post_footer( $options, null, $options['more_button'], null, array() );
			}
			?>
		</div>
	</div>
</article>
