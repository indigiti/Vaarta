<?php
/**
 * Cross-preset taxonomy and discussion fixtures for Vaarta demo posts.
 *
 * The hook runs only for posts carrying Vaarta's demo marker. Production posts
 * and unrelated site content are never modified.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ensure a demo taxonomy term exists.
 */
function vaarta_demo_ensure_category( string $slug, string $name ): int {
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
}

/**
 * Add cross-preset categories and deterministic comments to seeded posts.
 *
 * wp_after_insert_post fires after terms and meta are saved, so the original
 * seeded category and _vaarta_demo_seed marker are available here.
 */
function vaarta_add_editorial_demo_fixtures( int $post_id, WP_Post $post, bool $update ): void {
	if ( 'post' !== $post->post_type || 'publish' !== $post->post_status ) {
		return;
	}

	if ( '1' !== (string) get_post_meta( $post_id, '_vaarta_demo_seed', true ) ) {
		return;
	}

	$mobile_id     = vaarta_demo_ensure_category( 'mobile', __( 'Mobile', 'vaarta' ) );
	$strategies_id = vaarta_demo_ensure_category( 'strategies', __( 'Strategies', 'vaarta' ) );

	$category_slugs = wp_get_post_terms(
		$post_id,
		'category',
		array( 'fields' => 'slugs' )
	);

	if ( ! is_wp_error( $category_slugs ) ) {
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
			'post_id'    => $post_id,
			'status'     => 'all',
			'number'     => 0,
			'meta_key'   => '_vaarta_demo_comment',
			'meta_value' => '1',
		)
	);

	foreach ( $existing_demo_comments as $comment ) {
		wp_delete_comment( $comment->comment_ID, true );
	}

	$comment_total = ( $post_id % 4 ) + 1;

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
add_action( 'wp_after_insert_post', 'vaarta_add_editorial_demo_fixtures', 20, 3 );
