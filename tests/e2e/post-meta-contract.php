<?php
/**
 * Runtime contract for Vaarta-owned post metadata and retired legacy files.
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
function vaarta_test_meta_assert( $condition, $message ) {
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
}

$test_post = get_page_by_path( 'vaarta-test-story-1', OBJECT, 'post' );
vaarta_test_meta_assert( $test_post instanceof WP_Post, 'Seeded post-meta test post is unavailable.' );

$original_post = isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null;
$test_option   = 'vaarta_contract_post_meta';
$had_field     = isset( CSCO_Customizer::$fields[ $test_option ] );
$old_field     = $had_field ? CSCO_Customizer::$fields[ $test_option ] : null;
$old_mod       = get_theme_mod( $test_option, null );

try {
	$native_functions = array(
		'vaarta_get_post_meta_types',
		'vaarta_block_post_meta',
		'vaarta_block_normalize_meta',
		'vaarta_get_post_meta_renderer_registry',
		'vaarta_render_post_meta_type',
		'vaarta_get_post_meta',
		'vaarta_get_meta_category',
		'vaarta_get_meta_date',
		'vaarta_get_meta_author',
		'vaarta_get_meta_comments',
		'vaarta_get_meta_reading_time',
		'vaarta_get_meta_views',
		'vaarta_get_meta_shares',
	);

	foreach ( $native_functions as $function_name ) {
		vaarta_test_meta_assert( function_exists( $function_name ), 'Missing Vaarta post-meta function: ' . $function_name );
	}

	$compatibility_functions = array(
		'csco_block_post_meta',
		'csco_block_normalize_meta',
		'csco_get_post_meta',
		'csco_get_meta_category',
		'csco_get_meta_date',
		'csco_get_meta_author',
		'csco_get_meta_comments',
		'csco_get_meta_reading_time',
		'csco_get_meta_views',
		'csco_get_meta_shares',
	);

	foreach ( $compatibility_functions as $function_name ) {
		vaarta_test_meta_assert( function_exists( $function_name ), 'Missing post-meta compatibility wrapper: ' . $function_name );
		$reflection = new ReflectionFunction( $function_name );
		$filename   = wp_normalize_path( (string) $reflection->getFileName() );
		vaarta_test_meta_assert(
			str_ends_with( $filename, '/inc/vaarta-post-meta.php' ),
			$function_name . ' is not owned by vaarta-post-meta.php; actual=' . $filename
		);
	}

	$included_files = array_map( 'wp_normalize_path', get_included_files() );
	foreach ( array( '/inc/theme-tags.php', '/inc/post-meta.php' ) as $legacy_suffix ) {
		$loaded = array_filter(
			$included_files,
			static function ( $filename ) use ( $legacy_suffix ) {
				return str_ends_with( $filename, $legacy_suffix );
			}
		);
		vaarta_test_meta_assert( empty( $loaded ), 'Retired legacy runtime file is still included: ' . $legacy_suffix );
	}

	$functions_source = file_get_contents( get_theme_file_path( '/functions.php' ) );
	vaarta_test_meta_assert( false !== $functions_source, 'Unable to inspect functions.php.' );
	vaarta_test_meta_assert(
		false === strpos( $functions_source, "require_once get_theme_file_path( '/inc/theme-tags.php' );" ),
		'functions.php still bootstraps inc/theme-tags.php.'
	);
	vaarta_test_meta_assert(
		false === strpos( $functions_source, "require_once get_theme_file_path( '/inc/post-meta.php' );" ),
		'functions.php still bootstraps inc/post-meta.php.'
	);

	$GLOBALS['post'] = $test_post;
	setup_postdata( $test_post );

	$requested = array( 'category', 'author', 'date' );
	$settings  = array( 'container' => true );
	$native    = vaarta_get_post_meta( $requested, false, false, $requested, $settings );
	$legacy    = csco_get_post_meta( $requested, false, false, $requested, $settings );

	foreach ( array( $native, $legacy ) as $markup ) {
		vaarta_test_meta_assert( false !== strpos( $markup, 'cs-entry__post-meta' ), 'Metadata container contract was lost.' );
		vaarta_test_meta_assert( false !== strpos( $markup, 'cs-meta-category' ), 'Category metadata contract was lost.' );
		vaarta_test_meta_assert( false !== strpos( $markup, 'cs-meta-author' ), 'Author metadata contract was lost.' );
		vaarta_test_meta_assert( false !== strpos( $markup, 'cs-meta-date' ), 'Date metadata contract was lost.' );
	}

	$block_settings = array(
		'display_meta_category' => true,
		'display_meta_date'     => true,
		'meta-settings'         => array(
			'container' => false,
		),
	);
	$block_markup = csco_block_post_meta( $block_settings, array( 'category', 'date', 'author' ), false );
	vaarta_test_meta_assert( false !== strpos( $block_markup, 'cs-meta-category' ), 'Block metadata lost category output.' );
	vaarta_test_meta_assert( false !== strpos( $block_markup, 'cs-meta-date' ), 'Block metadata lost date output.' );
	vaarta_test_meta_assert( false === strpos( $block_markup, 'cs-meta-author' ), 'Block metadata ignored its allowlist.' );

	CSCO_Customizer::$fields[ $test_option ] = array(
		'default' => array( 'date' ),
	);
	set_theme_mod( $test_option, array( 'date', 'author' ) );
	$normalized = csco_block_normalize_meta( array(), $test_option );
	vaarta_test_meta_assert( true === $normalized['display_meta_date'], 'Metadata normalization lost the date flag.' );
	vaarta_test_meta_assert( true === $normalized['display_meta_author'], 'Metadata normalization lost the author flag.' );
	vaarta_test_meta_assert( false === $normalized['display_meta_category'], 'Metadata normalization enabled an unselected type.' );

	$custom_renderer = static function ( $tag ) {
		return '<' . tag_escape( $tag ) . ' class="vaarta-contract-meta">Contract meta</' . tag_escape( $tag ) . '>';
	};
	$registry_filter = static function ( $registry ) use ( $custom_renderer ) {
		$registry['contract'] = $custom_renderer;
		return $registry;
	};
	add_filter( 'vaarta_post_meta_renderer_registry', $registry_filter );
	$custom_markup = vaarta_get_post_meta( array( 'contract' ), false, false, array( 'contract' ), array( 'container' => false ) );
	remove_filter( 'vaarta_post_meta_renderer_registry', $registry_filter );
	vaarta_test_meta_assert( false !== strpos( $custom_markup, 'vaarta-contract-meta' ), 'Post-meta registry extension did not render.' );
} finally {
	wp_reset_postdata();
	$GLOBALS['post'] = $original_post;

	if ( $had_field ) {
		CSCO_Customizer::$fields[ $test_option ] = $old_field;
	} else {
		unset( CSCO_Customizer::$fields[ $test_option ] );
	}

	if ( null === $old_mod ) {
		remove_theme_mod( $test_option );
	} else {
		set_theme_mod( $test_option, $old_mod );
	}
}

fwrite( STDOUT, "Vaarta post-meta contract passed.\n" );
