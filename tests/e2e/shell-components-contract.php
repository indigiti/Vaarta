<?php
/**
 * Runtime contract for Vaarta-owned header/footer components.
 *
 * Executed through WP-CLI inside wp-env before the browser suite.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fail the contract when an assertion is not satisfied.
 *
 * @param bool   $condition Assertion result.
 * @param string $message   Failure description.
 * @return void
 */
function vaarta_test_component_assert( $condition, $message ) {
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
}

/**
 * Capture component output.
 *
 * @param callable $callback Renderer.
 * @param array    $settings Component settings.
 * @return string
 */
function vaarta_test_component_output( $callback, $settings = array() ) {
	ob_start();
	call_user_func( $callback, $settings );
	return (string) ob_get_clean();
}

$original_mods = get_theme_mods();
$original_mods = is_array( $original_mods ) ? $original_mods : array();

try {
	vaarta_test_component_assert( function_exists( 'vaarta_get_shell_component_registry' ), 'Vaarta shell component registry is not loaded.' );
	vaarta_test_component_assert( function_exists( 'vaarta_render_shell_component' ), 'Vaarta shell component dispatcher is not loaded.' );
	vaarta_test_component_assert( class_exists( 'Vaarta_Nav_Walker' ), 'Vaarta navigation walker is not loaded.' );
	vaarta_test_component_assert( class_exists( 'CSCO_NAV_Walker' ), 'Legacy navigation walker compatibility class is unavailable.' );
	vaarta_test_component_assert( is_subclass_of( 'CSCO_NAV_Walker', 'Vaarta_Nav_Walker' ), 'Legacy navigation walker does not delegate to Vaarta.' );

	$expected_components = array(
		'header_nav_menu',
		'fullscreen_nav_menu',
		'header_logo',
		'header_tagline',
		'header_search_form',
		'header_multi_column_widgets',
		'header_multi_column_posts',
		'header_fullscreen_widgets',
		'header_button',
		'header_social_links',
		'header_featured_columns',
		'footer_logo',
		'footer_description',
		'footer_copyright',
		'footer_menu',
		'footer_nav_menu',
		'footer_nav_menu_additional',
		'footer_social_links',
		'footer_subscription_form',
	);

	$registry = vaarta_get_shell_component_registry();
	foreach ( $expected_components as $component ) {
		vaarta_test_component_assert( isset( $registry[ $component ] ), 'Missing Vaarta shell component: ' . $component );
		vaarta_test_component_assert( is_callable( $registry[ $component ] ), 'Shell component is not callable: ' . $component );
	}

	// Key compatibility functions must now originate from the Vaarta module, not
	// the legacy theme-tags fallback file.
	foreach ( array( 'csco_header_nav_menu', 'csco_header_logo', 'csco_footer_logo', 'csco_footer_subscription_form' ) as $function_name ) {
		vaarta_test_component_assert( function_exists( $function_name ), 'Missing compatibility wrapper: ' . $function_name );
		$reflection = new ReflectionFunction( $function_name );
		$filename   = wp_normalize_path( (string) $reflection->getFileName() );
		vaarta_test_component_assert(
			str_ends_with( $filename, '/inc/vaarta-shell-components.php' ),
			$function_name . ' is not owned by vaarta-shell-components.php; actual=' . $filename
		);
	}

	// Both entry points must independently satisfy the established primary-menu
	// DOM/content contract. Consecutive wp_nav_menu() calls are intentionally not
	// compared byte-for-byte because WordPress/menu filters may add render-state
	// details between calls even when they use the same renderer.
	set_theme_mod( 'header_navigation_menu', true );
	$native_menu = vaarta_test_component_output( 'vaarta_render_header_nav_menu' );
	$legacy_menu = vaarta_test_component_output( 'csco_header_nav_menu' );
	foreach ( array( 'cs-header__nav', 'cs-header__nav-inner', 'Mega News' ) as $marker ) {
		vaarta_test_component_assert( false !== strpos( $native_menu, $marker ), 'Native primary menu missing contract marker: ' . $marker );
		vaarta_test_component_assert( false !== strpos( $legacy_menu, $marker ), 'Legacy primary-menu wrapper missing contract marker: ' . $marker );
	}

	// The adopted boolean setting must suppress both entry points identically.
	set_theme_mod( 'header_navigation_menu', false );
	vaarta_test_component_assert( '' === vaarta_test_component_output( 'vaarta_render_header_nav_menu' ), 'Native header navigation ignored the disabled setting.' );
	vaarta_test_component_assert( '' === vaarta_test_component_output( 'csco_header_nav_menu' ), 'Legacy header navigation wrapper ignored the disabled setting.' );

	$native_tagline = vaarta_test_component_output( 'vaarta_render_header_tagline' );
	$legacy_tagline = vaarta_test_component_output( 'csco_header_tagline' );
	foreach ( array( $native_tagline, $legacy_tagline ) as $tagline_output ) {
		if ( get_option( 'blogdescription' ) ) {
			vaarta_test_component_assert( false !== strpos( $tagline_output, 'cs-header__tag-line' ), 'Tagline renderer lost its established CSS class contract.' );
		}
	}

	$native_footer_logo = vaarta_test_component_output( 'vaarta_render_footer_logo' );
	$legacy_footer_logo = vaarta_test_component_output( 'csco_footer_logo' );
	vaarta_test_component_assert( false !== strpos( $native_footer_logo, 'cs-footer__logo' ), 'Native footer logo lost its established CSS class contract.' );
	vaarta_test_component_assert( false !== strpos( $legacy_footer_logo, 'cs-footer__logo' ), 'Legacy footer-logo wrapper lost its established CSS class contract.' );

	// Child themes/integrations can extend the native registry without replacing
	// the legacy csco_component() dispatcher.
	$custom_renderer = static function () {
		echo '<span data-vaarta-shell-component="test">Registry extension</span>';
	};
	$registry_filter = static function ( $components ) use ( $custom_renderer ) {
		$components['contract-extension'] = $custom_renderer;
		return $components;
	};
	add_filter( 'vaarta_shell_component_registry', $registry_filter );
	$extension_output = vaarta_test_component_output(
		static function () {
			vaarta_render_shell_component( 'contract-extension' );
		}
	);
	remove_filter( 'vaarta_shell_component_registry', $registry_filter );
	vaarta_test_component_assert( false !== strpos( $extension_output, 'Registry extension' ), 'Shell component registry extension did not render.' );
} finally {
	if ( array_key_exists( 'header_navigation_menu', $original_mods ) ) {
		set_theme_mod( 'header_navigation_menu', $original_mods['header_navigation_menu'] );
	} else {
		remove_theme_mod( 'header_navigation_menu' );
	}
}

fwrite( STDOUT, "Vaarta shell component contract passed.\n" );
