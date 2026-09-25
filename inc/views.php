<?php
/**
 * Lightweight post-view tracking and popularity helpers.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const VAARTA_VIEWS_META_KEY = '_vaarta_views';

/**
 * Return the stored view count for a post.
 *
 * @param int $post_id Post ID.
 * @return int
 */
function vaarta_get_post_views( int $post_id = 0 ): int {
	$post_id = $post_id ?: get_the_ID();

	if ( ! $post_id ) {
		return 0;
	}

	return max( 0, (int) get_post_meta( $post_id, VAARTA_VIEWS_META_KEY, true ) );
}

/**
 * Increment a published single post once per browser per day.
 *
 * This intentionally stays dependency-free. Sites with very high traffic can
 * replace the storage layer later while preserving the same helper API.
 */
function vaarta_track_post_view(): void {
	if (
		is_admin()
		|| wp_doing_ajax()
		|| wp_doing_cron()
		|| is_preview()
		|| ! is_singular( 'post' )
	) {
		return;
	}

	$post_id = get_queried_object_id();

	if ( ! $post_id || 'publish' !== get_post_status( $post_id ) ) {
		return;
	}

	$cookie_name = 'vaarta_viewed_' . $post_id;

	if ( isset( $_COOKIE[ $cookie_name ] ) ) {
		return;
	}

	$current = vaarta_get_post_views( $post_id );
	update_post_meta( $post_id, VAARTA_VIEWS_META_KEY, $current + 1 );

	if ( ! headers_sent() ) {
		setcookie(
			$cookie_name,
			'1',
			array(
				'expires'  => time() + DAY_IN_SECONDS,
				'path'     => COOKIEPATH ? COOKIEPATH : '/',
				'domain'   => COOKIE_DOMAIN,
				'secure'   => is_ssl(),
				'httponly' => true,
				'samesite' => 'Lax',
			)
		);
	}
}
add_action( 'template_redirect', 'vaarta_track_post_view' );
