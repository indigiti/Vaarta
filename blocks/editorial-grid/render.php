<?php
/**
 * Render the Editorial Grid block.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$layout         = isset( $attributes['layout'] ) ? sanitize_key( $attributes['layout'] ) : 'bento';
$card_style     = isset( $attributes['cardStyle'] ) ? sanitize_key( $attributes['cardStyle'] ) : 'standard';
$category_id    = isset( $attributes['categoryId'] ) ? absint( $attributes['categoryId'] ) : 0;
$category_slug  = isset( $attributes['categorySlug'] ) ? sanitize_title( $attributes['categorySlug'] ) : '';
$posts_to_show  = isset( $attributes['postsToShow'] ) ? absint( $attributes['postsToShow'] ) : 8;
$order_by       = isset( $attributes['orderBy'] ) ? sanitize_key( $attributes['orderBy'] ) : 'date';
$show_excerpt   = ! empty( $attributes['showExcerpt'] );
$show_author    = ! array_key_exists( 'showAuthor', $attributes ) || ! empty( $attributes['showAuthor'] );
$show_date         = ! array_key_exists( 'showDate', $attributes ) || ! empty( $attributes['showDate'] );
$show_reading_time = ! array_key_exists( 'showReadingTime', $attributes ) || ! empty( $attributes['showReadingTime'] );
$show_views        = ! array_key_exists( 'showViews', $attributes ) || ! empty( $attributes['showViews'] );

$allowed_layouts = array( 'bento', 'grid', 'list' );
if ( ! in_array( $layout, $allowed_layouts, true ) ) {
	$layout = 'bento';
}

$allowed_card_styles = array( 'standard', 'minimal', 'overlay', 'dark', 'compact' );
if ( ! in_array( $card_style, $allowed_card_styles, true ) ) {
	$card_style = 'standard';
}

$allowed_order_by = array( 'date', 'modified', 'title', 'rand', 'views', 'trending' );
if ( ! in_array( $order_by, $allowed_order_by, true ) ) {
	$order_by = 'date';
}

$query_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => max( 1, min( 16, $posts_to_show ) ),
	'orderby'             => in_array( $order_by, array( 'views', 'trending' ), true ) ? 'meta_value_num' : $order_by,
	'order'               => 'DESC',
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);

if ( in_array( $order_by, array( 'views', 'trending' ), true ) ) {
	$query_args['meta_key'] = VAARTA_VIEWS_META_KEY;
}

if ( 'trending' === $order_by ) {
	$query_args['date_query'] = array(
		array(
			'after'     => '7 days ago',
			'inclusive' => true,
		),
	);
}

if ( $category_slug ) {
	$query_args['category_name'] = $category_slug;
} elseif ( $category_id > 0 ) {
	$query_args['cat'] = $category_id;
}

$query = new WP_Query( $query_args );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => sprintf(
			'vaarta-editorial-grid vaarta-editorial-grid--%1$s vaarta-editorial-grid--cards-%2$s',
			$layout,
			$card_style
		),
	)
);

if ( ! $query->have_posts() ) {
	printf(
		'<div %1$s><p class="vaarta-editorial-grid__empty">%2$s</p></div>',
		$wrapper_attributes,
		esc_html__( 'No stories found.', 'vaarta' )
	);
	return;
}
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		?>
		<article <?php post_class( 'vaarta-story vaarta-story--' . $card_style ); ?>>
			<?php if ( has_post_thumbnail() && 'minimal' !== $card_style ) : ?>
				<a class="vaarta-story__media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php
					the_post_thumbnail(
						'large',
						array(
							'loading'  => 'lazy',
							'decoding' => 'async',
						)
					);
					?>
				</a>
			<?php endif; ?>

			<div class="vaarta-story__body">
				<div class="vaarta-story__terms">
					<?php the_category( ' · ' ); ?>
				</div>

				<h2 class="vaarta-story__title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>

				<?php if ( $show_excerpt ) : ?>
					<div class="vaarta-story__excerpt"><?php the_excerpt(); ?></div>
				<?php endif; ?>

				<?php if ( $show_author || $show_date || $show_reading_time || $show_views ) : ?>
					<div class="vaarta-story__meta">
						<?php if ( $show_author ) : ?>
							<span class="vaarta-story__author"><?php the_author_posts_link(); ?></span>
						<?php endif; ?>

						<?php if ( $show_date ) : ?>
							<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
								<?php echo esc_html( get_the_date() ); ?>
							</time>
						<?php endif; ?>

						<?php if ( $show_reading_time ) : ?>
							<span class="vaarta-story__reading-time">
								<?php
								printf(
									/* translators: %d: estimated reading time in minutes. */
									esc_html__( '%d min read', 'vaarta' ),
									vaarta_get_reading_time( get_the_ID() )
								);
								?>
							</span>
						<?php endif; ?>

						<?php if ( $show_views ) : ?>
							<span class="vaarta-story__views">
								<?php
								printf(
									/* translators: %s: formatted post view count. */
									esc_html__( '%s views', 'vaarta' ),
									esc_html( number_format_i18n( vaarta_get_post_views( get_the_ID() ) ) )
								);
								?>
							</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</article>
	<?php endwhile; ?>
</div>
<?php
wp_reset_postdata();
