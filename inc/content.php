<?php
/**
 * Content helpers.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Estimate article reading time.
 *
 * @param int $post_id Post ID.
 * @return int Minutes.
 */
function vaarta_get_reading_time( int $post_id = 0 ): int {
	$post_id = $post_id ?: get_the_ID();
	$content = get_post_field( 'post_content', $post_id );

	if ( ! is_string( $content ) || '' === trim( $content ) ) {
		return 1;
	}

	$text       = wp_strip_all_tags( strip_shortcodes( $content ) );
	$word_count = str_word_count( $text );
	$words_per_minute = 225;

	return max( 1, (int) ceil( $word_count / $words_per_minute ) );
}
