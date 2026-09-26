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

/**
 * Add a category-backed mega-menu item.
 *
 * @param int    $menu_id Menu ID.
 * @param int    $term_id Category term ID.
 * @param string $title   Menu label.
 * @return int
 */
function vaarta_e2e_mega_menu_item( $menu_id, $term_id, $title ) {
	$item_id = wp_update_nav_menu_item(
		$menu_id,
		0,
		array(
			'menu-item-title'     => $title,
			'menu-item-object-id' => $term_id,
			'menu-item-object'    => 'category',
			'menu-item-type'      => 'taxonomy',
			'menu-item-status'    => 'publish',
		)
	);

	if ( is_wp_error( $item_id ) ) {
		throw new RuntimeException( $item_id->get_error_message() );
	}

	update_post_meta( $item_id, 'menu-item-cs-mega-menu', '1' );
	return (int) $item_id;
}

$mega_term = get_term_by( 'slug', 'vaarta-mega-news', 'category' );
if ( ! $mega_term ) {
	$created = wp_insert_term( 'Vaarta Mega News', 'category', array( 'slug' => 'vaarta-mega-news' ) );
	if ( is_wp_error( $created ) ) {
		throw new RuntimeException( $created->get_error_message() );
	}
	$mega_term = get_term( (int) $created['term_id'], 'category' );
}
$mega_term_id = (int) $mega_term->term_id;

$primary_id    = vaarta_e2e_menu( 'Primary Navigation' );
$fullscreen_id = vaarta_e2e_menu( 'Fullscreen Navigation' );

$primary_items = wp_get_nav_menu_items( $primary_id );
if ( ! $primary_items ) {
	vaarta_e2e_menu_item( $primary_id, 'Home', home_url( '/' ) );
	$primary_items = wp_get_nav_menu_items( $primary_id );
}

$has_mega_item = false;
foreach ( (array) $primary_items as $primary_item ) {
	if ( 'category' === $primary_item->object && $mega_term_id === (int) $primary_item->object_id ) {
		update_post_meta( $primary_item->ID, 'menu-item-cs-mega-menu', '1' );
		$has_mega_item = true;
		break;
	}
}
if ( ! $has_mega_item ) {
	vaarta_e2e_mega_menu_item( $primary_id, $mega_term_id, 'Mega News' );
}

if ( ! wp_get_nav_menu_items( $fullscreen_id ) ) {
	$stories_id = vaarta_e2e_menu_item( $fullscreen_id, 'Stories', '#' );
	$news_id    = vaarta_e2e_menu_item( $fullscreen_id, 'News', '#', $stories_id );
	vaarta_e2e_menu_item( $fullscreen_id, 'World', home_url( '/?s=world' ), $news_id );
	vaarta_e2e_menu_item( $fullscreen_id, 'Culture', home_url( '/?s=culture' ), $stories_id );
}

$locations              = (array) get_theme_mod( 'nav_menu_locations', array() );
$locations['primary']    = $primary_id;
$locations['mobile']     = $primary_id;
$locations['fullscreen'] = $fullscreen_id;
set_theme_mod( 'nav_menu_locations', $locations );

set_theme_mod( 'header_navigation_menu', true );
set_theme_mod( 'header_search_button', true );
set_theme_mod( 'header_fullscreen_menu', true );
set_theme_mod( 'color_scheme_toggle', true );
set_theme_mod( 'color_scheme', 'system' );
set_theme_mod( 'post_share_link', true );
set_theme_mod( 'post_comments_simple', false );
set_theme_mod( 'post_load_nextpost', true );
set_theme_mod( 'post_load_nextpost_same_category', false );
set_theme_mod( 'post_load_nextpost_reverse', false );

// Keep archive pagination deterministic so the browser suite exercises the
// native Vaarta load-more transport against a real second query page.
update_option( 'posts_per_page', 2 );

for ( $index = 1; $index <= 3; $index++ ) {
	$title = sprintf( 'Vaarta Test Story %d', $index );
	$slug  = sanitize_title( $title );
	$post  = get_page_by_path( $slug, OBJECT, 'post' );

	if ( $post ) {
		$post_id = (int) $post->ID;
	} else {
		$post_date = sprintf( '2026-01-%02d 12:00:00', $index );
		$post_id   = wp_insert_post(
			array(
				'post_title'     => $title,
				'post_name'      => $slug,
				'post_content'   => str_repeat( 'Editorial test content. ', 30 ),
				'post_status'    => 'publish',
				'post_type'      => 'post',
				'post_date'      => $post_date,
				'post_date_gmt'  => get_gmt_from_date( $post_date ),
				'comment_status' => 'open',
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			throw new RuntimeException( $post_id->get_error_message() );
		}
	}

	$result = wp_set_post_terms( $post_id, array( $mega_term_id ), 'category', true );
	if ( is_wp_error( $result ) ) {
		throw new RuntimeException( $result->get_error_message() );
	}
}