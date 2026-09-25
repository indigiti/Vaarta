<?php
/**
 * Render Category Cards.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading          = isset( $attributes['heading'] ) ? sanitize_text_field( $attributes['heading'] ) : __( 'Explore Topics', 'vaarta' );
$category_slugs   = isset( $attributes['categorySlugs'] ) && is_array( $attributes['categorySlugs'] )
	? array_values( array_filter( array_map( 'sanitize_title', $attributes['categorySlugs'] ) ) )
	: array();
$max_categories   = isset( $attributes['maxCategories'] ) ? absint( $attributes['maxCategories'] ) : 5;
$show_image       = ! array_key_exists( 'showImage', $attributes ) || ! empty( $attributes['showImage'] );
$show_count       = ! array_key_exists( 'showCount', $attributes ) || ! empty( $attributes['showCount'] );
$show_description = ! empty( $attributes['showDescription'] );
$layout           = isset( $attributes['layout'] ) ? sanitize_key( $attributes['layout'] ) : 'grid';

$max_categories = max( 2, min( 12, $max_categories ) );

if ( ! in_array( $layout, array( 'grid', 'strip' ), true ) ) {
	$layout = 'grid';
}

$args = array(
	'taxonomy'   => 'category',
	'hide_empty' => true,
	'number'     => $max_categories,
);

if ( $category_slugs ) {
	$args['slug']    = $category_slugs;
	$args['orderby'] = 'name';
	$args['order']   = 'ASC';
} else {
	$args['orderby'] = 'count';
	$args['order']   = 'DESC';
}

$terms = get_terms( $args );

if ( is_wp_error( $terms ) || ! $terms ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'vaarta-category-cards vaarta-category-cards--' . $layout,
	)
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $heading ) : ?>
		<div class="vaarta-category-cards__header">
			<h2 class="vaarta-category-cards__heading"><?php echo esc_html( $heading ); ?></h2>
		</div>
	<?php endif; ?>

	<div class="vaarta-category-cards__items">
		<?php foreach ( $terms as $term ) : ?>
			<?php
			$url = get_term_link( $term );
			if ( is_wp_error( $url ) ) {
				continue;
			}
			?>
			<article class="vaarta-category-card">
				<?php
				$thumbnail_id = 0;

				if ( $show_image ) {
					$latest_ids = get_posts(
						array(
							'post_type'           => 'post',
							'post_status'         => 'publish',
							'posts_per_page'      => 1,
							'category'            => $term->term_id,
							'fields'              => 'ids',
							'ignore_sticky_posts' => true,
							'no_found_rows'       => true,
						)
					);

					if ( $latest_ids ) {
						$thumbnail_id = get_post_thumbnail_id( $latest_ids[0] );
					}
				}
				?>

				<?php if ( $thumbnail_id ) : ?>
					<a class="vaarta-category-card__media" href="<?php echo esc_url( $url ); ?>" aria-hidden="true" tabindex="-1">
						<?php echo wp_get_attachment_image( $thumbnail_id, 'medium_large', false, array( 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
					</a>
				<?php else : ?>
					<div class="vaarta-category-card__mark" aria-hidden="true">
						<?php echo esc_html( strtoupper( substr( $term->name, 0, 1 ) ) ); ?>
					</div>
				<?php endif; ?>

				<div class="vaarta-category-card__body">
					<h3 class="vaarta-category-card__title">
						<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $term->name ); ?></a>
					</h3>

					<?php if ( $show_count ) : ?>
						<p class="vaarta-category-card__count">
							<?php
							printf(
								/* translators: %s: formatted category post count. */
								esc_html__( '%s Posts', 'vaarta' ),
								esc_html( number_format_i18n( (int) $term->count ) )
							);
							?>
						</p>
					<?php endif; ?>

					<?php if ( $show_description && $term->description ) : ?>
						<p class="vaarta-category-card__description"><?php echo esc_html( wp_strip_all_tags( $term->description ) ); ?></p>
					<?php endif; ?>

					<a class="vaarta-category-card__link" href="<?php echo esc_url( $url ); ?>">
						<?php esc_html_e( 'View Posts', 'vaarta' ); ?>
					</a>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>
