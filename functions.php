<?php
/**
 * Vaarta theme functions and definitions.
 *
 * The frontend remains compatible with the legacy Caards markup while the
 * runtime is modernized incrementally.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Vaarta
 */

/**
 * Vaarta modernization bootstrap.
 */
require_once get_theme_file_path( '/inc/vaarta-foundation.php' );

if ( ! function_exists( 'csco_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Legacy csco_* identifiers are retained during the compatibility phase so
	 * existing templates, child themes, and integrations continue to work.
	 */
	function csco_setup() {
		// Keep the legacy text domain until the translation migration is complete.
		load_theme_textdomain( 'caards', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Register existing menu locations unchanged for backwards compatibility.
		register_nav_menus(
			array(
				'primary'           => esc_html__( 'Primary', 'caards' ),
				'fullscreen'        => esc_html__( 'Fullscreen', 'caards' ),
				'mobile'            => esc_html__( 'Mobile', 'caards' ),
				'footer-col-1'      => esc_html__( 'Footer Column 1', 'caards' ),
				'footer-col-2'      => esc_html__( 'Footer Column 2', 'caards' ),
				'footer'            => esc_html__( 'Footer Horizontal', 'caards' ),
				'footer-additional' => esc_html__( 'Footer Additional', 'caards' ),
			)
		);

		// Use valid HTML5 markup for core output.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'custom-line-height' );
		add_theme_support( 'custom-spacing' );
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'align-wide' );

		// Existing Canvas compatibility flags remain active during migration.
		add_theme_support( 'canvas-disable-section-responsive' );
		add_theme_support( 'canvas-enable-data-scheme' );
		add_theme_support( 'canvas-support-inverse-scheme' );

		add_theme_support( 'post-thumbnails' );

		// Preserve existing image-size contracts so current layouts do not regress.
		add_image_size( 'csco-smaller', 80, 80, true );
		add_image_size( 'csco-small', 110, 110, true );
		add_image_size( 'csco-thumbnail', 380, 250, true );
		add_image_size( 'csco-thumbnail-alt', 230, 150, true );
		add_image_size( 'csco-thumbnail-small', 260, 170, true );
		add_image_size( 'csco-thumbnail-uncropped', 380, 0, false );
		add_image_size( 'csco-intermediate', 550, 350, true );
		add_image_size( 'csco-intermediate-uncropped', 550, 0, true );
		add_image_size( 'csco-medium', 800, 500, true );
		add_image_size( 'csco-medium-uncropped', 800, 0, true );
		add_image_size( 'csco-large', 1160, 680, true );
		add_image_size( 'csco-large-uncropped', 1160, 0, true );
		add_image_size( 'csco-extra-large', 1920, 1024, true );
	}
}
add_action( 'after_setup_theme', 'csco_setup' );

/**
 * Theme Setup.
 */
require_once get_theme_file_path( '/inc/theme-setup.php' );

/**
 * Legacy Code Supply dashboard, remote license activation, and demo-import
 * runtime are intentionally not loaded. Their frontend-independent definitions
 * remain in the repository until the Vaarta-native admin/importer is rebuilt.
 */

/**
 * Customizer.
 */
require_once get_theme_file_path( '/core/customizer/class-customizer.php' );

/**
 * Assets.
 */
require_once get_theme_file_path( '/inc/assets.php' );

/**
 * Widgets Init.
 */
require_once get_theme_file_path( '/inc/widgets-init.php' );

/**
 * Template Functions.
 */
require_once get_theme_file_path( '/inc/theme-functions.php' );

/**
 * Demo definitions and import-finish hooks are retained as migration data.
 * No importer endpoint is registered while the legacy admin runtime is disabled.
 */
require_once get_theme_file_path( '/inc/theme-demos.php' );

/**
 * Theme Mods.
 */
require_once get_theme_file_path( '/inc/theme-mods.php' );

/**
 * Filters.
 */
require_once get_theme_file_path( '/inc/filters.php' );

/**
 * Gutenberg.
 */
require_once get_theme_file_path( '/inc/gutenberg.php' );

/**
 * Actions.
 */
require_once get_theme_file_path( '/inc/actions.php' );

/**
 * Partials.
 */
require_once get_theme_file_path( '/inc/partials.php' );

/**
 * Meta Boxes.
 */
require_once get_theme_file_path( '/inc/metabox.php' );

/**
 * Custom template tags for this theme.
 */
require_once get_theme_file_path( '/inc/theme-tags.php' );

/**
 * Custom post meta function.
 */
require_once get_theme_file_path( '/inc/post-meta.php' );

/**
 * Nav Menu.
 */
require_once get_theme_file_path( '/inc/nav-menu.php' );

/**
 * Mega menu.
 */
require_once get_theme_file_path( '/inc/mega-menu.php' );

/**
 * Load More.
 */
require_once get_theme_file_path( '/inc/load-more.php' );

/**
 * Load Nextpost.
 */
require_once get_theme_file_path( '/inc/load-nextpost.php' );

/**
 * Custom Content.
 */
require_once get_theme_file_path( '/inc/custom-content.php' );

/**
 * Sight.
 */
require_once get_theme_file_path( '/inc/sight.php' );

/**
 * Powerkit functions.
 */
require_once get_theme_file_path( '/inc/powerkit.php' );

/**
 * Deprecated compatibility layer.
 */
require_once get_theme_file_path( '/inc/deprecated.php' );
