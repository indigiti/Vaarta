<?php
/**
 * Vaarta custom Gutenberg blocks.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme-owned blocks.
 */
function vaarta_register_blocks(): void {
	$blocks = array(
		'editorial-grid',
		'story-meta',
		'newsletter',
		'ad-slot',
		'review',
		'progress',
		'social-share',
		'author-box',
		'related-posts',
		'contributors',
		'theme-toggle',
		'tabs',
		'tab',
		'search-overlay',
		'auto-load-posts',
		'popup',
		'social-feed',
		'breadcrumbs',
		'category-cards',
		'contact-form',
		'team-grid',
	);

	foreach ( $blocks as $block ) {
		$path = get_theme_file_path( 'blocks/' . $block );

		if ( file_exists( $path . '/block.json' ) ) {
			register_block_type( $path );
		}
	}
}
add_action( 'init', 'vaarta_register_blocks' );
