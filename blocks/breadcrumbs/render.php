<?php
/**
 * Render Breadcrumbs.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id       = ! empty( $block->context['postId'] ) ? absint( $block->context['postId'] ) : get_the_ID();
$show_current  = ! array_key_exists( 'showCurrent', $attributes ) || ! empty( $attributes['showCurrent'] );
$show_category = ! array_key_exists( 'showCategory', $attributes ) || ! empty( $attributes['showCategory'] );

$items = array(
	array(
		'label' => __( 'Home', 'vaarta' ),
		'url'   => home_url( '/' ),
	),
);

if ( $post_id && 'post' === get_post_type( $post_id ) ) {
	if ( $show_category ) {
		$categories = get_the_category( $post_id );
		if ( $categories ) {
			$category = $categories[0];
			$items[] = array(
				'label' => $category->name,
				'url'   => get_category_link( $category ),
			);
		}
	}

	if ( $show_current ) {
		$items[] = array(
			'label' => get_the_title( $post_id ),
			'url'   => '',
		);
	}
} elseif ( is_category() ) {
	$term = get_queried_object();
	if ( $term instanceof WP_Term ) {
		$items[] = array(
			'label' => $term->name,
			'url'   => '',
		);
	}
} elseif ( is_author() ) {
	$author = get_queried_object();
	if ( $author instanceof WP_User ) {
		$items[] = array(
			'label' => $author->display_name,
			'url'   => '',
		);
	}
} elseif ( is_search() ) {
	$items[] = array(
		'label' => sprintf(
			/* translators: %s: search query. */
			__( 'Search: %s', 'vaarta' ),
			get_search_query()
		),
		'url' => '',
	);
} elseif ( is_archive() ) {
	$title = get_the_archive_title();
	if ( $title ) {
		$items[] = array(
			'label' => wp_strip_all_tags( $title ),
			'url'   => '',
		);
	}
}

if ( count( $items ) < 2 ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'vaarta-breadcrumbs' ) );
?>
<nav <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-label="<?php echo esc_attr__( 'Breadcrumb', 'vaarta' ); ?>">
	<ol class="vaarta-breadcrumbs__list">
		<?php foreach ( $items as $index => $item ) : ?>
			<?php $is_last = $index === count( $items ) - 1; ?>
			<li class="vaarta-breadcrumbs__item">
				<?php if ( $item['url'] && ! $is_last ) : ?>
					<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
				<?php else : ?>
					<span<?php echo $is_last ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $item['label'] ); ?></span>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>
</nav>
