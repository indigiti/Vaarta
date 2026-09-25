<?php
/**
 * Vaarta styles for WordPress Core blocks.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vaarta_register_block_styles(): void {
	register_block_style(
		'core/group',
		array(
			'name'  => 'vaarta-card',
			'label' => __( 'Vaarta Card', 'vaarta' ),
		)
	);

	register_block_style(
		'core/group',
		array(
			'name'  => 'vaarta-dark-card',
			'label' => __( 'Vaarta Dark Card', 'vaarta' ),
		)
	);

	register_block_style(
		'core/image',
		array(
			'name'  => 'vaarta-editorial-image',
			'label' => __( 'Editorial Image', 'vaarta' ),
		)
	);

	register_block_style(
		'core/separator',
		array(
			'name'  => 'vaarta-hairline',
			'label' => __( 'Vaarta Hairline', 'vaarta' ),
		)
	);
}
add_action( 'init', 'vaarta_register_block_styles' );
