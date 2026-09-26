<?php
/**
 * Block editor assets.
 *
 * Frontend interaction code is intentionally not loaded in the editor. The
 * editor receives only presentation assets required for visual parity.
 *
 * @package Vaarta
 */

if ( ! function_exists( 'csco_editor_style' ) ) {
	/**
	 * Enable editor styles early enough for the block editor iframe.
	 */
	function csco_editor_style() {
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/editor-style.css' );
	}
}
add_action( 'after_setup_theme', 'csco_editor_style', 20 );

if ( ! function_exists( 'csco_enqueue_block_editor_assets' ) ) {
	/**
	 * Enqueue editor-only styles.
	 *
	 * Interactive frontend dependencies such as Flickity, Colcade, scroll
	 * handlers, cookie helpers, and continuous-reading code are excluded from
	 * the editor runtime. Editor-specific scripts can be added here as Vaarta's
	 * Gutenberg modules are migrated.
	 */
	function csco_enqueue_block_editor_assets() {
		$version = function_exists( 'vaarta_get_foundation_version' )
			? vaarta_get_foundation_version()
			: csco_get_theme_data( 'Version' );

		wp_register_style(
			'csco-editor',
			csco_style( get_template_directory_uri() . '/assets/css/editor-style.css' ),
			array(),
			$version
		);

		wp_style_add_data( 'csco-editor', 'rtl', 'replace' );
		wp_enqueue_style( 'csco-editor' );
	}
	add_action( 'enqueue_block_editor_assets', 'csco_enqueue_block_editor_assets' );
}
