<?php
/**
 * Instant-search REST endpoint.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the lightweight public search endpoint used by the Search Overlay block.
 */
function vaarta_register_search_route(): void {
	register_rest_route(
		'vaarta/v1',
		'/search',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'permission_callback' => '__return_true',
			'args'                => array(
				'q' => array(
					'type'              => 'string',
					'required'          => true,
					'sanitize_callback' => 'sanitize_text_field',
				),
				'limit' => array(
					'type'              => 'integer',
					'default'           => 6,
					'sanitize_callback' => 'absint',
				),
			),
			'callback'            => 'vaarta_rest_search',
		)
	);
}
add_action( 'rest_api_init', 'vaarta_register_search_route' );

/**
 * Return compact editorial search results.
 *
 * @param WP_REST_Request $request Request object.
 * @return WP_REST_Response
 */
function vaarta_rest_search( WP_REST_Request $request ): WP_REST_Response {
	$query = trim( (string) $request->get_param( 'q' ) );
	$limit = max( 1, min( 10, (int) $request->get_param( 'limit' ) ) );

	$query_length = function_exists( 'mb_strlen' ) ? mb_strlen( $query ) : strlen( $query );

	if ( $query_length < 2 ) {
		return rest_ensure_response(
			array(
				'results' => array(),
				'total'   => 0,
			)
		);
	}

	$search = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			's'                   => $query,
			'posts_per_page'      => $limit,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => false,
		)
	);

	$results = array();

	while ( $search->have_posts() ) {
		$search->the_post();

		$categories = get_the_category();
		$image      = get_the_post_thumbnail_url( get_the_ID(), 'medium' );

		$results[] = array(
			'id'          => get_the_ID(),
			'title'       => get_the_title(),
			'url'         => get_permalink(),
			'excerpt'     => wp_trim_words( get_the_excerpt(), 18 ),
			'image'       => $image ?: '',
			'category'    => $categories ? $categories[0]->name : '',
			'readingTime' => vaarta_get_reading_time( get_the_ID() ),
		);
	}

	wp_reset_postdata();

	return rest_ensure_response(
		array(
			'results' => $results,
			'total'   => (int) $search->found_posts,
		)
	);
}
