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

/**
 * Add a custom-link item and fail loudly when WordPress rejects the fixture.
 *
 * @param int    $menu_id   Menu ID.
 * @param string $title     Item title.
 * @param string $url       Link URL.
 * @param int    $parent_id Optional parent menu-item ID.
 * @return int
 */
function vaarta_e2e_menu_item( $menu_id, $title, $url, $parent_id = 0 ) {
	$item_id = wp_update_nav_menu_item(
		$menu_id,
		0,
		array(
			'menu-item-title'     => $title,
			'menu-item-url'       => $url,
			'menu-item-status'    => 'publish',
			'menu-item-type'      => 'custom',
			'menu-item-object'    => 'custom',
			'menu-item-parent-id' => $parent_id,
		)
	);

	if ( is_wp_error( $item_id ) ) {
		throw new RuntimeException( $item_id->get_error_message() );
	}

	return (int) $item_id;
}

$primary_id    = vaarta_e2e_menu( 'Primary Navigation' );
$fullscreen_id = vaarta_e2e_menu( 'Fullscreen Navigation' );

if ( ! wp_get_nav_menu_items( $primary_id ) ) {
	vaarta_e2e_menu_item( $primary_id, 'Home', home_url( '/' ) );
}

if ( ! wp_get_nav_menu_items( $fullscreen_id ) ) {
	$stories_id = vaarta_e2e_menu_item( $fullscreen_id, 'Stories', '#' );
	$news_id    = vaarta_e2e_menu_item( $fullscreen_id, 'News', '#', $stories_id );
	vaarta_e2e_menu_item( $fullscreen_id, 'World', home_url( '/?s=world' ), $news_id );
	vaarta_e2e_menu_item( $fullscreen_id, 'Culture', home_url( '/?s=culture' ), $stories_id );
}

$locations                = (array) get_theme_mod( 'nav_menu_locations', array() );
$locations['primary']      = $primary_id;
$locations['mobile']       = $primary_id;
$locations['fullscreen']   = $fullscreen_id;
set_theme_mod( 'nav_menu_locations', $locations );

set_theme_mod( 'header_navigation_menu', true );
set_theme_mod( 'header_search_button', true );
set_theme_mod( 'header_fullscreen_menu', true );
set_theme_mod( 'color_scheme_toggle', true );
set_theme_mod( 'color_scheme', 'system' );
set_theme_mod( 'post_share_link', true );
set_theme_mod( 'post_comments_simple', false );

if ( ! get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'numberposts' => 1 ) ) ) {
	for ( $index = 1; $index <= 3; $index++ ) {
		wp_insert_post(
			array(
				'post_title'    => sprintf( 'Vaarta Test Story %d', $index ),
				'post_content'  => str_repeat( 'Editorial test content. ', 30 ),
				'post_status'   => 'publish',
				'post_type'     => 'post',
				'comment_status' => 'open',
			)
		);
	}
}