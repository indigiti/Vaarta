<?php
/**
 * Browser-test fixtures for a clean wp-env installation.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create or resolve a navigation menu by name.
 *
 * @param string $name Menu name.
 * @return int
 */
function vaarta_e2e_menu( $name ) {
	$menu = wp_get_nav_menu_object( $name );
	if ( $menu ) {
		return (int) $menu->term_id;
	}

	$menu_id = wp_create_nav_menu( $name );
	if ( is_wp_error( $menu_id ) ) {
		throw new RuntimeException( $menu_id->get_error_message() );
	}

	return (int) $menu_id;
}

$primary_id = vaarta_e2e_menu( 'Primary Navigation' );
$fullscreen_id = vaarta_e2e_menu( 'Fullscreen Navigation' );

if ( ! wp_get_nav_menu_items( $primary_id ) ) {
	wp_update_nav_menu_item(
		$primary_id,
		0,
		array(
			'menu-item-title'  => 'Home',
			'menu-item-url'    => home_url( '/' ),
			'menu-item-status' => 'publish',
		)
	);
}

if ( ! wp_get_nav_menu_items( $fullscreen_id ) ) {
	wp_update_nav_menu_item(
		$fullscreen_id,
		0,
		array(
			'menu-item-title'  => 'Stories',
			'menu-item-url'    => home_url( '/' ),
			'menu-item-status' => 'publish',
		)
	);
}

$locations = (array) get_theme_mod( 'nav_menu_locations', array() );
$locations['primary'] = $primary_id;
$locations['mobile'] = $primary_id;
$locations['fullscreen'] = $fullscreen_id;
set_theme_mod( 'nav_menu_locations', $locations );

set_theme_mod( 'header_navigation_menu', true );
set_theme_mod( 'header_search_button', true );
set_theme_mod( 'header_fullscreen_menu', true );
set_theme_mod( 'color_scheme_toggle', true );
set_theme_mod( 'color_scheme', 'system' );

if ( ! get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 1 ) ) ) {
	for ( $index = 1; $index <= 3; $index++ ) {
		wp_insert_post(
			array(
				'post_title'   => sprintf( 'Vaarta Test Story %d', $index ),
				'post_content' => str_repeat( 'Editorial test content. ', 30 ),
				'post_status'  => 'publish',
				'post_type'    => 'post',
			)
		);
	}
}
