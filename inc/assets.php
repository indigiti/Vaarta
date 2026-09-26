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

		// Keep the remaining legacy dependency graph while Vaarta replaces
		// individual behaviors with small native modules.
		wp_register_script( 'flickity', get_template_directory_uri() . '/assets/vendor/flickity.pkgd.min.js', array(), $version, true );
		wp_register_script( 'colcade', get_template_directory_uri() . '/assets/vendor/colcade.js', array(), $version, true );
		wp_register_script( 'csco-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery', 'imagesloaded', 'flickity', 'colcade' ), $version, true );

		// Modular Vaarta runtime. The compiled bundle remains only for behaviors
		// that have not yet moved to native modules.
		wp_register_script( 'vaarta-runtime', get_template_directory_uri() . '/assets/js/modules/runtime.js', array( 'csco-scripts' ), $version, true );
		wp_register_script( 'vaarta-search', get_template_directory_uri() . '/assets/js/modules/search.js', array( 'vaarta-runtime' ), $version, true );
		wp_register_script( 'vaarta-navigation', get_template_directory_uri() . '/assets/js/modules/navigation.js', array( 'vaarta-runtime', 'vaarta-search' ), $version, true );
		wp_register_script( 'vaarta-carousel', get_template_directory_uri() . '/assets/js/modules/carousel.js', array( 'vaarta-runtime', 'flickity', 'imagesloaded' ), $version, true );
		wp_register_script( 'vaarta-mega-menu', get_template_directory_uri() . '/assets/js/modules/mega-menu.js', array( 'vaarta-runtime', 'vaarta-navigation' ), $version, true );
		wp_register_script( 'vaarta-offcanvas', get_template_directory_uri() . '/assets/js/modules/offcanvas.js', array( 'vaarta-runtime' ), $version, true );
		wp_register_script( 'vaarta-fullscreen-nav', get_template_directory_uri() . '/assets/js/modules/fullscreen-nav.js', array( 'vaarta-runtime' ), $version, true );
		wp_register_script( 'vaarta-fullscreen', get_template_directory_uri() . '/assets/js/modules/fullscreen.js', array( 'vaarta-runtime', 'vaarta-search', 'vaarta-fullscreen-nav' ), $version, true );
		wp_register_script( 'vaarta-scheme', get_template_directory_uri() . '/assets/js/modules/scheme.js', array( 'vaarta-runtime' ), $version, true );
		wp_register_script( 'vaarta-article-interactions', get_template_directory_uri() . '/assets/js/modules/article-interactions.js', array( 'vaarta-runtime' ), $version, true );
		wp_register_script( 'vaarta-metabar-alignment', get_template_directory_uri() . '/assets/js/modules/metabar-alignment.js', array( 'vaarta-runtime' ), $version, true );
		wp_register_script( 'vaarta-tile-hover', get_template_directory_uri() . '/assets/js/modules/tile-hover.js', array( 'vaarta-runtime' ), $version, true );
		wp_register_script( 'vaarta-player-controls', get_template_directory_uri() . '/assets/js/modules/player-controls.js', array( 'vaarta-runtime' ), $version, true );
		wp_register_script( 'vaarta-widget-nav', get_template_directory_uri() . '/assets/js/modules/widget-nav.js', array( 'vaarta-runtime' ), $version, true );
		wp_register_script( 'vaarta-sticky-sidebar', get_template_directory_uri() . '/assets/js/modules/sticky-sidebar.js', array( 'vaarta-runtime', 'vaarta-navigation' ), $version, true );
		wp_register_script( 'vaarta-video-background', get_template_directory_uri() . '/assets/js/modules/video-background.js', array( 'vaarta-runtime' ), $version, true );
		wp_register_script( 'vaarta-masonry', get_template_directory_uri() . '/assets/js/modules/masonry.js', array( 'vaarta-runtime', 'colcade' ), $version, true );
		wp_register_script( 'vaarta-load-more', get_template_directory_uri() . '/assets/js/modules/load-more.js', array( 'vaarta-runtime', 'vaarta-masonry' ), $version, true );
		wp_register_script( 'vaarta-continuous-reading', get_template_directory_uri() . '/assets/js/modules/continuous-reading.js', array( 'vaarta-runtime' ), $version, true );
		wp_register_script(
			'vaarta-chrome',
			get_template_directory_uri() . '/assets/js/vaarta-chrome.js',
			array(
				'vaarta-search',
				'vaarta-offcanvas',
				'vaarta-fullscreen',
				'vaarta-scheme',
				'vaarta-article-interactions',
				'vaarta-metabar-alignment',
				'vaarta-tile-hover',
				'vaarta-player-controls',
				'vaarta-widget-nav',
				'vaarta-sticky-sidebar',
				'vaarta-video-background',
			),
			$version,
			true
		);

		$deferred_scripts = array(
			'flickity',
			'colcade',
			'csco-scripts',
			'vaarta-runtime',
			'vaarta-search',
			'vaarta-navigation',
			'vaarta-carousel',
			'vaarta-mega-menu',
			'vaarta-offcanvas',
			'vaarta-fullscreen-nav',
			'vaarta-fullscreen',
			'vaarta-scheme',
			'vaarta-article-interactions',
			'vaarta-metabar-alignment',
			'vaarta-tile-hover',
			'vaarta-player-controls',
			'vaarta-widget-nav',
			'vaarta-sticky-sidebar',
			'vaarta-video-background',
			'vaarta-masonry',
			'vaarta-load-more',
			'vaarta-continuous-reading',
			'vaarta-chrome',
		);

		foreach ( $deferred_scripts as $handle ) {
			wp_script_add_data( $handle, 'strategy', 'defer' );
		}

		$localize = array(
			'siteSchemeMode'   => get_theme_mod( 'color_scheme', 'system' ),
			'siteSchemeToogle' => get_theme_mod( 'color_scheme_toggle', true ),
		);

		wp_localize_script( 'csco-scripts', 'csLocalize', $localize );
		wp_localize_script(
			'vaarta-article-interactions',
			'vaartaArticleI18n',
			array(
				'copyLabel'  => esc_html__( 'Copy shareable URL', 'caards' ),
				'copiedLabel' => esc_html__( 'Shareable URL copied', 'caards' ),
				'copied'      => esc_html__( 'Shareable URL copied.', 'caards' ),
				'copyFailed'  => esc_html__( 'Copy failed. Select the URL and copy it manually.', 'caards' ),
			)
		);

		wp_enqueue_script( 'vaarta-navigation' );
		wp_enqueue_script( 'vaarta-carousel' );
		wp_enqueue_script( 'vaarta-mega-menu' );
		wp_enqueue_script( 'vaarta-load-more' );
		wp_enqueue_script( 'vaarta-continuous-reading' );
		wp_enqueue_script( 'vaarta-chrome' );

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

		// Add keyboard/focus affordances without altering legacy component visuals.
		wp_register_style(
			'vaarta-chrome',
			get_template_directory_uri() . '/assets/css/vaarta-chrome.css',
			array( 'vaarta-design-system' ),
			$version
		);
		wp_enqueue_style( 'vaarta-chrome' );

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
