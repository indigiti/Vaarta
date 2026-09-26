<?php
/**
 * Add cross-preset taxonomy assignments and discussion fixtures to demo data.
 *
 * This file runs after tools/seed-demo.php from the admin/CLI demo installer.
 * It does not replace normal WordPress content; it only augments posts carrying
 * the Vaarta demo marker.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$seed_key = '_vaarta_demo_seed';

$ensure_category = static function ( string $slug, string $name ): int {
	$term = term_exists( $slug, 'category' );

	if ( ! $term ) {
		$term = wp_insert_term(
			$name,
			'category',
			array( 'slug' => $slug )
		);
	}

	if ( is_wp_error( $term ) ) {
		return 0;
	}

	return (int) ( is_array( $term ) ? $term['term_id'] : $term );
};

$mobile_id     = $ensure_category( 'mobile', __( 'Mobile', 'vaarta' ) );
$strategies_id = $ensure_category( 'strategies', __( 'Strategies', 'vaarta' ) );

$demo_posts = get_posts(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'meta_key'       => $seed_key,
		'meta_value'     => '1',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'fields'         => 'ids',
	)
);

foreach ( $demo_posts as $post_id ) {
	$category_slugs = wp_get_post_terms(
		$post_id,
		'category',
		array( 'fields' => 'slugs' )
	);

	if ( is_wp_error( $category_slugs ) ) {
		continue;
	}

	if (
		$mobile_id > 0 &&
		array_intersect( array( 'gear', 'wearables', 'connectivity', 'computers' ), $category_slugs )
	) {
		wp_set_post_categories( $post_id, array( $mobile_id ), true );
	}

	if (
		$strategies_id > 0 &&
		array_intersect( array( 'entrepreneurship', 'insights', 'business-tech' ), $category_slugs )
	) {
		wp_set_post_categories( $post_id, array( $strategies_id ), true );
	}
}

$existing_demo_comments = get_comments(
	array(
		'status'     => 'all',
		'number'     => 0,
		'meta_key'   => '_vaarta_demo_comment',
		'meta_value' => '1',
	)
);

foreach ( $existing_demo_comments as $comment ) {
	wp_delete_comment( $comment->comment_ID, true );
}

$discussion_posts = array_slice( $demo_posts, 0, 8 );

foreach ( $discussion_posts as $post_index => $post_id ) {
	$comment_total = ( $post_index % 4 ) + 1;

	for ( $comment_index = 0; $comment_index < $comment_total; $comment_index++ ) {
		$comment_id = wp_insert_comment(
			array(
				'comment_post_ID'      => $post_id,
				'comment_author'       => sprintf( 'Reader %d', $comment_index + 1 ),
				'comment_author_email' => sprintf( 'reader%d@example.test', $comment_index + 1 ),
				'comment_content'      => __( 'A deterministic demo comment used to test discussion ranking and comment presentation.', 'vaarta' ),
				'comment_approved'     => 1,
				'comment_agent'        => 'Vaarta Demo Seeder',
			)
		);

		if ( $comment_id ) {
			add_comment_meta( $comment_id, '_vaarta_demo_comment', '1', true );
		}
	}
}
