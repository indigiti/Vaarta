<?php
/**
 * Story Carousel dynamic block renderer.
 *
 * Keeps the legacy carousel DOM/CSS contract so the existing Flickity runtime
 * and theme styles continue to apply, while Vaarta owns the query and block
 * attributes. Legacy card helpers are reused when present; otherwise a native
 * fallback card is rendered without making Canvas or Powerkit mandatory.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block_attributes = is_array( $attributes ) ? $attributes : array();

$variant = isset( $block_attributes['variant'] ) ? sanitize_key( $block_attributes['variant'] ) : 'wide';
if ( ! in_array( $variant, array( 'wide', 'large' ), true ) ) {
	$variant = 'wide';
}

$posts_to_show = isset( $block_attributes['postsToShow'] ) ? absint( $block_attributes['postsToShow'] ) : 6;
$posts_to_show = min( 20, max( 1, $posts_to_show ) );

$category = isset( $block_attributes['category'] ) ? absint( $block_attributes['category'] ) : 0;

$allowed_orderby = array( 'date', 'modified', 'comment_count', 'title', 'rand' );
$order_by        = isset( $block_attributes['orderBy'] ) ? sanitize_key( $block_attributes['orderBy'] ) : 'date';
if ( ! in_array( $order_by, $allowed_orderby, true ) ) {
	$order_by = 'date';
}

$order = isset( $block_attributes['order'] ) ? strtoupper( sanitize_text_field( $block_attributes['order'] ) ) : 'DESC';
if ( ! in_array( $order, array( 'ASC', 'DESC' ), true ) ) {
	$order = 'DESC';
}

$exclude_current = ! isset( $block_attributes['excludeCurrent'] ) || (bool) $block_attributes['excludeCurrent'];
$columns         = isset( $block_attributes['columns'] ) ? absint( $block_attributes['columns'] ) : 4;
$columns         = min( 6, max( 1, $columns ) );
$gap             = isset( $block_attributes['gap'] ) ? absint( $block_attributes['gap'] ) : 40;
$gap             = min( 120, $gap );
$autoplay        = ! isset( $block_attributes['autoplay'] ) || (bool) $block_attributes['autoplay'];
$page_dots       = ! isset( $block_attributes['pageDots'] ) || (bool) $block_attributes['pageDots'];
$wrap_around     = ! isset( $block_attributes['wrapAround'] ) || (bool) $block_attributes['wrapAround'];

$image_size = isset( $block_attributes['imageSize'] ) ? sanitize_key( $block_attributes['imageSize'] ) : 'medium_large';
if ( ! $image_size ) {
	$image_size = 'medium_large';
}

$allowed_orientations = array(
	'stretch',
	'original',
	'landscape',
	'landscape-3-2',
	'landscape-16-9',
	'landscape-21-10',
	'portrait',
	'portrait-2-3',
	'square',
);
$image_orientation = isset( $block_attributes['imageOrientation'] ) ? sanitize_key( $block_attributes['imageOrientation'] ) : 'landscape-16-9';
if ( ! in_array( $image_orientation, $allowed_orientations, true ) ) {
	$image_orientation = 'landscape-16-9';
}

$allowed_top_meta = array( 'none', 'author', 'category', 'count' );
$top_meta         = isset( $block_attributes['topMeta'] ) ? sanitize_key( $block_attributes['topMeta'] ) : 'author';
if ( ! in_array( $top_meta, $allowed_top_meta, true ) ) {
	$top_meta = 'author';
}

$show_category = ! isset( $block_attributes['showCategory'] ) || (bool) $block_attributes['showCategory'];
$show_author   = ! isset( $block_attributes['showAuthor'] ) || (bool) $block_attributes['showAuthor'];
$show_date     = ! isset( $block_attributes['showDate'] ) || (bool) $block_attributes['showDate'];
$show_excerpt  = ! isset( $block_attributes['showExcerpt'] ) || (bool) $block_attributes['showExcerpt'];
$excerpt_words = isset( $block_attributes['excerptLength'] ) ? absint( $block_attributes['excerptLength'] ) : 20;
$excerpt_words = min( 80, max( 1, $excerpt_words ) );

$query_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => $posts_to_show,
	'orderby'             => $order_by,
	'order'               => $order,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);

if ( $category ) {
	$query_args['cat'] = $category;
}

if ( $exclude_current && is_singular( 'post' ) ) {
	$current_post_id = get_queried_object_id();
	if ( $current_post_id ) {
		$query_args['post__not_in'] = array( $current_post_id );
	}
}

/**
 * Filter Story Carousel query arguments after block input has been constrained.
 *
 * @param array $query_args       WP_Query arguments.
 * @param array $block_attributes Original block attributes.
 */
$query_args = apply_filters( 'vaarta_story_carousel_query_args', $query_args, $block_attributes );

$posts = new WP_Query( $query_args );

$wrapper_class = 'wide' === $variant
	? 'cnvs-block-posts-layout-wide-type-1 cnvs-block-posts-layout-tile-type-1'
	: 'cnvs-block-posts-layout-large-type-1 cnvs-block-posts-layout-tile-type-1';

$wrapper_style = sprintf(
	'--cs-carousel-columns:%1$d;--cs-carousel-gap:%2$dpx;',
	$columns,
	$gap
);

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'vaarta-story-carousel ' . $wrapper_class,
		'style' => $wrapper_style,
	)
);

if ( ! $posts->have_posts() ) {
	?>
	<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Generated by core. ?>>
		<p class="vaarta-story-carousel__empty"><?php esc_html_e( 'No stories found.', 'caards' ); ?></p>
	</div>
	<?php
	return;
}

$options = array(
	'image_orientation'          => $image_orientation,
	'image_size'                 => $image_size,
	'top_meta'                   => $top_meta,
	'display_meta_category'      => $show_category,
	'display_meta_author'        => $show_author,
	'display_meta_date'          => $show_date,
	'display_meta_comments'      => false,
	'display_meta_views'         => false,
	'display_meta_reading_time'  => false,
	'display_meta_shares'        => false,
	'display_meta_compact'       => false,
	'display_excerpt'            => $show_excerpt,
	'excerpt_length'             => max( 40, $excerpt_words * 5 ),
	'typography_heading_tag'     => 'h3',
	'display_view_post_button'   => true,
	'view_post_button_label'     => esc_html__( 'View Post', 'caards' ),
	'view_post_button_type'      => 'simple',
	'view_post_button_size'      => 'small',
	'view_post_button_fullwidth' => false,
	'post_class'                 => '',
	'current_post'               => 0,
);

$legacy_attributes = array(
	'className' => 'vaarta-story-carousel__legacy',
	'layout'    => 'wide' === $variant ? 'carousel-type-1' : 'carousel-type-2',
);

$required_helpers = array(
	'cnvs_block_post_meta',
	'csco_block_post_overlay_thumbnail',
	'csco_block_post_author',
	'csco_block_post_category',
	'csco_block_post_title',
	'csco_block_post_excerpt',
	'csco_block_post_footer',
);

$legacy_available = true;
foreach ( $required_helpers as $helper ) {
	if ( ! function_exists( $helper ) ) {
		$legacy_available = false;
		break;
	}
}

$render_native_card = static function ( $image_size_value, $orientation, $display_category, $display_author, $display_date, $display_excerpt, $words, $top_meta_value, $index ) {
	$ratio_class = 'stretch' === $orientation ? 'landscape-16-9' : $orientation;
	?>
	<article <?php post_class( 'cs-entry vaarta-story-carousel__card' ); ?>>
		<div class="cs-entry__outer cs-entry__overlay cs-overlay-ratio cs-ratio-<?php echo esc_attr( $ratio_class ); ?>" data-scheme="inverse">
			<div class="cs-entry__inner cs-entry__thumbnail">
				<?php if ( has_post_thumbnail() ) { ?>
					<?php the_post_thumbnail( $image_size_value ); ?>
				<?php } ?>
			</div>

			<div class="cs-entry__item">
				<?php if ( 'none' !== $top_meta_value && 'count' !== $top_meta_value ) { ?>
					<div class="cs-entry__inner cs-entry__content">
						<?php if ( 'author' === $top_meta_value ) { ?>
							<span class="cs-entry__post-meta-author"><?php echo esc_html( get_the_author() ); ?></span>
						<?php } elseif ( 'category' === $top_meta_value ) { ?>
							<?php echo wp_kses_post( get_the_category_list( ', ' ) ); ?>
						<?php } ?>
					</div>
				<?php } elseif ( 'count' === $top_meta_value ) { ?>
					<div class="cs-entry__inner cs-entry__content"><span class="cs-entry__number"><?php echo esc_html( (string) $index ); ?></span></div>
				<?php } ?>

				<div class="cs-entry__inner cs-entry__content cs-overlay-content">
					<?php if ( $display_category ) { ?>
						<div class="cs-entry__post-meta cs-entry__post-meta-category"><?php echo wp_kses_post( get_the_category_list( ', ' ) ); ?></div>
					<?php } ?>

					<h3 class="cs-entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

					<?php if ( $display_author || $display_date ) { ?>
						<div class="cs-entry__post-meta">
							<?php if ( $display_author ) { ?>
								<span class="cs-entry__post-meta-author"><?php echo esc_html( get_the_author() ); ?></span>
							<?php } ?>
							<?php if ( $display_date ) { ?>
								<time class="cs-entry__post-meta-date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<?php } ?>
						</div>
					<?php } ?>

					<?php if ( $display_excerpt ) { ?>
						<div class="cs-entry__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), $words, '…' ) ); ?></div>
					<?php } ?>
				</div>
			</div>

			<a href="<?php the_permalink(); ?>" class="cs-overlay-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>
		</div>
	</article>
	<?php
};
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Generated by core. ?>>
	<div class="cnvs-block-posts-inner">
		<div
			class="cs-carousel cs-flickity-init"
			data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>"
			data-wraparound="<?php echo $wrap_around ? 'true' : 'false'; ?>"
			data-pagedots="<?php echo $page_dots ? 'true' : 'false'; ?>"
			<?php if ( 'large' === $variant ) { ?>data-groupcells="true"<?php } ?>
		>
			<div class="cs-carousel__wrap">
				<div class="cs-carousel__items">
					<?php
					$current = 0;
					while ( $posts->have_posts() ) {
						$posts->the_post();
						$current++;
						$options['current_post'] = $current;
						?>
						<div class="cs-carousel__cell">
							<?php if ( $legacy_available ) { ?>
								<article <?php post_class(); ?>>
									<div class="cs-entry__outer cs-entry__overlay cs-overlay-ratio cs-ratio-<?php echo esc_attr( $image_orientation ); ?>" data-scheme="inverse">
										<div class="cs-entry__inner cs-entry__thumbnail">
											<?php csco_block_post_overlay_thumbnail( $options, $legacy_attributes ); ?>
										</div>

										<div class="cs-entry__item">
											<?php if ( 'count' !== $top_meta && 'none' !== $top_meta ) { ?>
												<div class="cs-entry__inner cs-entry__content">
													<?php if ( 'author' === $top_meta ) { ?>
														<?php csco_block_post_author( $options ); ?>
													<?php } elseif ( 'category' === $top_meta ) { ?>
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
							<?php } else { ?>
								<?php $render_native_card( $image_size, $image_orientation, $show_category, $show_author, $show_date, $show_excerpt, $excerpt_words, $top_meta, $current ); ?>
							<?php } ?>
						</div>
					<?php } ?>
				</div>

				<div class="cs-carousel__organizer-wrapper">
					<?php if ( 'large' === $variant ) { ?><div class="cs-container"><?php } ?>
						<div class="cs-carousel__organizer">
							<div class="cs-carousel__counters">
								<span class="cs-carousel__counters-current"></span>
								<span class="cs-carousel__counters-total"></span>
							</div>
							<div class="cs-carousel__arrows">
								<button type="button" class="cs-carousel__arrow cs-carousel__arrow-previous" aria-label="<?php esc_attr_e( 'Previous story', 'caards' ); ?>"></button>
								<button type="button" class="cs-carousel__arrow cs-carousel__arrow-next" aria-label="<?php esc_attr_e( 'Next story', 'caards' ); ?>"></button>
							</div>
						</div>
					<?php if ( 'large' === $variant ) { ?></div><?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
wp_reset_postdata();
