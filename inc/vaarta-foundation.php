<?php
/**
 * Vaarta modernization bootstrap.
 *
 * This file contains compatibility helpers used while the legacy Caards
 * runtime is migrated incrementally. It intentionally does not alter
 * frontend markup or legacy hook names.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'VAARTA_FOUNDATION_VERSION' ) ) {
	define( 'VAARTA_FOUNDATION_VERSION', '2.0.0-alpha.1' );
}

if ( ! defined( 'VAARTA_MINIMUM_WP_VERSION' ) ) {
	define( 'VAARTA_MINIMUM_WP_VERSION', '6.8' );
}

if ( ! defined( 'VAARTA_MINIMUM_PHP_VERSION' ) ) {
	define( 'VAARTA_MINIMUM_PHP_VERSION', '8.1' );
}

/**
 * Return the effective theme asset version.
 *
 * During the migration the style.css header still carries the legacy release
 * number, so Vaarta's foundation version is used for cache busting on new code.
 *
 * @return string
 */
function vaarta_get_foundation_version() {
	return VAARTA_FOUNDATION_VERSION;
}

/**
 * Check whether the active environment meets Vaarta's modernization baseline.
 *
 * @return bool
 */
function vaarta_environment_supported() {
	global $wp_version;

	return version_compare( PHP_VERSION, VAARTA_MINIMUM_PHP_VERSION, '>=' )
		&& version_compare( $wp_version, VAARTA_MINIMUM_WP_VERSION, '>=' );
}

/**
 * Display a non-blocking admin notice when the environment is below the
 * supported Vaarta baseline. The legacy theme remains loadable so an existing
 * site is not taken offline merely by activating the modernization layer.
 */
function vaarta_environment_notice() {
	if ( vaarta_environment_supported() || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	global $wp_version;

	$message = sprintf(
		/* translators: 1: minimum WordPress version, 2: minimum PHP version, 3: current WordPress version, 4: current PHP version. */
		esc_html__( 'Vaarta development targets WordPress %1$s+ and PHP %2$s+. This site is currently running WordPress %3$s and PHP %4$s. The compatibility layer remains active, but new Vaarta features may be unavailable.', 'caards' ),
		VAARTA_MINIMUM_WP_VERSION,
		VAARTA_MINIMUM_PHP_VERSION,
		$wp_version,
		PHP_VERSION
	);

	printf(
		'<div class="notice notice-warning"><p>%s</p></div>',
		esc_html( $message )
	);
}
add_action( 'admin_notices', 'vaarta_environment_notice' );

/**
 * Sanitize an identifier from a finite allowlist.
 *
 * @param mixed $value   Candidate value.
 * @param array $allowed Allowed values.
 * @param mixed $default Fallback value.
 * @return mixed
 */
function vaarta_sanitize_choice( $value, array $allowed, $default = '' ) {
	$value = is_scalar( $value ) ? sanitize_key( (string) $value ) : '';

	return in_array( $value, $allowed, true ) ? $value : $default;
}

/**
 * Normalize a positive integer with optional bounds.
 *
 * @param mixed    $value Candidate value.
 * @param int      $min   Minimum value.
 * @param int|null $max   Optional maximum value.
 * @return int
 */
function vaarta_sanitize_positive_int( $value, $min = 1, $max = null ) {
	$value = max( (int) $min, absint( $value ) );

	if ( null !== $max ) {
		$value = min( (int) $max, $value );
	}

	return $value;
}

/**
 * Sanitize a checkbox/toggle value.
 *
 * @param mixed $value Candidate value.
 * @return bool
 */
function vaarta_customize_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Sanitize a numeric Customizer value without forcing dimensions or complex
 * controls through an integer-only conversion.
 *
 * @param mixed $value Candidate value.
 * @return int|float
 */
function vaarta_customize_sanitize_number( $value ) {
	if ( ! is_numeric( $value ) ) {
		return 0;
	}

	return 0 + $value;
}

/**
 * Supply safe defaults for primitive legacy Customizer controls that omitted a
 * sanitize callback. Complex controls (typography, backgrounds, dimensions,
 * alpha colors, multicheck arrays) are deliberately left to their existing
 * control-specific sanitizers and will be migrated individually.
 *
 * @param array $args Legacy Customizer field definition.
 * @return array
 */
function vaarta_customize_default_sanitizers( $args ) {
	if ( ! is_array( $args ) || ! empty( $args['sanitize_callback'] ) || empty( $args['type'] ) ) {
		return $args;
	}

	switch ( $args['type'] ) {
		case 'checkbox':
		case 'toggle':
			$args['sanitize_callback'] = 'vaarta_customize_sanitize_checkbox';
			break;

		case 'number':
			$args['sanitize_callback'] = 'vaarta_customize_sanitize_number';
			break;

		case 'select':
		case 'radio':
			$args['sanitize_callback'] = 'sanitize_key';
			break;

		case 'text':
			$args['sanitize_callback'] = 'sanitize_text_field';
			break;

		case 'textarea':
			$args['sanitize_callback'] = 'sanitize_textarea_field';
			break;

		case 'url':
			$args['sanitize_callback'] = 'esc_url_raw';
			break;
	}

	return $args;
}
add_filter( 'csco_customizer_field_add_setting_args', 'vaarta_customize_default_sanitizers', 5 );
