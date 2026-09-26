<?php
/**
 * Template part entry header
 *
 * @package Caards
 */

$header_type = csco_get_page_header_type();

$thumbnail_size = 'csco-medium';

if ( 'uncropped' === csco_get_page_preview() && 'standard' === $header_type ) {
	$thumbnail_size = sprintf( '%s-uncropped', $thumbnail_size );
}

?>

<div class="cs-entry__header cs-entry__header-<?php echo esc_attr( $header_type ); ?>">
	<div class="cs-entry__header-inner">
		<div class="cs-entry__header-info">
			<?php
			csco_entry_breadcrumbs();

			the_title( '<h1 class="cs-entry__title"><span>', '</span></h1>' );

			if ( 'title' !== $header_type ) {
				if ( is_singular( 'post' ) ) {
					csco_get_post_meta( array( 'author', 'date', 'comments', 'shares' ), false, true, 'post_meta', array( 'shares_total' => true, 'shares_link' => false ) );
				}

				csco_post_subtitle();
			}
			?>
		</div>

		<?php if ( has_post_thumbnail() && 'title' !== $header_type ) { ?>
			<figure class="cs-entry__post-media post-media">
				<?php the_post_thumbnail( $thumbnail_size ); ?>
			</figure>
			<?php if ( get_the_post_thumbnail_caption() ) { ?>
				<figcaption class="cs-entry__caption-text wp-caption-text"><?php the_post_thumbnail_caption(); ?></figcaption>
			<?php } ?>
		<?php } ?>
	</div>
</div>
