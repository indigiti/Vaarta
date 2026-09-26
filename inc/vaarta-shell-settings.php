<?php
/**
 * Typed settings adopted by Vaarta's site shell.
 *
 * These settings keep their existing theme_mod persistence keys and Customizer
 * controls. Vaarta owns their normalization so templates and future block-based
 * shell rendering can consume one typed contract without changing stored data.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the shell settings adopted in this migration layer.
 *
 * @return array<string,array<string,mixed>>
 */
function vaarta_get_shell_settings_schema() {
	return array(
		'header_search_form' => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'header_fullscreen_menu' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'header_multi_column_display' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'header_multi_column_posts' => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'header_social_links' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'header_social_links_scheme' => array(
			'type'    => 'choice',
			'default' => 'light',
			'choices' => array( 'light', 'bold' ),
		),
		'header_social_links_maximum' => array(
			'type'    => 'integer',
			'default' => 3,
		),
		'header_social_links_counts' => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'footer_social_links' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'footer_social_links_scheme' => array(
			'type'    => 'choice',
			'default' => 'light',
			'choices' => array( 'light', 'bold' ),
		),
		'footer_social_links_maximum' => array(
			'type'    => 'integer',
			'default' => 4,
		),
		'footer_social_links_counts' => array(
			'type'    => 'boolean',
			'default' => true,
		),
		'footer_subscribe' => array(
			'type'    => 'boolean',
			'default' => false,
		),
		'footer_subscribe_name' => array(
			'type'    => 'boolean',
			'default' => true,
		),
	);
}

/**
 * Extend Vaarta's typed settings registry with site-shell controls.
 *
 * @param array<string,array<string,mixed>> $schema Existing schema.
 * @return array<string,array<string,mixed>>
 */
function vaarta_register_shell_settings_schema( $schema ) {
	return array_merge( $schema, vaarta_get_shell_settings_schema() );
}
add_filter( 'vaarta_settings_schema', 'vaarta_register_shell_settings_schema', 20 );

/**
 * Normalize direct legacy get_theme_mod() reads for newly adopted shell keys.
 *
 * The base settings module registered its read filters before this extension was
 * loaded, so this module attaches the same typed normalizer to its own keys.
 *
 * @return void
 */
function vaarta_register_shell_theme_mod_filters() {
	foreach ( array_keys( vaarta_get_shell_settings_schema() ) as $setting_id ) {
		add_filter( 'theme_mod_' . $setting_id, 'vaarta_filter_registered_theme_mod', 5 );
	}
}
vaarta_register_shell_theme_mod_filters();
