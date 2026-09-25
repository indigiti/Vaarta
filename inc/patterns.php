<?php
/**
 * Pattern categories.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vaarta_register_pattern_categories(): void {
	$categories = array(
		'vaarta'            => __( 'Vaarta', 'vaarta' ),
		'vaarta-heroes'     => __( 'Vaarta Heroes', 'vaarta' ),
		'vaarta-editorial'  => __( 'Vaarta Editorial', 'vaarta' ),
		'vaarta-promo'      => __( 'Vaarta Promo', 'vaarta' ),
		'vaarta-newsletter' => __( 'Vaarta Newsletter', 'vaarta' ),
	);

	foreach ( $categories as $slug => $label ) {
		register_block_pattern_category( $slug, array( 'label' => $label ) );
	}
}
add_action( 'init', 'vaarta_register_pattern_categories' );
