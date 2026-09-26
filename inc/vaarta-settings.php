<?php
/**
 * Vaarta settings compatibility layer.
 *
 * Legacy theme_mod names remain the persistence contract while Vaarta moves
 * design controls toward theme.json and Global Styles. This module gives new
 * code a typed API and hardens legacy Customizer choice fields without changing
 * stored option names or frontend selectors.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'VAARTA_SETTINGS_SCHEMA_VERSION' ) ) {
	define( 'VAARTA_SETTINGS_SCHEMA_VERSION', 1 );
}

/**
 * Return the settings that Vaarta has adopted into its typed compatibility API.
 *
 * The registry is intentionally incremental. Unlisted legacy theme_mods continue
 * to work unchanged until their owning component is migrated.
 *
 * @return array<string,array<string,mixed>>
 */
function vaarta_get_settings_schema() {
	$schema = array(
		'color_scheme' => array(
			'type'    => 'choice',
			'default' => 'system',
			'choices' => array( 'system', 'light', 'dark' ),
		),
		'color_scheme_toggle' => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'color_primary' => array(
			'type'    => 'color',
			'default' => '#2F323D',
		),
		'color_secondary' => array(
			'type'    => 'color',
			'default' => '#67717A',
		),
		'color_accent' => array(
			'type'    => 'color',
			'default' => '#2D5DE0',
		),
		'header_layout' => array(
			'type'    => 'choice',
			'default' => 'one',
			'choices' => array( 'one', 'two', 'three', 'four' ),
		),
		'header_search_type' => array(
			'type'    => 'choice',
			'default' => 'one',
			'choices' => array( 'one', 'two' ),
		),
		'navbar_sticky' => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'navbar_smart_sticky' => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'header_navigation_menu' => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'header_search_button' => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'header_button_link' => array(
			'type'    => 'url',
			'default' => '',
		),
		'header_button_target' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'footer_layout' => array(
			'type'    => 'choice',
			'default' => 'one',
			'choices' => array( 'one', 'two', 'three', 'four' ),
		),
	);

	/**
	 * Filter Vaarta's typed settings schema.
	 *
	 * Compatibility integrations may extend this registry without replacing the
	 * underlying theme_mod storage contract.
	 *
	 * @param array $schema Settings schema.
	 */
	return apply_filters( 'vaarta_settings_schema', $schema );
}

/**
 * Return one typed setting definition.
 *
 * @param string $setting_id Theme mod identifier.
 * @return array<string,mixed>|null
 */
function vaarta_get_setting_definition( $setting_id ) {
	$schema = vaarta_get_settings_schema();

	return isset( $schema[ $setting_id ] ) && is_array( $schema[ $setting_id ] )
		? $schema[ $setting_id ]
		: null;
}

/**
 * Return a legacy Customizer field definition when it has been registered.
 *
 * @param string $setting_id Theme mod identifier.
 * @return array<string,mixed>|null
 */
function vaarta_get_customizer_field( $setting_id ) {
	if ( ! class_exists( 'CSCO_Customizer' ) || ! isset( CSCO_Customizer::$fields[ $setting_id ] ) ) {
		return null;
	}

	$field = CSCO_Customizer::$fields[ $setting_id ];

	return is_array( $field ) ? $field : null;
}

/**
 * Return the finite choice keys for a setting.
 *
 * Registered Customizer choices take precedence so child themes and existing
 * csco_* choice filters remain compatible with the typed API.
 *
 * @param string                   $setting_id Theme mod identifier.
 * @param array<string,mixed>|null $definition Optional typed definition.
 * @return array<int|string,mixed>
 */
function vaarta_get_setting_choices( $setting_id, $definition = null ) {
	$field = vaarta_get_customizer_field( $setting_id );

	if ( $field && ! empty( $field['choices'] ) && is_array( $field['choices'] ) ) {
		return $field['choices'];
	}

	if ( null === $definition ) {
		$definition = vaarta_get_setting_definition( $setting_id );
	}

	if ( ! $definition || empty( $definition['choices'] ) || ! is_array( $definition['choices'] ) ) {
		return array();
	}

	// Schema choices may be represented as a simple list or as key => label.
	if ( array_is_list( $definition['choices'] ) ) {
		return array_fill_keys( $definition['choices'], true );
	}

	return $definition['choices'];
}

/**
 * Normalize a boolean value without treating the string "false" as true.
 *
 * @param mixed $value Candidate value.
 * @return bool
 */
function vaarta_normalize_boolean( $value ) {
	if ( is_string( $value ) ) {
		$normalized = strtolower( trim( $value ) );

		if ( in_array( $normalized, array( '', '0', 'false', 'no', 'off' ), true ) ) {
			return false;
		}

		if ( in_array( $normalized, array( '1', 'true', 'yes', 'on' ), true ) ) {
			return true;
		}
	}

	return (bool) $value;
}

/**
 * Sanitize the CSS color formats emitted by the legacy alpha-color control.
 *
 * @param mixed  $value   Candidate color.
 * @param string $default Fallback color.
 * @return string
 */
function vaarta_sanitize_css_color( $value, $default = '' ) {
	if ( ! is_scalar( $value ) ) {
		return $default;
	}

	$value = trim( wp_strip_all_tags( (string) $value ) );

	if ( preg_match( '/^#(?:[0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value ) ) {
		return $value;
	}

	if ( preg_match( '/^(?:rgb|rgba|hsl|hsla)\(\s*[-+0-9.%\s,\/]+\)$/i', $value ) ) {
		return $value;
	}

	return $default;
}

/**
 * Sanitize a value according to Vaarta's typed setting definition.
 *
 * @param string                   $setting_id Theme mod identifier.
 * @param mixed                    $value      Candidate value.
 * @param array<string,mixed>|null $definition Optional typed definition.
 * @return mixed
 */
function vaarta_sanitize_setting_value( $setting_id, $value, $definition = null ) {
	if ( null === $definition ) {
		$definition = vaarta_get_setting_definition( $setting_id );
	}

	if ( ! $definition ) {
		return $value;
	}

	$default = array_key_exists( 'default', $definition ) ? $definition['default'] : null;
	$type    = isset( $definition['type'] ) ? $definition['type'] : 'raw';

	switch ( $type ) {
		case 'boolean':
			return vaarta_normalize_boolean( $value );

		case 'choice':
			if ( ! is_scalar( $value ) ) {
				return $default;
			}

			$value   = (string) $value;
			$choices = vaarta_get_setting_choices( $setting_id, $definition );

			return array_key_exists( $value, $choices ) ? $value : $default;

		case 'url':
			return is_scalar( $value ) ? esc_url_raw( (string) $value ) : $default;

		case 'color':
			return vaarta_sanitize_css_color( $value, (string) $default );

		case 'integer':
			return absint( $value );

		case 'text':
			return is_scalar( $value ) ? sanitize_text_field( (string) $value ) : $default;
	}

	return $value;
}

/**
 * Read a legacy theme_mod through Vaarta's typed compatibility schema.
 *
 * @param string $setting_id Theme mod identifier.
 * @param mixed  $fallback   Optional fallback for unregistered settings.
 * @return mixed
 */
function vaarta_get_setting( $setting_id, $fallback = null ) {
	$definition = vaarta_get_setting_definition( $setting_id );

	if ( $definition ) {
		$default = array_key_exists( 'default', $definition ) ? $definition['default'] : $fallback;
		$value   = get_theme_mod( $setting_id, $default );
		$value   = vaarta_sanitize_setting_value( $setting_id, $value, $definition );
	} else {
		$value = get_theme_mod( $setting_id, $fallback );
	}

	/**
	 * Filter a typed Vaarta setting value.
	 *
	 * @param mixed  $value      Normalized value.
	 * @param string $setting_id Theme mod identifier.
	 */
	$value = apply_filters( 'vaarta_setting_value', $value, $setting_id );

	/**
	 * Filter an individual typed Vaarta setting value.
	 *
	 * @param mixed $value Normalized value.
	 */
	return apply_filters( 'vaarta_setting_' . $setting_id, $value );
}

/**
 * Normalize direct legacy get_theme_mod() reads for adopted settings.
 *
 * This runs early enough that an existing child-theme theme_mod_* filter can
 * still intentionally override the normalized value at the default priority.
 *
 * @param mixed $value Theme mod value.
 * @return mixed
 */
function vaarta_filter_registered_theme_mod( $value ) {
	$filter = current_filter();
	$prefix = 'theme_mod_';

	if ( 0 !== strpos( $filter, $prefix ) ) {
		return $value;
	}

	$setting_id = substr( $filter, strlen( $prefix ) );

	return vaarta_sanitize_setting_value( $setting_id, $value );
}

foreach ( array_keys( vaarta_get_settings_schema() ) as $vaarta_setting_id ) {
	add_filter( 'theme_mod_' . $vaarta_setting_id, 'vaarta_filter_registered_theme_mod', 5 );
}
unset( $vaarta_setting_id );

/**
 * Sanitize a finite Customizer choice against the registered field choices.
 *
 * Unlike sanitize_key(), this preserves case-sensitive keys such as ASC/DESC.
 *
 * @param mixed  $value   Candidate value.
 * @param object $setting WP_Customize_Setting-compatible object.
 * @return mixed
 */
function vaarta_customize_sanitize_choice_value( $value, $setting ) {
	$setting_id = isset( $setting->id ) ? (string) $setting->id : '';
	$default    = isset( $setting->default ) ? $setting->default : '';
	$choices    = vaarta_get_setting_choices( $setting_id );

	if ( ! is_scalar( $value ) || empty( $choices ) ) {
		return $default;
	}

	$value = (string) $value;

	return array_key_exists( $value, $choices ) ? $value : $default;
}

/**
 * Upgrade legacy Customizer sanitizers while preserving control definitions.
 *
 * @param array<string,mixed> $args Customizer field definition.
 * @return array<string,mixed>
 */
function vaarta_customize_schema_sanitizers( $args ) {
	if ( ! is_array( $args ) || empty( $args['settings'] ) || empty( $args['type'] ) ) {
		return $args;
	}

	if ( in_array( $args['type'], array( 'select', 'radio' ), true ) && ! empty( $args['choices'] ) && is_array( $args['choices'] ) ) {
		$args['sanitize_callback'] = 'vaarta_customize_sanitize_choice_value';
	}

	$definition = vaarta_get_setting_definition( $args['settings'] );

	if ( $definition && 'url' === $definition['type'] ) {
		$args['sanitize_callback'] = 'esc_url_raw';
	}

	return $args;
}
add_filter( 'csco_customizer_field_add_setting_args', 'vaarta_customize_schema_sanitizers', 6 );

/**
 * Normalize legacy Customizer values before its CSS output engine consumes them.
 *
 * @param mixed  $value    Stored value.
 * @param string $field_id Customizer field identifier.
 * @return mixed
 */
function vaarta_filter_customizer_value( $value, $field_id ) {
	$field = vaarta_get_customizer_field( $field_id );

	if ( ! $field || empty( $field['type'] ) ) {
		return $value;
	}

	if ( in_array( $field['type'], array( 'select', 'radio' ), true ) && ! empty( $field['choices'] ) && is_array( $field['choices'] ) ) {
		$choices = $field['choices'];
		$default = isset( $field['default'] ) ? $field['default'] : '';
		$value   = is_scalar( $value ) ? (string) $value : '';

		return array_key_exists( $value, $choices ) ? $value : $default;
	}

	if ( in_array( $field['type'], array( 'checkbox', 'toggle' ), true ) ) {
		return vaarta_normalize_boolean( $value );
	}

	return $value;
}
add_filter( 'csco_customizer_values_get_value', 'vaarta_filter_customizer_value', 10, 2 );

/**
 * Build the theme-origin WordPress palette from adopted legacy color settings.
 *
 * The surface tokens stay fixed for now; only colors already represented by a
 * one-to-one legacy theme_mod are synchronized in this phase.
 *
 * @return array<int,array<string,string>>
 */
function vaarta_get_global_styles_palette() {
	return array(
		array(
			'slug'  => 'primary',
			'name'  => 'Primary',
			'color' => vaarta_get_setting( 'color_primary' ),
		),
		array(
			'slug'  => 'secondary',
			'name'  => 'Secondary',
			'color' => vaarta_get_setting( 'color_secondary' ),
		),
		array(
			'slug'  => 'accent',
			'name'  => 'Accent',
			'color' => vaarta_get_setting( 'color_accent' ),
		),
		array(
			'slug'  => 'surface',
			'name'  => 'Surface',
			'color' => '#FFFFFF',
		),
		array(
			'slug'  => 'surface-muted',
			'name'  => 'Muted Surface',
			'color' => '#F6F7F8',
		),
		array(
			'slug'  => 'site-background',
			'name'  => 'Site Background',
			'color' => '#E6E9EB',
		),
		array(
			'slug'  => 'dark-surface',
			'name'  => 'Dark Surface',
			'color' => '#1B1C1F',
		),
		array(
			'slug'  => 'dark-background',
			'name'  => 'Dark Background',
			'color' => '#30323E',
		),
	);
}

/**
 * Synchronize adopted Customizer colors into the theme-origin Global Styles.
 *
 * User-origin Global Styles still merge after theme-origin data, so Site Editor
 * choices retain WordPress's normal precedence.
 *
 * @param WP_Theme_JSON_Data $theme_json Theme-origin theme.json data.
 * @return WP_Theme_JSON_Data
 */
function vaarta_filter_theme_json_data_theme( $theme_json ) {
	if ( ! is_object( $theme_json ) || ! method_exists( $theme_json, 'update_with' ) ) {
		return $theme_json;
	}

	return $theme_json->update_with(
		array(
			'version'  => 3,
			'settings' => array(
				'color' => array(
					'palette' => vaarta_get_global_styles_palette(),
				),
			),
		)
	);
}
add_filter( 'wp_theme_json_data_theme', 'vaarta_filter_theme_json_data_theme', 20 );

/**
 * Vaarta-native header layout accessor.
 *
 * @return string
 */
function vaarta_get_header_layout() {
	return (string) apply_filters( 'csco_header_layout_type', vaarta_get_setting( 'header_layout' ) );
}

/**
 * Vaarta-native footer layout accessor.
 *
 * @return string
 */
function vaarta_get_footer_layout() {
	return (string) apply_filters( 'csco_footer_layout_type', vaarta_get_setting( 'footer_layout' ) );
}

if ( ! function_exists( 'csco_get_header_search_type' ) ) {
	/**
	 * Legacy compatibility wrapper for the adopted search-layout setting.
	 *
	 * @return string
	 */
	function csco_get_header_search_type() {
		return apply_filters( 'csco_header_search_type', vaarta_get_setting( 'header_search_type' ) );
	}
}

if ( ! function_exists( 'csco_get_header_layout_type' ) ) {
	/**
	 * Legacy compatibility wrapper for the Vaarta header-layout API.
	 *
	 * @return string
	 */
	function csco_get_header_layout_type() {
		return vaarta_get_header_layout();
	}
}

if ( ! function_exists( 'csco_get_footer_layout_type' ) ) {
	/**
	 * Legacy compatibility wrapper for the Vaarta footer-layout API.
	 *
	 * @return string
	 */
	function csco_get_footer_layout_type() {
		return vaarta_get_footer_layout();
	}
}
