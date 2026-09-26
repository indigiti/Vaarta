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
	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'vaarta-global',
		get_theme_file_uri( 'assets/css/global.css' ),
		array(),
		$theme_version
	);

	wp_enqueue_style(
		'vaarta-editorial-modules',
		get_theme_file_uri( 'assets/css/editorial-modules.css' ),
		array( 'vaarta-global' ),
		$theme_version
	);
}
add_action( 'wp_enqueue_scripts', 'vaarta_enqueue_assets' );
