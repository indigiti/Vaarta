<?php
/**
 * Vaarta styles for WordPress Core blocks.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register visual variations for Core blocks.
 */
function vaarta_register_block_styles(): void {
	$styles = array(
		'core/group' => array(
			'vaarta-card'      => __( 'Vaarta Card', 'vaarta' ),
			'vaarta-dark-card' => __( 'Vaarta Dark Card', 'vaarta' ),
			'vaarta-alert'     => __( 'Vaarta Alert', 'vaarta' ),
		),
		'core/image' => array(
			'vaarta-editorial-image' => __( 'Editorial Image', 'vaarta' ),
		),
		'core/separator' => array(
			'vaarta-hairline' => __( 'Vaarta Hairline', 'vaarta' ),
		),
		'core/details' => array(
			'vaarta-accordion' => __( 'Vaarta Accordion', 'vaarta' ),
		),
		'core/paragraph' => array(
			'vaarta-badge'    => __( 'Vaarta Badge', 'vaarta' ),
			'vaarta-drop-cap' => __( 'Vaarta Drop Cap', 'vaarta' ),
		),
		'core/list' => array(
			'vaarta-check-list' => __( 'Vaarta Check List', 'vaarta' ),
		),
		'core/heading' => array(
			'vaarta-numbered' => __( 'Vaarta Numbered', 'vaarta' ),
		),
		'core/social-links' => array(
			'vaarta-pills' => __( 'Vaarta Pills', 'vaarta' ),
		),
	);

	foreach ( $styles as $block_name => $block_styles ) {
		foreach ( $block_styles as $name => $label ) {
			register_block_style(
				$block_name,
				array(
					'name'  => $name,
					'label' => $label,
				)
			);
		}
	}
}
add_action( 'init', 'vaarta_register_block_styles' );
