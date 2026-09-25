<?php
/**
 * Render Related Stories.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = ! empty( $block->context['postId'] ) ? absint( $block->context['postId'] ) : get_the_ID();

if ( ! $post_id ) {
	return;
}

$heading       = isset( $attributes['heading'] ) ? sanitize_text_field( $attributes['heading'] ) : __( 'Related Stories', 'vaarta' );
$posts_to_show = isset( $attributes['postsToShow'] ) ? absint( $attributes['postsToShow'] ) : 3;
$layout        = isset( $attributes['layout'] ) ? sanitize_key( $attributes['layout'] ) : 'grid';

if ( ! in_array( $layout, array( 'grid', 'compact' ), true ) ) {
	$layout = 'grid';
}

$category_ids = wp_get_post_categories( $post_id );

$query_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'post__not_in'        => array( $post_id ),
	'posts_per_page'      => max( 2, min( 6, $posts_to_show ) ),
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);

if ( $category_ids ) {
	$query_args['category__in'] = $category_ids;
}

$query = new WP_Query( $query_args );

if ( ! $query->have_posts() ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'vaarta-related-posts vaarta-related-posts--' . $layout,
	)
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $heading ) : ?>
		<h2 class="vaarta-related-posts__heading"><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>

	<div class="vaarta-related-posts__items">
		<?php while ( $query->have_posts() ) : ?>
			<?php $query->the_post(); ?>
			<article class="vaarta-related-post">
				<?php if ( has_post_thumbnail() ) : ?>
					<a class="vaarta-related-post__media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
						<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
					</a>
				<?php endif; ?>
				<div>
					<div class="vaarta-related-post__terms"><?php the_category( ' · ' ); ?></div>
					<h3 class="vaarta-related-post__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<div class="vaarta-related-post__meta">
						<?php echo esc_html( get_the_date() ); ?>
						<span aria-hidden="true"> · </span>
						<?php
						printf(
							/* translators: %d: estimated reading time in minutes. */
							esc_html__( '%d min read', 'vaarta' ),
							vaarta_get_reading_time( get_the_ID() )
						);
						?>
					</div>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
</section>
<?php
wp_reset_postdata();
