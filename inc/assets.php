<?php
/**
 * Front-end assets.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vaarta_enqueue_assets(): void {
	wp_enqueue_style(
		'vaarta-global',
		get_theme_file_uri( 'assets/css/global.css' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'vaarta_enqueue_assets' );
