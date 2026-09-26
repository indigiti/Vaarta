<?php
/**
 * Vaarta block pattern categories.
 *
 * Pattern files in /patterns are discovered by WordPress. This file only
 * establishes stable Vaarta categories so editorial compositions stay grouped
 * independently from legacy Canvas layouts.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Vaarta pattern categories.
 */
function vaarta_register_pattern_categories() {
	register_block_pattern_category(
		'vaarta-home',
		array(
			'label'       => esc_html__( 'Vaarta Home', 'caards' ),
			'description' => esc_html__( 'Editorial homepage compositions built with native Vaarta blocks.', 'caards' ),
		)
	);

	register_block_pattern_category(
		'vaarta-editorial',
		array(
			'label'       => esc_html__( 'Vaarta Editorial', 'caards' ),
			'description' => esc_html__( 'Reusable story grids, rails, and category sections.', 'caards' ),
		)
	);
}
add_action( 'init', 'vaarta_register_pattern_categories' );
