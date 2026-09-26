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
	'header_height',
	'header_button_link',
	'header_button_target',
	'header_multi_column_posts_meta',
	'footer_layout',
	'site_background',
	'font_base',
);

$original_mods = get_theme_mods();
$original_mods = is_array( $original_mods ) ? $original_mods : array();

try {
	vaarta_test_settings_assert( function_exists( 'vaarta_get_setting' ), 'Typed settings API is not loaded.' );
	vaarta_test_settings_assert( function_exists( 'vaarta_render_site_header' ), 'Vaarta header renderer is not loaded.' );
	vaarta_test_settings_assert( function_exists( 'vaarta_render_site_footer' ), 'Vaarta footer renderer is not loaded.' );
	vaarta_test_settings_assert( function_exists( 'vaarta_powerkit_module_enabled' ), 'Vaarta integration facade is not loaded.' );
	vaarta_test_settings_assert( function_exists( 'vaarta_sanitize_customizer_field_value' ), 'Complex Customizer sanitation layer is not loaded.' );

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

	// Dimension fields must keep valid CSS lengths while rejecting declarations.
	set_theme_mod( 'header_height', '92px' );
	vaarta_test_settings_assert( '92px' === get_theme_mod( 'header_height' ), 'Valid dimension was not preserved.' );
	set_theme_mod( 'header_height', '80px; color:red' );
	vaarta_test_settings_assert( '80px' === get_theme_mod( 'header_height' ), 'Injected dimension did not fall back to the field default.' );

	// Multicheck values are a finite set, not arbitrary strings.
	set_theme_mod( 'header_multi_column_posts_meta', array( 'date', 'views', 'not-a-meta-key', 'date' ) );
	vaarta_test_settings_assert(
		array( 'date', 'views' ) === get_theme_mod( 'header_multi_column_posts_meta' ),
		'Multicheck sanitizer did not remove unsupported or duplicate values.'
	);

	// Grouped backgrounds retain their exact legacy array contract while each
	// CSS/URL sub-value is constrained server-side.
	set_theme_mod(
		'site_background',
		array(
			'background-color'      => 'expression(alert(1))',
			'background-image'      => 'javascript:alert(1)',
			'background-repeat'     => 'inject-repeat',
			'background-position'   => 'center top',
			'background-size'       => 'inject-size',
			'background-attachment' => 'inject-attachment',
		)
	);
	$background = get_theme_mod( 'site_background' );
	vaarta_test_settings_assert( is_array( $background ), 'Background sanitizer changed the stored value shape.' );
	vaarta_test_settings_assert( '#f6f7f8' === $background['background-color'], 'Unsafe background color did not fall back safely.' );
	vaarta_test_settings_assert( '' === $background['background-image'], 'Unsafe background image URL was not rejected.' );
	vaarta_test_settings_assert( 'no-repeat' === $background['background-repeat'], 'Invalid background repeat did not fall back.' );
	vaarta_test_settings_assert( 'center top' === $background['background-position'], 'Valid background position was not preserved.' );
	vaarta_test_settings_assert( 'contain' === $background['background-size'], 'Invalid background size did not fall back.' );
	vaarta_test_settings_assert( 'scroll' === $background['background-attachment'], 'Invalid background attachment did not fall back.' );

	// Typography must preserve legacy semantic values such as `normal` and font
	// subsets while dropping CSS declaration injection attempts.
	set_theme_mod(
		'font_base',
		array(
			'font-family'    => 'Manrope; color:red',
			'font-size'      => '1rem; color:red',
			'variant'        => '700italic',
			'letter-spacing' => 'normal',
			'line-height'    => '1.5',
			'subsets'        => array( 'latin', 'latin-ext', '<bad>' ),
		)
	);
	$font_base = get_theme_mod( 'font_base' );
	vaarta_test_settings_assert( is_array( $font_base ), 'Typography sanitizer changed the stored value shape.' );
	vaarta_test_settings_assert( false === strpos( $font_base['font-family'], ';' ), 'Typography font family retained a CSS declaration delimiter.' );
	vaarta_test_settings_assert( ! isset( $font_base['font-size'] ), 'Injected typography font size was not removed.' );
	vaarta_test_settings_assert( '700italic' === $font_base['variant'], 'Allowed typography variant was not preserved.' );
	vaarta_test_settings_assert( 'normal' === $font_base['letter-spacing'], 'Legacy `normal` letter spacing was not preserved.' );
	vaarta_test_settings_assert( '1.5' === $font_base['line-height'], 'Unitless line height was not preserved.' );
	vaarta_test_settings_assert( array( 'latin', 'latin-ext' ) === $font_base['subsets'], 'Typography subsets were not sanitized compatibly.' );
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
