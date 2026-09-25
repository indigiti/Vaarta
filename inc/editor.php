<?php
/**
 * Block editor ergonomics.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add a dedicated Vaarta block category near the top of the inserter.
 *
 * @param array $categories Existing categories.
 * @return array
 */
function vaarta_block_category( array $categories ): array {
	$category = array(
		'slug'  => 'vaarta',
		'title' => __( 'Vaarta Editorial', 'vaarta' ),
		'icon'  => null,
	);

	array_splice( $categories, 1, 0, array( $category ) );

	return $categories;
}
add_filter( 'block_categories_all', 'vaarta_block_category' );
