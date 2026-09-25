<?php
/**
 * Advertising integration hooks.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolve provider markup for a named ad slot.
 *
 * Integrations can return markup through the vaarta_ad_slot_html filter
 * without replacing the Gutenberg block or changing theme templates.
 *
 * @param string $slot_name Slot identifier.
 * @param array  $attributes Block attributes.
 * @return string
 */
function vaarta_get_ad_slot_html( string $slot_name, array $attributes = array() ): string {
	$html = apply_filters(
		'vaarta_ad_slot_html',
		'',
		$slot_name,
		$attributes
	);

	return is_string( $html ) ? $html : '';
}
