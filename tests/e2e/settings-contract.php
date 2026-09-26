<?php
/**
 * Runtime contract for Vaarta's typed settings compatibility layer.
 *
 * Executed through WP-CLI inside wp-env before the browser suite.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fail the WP-CLI run when a settings contract is not satisfied.
 *
 * @param bool   $condition Assertion result.
 * @param string $message   Failure description.
 * @return void
 */
function vaarta_test_settings_assert( $condition, $message ) {
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
}

/**
 * Return one color from Vaarta's Global Styles palette helper.
 *
 * @param string $slug Palette slug.
 * @return string|null
 */
function vaarta_test_palette_color( $slug ) {
	foreach ( vaarta_get_global_styles_palette() as $color ) {
		if ( isset( $color['slug'], $color['color'] ) && $slug === $color['slug'] ) {
			return $color['color'];
		}
	}

	return null;
}

$test_keys = array(
	'color_scheme',
	'color_scheme_toggle',
	'color_primary',
	'color_secondary',
	'color_accent',
	'header_layout',
	'header_search_type',
	'header_button_link',
	'header_button_target',
	'footer_layout',
);

$original_mods = get_theme_mods();
$original_mods = is_array( $original_mods ) ? $original_mods : array();

try {
	vaarta_test_settings_assert( function_exists( 'vaarta_get_setting' ), 'Typed settings API is not loaded.' );
	vaarta_test_settings_assert( function_exists( 'vaarta_render_site_header' ), 'Vaarta header renderer is not loaded.' );
	vaarta_test_settings_assert( function_exists( 'vaarta_render_site_footer' ), 'Vaarta footer renderer is not loaded.' );
	vaarta_test_settings_assert( function_exists( 'vaarta_powerkit_module_enabled' ), 'Vaarta integration facade is not loaded.' );

	set_theme_mod( 'header_layout', 'three' );
	vaarta_test_settings_assert( 'three' === vaarta_get_setting( 'header_layout' ), 'Valid header layout was not preserved.' );
	vaarta_test_settings_assert( 'three' === csco_get_header_layout_type(), 'Legacy header-layout wrapper diverged from Vaarta settings.' );

	set_theme_mod( 'header_layout', 'not-a-layout' );
	vaarta_test_settings_assert( 'one' === vaarta_get_setting( 'header_layout' ), 'Invalid header layout did not fall back safely.' );
	vaarta_test_settings_assert( 'one' === get_theme_mod( 'header_layout' ), 'Direct legacy theme_mod read was not normalized.' );

	set_theme_mod( 'footer_layout', 'four' );
	vaarta_test_settings_assert( 'four' === csco_get_footer_layout_type(), 'Footer layout compatibility wrapper failed.' );

	set_theme_mod( 'color_scheme_toggle', 'false' );
	vaarta_test_settings_assert( false === vaarta_get_setting( 'color_scheme_toggle' ), 'Boolean string normalization failed.' );

	set_theme_mod( 'header_button_link', 'javascript:alert(1)' );
	vaarta_test_settings_assert( '' === vaarta_get_setting( 'header_button_link' ), 'Unsafe header button URL was not rejected.' );

	set_theme_mod( 'header_button_link', 'https://example.com/read-more/' );
	vaarta_test_settings_assert( 'https://example.com/read-more/' === vaarta_get_setting( 'header_button_link' ), 'Safe header button URL was not preserved.' );

	set_theme_mod( 'color_secondary', '#123ABC' );
	vaarta_test_settings_assert( '#123ABC' === vaarta_test_palette_color( 'secondary' ), 'Customizer color did not reach the Global Styles palette.' );

	set_theme_mod( 'color_accent', 'expression(alert(1))' );
	vaarta_test_settings_assert( '#2D5DE0' === vaarta_test_palette_color( 'accent' ), 'Unsafe color did not fall back to the schema default.' );

	$order_field = vaarta_get_customizer_field( 'header_multi_column_posts_order' );
	vaarta_test_settings_assert( is_array( $order_field ) && ! empty( $order_field['choices'] ), 'Expected legacy order choices are not registered.' );

	$order_setting = (object) array(
		'id'      => 'header_multi_column_posts_order',
		'default' => 'DESC',
	);
	vaarta_test_settings_assert( 'ASC' === vaarta_customize_sanitize_choice_value( 'ASC', $order_setting ), 'Choice sanitizer must preserve case-sensitive keys.' );
	vaarta_test_settings_assert( 'DESC' === vaarta_customize_sanitize_choice_value( 'invalid', $order_setting ), 'Invalid finite choice did not fall back to its default.' );
} finally {
	foreach ( $test_keys as $key ) {
		if ( array_key_exists( $key, $original_mods ) ) {
			set_theme_mod( $key, $original_mods[ $key ] );
		} else {
			remove_theme_mod( $key );
		}
	}
}

fwrite( STDOUT, "Vaarta settings compatibility contract passed.\n" );
