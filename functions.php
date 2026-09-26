<?php
/**
 * Caards functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Caards
 */

if ( ! function_exists( 'csco_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function csco_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Caards, use a find and replace
		 * to change 'caards' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'caards', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// This theme uses wp_nav_menu() in one location.
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

		/*
		 * Switch default core markup for search form, comment form, comments, etc.
		 * to output valid HTML5.
		 */
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

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom line height controls.
		add_theme_support( 'custom-line-height' );

		// Add support for experimental cover block spacing.
		add_theme_support( 'custom-spacing' );

		// Supported Formats.
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Canvas: Disable section responsive.
		add_theme_support( 'canvas-disable-section-responsive' );

		// Canvas: Enable data scheme.
		add_theme_support( 'canvas-enable-data-scheme' );
		add_theme_support( 'canvas-support-inverse-scheme' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Register custom thumbnail sizes.
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
 * Theme dashboard.
 */
require_once get_theme_file_path( '/core/theme-dashboard/class-theme-dashboard.php' );

/**
 * Theme demos.
 */
require_once get_theme_file_path( '/core/theme-demos/class-theme-demos.php' );

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
 *
 * Template Functions.
 */
require_once get_theme_file_path( '/inc/theme-functions.php' );

/**
 * Theme Demos.
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
 * Powerkit fuctions.
 */
require_once get_theme_file_path( '/inc/powerkit.php' );

/**
 * Deprecated.
 */
require_once get_theme_file_path( '/inc/deprecated.php' );
