<?php
/**
 * Runtime contract for Vaarta-owned editorial components and card renderers.
 *
 * Executed through WP-CLI inside wp-env before the browser suite.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fail the contract when an assertion is not satisfied.
 *
 * @param bool   $condition Assertion result.
 * @param string $message   Failure description.
 * @return void
 */
function vaarta_test_editorial_assert( $condition, $message ) {
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
}

/**
 * Capture renderer output.
 *
 * @param callable $callback Renderer.
 * @param array    $args     Positional arguments.
 * @return string
 */
function vaarta_test_editorial_output( $callback, $args = array() ) {
	ob_start();
	call_user_func_array( $callback, $args );
	return (string) ob_get_clean();
}

$test_post = get_page_by_path( 'vaarta-test-story-1', OBJECT, 'post' );
vaarta_test_editorial_assert( $test_post instanceof WP_Post, 'Seeded editorial test post is unavailable.' );

$original_post        = isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null;
$original_wp_query    = isset( $GLOBALS['wp_query'] ) ? $GLOBALS['wp_query'] : null;
$original_post_format = get_post_format( $test_post->ID );

try {
	$native_functions = array(
		'vaarta_get_primary_category_data',
		'vaarta_render_post_format_icon',
		'vaarta_render_post_subtitle',
		'vaarta_render_post_category',
		'vaarta_render_post_author',
		'vaarta_render_archive_post_description',
		'vaarta_render_archive_post_count',
		'vaarta_render_subcategories',
		'vaarta_render_card_thumbnail',
		'vaarta_render_card_overlay_thumbnail',
		'vaarta_render_card_title',
		'vaarta_render_card_excerpt',
		'vaarta_render_card_more',
		'vaarta_render_card_footer',
		'vaarta_render_card_author',
		'vaarta_render_card_category',
	);

	foreach ( $native_functions as $function_name ) {
		vaarta_test_editorial_assert( function_exists( $function_name ), 'Missing Vaarta editorial function: ' . $function_name );
	}

	$ownership = array(
		'csco_the_post_format_icon' => '/inc/vaarta-editorial-components.php',
		'csco_post_category'        => '/inc/vaarta-editorial-components.php',
		'csco_post_author'          => '/inc/vaarta-editorial-components.php',
		'csco_archive_post_count'   => '/inc/vaarta-editorial-components.php',
		'csco_block_post_thumbnail' => '/inc/vaarta-card-renderers.php',
		'csco_block_post_title'     => '/inc/vaarta-card-renderers.php',
		'csco_block_post_excerpt'   => '/inc/vaarta-card-renderers.php',
		'csco_block_post_footer'    => '/inc/vaarta-card-renderers.php',
		'csco_block_post_category'  => '/inc/vaarta-card-renderers.php',
	);

	foreach ( $ownership as $function_name => $expected_suffix ) {
		vaarta_test_editorial_assert( function_exists( $function_name ), 'Missing compatibility wrapper: ' . $function_name );
		$reflection = new ReflectionFunction( $function_name );
		$filename   = wp_normalize_path( (string) $reflection->getFileName() );
		vaarta_test_editorial_assert(
			str_ends_with( $filename, $expected_suffix ),
			$function_name . ' is not owned by the expected Vaarta module; actual=' . $filename
		);
	}

	$GLOBALS['post'] = $test_post;
	setup_postdata( $test_post );

	$category = vaarta_get_primary_category_data( $test_post->ID );
	vaarta_test_editorial_assert( is_array( $category ), 'Primary-category presentation data was not resolved.' );
	vaarta_test_editorial_assert( ! empty( $category['name'] ), 'Primary-category presentation is missing a name.' );
	vaarta_test_editorial_assert( ! empty( $category['link'] ), 'Primary-category presentation is missing a link.' );

	$native_author = vaarta_test_editorial_output( 'vaarta_render_post_author' );
	$legacy_author = vaarta_test_editorial_output( 'csco_post_author' );
	foreach ( array( $native_author, $legacy_author ) as $author_output ) {
		vaarta_test_editorial_assert( false !== strpos( $author_output, 'cs-entry__author-inner' ), 'Post-author renderer lost its DOM contract.' );
	}

	$title_options = array(
		'typography_heading_tag' => 'h3',
	);
	$native_title = vaarta_test_editorial_output( 'vaarta_render_card_title', array( $title_options ) );
	$legacy_title = vaarta_test_editorial_output( 'csco_block_post_title', array( $title_options ) );
	foreach ( array( $native_title, $legacy_title ) as $title_output ) {
		vaarta_test_editorial_assert( false !== strpos( $title_output, 'cs-entry__title' ), 'Card-title renderer lost its CSS class contract.' );
		vaarta_test_editorial_assert( false !== strpos( $title_output, 'Vaarta Test Story 1' ), 'Card-title renderer lost the current post title.' );
	}

	$excerpt_options = array(
		'display_excerpt' => true,
		'excerpt_length'  => 12,
	);
	$native_excerpt = vaarta_test_editorial_output( 'vaarta_render_card_excerpt', array( $excerpt_options ) );
	$legacy_excerpt = vaarta_test_editorial_output( 'csco_block_post_excerpt', array( $excerpt_options ) );
	foreach ( array( $native_excerpt, $legacy_excerpt ) as $excerpt_output ) {
		vaarta_test_editorial_assert( false !== strpos( $excerpt_output, 'cs-entry__excerpt' ), 'Card-excerpt renderer lost its CSS class contract.' );
	}

	$more_options = array(
		'display_more_button' => true,
		'more_button_label'   => 'Continue Reading',
	);
	$native_more = vaarta_test_editorial_output( 'vaarta_render_card_more', array( $more_options ) );
	$legacy_more = vaarta_test_editorial_output( 'csco_block_post_more', array( $more_options ) );
	foreach ( array( $native_more, $legacy_more ) as $more_output ) {
		vaarta_test_editorial_assert( false !== strpos( $more_output, 'cs-entry__read-more' ), 'Card read-more renderer lost its CSS class contract.' );
		vaarta_test_editorial_assert( false !== strpos( $more_output, 'Continue Reading' ), 'Card read-more renderer lost its configured label.' );
	}

	$native_footer = vaarta_test_editorial_output( 'vaarta_render_card_footer', array( array(), null, true, array( 'readmore_label' => 'Read More' ) ) );
	$legacy_footer = vaarta_test_editorial_output( 'csco_block_post_footer', array( array(), null, true, array( 'readmore_label' => 'Read More' ) ) );
	foreach ( array( $native_footer, $legacy_footer ) as $footer_output ) {
		vaarta_test_editorial_assert( false !== strpos( $footer_output, 'cs-entry__footer' ), 'Card-footer renderer lost its CSS class contract.' );
		vaarta_test_editorial_assert( false !== strpos( $footer_output, 'cs-entry__read-more' ), 'Card-footer renderer lost its read-more contract.' );
	}

	$card_author_options = array(
		'top_meta'            => 'author',
		'post_author_details' => true,
	);
	$card_author = vaarta_test_editorial_output( 'csco_block_post_author', array( $card_author_options ) );
	vaarta_test_editorial_assert( false !== strpos( $card_author, 'cs-entry__details-author' ), 'Card-author renderer lost its DOM contract.' );

	$card_category = vaarta_test_editorial_output( 'csco_block_post_category', array( array( 'post_category_label' => true ) ) );
	vaarta_test_editorial_assert( false !== strpos( $card_category, 'cs-entry__category' ), 'Card-category renderer lost its DOM contract.' );
	vaarta_test_editorial_assert( false !== strpos( $card_category, 'cs-entry__category-label' ), 'Card-category label contract was not preserved.' );

	set_post_format( $test_post->ID, 'video' );
	$native_format = vaarta_test_editorial_output( 'vaarta_render_post_format_icon' );
	$legacy_format = vaarta_test_editorial_output( 'csco_the_post_format_icon' );
	foreach ( array( $native_format, $legacy_format ) as $format_output ) {
		vaarta_test_editorial_assert( false !== strpos( $format_output, 'cs-entry-format' ), 'Post-format renderer lost its DOM contract.' );
		vaarta_test_editorial_assert( false !== strpos( $format_output, 'cs-format-video' ), 'Post-format renderer lost the format-specific class.' );
	}

	$GLOBALS['wp_query']              = new WP_Query();
	$GLOBALS['wp_query']->found_posts = 3;
	$archive_count = vaarta_test_editorial_output( 'csco_archive_post_count' );
	vaarta_test_editorial_assert( false !== strpos( $archive_count, 'cs-page__archive-count' ), 'Archive-count renderer lost its DOM contract.' );
	vaarta_test_editorial_assert( false !== strpos( $archive_count, '3 posts' ), 'Archive-count renderer lost the post count.' );
} finally {
	if ( $original_post_format ) {
		set_post_format( $test_post->ID, $original_post_format );
	} else {
		set_post_format( $test_post->ID, false );
	}

	wp_reset_postdata();
	$GLOBALS['post']     = $original_post;
	$GLOBALS['wp_query'] = $original_wp_query;
}

fwrite( STDOUT, "Vaarta editorial component contract passed.\n" );
