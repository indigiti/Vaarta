<?php
/**
 * All core theme actions.
 *
 * Please do not modify this file directly.
 * You may remove actions in your child theme by using remove_action().
 *
 * Please see /inc/partials.php for the list of partials,
 * added to actions.
 *
 * @package Caards
 */

/**
 * Body
 */

add_action( 'csco_site_before', 'csco_offcanvas', 10 );
add_action( 'csco_site_before', 'csco_fullscreen_menu', 20 );

/**
 * Main
 */
add_action( 'csco_main_before', 'csco_page_header', 100 );

/**
 * Category
 */
add_action( 'csco_page_header_after', 'csco_subcategories', 10 );

/**
 * Singular
 */
add_action( 'csco_entry_content_before', 'csco_singular_post_type_before', 10 );
add_action( 'csco_entry_content_after', 'csco_singular_post_type_after', 999 );

/**
 * Entry Header
 */
add_action( 'csco_entry_content_before', 'csco_entry_header', 10 );
add_action( 'csco_main_content_before', 'csco_entry_header_large', 10 );
add_action( 'csco_site_content_start', 'csco_entry_header_full', 10 );

/**
 * Entry Elements
 */
add_action( 'csco_entry_container_start', 'csco_entry_metabar', 10 );

/**
 * Entry Sections
 */
add_action( 'csco_entry_content_after', 'csco_page_pagination', 10 );
add_action( 'csco_entry_content_after', 'csco_entry_tags', 20 );
add_action( 'csco_entry_content_after', 'csco_entry_share', 30 );
add_action( 'csco_entry_content_after', 'csco_entry_author', 40 );
add_action( 'csco_entry_content_after', 'csco_entry_subscribe', 50 );
add_action( 'csco_entry_content_after', 'csco_entry_prev_next', 60 );
add_action( 'csco_entry_content_after', 'csco_entry_comments', 70 );
add_action( 'csco_main_content_after', 'csco_entry_related', 10 );

/**
 * Template Page
 */
add_action( 'csco_entry_content_after', 'csco_meet_team', 10 );

/**
 * Footer
 */
add_action( 'csco_footer_before', 'csco_site_subscribe', 10 );
