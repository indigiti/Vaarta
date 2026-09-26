<?php
/**
 * Vaarta integration facade.
 *
 * Third-party plugin detection lives behind Vaarta-owned helpers so templates
 * and new modules do not need to couple themselves directly to plugin globals.
 * Legacy csco_* helpers remain available as wrappers during migration.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Determine whether a Powerkit module is available and enabled.
 *
 * @param string $module Module slug.
 * @return bool
 */
function vaarta_powerkit_module_enabled( $module ) {
	$module  = sanitize_key( $module );
	$enabled = false;

	if ( $module && function_exists( 'powerkit_module_enabled' ) ) {
		$enabled = (bool) powerkit_module_enabled( $module );
	}

	/**
	 * Filter Powerkit feature availability for compatibility integrations.
	 *
	 * @param bool   $enabled Whether the module is enabled.
	 * @param string $module  Powerkit module slug.
	 */
	return (bool) apply_filters( 'vaarta_powerkit_module_enabled', $enabled, $module );
}

/**
 * Return the active post-views provider identifier.
 *
 * @return string|false
 */
function vaarta_get_post_views_provider() {
	$provider = false;

	if ( class_exists( 'Post_Views_Counter' ) ) {
		$provider = 'post_views';
	} elseif ( vaarta_powerkit_module_enabled( 'post_views' ) ) {
		$provider = 'pk_post_views';
	}

	/**
	 * Filter the detected post-views provider.
	 *
	 * @param string|false $provider Provider identifier or false.
	 */
	return apply_filters( 'vaarta_post_views_provider', $provider );
}

/**
 * Determine whether optional social-links presentation can be rendered.
 *
 * @return bool
 */
function vaarta_has_social_links_integration() {
	return vaarta_powerkit_module_enabled( 'social_links' );
}

/**
 * Determine whether optional opt-in form presentation can be rendered.
 *
 * @return bool
 */
function vaarta_has_opt_in_forms_integration() {
	return vaarta_powerkit_module_enabled( 'opt_in_forms' );
}

if ( ! function_exists( 'csco_powerkit_module_enabled' ) ) {
	/**
	 * Legacy compatibility wrapper for Powerkit feature detection.
	 *
	 * @param string $name Powerkit module slug.
	 * @return bool
	 */
	function csco_powerkit_module_enabled( $name ) {
		return vaarta_powerkit_module_enabled( $name );
	}
}

if ( ! function_exists( 'csco_post_views_enabled' ) ) {
	/**
	 * Legacy compatibility wrapper for post-views provider detection.
	 *
	 * @return string|false
	 */
	function csco_post_views_enabled() {
		return vaarta_get_post_views_provider();
	}
}
