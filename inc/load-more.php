<?php
/**
 * Load More Posts via AJAX.
 *
 * @package Caards
 */

/**
 * Processing data query for load more.
 *
 * @param string $method Processing method $wp_query.
 * @param array  $data Data array.
 */
function csco_load_more_query_data( $method = 'get', $data = array() ) {
	global $wp_query;

	$output = array();
	$vars   = array(
		'in_the_loop',
		'is_single',
		'is_page',
		'is_archive',
		'is_author',
		'is_category',
		'is_tag',
		'is_tax',
		'is_home',
		'is_singular',
		'is_post_query',
	);

	if ( 'get' === $method ) {
		$output = $data;
	}

	foreach ( $vars as $variable ) {
		if ( ! isset( $wp_query->$variable ) ) {
			continue;
		}

		if ( 'get' === $method ) {
			$output[ $variable ] = (bool) $wp_query->$variable;
		}

		if ( isset( $data[ $variable ] ) && 'init' === $method ) {
			$wp_query->$variable = (bool) $data[ $variable ];
		}
	}

	if ( 'get' === $method ) {
		$output = apply_filters( 'ajax_query_args', $output );
	}

	return wp_json_encode( $output );
}

/**
 * Return the post-area layouts that may be rendered by a public request.
 *
 * @return array
 */
function csco_load_more_allowed_layouts() {
	return array(
		'standard-type-1',
		'standard-type-2',
		'standard-type-3',
		'standard-type-4',
		'masonry-type-1',
		'horizontal-type-1',
		'horizontal-type-2',
		'horizontal-type-3',
		'horizontal-type-4',
		'horizontal-type-5',
		'tile-type-1',
		'tile-type-2',
		'tile-type-3',
		'tile-type-4',
		'carousel-type-1',
		'carousel-type-2',
	);
}

/**
 * Get load more args.
 *
 * @param array $data       The data.
 * @param array $attributes The attributes.
 * @param array $options    The options.
 */
function csco_get_load_more_args( $data, $attributes = false, $options = false ) {
	$ajax_type = version_compare( get_bloginfo( 'version' ), '4.7', '>=' ) ? 'ajax_restapi' : 'ajax';
	$ajax_type = apply_filters( 'ajax_load_more_method', $ajax_type );

	return array(
		'type'           => $ajax_type,
		'nonce'          => wp_create_nonce(),
		'url'            => admin_url( 'admin-ajax.php' ),
		'rest_url'       => esc_url( get_rest_url( null, '/csco/v1/more-posts' ) ),
		'posts_per_page' => get_query_var( 'posts_per_page' ),
		'query_data'     => csco_load_more_query_data( 'get', $data ),
		'attributes'     => wp_json_encode( $attributes ),
		'options'        => wp_json_encode( $options ),
		'infinite_load'  => $data['infinite_load'] ? 'true' : 'false',
		'translation'    => array(
			'load_more' => esc_html__( 'Load More', 'caards' ),
			'loading'   => esc_html__( 'Loading', 'caards' ),
		),
	);
}

/**
 * Localize the main theme scripts.
 */
function csco_load_more_js() {
	global $wp_query;

	$paged = get_query_var( 'paged' );

	if ( $wp_query->max_num_pages <= 1 || $paged > 1 ) {
		return;
	}

	$pagination_type = get_theme_mod( csco_get_archive_option( 'pagination_type' ), 'load-more' );

	if ( 'load-more' === $pagination_type || 'infinite' === $pagination_type ) {
		$wp_query->infinite = 'infinite' === $pagination_type;

		$data = array(
			'first_post_count' => $wp_query->post_count,
			'infinite_load'    => $wp_query->infinite,
			'query_vars'       => $wp_query->query_vars,
		);

		$args = csco_get_load_more_args( $data, false, csco_get_archive_options() );
		wp_localize_script( 'csco-scripts', 'csco_ajax_pagination', $args );
	}
}
add_action( 'wp_enqueue_scripts', 'csco_load_more_js' );

/**
 * Decode a JSON request field into an array.
 *
 * @param mixed $value Raw request value.
 * @return array
 */
function csco_load_more_decode_array( $value ) {
	if ( is_array( $value ) ) {
		return $value;
	}

	if ( ! is_string( $value ) || '' === $value ) {
		return array();
	}

	$decoded = json_decode( wp_unslash( $value ), true );

	return is_array( $decoded ) ? $decoded : array();
}

/**
 * Normalize query vars received from the public pagination endpoint.
 *
 * @param array $query_vars Query variables.
 * @return array
 */
function csco_load_more_sanitize_query_vars( $query_vars ) {
	$query_vars = is_array( $query_vars ) ? $query_vars : array();

	// Public pagination is only allowed to return published posts. These values
	// intentionally override anything serialized by the browser.
	$query_vars['post_type']   = 'post';
	$query_vars['post_status'] = 'publish';
	$query_vars['perm']        = 'readable';

	unset(
		$query_vars['fields'],
		$query_vars['cache_results'],
		$query_vars['update_post_meta_cache'],
		$query_vars['update_post_term_cache']
	);

	return $query_vars;
}

/**
 * Get More Posts.
 */
function csco_load_more_posts() {
	$posts_end = false;
	$content   = '';

	$response = array(
		'page'           => 2,
		'posts_per_page' => 10,
		'query_data'     => array(),
		'attributes'     => array(),
		'options'        => array(),
	);

	if ( isset( $_POST['page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified by transport-specific handlers.
		$response['page'] = max( 1, absint( wp_unslash( $_POST['page'] ) ) );
	}

	if ( isset( $_POST['posts_per_page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified by transport-specific handlers.
		$response['posts_per_page'] = min( 50, max( 1, absint( wp_unslash( $_POST['posts_per_page'] ) ) ) );
	}

	if ( isset( $_POST['query_data'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified by transport-specific handlers.
		$response['query_data'] = csco_load_more_decode_array( $_POST['query_data'] );
	}

	if ( isset( $_POST['attributes'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified by transport-specific handlers.
		$response['attributes'] = csco_load_more_decode_array( $_POST['attributes'] );
	}

	if ( isset( $_POST['options'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified by transport-specific handlers.
		$response['options'] = csco_load_more_decode_array( $_POST['options'] );
	}

	$query_data = $response['query_data'];
	$query_vars = isset( $query_data['query_vars'] ) ? csco_load_more_sanitize_query_vars( $query_data['query_vars'] ) : array();

	$query_vars = array_merge(
		$query_vars,
		array(
			'is_post_query'  => true,
			'paged'          => $response['page'],
			'posts_per_page' => $response['posts_per_page'],
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'perm'           => 'readable',
		)
	);

	if ( ! empty( $query_data['is_author'] ) && ! empty( $query_vars['author'] ) ) {
		$query_vars['suppress_filters'] = true;
	}

	$the_query = new WP_Query( $query_vars );
	$GLOBALS['wp_query'] = $the_query;

	csco_load_more_query_data( 'init', $query_data );

	if ( $the_query->have_posts() ) {
		set_query_var( 'csco_query', $query_data );

		$attributes = $response['attributes'];
		$options    = $response['options'];

		if ( $attributes ) {
			$layout = isset( $attributes['layout'] ) ? sanitize_key( $attributes['layout'] ) : '';

			if ( ! in_array( $layout, csco_load_more_allowed_layouts(), true ) ) {
				wp_reset_postdata();
				return array(
					'posts_end' => true,
					'content'   => '',
				);
			}

			$attributes['layout'] = $layout;
		}

		ob_start();

		while ( $the_query->have_posts() ) {
			$the_query->the_post();

			$current = $the_query->current_post + 1 + $query_vars['posts_per_page'] * $query_vars['paged'] - $query_vars['posts_per_page'];

			if ( $the_query->found_posts - $current <= 0 ) {
				$posts_end = true;
			}

			$options['current_post'] = $current;

			if ( $attributes ) {
				set_query_var( 'attributes', $attributes );
				set_query_var( 'options', $options );

				if ( 'masonry-type-1' === $attributes['layout'] ) {
					?>
					<div class="cs-posts-area-card">
					<?php
				}

				get_template_part( 'template-parts/blocks/posts-area/' . $attributes['layout'] );

				if ( 'masonry-type-1' === $attributes['layout'] ) {
					?>
					</div>
					<?php
					csco_the_widget_postarea_loop( $current );
				}
			} else {
				set_query_var( 'options', $options );

				$archive_layout = isset( $options['layout'] ) ? sanitize_key( $options['layout'] ) : '';

				if ( 'masonry' === $archive_layout ) {
					?>
					<div class="cs-posts-area-card">
					<?php
				}

				if ( 'full' === $archive_layout ) {
					get_template_part( 'template-parts/archive/content-full' );
				} else {
					get_template_part( 'template-parts/archive/content' );
				}

				if ( 'masonry' === $archive_layout ) {
					?>
					</div>
					<?php
					csco_the_widget_archive_loop( $current );
				}
			}
		}

		$content = ob_get_clean();
	}

	wp_reset_postdata();

	if ( ! $content ) {
		$posts_end = true;
	}

	return array(
		'posts_end' => $posts_end,
		'content'   => $content,
	);
}

/**
 * AJAX Load More.
 */
function csco_ajax_load_more() {
	check_ajax_referer();

	wp_send_json_success( csco_load_more_posts() );
}
add_action( 'wp_ajax_csco_ajax_load_more', 'csco_ajax_load_more' );
add_action( 'wp_ajax_nopriv_csco_ajax_load_more', 'csco_ajax_load_more' );

/**
 * Validate REST load-more requests.
 *
 * @param WP_REST_Request $request REST request.
 * @return bool
 */
function csco_load_more_rest_permission( $request ) {
	$nonce = $request->get_param( 'nonce' );

	return is_string( $nonce ) && (bool) wp_verify_nonce( $nonce, -1 );
}

/**
 * More Posts API Response.
 *
 * @param WP_REST_Request $request REST API Request.
 */
function csco_more_posts_restapi( $request ) {
	$params = $request->get_params();

	foreach ( array( 'page', 'posts_per_page', 'query_data', 'attributes', 'options' ) as $key ) {
		if ( isset( $params[ $key ] ) ) {
			$_POST[ $key ] = $params[ $key ];
		}
	}

	return rest_ensure_response(
		array(
			'success' => true,
			'data'    => csco_load_more_posts(),
		)
	);
}

/**
 * Register REST More Posts Routes.
 */
function csco_register_more_posts_route() {
	register_rest_route(
		'csco/v1',
		'/more-posts',
		array(
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => 'csco_more_posts_restapi',
			'permission_callback' => 'csco_load_more_rest_permission',
			'args'                => array(
				'nonce' => array(
					'required'          => true,
					'sanitize_callback' => 'sanitize_text_field',
				),
				'page' => array(
					'default'           => 2,
					'sanitize_callback' => 'absint',
				),
				'posts_per_page' => array(
					'default'           => 10,
					'sanitize_callback' => 'absint',
				),
			),
		)
	);
}
add_action( 'rest_api_init', 'csco_register_more_posts_route' );
