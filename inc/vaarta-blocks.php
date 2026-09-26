<?php
/**
 * Native Gutenberg block registration for Vaarta.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add a dedicated Vaarta editorial category to the block inserter.
 *
 * @param array $categories Existing block categories.
 * @return array
 */
function vaarta_register_block_category( $categories ) {
	$category = array(
		'slug'  => 'vaarta-editorial',
		'title' => esc_html__( 'Vaarta Editorial', 'caards' ),
		'icon'  => null,
	);

	foreach ( $categories as $existing ) {
		if ( isset( $existing['slug'] ) && 'vaarta-editorial' === $existing['slug'] ) {
			return $categories;
		}
	}

	array_unshift( $categories, $category );

	return $categories;
}
add_filter( 'block_categories_all', 'vaarta_register_block_category' );

/**
 * Register Vaarta's native blocks from block.json metadata.
 */
function vaarta_register_native_blocks() {
	$blocks = array(
		'story-meta',
		'editorial-query',
		'story-carousel',
	);

	foreach ( $blocks as $block ) {
		$path = get_theme_file_path( '/blocks/' . $block );

		if ( file_exists( $path . '/block.json' ) ) {
			register_block_type( $path );
		}
	}
}
add_action( 'init', 'vaarta_register_native_blocks' );
