<?php
/**
 * Theme setup.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vaarta_setup(): void {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/global.css' );
}
add_action( 'after_setup_theme', 'vaarta_setup' );
