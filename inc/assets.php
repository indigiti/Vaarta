<?php
/**
 * Frontend assets.
 *
 * All public-facing scripts and styles are registered here while the legacy
 * bundle is progressively split into Vaarta modules.
 *
 * @package Vaarta
 */

if ( ! function_exists( 'csco_content_width' ) ) {
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * @global int $content_width
	 */
	function csco_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'csco_content_width', 1200 );
	}
}
add_action( 'after_setup_theme', 'csco_content_width', 0 );

if ( ! function_exists( 'csco_enqueue_scripts' ) ) {
	/**
	 * Enqueue scripts and styles.
	 */
	function csco_enqueue_scripts() {
		$version = function_exists( 'vaarta_get_foundation_version' )
			? vaarta_get_foundation_version()
			: csco_get_theme_data( 'Version' );

		// Keep the existing dependency graph while allowing WordPress to defer it.
		wp_register_script( 'flickity', get_template_directory_uri() . '/assets/vendor/flickity.pkgd.min.js', array( 'jquery' ), $version, true );
		wp_register_script( 'colcade', get_template_directory_uri() . '/assets/vendor/colcade.js', array( 'jquery' ), $version, true );
		wp_register_script( 'csco-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery', 'imagesloaded', 'flickity', 'colcade' ), $version, true );

		wp_script_add_data( 'flickity', 'strategy', 'defer' );
		wp_script_add_data( 'colcade', 'strategy', 'defer' );
		wp_script_add_data( 'csco-scripts', 'strategy', 'defer' );

		$localize = array(
			'siteSchemeMode'   => get_theme_mod( 'color_scheme', 'system' ),
			'siteSchemeToogle' => get_theme_mod( 'color_scheme_toggle', true ),
		);

		wp_localize_script( 'csco-scripts', 'csLocalize', $localize );
		wp_enqueue_script( 'csco-scripts' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_register_style( 'csco-styles', csco_style( get_template_directory_uri() . '/style.css' ), array(), $version );
		wp_enqueue_style( 'csco-styles' );
		wp_style_add_data( 'csco-styles', 'rtl', 'replace' );

		// Bridge theme.json tokens into the established --cs-* visual contract.
		wp_register_style(
			'vaarta-design-system',
			get_template_directory_uri() . '/assets/css/vaarta-design-system.css',
			array( 'csco-styles' ),
			$version
		);
		wp_enqueue_style( 'vaarta-design-system' );

		wp_add_inline_style( 'csco-styles', sprintf( ':root { --social-links-label: "%s"; }', esc_html__( 'CONNECT', 'caards' ) ) );

		// Preserve the legacy Contact Form 7 styling behavior during visual migration.
		wp_dequeue_style( 'contact-form-7' );
	}
}
add_action( 'wp_enqueue_scripts', 'csco_enqueue_scripts' );

if ( ! function_exists( 'csco_magnific_popup_enqueue_scripts' ) ) {
	/**
	 * Enqueue theme-compatible Magnific Popup styles when the plugin runtime is active.
	 */
	function csco_magnific_popup_enqueue_scripts() {
		$version = function_exists( 'vaarta_get_foundation_version' )
			? vaarta_get_foundation_version()
			: csco_get_theme_data( 'Version' );

		if ( wp_style_is( 'magnific-popup', 'enqueued' ) ) {
			wp_deregister_style( 'magnific-popup' );
			wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css', array(), $version );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'csco_magnific_popup_enqueue_scripts', 999 );