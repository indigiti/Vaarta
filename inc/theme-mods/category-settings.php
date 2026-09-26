<?php
/**
 * Category Settings
 *
 * @package Caards
 */

CSCO_Customizer::add_section(
	'category_settings',
	array(
		'title' => esc_html__( 'Category Settings', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'category_subcategories',
		'label'    => esc_html__( 'Display subcategory filter', 'caards' ),
		'section'  => 'category_settings',
		'default'  => false,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'              => 'text',
		'settings'          => 'category_subtitle',
		'label'             => esc_html__( 'Subtitle', 'caards' ),
		'section'           => 'category_settings',
		'default'           => esc_html__( 'Browsing Category', 'caards' ),
		'sanitize_callback' => 'csco_kses',
	)
);
