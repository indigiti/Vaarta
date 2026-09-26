<?php
/**
 * Server-side sanitizers for legacy complex Customizer controls.
 *
 * Several legacy controls sanitized values only while rendering their UI or
 * output. Vaarta attaches the sanitation to WP_Customize_Setting itself and to
 * legacy theme_mod reads so existing data shapes are retained but unsafe CSS or
 * unsupported choices cannot reach frontend output.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return a setting object's default value when available.
 *
 * @param object|null $setting WP_Customize_Setting-compatible object.
 * @param mixed       $fallback Fallback value.
 * @return mixed
 */
function vaarta_customize_setting_default( $setting, $fallback = '' ) {
	return is_object( $setting ) && isset( $setting->default ) ? $setting->default : $fallback;
}

/**
 * Sanitize a CSS dimension used by legacy dimension/typography controls.
 *
 * @param mixed       $value   Candidate value.
 * @param object|null $setting Optional setting object.
 * @return string
 */
function vaarta_customize_sanitize_dimension_value( $value, $setting = null ) {
	$default = vaarta_customize_setting_default( $setting, '' );
	$default = is_scalar( $default ) ? trim( (string) $default ) : '';

	if ( ! is_scalar( $value ) ) {
		return $default;
	}

	$value = trim( wp_strip_all_tags( (string) $value ) );

	if ( '' === $value ) {
		return '';
	}

	if ( in_array( strtolower( $value ), array( 'auto', 'inherit', 'initial', 'unset' ), true ) ) {
		return strtolower( $value );
	}

	if ( preg_match( '/^-?(?:\d+|\d*\.\d+)(?:px|rem|em|%|vw|vh|vmin|vmax|ch|ex|pt|pc|cm|mm|in)?$/i', $value ) ) {
		return $value;
	}

	// Preserve practical responsive expressions without permitting CSS statement
	// delimiters, URLs, custom-property declarations, or arbitrary functions.
	if ( preg_match( '/^(?:calc|min|max|clamp)\([0-9a-z.%+\-*\/(),\s]+\)$/i', $value ) ) {
		return $value;
	}

	return $default;
}

/**
 * Sanitize a CSS color used by legacy color controls.
 *
 * @param mixed       $value   Candidate color.
 * @param object|null $setting Optional setting object.
 * @return string
 */
function vaarta_customize_sanitize_color_value( $value, $setting = null ) {
	$default = vaarta_customize_setting_default( $setting, '' );
	$default = is_scalar( $default ) ? trim( (string) $default ) : '';

	if ( is_scalar( $value ) ) {
		$keyword = strtolower( trim( (string) $value ) );
		if ( in_array( $keyword, array( 'transparent', 'currentcolor', 'inherit', 'initial', 'unset' ), true ) ) {
			return $keyword;
		}
	}

	return vaarta_sanitize_css_color( $value, vaarta_sanitize_css_color( $default, '' ) );
}

/**
 * Sanitize an image URL.
 *
 * @param mixed       $value   Candidate URL.
 * @param object|null $setting Optional setting object.
 * @return string
 */
function vaarta_customize_sanitize_image_value( $value, $setting = null ) {
	$default = vaarta_customize_setting_default( $setting, '' );
	$default = is_scalar( $default ) ? esc_url_raw( (string) $default ) : '';

	return is_scalar( $value ) ? esc_url_raw( (string) $value ) : $default;
}

/**
 * Sanitize a multicheck value against the field's finite choices.
 *
 * @param mixed       $value   Candidate values.
 * @param object|null $setting Optional setting object.
 * @return array<int,string>
 */
function vaarta_customize_sanitize_multicheck_value( $value, $setting = null ) {
	$setting_id = is_object( $setting ) && isset( $setting->id ) ? (string) $setting->id : '';
	$choices    = vaarta_get_setting_choices( $setting_id );
	$values     = is_array( $value ) ? $value : explode( ',', (string) $value );
	$sanitized  = array();

	foreach ( $values as $candidate ) {
		if ( ! is_scalar( $candidate ) ) {
			continue;
		}

		$candidate = (string) $candidate;

		if ( array_key_exists( $candidate, $choices ) && ! in_array( $candidate, $sanitized, true ) ) {
			$sanitized[] = $candidate;
		}
	}

	return $sanitized;
}

/**
 * Return a finite background sub-control value or its default.
 *
 * @param mixed  $value   Candidate value.
 * @param array  $allowed Allowed values.
 * @param string $default Default value.
 * @return string
 */
function vaarta_customize_sanitize_background_choice( $value, $allowed, $default ) {
	$value = is_scalar( $value ) ? (string) $value : '';

	return in_array( $value, $allowed, true ) ? $value : $default;
}

/**
 * Sanitize a legacy grouped background value without changing its array shape.
 *
 * @param mixed       $value   Candidate background array.
 * @param object|null $setting Optional setting object.
 * @return array<string,string>
 */
function vaarta_customize_sanitize_background_value( $value, $setting = null ) {
	$defaults = vaarta_customize_setting_default( $setting, array() );
	$defaults = is_array( $defaults ) ? $defaults : array();
	$value    = is_array( $value ) ? $value : array();

	$color_default      = isset( $defaults['background-color'] ) ? (string) $defaults['background-color'] : '';
	$image_default      = isset( $defaults['background-image'] ) ? (string) $defaults['background-image'] : '';
	$repeat_default     = isset( $defaults['background-repeat'] ) ? (string) $defaults['background-repeat'] : 'no-repeat';
	$position_default   = isset( $defaults['background-position'] ) ? (string) $defaults['background-position'] : 'center top';
	$size_default       = isset( $defaults['background-size'] ) ? (string) $defaults['background-size'] : 'contain';
	$attachment_default = isset( $defaults['background-attachment'] ) ? (string) $defaults['background-attachment'] : 'scroll';

	$color_setting = (object) array( 'default' => $color_default );
	$image_setting = (object) array( 'default' => $image_default );

	return array(
		'background-color'      => vaarta_customize_sanitize_color_value( $value['background-color'] ?? $color_default, $color_setting ),
		'background-image'      => vaarta_customize_sanitize_image_value( $value['background-image'] ?? $image_default, $image_setting ),
		'background-repeat'     => vaarta_customize_sanitize_background_choice(
			$value['background-repeat'] ?? $repeat_default,
			array( 'no-repeat', 'repeat', 'repeat-x', 'repeat-y' ),
			$repeat_default
		),
		'background-position'   => vaarta_customize_sanitize_background_choice(
			$value['background-position'] ?? $position_default,
			array(
				'left top', 'left center', 'left bottom',
				'right top', 'right center', 'right bottom',
				'center top', 'center center', 'center bottom',
			),
			$position_default
		),
		'background-size'       => vaarta_customize_sanitize_background_choice(
			$value['background-size'] ?? $size_default,
			array( 'cover', 'contain', 'auto' ),
			$size_default
		),
		'background-attachment' => vaarta_customize_sanitize_background_choice(
			$value['background-attachment'] ?? $attachment_default,
			array( 'scroll', 'fixed' ),
			$attachment_default
		),
	);
}

/**
 * Sanitize legacy typography settings into their existing array contract.
 *
 * @param mixed       $value   Candidate typography array.
 * @param object|null $setting Optional setting object.
 * @return array<string,mixed>
 */
function vaarta_customize_sanitize_typography_value( $value, $setting = null ) {
	if ( ! is_array( $value ) ) {
		return array();
	}

	$setting_id = is_object( $setting ) && isset( $setting->id ) ? (string) $setting->id : '';
	$field      = vaarta_get_customizer_field( $setting_id );
	$defaults   = $field && isset( $field['default'] ) && is_array( $field['default'] ) ? $field['default'] : array();
	$output     = array();

	foreach ( $value as $key => $candidate ) {
		if ( ! array_key_exists( $key, $defaults ) && ! in_array( $key, array( 'variant', 'font-weight', 'font-style' ), true ) ) {
			continue;
		}

		switch ( $key ) {
			case 'font-family':
				if ( is_scalar( $candidate ) ) {
					$family = sanitize_text_field( (string) $candidate );
					$family = preg_replace( '/[;{}<>]/', '', $family );
					if ( '' !== $family ) {
						$output[ $key ] = $family;
					}
				}
				break;

			case 'variant':
				if ( is_scalar( $candidate ) ) {
					$variant = strtolower( trim( (string) $candidate ) );
					if ( preg_match( '/^(?:regular|italic|[1-9]00(?:italic)?)$/', $variant ) ) {
						$output[ $key ] = $variant;
					}
				}
				break;

			case 'font-weight':
				$weight = absint( $candidate );
				if ( $weight >= 100 && $weight <= 900 && 0 === $weight % 100 ) {
					$output[ $key ] = $weight;
				}
				break;

			case 'font-style':
				$style = is_scalar( $candidate ) ? strtolower( trim( (string) $candidate ) ) : '';
				if ( in_array( $style, array( 'normal', 'italic' ), true ) ) {
					$output[ $key ] = $style;
				}
				break;

			case 'font-size':
			case 'letter-spacing':
			case 'word-spacing':
			case 'line-height':
				$dimension = vaarta_customize_sanitize_dimension_value( $candidate );
				if ( '' !== $dimension ) {
					$output[ $key ] = $dimension;
				}
				break;

			case 'text-align':
				$align = is_scalar( $candidate ) ? strtolower( trim( (string) $candidate ) ) : '';
				if ( in_array( $align, array( '', 'inherit', 'left', 'center', 'right', 'justify' ), true ) ) {
					$output[ $key ] = $align;
				}
				break;

			case 'text-transform':
				$transform = is_scalar( $candidate ) ? strtolower( trim( (string) $candidate ) ) : '';
				if ( in_array( $transform, array( '', 'none', 'capitalize', 'uppercase', 'lowercase', 'initial', 'inherit' ), true ) ) {
					$output[ $key ] = $transform;
				}
				break;

			case 'text-decoration':
				$decoration = is_scalar( $candidate ) ? strtolower( trim( (string) $candidate ) ) : '';
				if ( in_array( $decoration, array( '', 'none', 'underline', 'overline', 'line-through', 'initial', 'inherit' ), true ) ) {
					$output[ $key ] = $decoration;
				}
				break;

			case 'color':
				$color = vaarta_customize_sanitize_color_value( $candidate );
				if ( '' !== $color ) {
					$output[ $key ] = $color;
				}
				break;
		}
	}

	return $output;
}

/**
 * Select the correct server-side sanitizer for complex legacy controls.
 *
 * @param array<string,mixed> $args Customizer field definition.
 * @return array<string,mixed>
 */
function vaarta_customize_complex_setting_sanitizers( $args ) {
	if ( ! is_array( $args ) || empty( $args['type'] ) ) {
		return $args;
	}

	$callbacks = array(
		'color'            => 'vaarta_customize_sanitize_color_value',
		'color-alpha'      => 'vaarta_customize_sanitize_color_value',
		'image'            => 'vaarta_customize_sanitize_image_value',
		'dimension'        => 'vaarta_customize_sanitize_dimension_value',
		'group-background' => 'vaarta_customize_sanitize_background_value',
		'multicheck'       => 'vaarta_customize_sanitize_multicheck_value',
		'typography'       => 'vaarta_customize_sanitize_typography_value',
	);

	if ( isset( $callbacks[ $args['type'] ] ) && empty( $args['sanitize_callback'] ) ) {
		$args['sanitize_callback'] = $callbacks[ $args['type'] ];
	}

	return $args;
}
add_filter( 'csco_customizer_field_add_setting_args', 'vaarta_customize_complex_setting_sanitizers', 7 );

/**
 * Sanitize a registered legacy field value using the same callbacks as writes.
 *
 * @param string $field_id Customizer field identifier.
 * @param mixed  $value    Stored value.
 * @return mixed
 */
function vaarta_sanitize_customizer_field_value( $field_id, $value ) {
	$field = vaarta_get_customizer_field( $field_id );

	if ( ! $field || empty( $field['type'] ) ) {
		return $value;
	}

	$callbacks = array(
		'color'            => 'vaarta_customize_sanitize_color_value',
		'color-alpha'      => 'vaarta_customize_sanitize_color_value',
		'image'            => 'vaarta_customize_sanitize_image_value',
		'dimension'        => 'vaarta_customize_sanitize_dimension_value',
		'group-background' => 'vaarta_customize_sanitize_background_value',
		'multicheck'       => 'vaarta_customize_sanitize_multicheck_value',
		'typography'       => 'vaarta_customize_sanitize_typography_value',
	);

	if ( ! isset( $callbacks[ $field['type'] ] ) ) {
		return $value;
	}

	$setting = (object) array(
		'id'      => $field_id,
		'default' => $field['default'] ?? '',
	);

	return call_user_func( $callbacks[ $field['type'] ], $value, $setting );
}

/**
 * Harden values consumed by the legacy Customizer CSS output engine.
 *
 * @param mixed  $value    Stored value.
 * @param string $field_id Customizer field identifier.
 * @return mixed
 */
function vaarta_filter_complex_customizer_value( $value, $field_id ) {
	return vaarta_sanitize_customizer_field_value( $field_id, $value );
}
add_filter( 'csco_customizer_values_get_value', 'vaarta_filter_complex_customizer_value', 11, 2 );

/**
 * Harden direct get_theme_mod() reads for complex Customizer fields.
 *
 * @param mixed $value Stored theme mod value.
 * @return mixed
 */
function vaarta_filter_complex_theme_mod_value( $value ) {
	$field_id = substr( current_filter(), strlen( 'theme_mod_' ) );

	return vaarta_sanitize_customizer_field_value( $field_id, $value );
}

/**
 * Register read-time filters after legacy theme-mod definitions are loaded.
 *
 * @return void
 */
function vaarta_register_complex_theme_mod_filters() {
	if ( ! class_exists( 'CSCO_Customizer' ) ) {
		return;
	}

	$complex_types = array( 'color', 'color-alpha', 'image', 'dimension', 'group-background', 'multicheck', 'typography' );

	foreach ( CSCO_Customizer::$fields as $field_id => $field ) {
		if ( ! is_array( $field ) || empty( $field['type'] ) || ! in_array( $field['type'], $complex_types, true ) ) {
			continue;
		}

		add_filter( 'theme_mod_' . $field_id, 'vaarta_filter_complex_theme_mod_value', 5 );
	}
}
add_action( 'after_setup_theme', 'vaarta_register_complex_theme_mod_filters', 30 );
