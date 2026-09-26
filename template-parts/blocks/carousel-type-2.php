<?php
/**
 * Block Small Carousel Type 2
 *
 * @var        $attributes - block attributes
 * @var        $options - layout options
 * @var        $posts - all available posts
 *
 * @package Caards
 */

// Check if there're enough posts in the query.

$attributes['className'] .= ' cnvs-block-posts-layout-large-type-1 cnvs-block-posts-layout-tile-type-1';

if ( $posts->have_posts() ) { ?>

	<div class="<?php echo esc_attr( $attributes['className'] ); ?>">
		<div class="cnvs-block-posts-inner">
			<div class="cs-carousel cs-flickity-init" data-autoplay="false" data-wraparound="true" data-pagedots="true" data-groupcells="true">
				<div class="cs-carousel__wrap">
					<div class="cs-carousel__items">
						<?php
						while ( $posts->have_posts() ) {
							$posts->the_post();
							?>
							<div class="cs-carousel__cell">
								<article <?php post_class(); ?>>
									<div class="cs-entry__outer cs-entry__overlay cs-overlay-ratio cs-ratio-<?php echo esc_attr( $options['image_orientation'] ); ?>" data-scheme="inverse">

										<div class="cs-entry__inner cs-entry__thumbnail">
											<?php csco_block_post_overlay_thumbnail( $options, $attributes ); ?>
										</div>

										<div class="cs-entry__item">

											<?php if ( 'count' !== $options['top_meta'] && 'none' !== $options['top_meta'] ) { ?>
												<div class="cs-entry__inner cs-entry__content">

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
							</div>
						<?php } ?>
					</div>
					<div class="cs-carousel__organizer-wrapper">
						<div class="cs-container">
							<div class="cs-carousel__organizer">
								<div class="cs-carousel__counters">
									<span class="cs-carousel__counters-current"></span>
									<span class="cs-carousel__counters-total"></span>
								</div>
								<div class="cs-carousel__arrows">
									<span class="cs-carousel__arrow cs-carousel__arrow-previous"></span>
									<span class="cs-carousel__arrow cs-carousel__arrow-next"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<?php
} else {
	cnvs_alert_warning( esc_html__( 'There aren\'t enough posts that match the filter criteria.', 'caards' ) );
}
