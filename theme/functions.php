<?php
/**
 * Vaarta theme setup.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue the small global stylesheet.
 */
function vaarta_enqueue_assets(): void {
	wp_enqueue_style(
		'vaarta-global',
		get_theme_file_uri( 'assets/css/global.css' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'vaarta_enqueue_assets' );

/**
 * Register the theme pattern category.
 */
function vaarta_register_pattern_categories(): void {
	register_block_pattern_category(
		'vaarta',
		array(
			'label' => __( 'Vaarta', 'vaarta' ),
		)
	);
}
add_action( 'init', 'vaarta_register_pattern_categories' );
