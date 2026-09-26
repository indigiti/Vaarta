<?php
/**
 * Runtime contract for Vaarta-owned category presentation metadata.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vaarta_test_category_meta_assert( $condition, $message ) {
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
}

$original_user_id = get_current_user_id();
$original_post    = $_POST;
$term_id          = 0;

try {
	foreach ( array( 'vaarta_get_category_meta_schema', 'vaarta_category_meta_add_fields', 'vaarta_category_meta_edit_fields', 'vaarta_category_meta_save', 'vaarta_category_meta_enqueue_scripts' ) as $function_name ) {
		vaarta_test_category_meta_assert( function_exists( $function_name ), 'Missing Vaarta category-meta function: ' . $function_name );
	}

	foreach ( array( 'csco_mb_category_options_add', 'csco_mb_category_options_edit', 'csco_mb_category_options_save', 'csco_mb_category_enqueue_scripts' ) as $function_name ) {
		vaarta_test_category_meta_assert( function_exists( $function_name ), 'Missing category-meta compatibility wrapper: ' . $function_name );
		$reflection = new ReflectionFunction( $function_name );
		$filename   = wp_normalize_path( (string) $reflection->getFileName() );
		vaarta_test_category_meta_assert(
			str_ends_with( $filename, '/inc/vaarta-category-meta.php' ),
			$function_name . ' is not owned by vaarta-category-meta.php; actual=' . $filename
		);
	}

	$schema = vaarta_get_category_meta_schema();
	vaarta_test_category_meta_assert(
		array_keys( $schema ) === array( 'csco_letter_color', 'csco_gradient_start_color', 'csco_gradient_end_color' ),
		'Category presentation meta keys changed.'
	);

	$included_files = array_map( 'wp_normalize_path', get_included_files() );
	$legacy_loaded  = array_filter(
		$included_files,
		static function ( $filename ) {
			return str_ends_with( $filename, '/inc/metabox.php' );
		}
	);
	vaarta_test_category_meta_assert( empty( $legacy_loaded ), 'Retired inc/metabox.php is still included.' );

	$functions_source = file_get_contents( get_theme_file_path( '/functions.php' ) );
	vaarta_test_category_meta_assert( false !== $functions_source, 'Unable to inspect functions.php.' );
	vaarta_test_category_meta_assert(
		false === strpos( $functions_source, "require_once get_theme_file_path( '/inc/metabox.php' );" ),
		'functions.php still bootstraps inc/metabox.php.'
	);

	vaarta_test_category_meta_assert( false !== has_action( 'category_add_form_fields', 'csco_mb_category_options_add' ), 'Add-category hook is not registered.' );
	vaarta_test_category_meta_assert( false !== has_action( 'category_edit_form_fields', 'csco_mb_category_options_edit' ), 'Edit-category hook is not registered.' );
	vaarta_test_category_meta_assert( false !== has_action( 'edited_category', 'csco_mb_category_options_save' ), 'Category save hook is not registered.' );

	$admin = get_user_by( 'id', 1 );
	vaarta_test_category_meta_assert( $admin instanceof WP_User, 'Administrator fixture user is unavailable.' );
	wp_set_current_user( $admin->ID );

	$created = wp_insert_term( 'Vaarta Category Meta Contract', 'category' );
	vaarta_test_category_meta_assert( ! is_wp_error( $created ), 'Unable to create category-meta contract term.' );
	$term_id = (int) $created['term_id'];
	vaarta_test_category_meta_assert( current_user_can( 'edit_term', $term_id ), 'Contract administrator cannot edit the test category.' );

	$_POST = array(
		'vaarta_category_options_nonce' => wp_create_nonce( 'vaarta_category_options' ),
		'csco_letter_color'             => '#123456',
		'csco_gradient_start_color'     => 'not-a-color',
		'csco_gradient_end_color'       => '#abcdef',
	);
	csco_mb_category_options_save( $term_id, 0 );

	vaarta_test_category_meta_assert( '#123456' === get_term_meta( $term_id, 'csco_letter_color', true ), 'Letter color was not saved.' );
	vaarta_test_category_meta_assert( '' === get_term_meta( $term_id, 'csco_gradient_start_color', true ), 'Invalid gradient color was not rejected.' );
	vaarta_test_category_meta_assert( '#abcdef' === get_term_meta( $term_id, 'csco_gradient_end_color', true ), 'Gradient end color was not saved.' );

	$_POST = array(
		'vaarta_category_options_nonce' => 'invalid-nonce',
		'csco_letter_color'             => '#654321',
	);
	csco_mb_category_options_save( $term_id, 0 );
	vaarta_test_category_meta_assert( '#123456' === get_term_meta( $term_id, 'csco_letter_color', true ), 'Invalid nonce modified category metadata.' );

	ob_start();
	csco_mb_category_options_edit( get_term( $term_id, 'category' ), 'category' );
	$edit_markup = (string) ob_get_clean();
	vaarta_test_category_meta_assert( false !== strpos( $edit_markup, 'csco_letter_color' ), 'Category edit UI lost the letter-color field.' );
	vaarta_test_category_meta_assert( false !== strpos( $edit_markup, '#123456' ), 'Category edit UI lost the stored color value.' );
} finally {
	$_POST = $original_post;
	wp_set_current_user( $original_user_id );
	if ( $term_id ) {
		wp_delete_term( $term_id, 'category' );
	}
}

fwrite( STDOUT, "Vaarta category-meta contract passed.\n" );
