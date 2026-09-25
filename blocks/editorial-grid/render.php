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
$posts_to_show = isset( $attributes['postsToShow'] ) ? absint( $attributes['postsToShow'] ) : 8;
$order_by       = isset( $attributes['orderBy'] ) ? sanitize_key( $attributes['orderBy'] ) : 'date';
$show_excerpt   = ! empty( $attributes['showExcerpt'] );
$show_author    = ! array_key_exists( 'showAuthor', $attributes ) || ! empty( $attributes['showAuthor'] );
$show_date      = ! array_key_exists( 'showDate', $attributes ) || ! empty( $attributes['showDate'] );

$allowed_layouts = array( 'bento', 'grid', 'list' );
if ( ! in_array( $layout, $allowed_layouts, true ) ) {
	$layout = 'bento';
}

$allowed_order_by = array( 'date', 'modified', 'title', 'rand' );
if ( ! in_array( $order_by, $allowed_order_by, true ) ) {
	$order_by = 'date';
}

$query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => max( 1, min( 16, $posts_to_show ) ),
		'orderby'             => $order_by,
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'vaarta-editorial-grid vaarta-editorial-grid--' . $layout,
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
		<article <?php post_class( 'vaarta-story' ); ?>>
			<?php if ( has_post_thumbnail() ) : ?>
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

				<?php if ( $show_author || $show_date ) : ?>
					<div class="vaarta-story__meta">
						<?php if ( $show_author ) : ?>
							<span class="vaarta-story__author"><?php the_author_posts_link(); ?></span>
						<?php endif; ?>
						<?php if ( $show_date ) : ?>
							<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
								<?php echo esc_html( get_the_date() ); ?>
							</time>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</article>
	<?php endwhile; ?>
</div>
<?php
wp_reset_postdata();
