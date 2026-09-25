<?php
/**
 * Query Loop variation assets.
 *
 * The first variations are registered in the editor through the accompanying
 * JavaScript module. This PHP file is intentionally the stable bootstrap point
 * for future server-side query filters such as trending and most-viewed.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vaarta_enqueue_query_variations(): void {
	$asset = get_theme_file_path( 'assets/js/query-variations.js' );

	if ( ! file_exists( $asset ) ) {
		return;
	}

	wp_enqueue_script(
		'vaarta-query-variations',
		get_theme_file_uri( 'assets/js/query-variations.js' ),
		array( 'wp-blocks', 'wp-dom-ready', 'wp-i18n' ),
		(string) filemtime( $asset ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'vaarta_enqueue_query_variations' );
