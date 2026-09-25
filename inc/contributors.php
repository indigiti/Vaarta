<?php
/**
 * Structured multiple-author support.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const VAARTA_CONTRIBUTORS_META_KEY = '_vaarta_contributors';

/**
 * Sanitize contributor user IDs.
 *
 * @param mixed $value Raw meta value.
 * @return array<int>
 */
function vaarta_sanitize_contributor_ids( $value ): array {
	if ( ! is_array( $value ) ) {
		return array();
	}

	$ids = array_values(
		array_unique(
			array_filter(
				array_map( 'absint', $value ),
				static function ( int $user_id ): bool {
					return $user_id > 0 && (bool) get_user_by( 'id', $user_id );
				}
			)
		)
	);

	return $ids;
}

/**
 * Register contributor relationships as REST-visible post meta.
 */
function vaarta_register_contributor_meta(): void {
	register_post_meta(
		'post',
		VAARTA_CONTRIBUTORS_META_KEY,
		array(
			'type'              => 'array',
			'single'            => true,
			'default'           => array(),
			'sanitize_callback' => 'vaarta_sanitize_contributor_ids',
			'auth_callback'     => static function ( bool $allowed, string $meta_key, int $post_id ): bool {
				return current_user_can( 'edit_post', $post_id );
			},
			'show_in_rest'      => array(
				'schema' => array(
					'type'  => 'array',
					'items' => array(
						'type' => 'integer',
					),
				),
			),
		)
	);
}
add_action( 'init', 'vaarta_register_contributor_meta' );

/**
 * Get contributor user IDs, excluding the primary post author.
 *
 * @param int $post_id Post ID.
 * @return array<int>
 */
function vaarta_get_contributor_ids( int $post_id = 0 ): array {
	$post_id = $post_id ?: get_the_ID();

	if ( ! $post_id ) {
		return array();
	}

	$primary_author = (int) get_post_field( 'post_author', $post_id );
	$ids            = vaarta_sanitize_contributor_ids(
		get_post_meta( $post_id, VAARTA_CONTRIBUTORS_META_KEY, true )
	);

	return array_values(
		array_filter(
			$ids,
			static fn ( int $user_id ): bool => $user_id !== $primary_author
		)
	);
}
