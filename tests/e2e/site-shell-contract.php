<?php
/**
 * Runtime contract for Vaarta's site-shell routing and adopted shell settings.
 *
 * Executed through WP-CLI inside wp-env before the browser suite.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fail the WP-CLI run when a shell contract is not satisfied.
 *
 * @param bool   $condition Assertion result.
 * @param string $message   Failure description.
 * @return void
 */
function vaarta_test_shell_assert( $condition, $message ) {
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
}

$test_keys = array(
	'header_layout',
	'footer_layout',
	'header_search_form',
	'header_fullscreen_menu',
	'header_multi_column_display',
	'header_multi_column_posts',
	'footer_social_links',
	'footer_social_links_scheme',
	'footer_social_links_maximum',
	'footer_social_links_counts',
);

$original_mods = get_theme_mods();
$original_mods = is_array( $original_mods ) ? $original_mods : array();

try {
	vaarta_test_shell_assert( function_exists( 'vaarta_get_site_shell_registry' ), 'Site-shell registry is not loaded.' );
	vaarta_test_shell_assert( function_exists( 'vaarta_get_site_shell_layout' ), 'Site-shell layout resolver is not loaded.' );
	vaarta_test_shell_assert( function_exists( 'vaarta_get_site_shell_part' ), 'Site-shell template resolver is not loaded.' );
	vaarta_test_shell_assert( function_exists( 'vaarta_render_site_shell_part' ), 'Site-shell renderer is not loaded.' );
	vaarta_test_shell_assert( function_exists( 'vaarta_get_shell_settings_schema' ), 'Typed shell settings are not loaded.' );

	$registry = vaarta_get_site_shell_registry();
	vaarta_test_shell_assert( isset( $registry['header'] ) && 4 === count( $registry['header'] ), 'Expected four built-in header layouts.' );
	vaarta_test_shell_assert( isset( $registry['footer'] ) && 4 === count( $registry['footer'] ), 'Expected four built-in footer layouts.' );

	set_theme_mod( 'header_layout', 'three' );
	$header = vaarta_get_site_shell_part( 'header' );
	vaarta_test_shell_assert( is_array( $header ), 'Header shell did not resolve to a template part.' );
	vaarta_test_shell_assert( 'three' === $header['layout'], 'Header shell did not preserve the active layout.' );
	vaarta_test_shell_assert( 'template-parts/headers/header' === $header['slug'], 'Header shell resolved an unexpected template slug.' );
	vaarta_test_shell_assert( 'three' === $header['name'], 'Header shell resolved an unexpected template name.' );

	set_theme_mod( 'footer_layout', 'four' );
	$footer = vaarta_get_site_shell_part( 'footer' );
	vaarta_test_shell_assert( is_array( $footer ), 'Footer shell did not resolve to a template part.' );
	vaarta_test_shell_assert( 'four' === $footer['layout'], 'Footer shell did not preserve the active layout.' );
	vaarta_test_shell_assert( 'template-parts/footers/footer' === $footer['slug'], 'Footer shell resolved an unexpected template slug.' );
	vaarta_test_shell_assert( 'four' === $footer['name'], 'Footer shell resolved an unexpected template name.' );
	vaarta_test_shell_assert( null === vaarta_get_site_shell_part( 'sidebar' ), 'Unknown shell areas must not resolve a template.' );

	// Shell controls keep their legacy theme_mod keys but normalize through the
	// Vaarta typed schema for both native API and direct legacy reads.
	set_theme_mod( 'header_fullscreen_menu', 'false' );
	vaarta_test_shell_assert( false === vaarta_get_setting( 'header_fullscreen_menu' ), 'Fullscreen-menu boolean normalization failed.' );
	vaarta_test_shell_assert( false === get_theme_mod( 'header_fullscreen_menu' ), 'Direct fullscreen-menu theme_mod read was not normalized.' );

	set_theme_mod( 'header_search_form', '0' );
	vaarta_test_shell_assert( false === vaarta_get_setting( 'header_search_form' ), 'Search-form boolean normalization failed.' );

	set_theme_mod( 'header_multi_column_posts', 'false' );
	vaarta_test_shell_assert( false === get_theme_mod( 'header_multi_column_posts' ), 'Multi-column posts boolean normalization failed.' );

	set_theme_mod( 'footer_social_links_scheme', 'not-a-scheme' );
	vaarta_test_shell_assert( 'light' === vaarta_get_setting( 'footer_social_links_scheme' ), 'Footer social scheme did not fall back safely.' );
	vaarta_test_shell_assert( 'light' === get_theme_mod( 'footer_social_links_scheme' ), 'Direct footer social scheme read was not normalized.' );

	set_theme_mod( 'footer_social_links_maximum', '6' );
	vaarta_test_shell_assert( 6 === vaarta_get_setting( 'footer_social_links_maximum' ), 'Footer social maximum was not normalized to an integer.' );

	// Child themes can extend the explicit registry while the established csco_*
	// layout filter remains the selection compatibility surface.
	$registry_filter = static function ( $layouts ) {
		$layouts['header']['compat-test'] = array(
			'slug' => 'template-parts/headers/header',
			'name' => 'one',
		);
		return $layouts;
	};
	$layout_filter = static function () {
		return 'compat-test';
	};
	add_filter( 'vaarta_site_shell_registry', $registry_filter );
	add_filter( 'csco_header_layout_type', $layout_filter );

	$extended_header = vaarta_get_site_shell_part( 'header' );
	vaarta_test_shell_assert( 'compat-test' === $extended_header['layout'], 'Extended header layout did not route through the Vaarta registry.' );
	vaarta_test_shell_assert( 'one' === $extended_header['name'], 'Extended header layout did not use its registered template target.' );

	remove_filter( 'csco_header_layout_type', $layout_filter );
	remove_filter( 'vaarta_site_shell_registry', $registry_filter );
} finally {
	foreach ( $test_keys as $key ) {
		if ( array_key_exists( $key, $original_mods ) ) {
			set_theme_mod( $key, $original_mods[ $key ] );
		} else {
			remove_theme_mod( $key );
		}
	}
}

fwrite( STDOUT, "Vaarta site shell contract passed.\n" );
