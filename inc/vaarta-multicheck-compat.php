<?php
/**
 * Multicheck compatibility normalization.
 *
 * Legacy multicheck controls may expose their finite choices directly on the
 * registered Customizer field rather than through the generic settings-choice
 * lookup. Keep the stored option names/data shape while making both writes and
 * direct theme-mod reads use that authoritative field definition.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the allowed scalar values for a registered multicheck field.
 *
 * @param string $setting_id Customizer setting identifier.
 * @return array<int,string>
 */
function vaarta_multicheck_allowed_values( $setting_id ) {
	$field = vaarta_get_customizer_field( $setting_id );

	if ( ! $field || 'multicheck' !== ( $field['type'] ?? '' ) || empty( $field['choices'] ) || ! is_array( $field['choices'] ) ) {
		return array();
	}

	$choices = $field['choices'];
	$values  = array_is_list( $choices ) ? array_values( $choices ) : array_keys( $choices );
	$allowed = array();

	foreach ( $values as $candidate ) {
		if ( ! is_scalar( $candidate ) ) {
			continue;
		}

		$candidate = (string) $candidate;

		if ( '' !== $candidate && ! in_array( $candidate, $allowed, true ) ) {
			$allowed[] = $candidate;
		}
	}

	return $allowed;
}

/**
 * Sanitize a multicheck value against the registered field choices.
 *
 * @param mixed       $value   Candidate value.
 * @param object|null $setting Optional WP_Customize_Setting-compatible object.
 * @return array<int,string>
 */
function vaarta_customize_sanitize_registered_multicheck( $value, $setting = null ) {
	$setting_id = is_object( $setting ) && isset( $setting->id ) ? (string) $setting->id : '';
	$allowed    = vaarta_multicheck_allowed_values( $setting_id );
	$values     = is_array( $value ) ? $value : explode( ',', (string) $value );
	$sanitized  = array();

	foreach ( $values as $candidate ) {
		if ( ! is_scalar( $candidate ) ) {
			continue;
		}

		$candidate = (string) $candidate;

		if ( in_array( $candidate, $allowed, true ) && ! in_array( $candidate, $sanitized, true ) ) {
			$sanitized[] = $candidate;
		}
	}

	return $sanitized;
}

/**
 * Force multicheck Customizer writes onto the registered-field sanitizer.
 *
 * @param array<string,mixed> $args Customizer field definition.
 * @return array<string,mixed>
 */
function vaarta_customize_registered_multicheck_setting_args( $args ) {
	if ( is_array( $args ) && 'multicheck' === ( $args['type'] ?? '' ) ) {
		$args['sanitize_callback'] = 'vaarta_customize_sanitize_registered_multicheck';
	}

	return $args;
}
add_filter( 'csco_customizer_field_add_setting_args', 'vaarta_customize_registered_multicheck_setting_args', 20 );

/**
 * Keep the legacy output engine on the same multicheck data contract.
 *
 * @param mixed  $value    Stored value.
 * @param string $field_id Customizer field identifier.
 * @return mixed
 */
function vaarta_filter_customizer_value_with_multicheck_compat( $value, $field_id ) {
	$field = vaarta_get_customizer_field( $field_id );

	if ( $field && 'multicheck' === ( $field['type'] ?? '' ) ) {
		return vaarta_customize_sanitize_registered_multicheck(
			$value,
			(object) array( 'id' => $field_id )
		);
	}

	return vaarta_sanitize_customizer_field_value( $field_id, $value );
}

remove_filter( 'csco_customizer_values_get_value', 'vaarta_filter_complex_customizer_value', 11 );
add_filter( 'csco_customizer_values_get_value', 'vaarta_filter_customizer_value_with_multicheck_compat', 11, 2 );

/**
 * Sanitize a direct get_theme_mod() read for one multicheck field.
 *
 * @param mixed $value Stored value.
 * @return array<int,string>
 */
function vaarta_filter_registered_multicheck_theme_mod( $value ) {
	$field_id = substr( current_filter(), strlen( 'theme_mod_' ) );

	return vaarta_customize_sanitize_registered_multicheck(
		$value,
		(object) array( 'id' => $field_id )
	);
}

/**
 * Replace the generic read-time filter for multicheck fields after all legacy
 * theme-mod definitions have registered their choices.
 *
 * @return void
 */
function vaarta_register_multicheck_theme_mod_filters() {
	if ( ! class_exists( 'CSCO_Customizer' ) ) {
		return;
	}

	foreach ( CSCO_Customizer::$fields as $field_id => $field ) {
		if ( ! is_array( $field ) || 'multicheck' !== ( $field['type'] ?? '' ) ) {
			continue;
		}

		remove_filter( 'theme_mod_' . $field_id, 'vaarta_filter_complex_theme_mod_value', 5 );
		add_filter( 'theme_mod_' . $field_id, 'vaarta_filter_registered_multicheck_theme_mod', 5 );
	}
}
add_action( 'after_setup_theme', 'vaarta_register_multicheck_theme_mod_filters', 31 );
