<?php
/**
 * Template part entry header full
 *
 * @package Caards
 */

$header_type = csco_get_page_header_type();

?>

<div class="cs-entry__header cs-entry__header-<?php echo esc_attr( $header_type ); ?>">
	<div class="cs-entry__header-inner">
		<div class="cs-ratio-wide cs-entry__header-wrap cs-video-wrap" data-scheme="inverse">

			<figure class="cs-entry__post-media cs-entry__overlay-bg cs-overlay-background">
				<?php the_post_thumbnail( 'csco-extra-large' ); ?>

				<?php csco_get_video_background( 'full-header', null, 'large', false ); ?>
			</figure>

			<div class="cs-container">
				<div class="cs-entry__header-container">
					<div class="cs-entry__header-info">
						<?php csco_post_category(); ?>

						<div class="cs-entry__header-info-item">
							<?php
							csco_entry_breadcrumbs();

							the_title( '<h1 class="cs-entry__title"><span>', '</span></h1>' );

							if ( is_singular( 'post' ) ) {
								csco_get_post_meta( array( 'author', 'date', 'comments', 'shares' ), false, true, 'post_meta', array( 'shares_total' => true, 'shares_link' => false ) );
							}

							csco_post_subtitle();
							?>
						</div>
					</div>
				</div>

				<?php csco_get_video_controls(); ?>
			</div>
		</div>
	</div>
</div>
