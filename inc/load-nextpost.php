<?php
/**
 * Load Load Next Post via AJAX.
 *
 * @package Caards
 */

/**
 * Retrieve next post that is adjacent to current post.
 */
function csco_nextpost_get_id() {
	global $post;

	$next_post = false;

	$in_same_term = get_theme_mod( 'post_load_nextpost_same_category', false );

	if ( get_theme_mod( 'post_load_nextpost_reverse', false ) ) {
		$object_next_post = get_previous_post( $in_same_term );
	} else {
		$object_next_post = get_next_post( $in_same_term );
	}

	if ( isset( $object_next_post->ID ) ) {
		$post = get_post( $object_next_post->ID );
		setup_postdata( $post );
		$next_post = $object_next_post->ID;
	}

	wp_reset_postdata();

	return $next_post;
}

/**
 * Localize the main theme scripts.
 */
function csco_nextpost_more_js() {
	if ( ! csco_get_state_load_nextpost() ) {
		return;
	}

	if ( ! is_singular( 'post' ) ) {
		return false;
	}

	$ajax_type = version_compare( get_bloginfo( 'version' ), '4.7', '>=' ) ? 'ajax_restapi' : 'ajax';
	$ajax_type = apply_filters( 'ajax_load_nextpost_method', $ajax_type );

	$args = array(
		'type'      => $ajax_type,
		'not_in'    => (array) get_the_ID(),
		'next_post' => csco_nextpost_get_id(),
		'nonce'     => wp_create_nonce( 'csco-load-nextpost-nonce' ),
		'rest_url'  => esc_url( get_rest_url( null, '/csco/v1/more-nextpost' ) ),
		'url'       => admin_url( 'admin-ajax.php' ),
	);

	wp_localize_script( 'csco-scripts', 'csco_ajax_nextpost', $args );
}
add_action( 'wp_enqueue_scripts', 'csco_nextpost_more_js' );

/**
 * Validate the continuous-reading nonce for REST requests.
 *
 * The endpoint is intentionally available to logged-out readers, but the request
 * must originate from a page rendered by WordPress. User identity is never
 * accepted from client input.
 *
 * @param WP_REST_Request $request REST request.
 * @return bool
 */
function csco_load_nextpost_rest_permission( $request ) {
	$nonce = $request->get_param( 'nonce' );

	return is_string( $nonce ) && (bool) wp_verify_nonce( $nonce, 'csco-load-nextpost-nonce' );
}

/**
 * Get More Post.
 */
function csco_load_nextpost() {
	global $csco_related_not_in;
	global $wp_query;
	global $post;
	global $more;

	$not_in    = array();
	$next_post = null;
	$post_id   = 0;

	if ( isset( $_POST['not_in'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified by transport-specific handlers.
		$not_in = array_filter( array_map( 'absint', (array) wp_unslash( $_POST['not_in'] ) ) );
	}

	if ( isset( $_POST['next_post'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified by transport-specific handlers.
		$post_id = absint( wp_unslash( $_POST['next_post'] ) );
	}

	// Never trust client-provided user IDs. WordPress determines the current user
	// from its own authentication mechanism before this callback runs.
	unset( $_POST['current_user'] );

	ob_start();

	if ( $post_id && 'publish' === get_post_status( $post_id ) && 'post' === get_post_type( $post_id ) ) {
		$not_in[] = $post_id;
		$not_in   = array_values( array_unique( array_map( 'absint', $not_in ) ) );

		$csco_related_not_in = $not_in;

		$query = new WP_Query(
			array(
				'p'           => $post_id,
				'post_type'   => 'post',
				'post_status' => 'publish',
			)
		);

		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) :
				$query->the_post();

				$wp_query              = $query;
				$wp_query->is_single   = true;
				$wp_query->is_singular = true;
				$more                  = 1;
				?>
				<div class="cs-nextpost-section" data-title="<?php the_title_attribute(); ?>"
					data-url="<?php echo esc_url( get_permalink() ); ?>">

					<?php do_action( 'csco_load_nextpost_before' ); ?>

					<div <?php csco_site_content_class(); ?>>
						<?php do_action( 'csco_site_content_start' ); ?>

						<div class="cs-container">
						<?php do_action( 'csco_main_content_before' ); ?>

							<div id="content" class="cs-main-content">
								<?php do_action( 'csco_main_content_start' ); ?>

									<div id="primary" class="cs-content-area">
										<?php do_action( 'csco_main_before' ); ?>
										<?php do_action( 'csco_post_before' ); ?>

										<?php get_template_part( 'template-parts/content-singular' ); ?>

										<?php do_action( 'csco_post_after' ); ?>

										<?php $next_post = csco_nextpost_get_id(); ?>

										<?php do_action( 'csco_main_after' ); ?>
									</div>

									<?php get_sidebar(); ?>
								</div>

							<?php do_action( 'csco_main_content_after' ); ?>
						</div>

						<?php do_action( 'csco_site_content_end' ); ?>
					</div>

					<?php do_action( 'csco_load_nextpost_after' ); ?>
				</div>
				<?php
			endwhile;
		endif;

		wp_reset_postdata();
	}

	$content = ob_get_clean();

	if ( ! $content ) {
		$next_post = null;
	}

	return array(
		'not_in'    => $not_in,
		'next_post' => $next_post,
		'content'   => $content,
	);
}

/**
 * AJAX Load Nextpost.
 */
function csco_ajax_load_nextpost() {
	check_ajax_referer( 'csco-load-nextpost-nonce', 'nonce' );

	$data = csco_load_nextpost();

	wp_send_json_success( $data );
}
add_action( 'wp_ajax_csco_ajax_load_nextpost', 'csco_ajax_load_nextpost' );
add_action( 'wp_ajax_nopriv_csco_ajax_load_nextpost', 'csco_ajax_load_nextpost' );

/**
 * Nextpost API Response.
 *
 * @param WP_REST_Request $request REST API Request.
 */
function csco_load_nextpost_restapi( $request ) {
	// Normalize REST parameters into the legacy request shape while the front-end
	// transport is being modernized.
	$params = $request->get_params();

	$_POST['not_in']    = isset( $params['not_in'] ) ? $params['not_in'] : array();
	$_POST['next_post'] = isset( $params['next_post'] ) ? $params['next_post'] : 0;

	return rest_ensure_response(
		array(
			'success' => true,
			'data'    => csco_load_nextpost(),
		)
	);
}

/**
 * Register REST Nextpost Routes.
 */
function csco_register_nextpost_route() {
	register_rest_route(
		'csco/v1',
		'/more-nextpost',
		array(
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => 'csco_load_nextpost_restapi',
			'permission_callback' => 'csco_load_nextpost_rest_permission',
			'args'                => array(
				'nonce'     => array(
					'required'          => true,
					'sanitize_callback' => 'sanitize_text_field',
				),
				'next_post' => array(
					'required'          => true,
					'sanitize_callback' => 'absint',
				),
				'not_in'    => array(
					'default' => array(),
				),
			),
		)
	);
}
add_action( 'rest_api_init', 'csco_register_nextpost_route' );

/**
 * Filter all auto load posts from related.
 *
 * @param object $data The query.
 */
function csco_nextpost_filter_related( $data ) {
	global $csco_related_not_in;

	if ( ! is_single() ) {
		return $data;
	}

	if ( isset( $data->query_vars['query_type'] ) && 'related' === $data->query_vars['query_type'] ) {
		if ( csco_get_state_load_nextpost() ) {
			$next_post = csco_nextpost_get_id();
			$data->query_vars['post__not_in'][] = $next_post ? $next_post : false;
		}

		$data->query_vars['post__not_in'] = array_merge(
			(array) $data->query_vars['post__not_in'],
			(array) $csco_related_not_in
		);
	}

	return $data;
}
add_action( 'pre_get_posts', 'csco_nextpost_filter_related' );
