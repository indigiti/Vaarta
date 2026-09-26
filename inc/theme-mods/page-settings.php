<?php
/**
 * Page Settings
 *
 * @package Caards
 */

CSCO_Customizer::add_section(
	'page_settings',
	array(
		'title' => esc_html__( 'Page Settings', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'radio',
		'settings' => 'page_sidebar',
		'label'    => esc_html__( 'Default Sidebar', 'caards' ),
		'section'  => 'page_settings',
		'default'  => 'right',
		'choices'  => array(
			'right'    => esc_html__( 'Right Sidebar', 'caards' ),
			'left'     => esc_html__( 'Left Sidebar', 'caards' ),
			'disabled' => esc_html__( 'No Sidebar', 'caards' ),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'radio',
		'settings' => 'page_header_type',
		'label'    => esc_html__( 'Page Header Type', 'caards' ),
		'section'  => 'page_settings',
		'default'  => 'standard',
		'choices'  => array(
			'standard' => esc_html__( 'Standard', 'caards' ),
			'large'    => esc_html__( 'Large', 'caards' ),
			'full'     => esc_html__( 'Full', 'caards' ),
			'title'    => esc_html__( 'Page Title Only', 'caards' ),
			'none'     => esc_html__( 'None', 'caards' ),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'radio',
		'settings'        => 'page_media_preview',
		'label'           => esc_html__( 'Standard Page Header Preview', 'caards' ),
		'section'         => 'page_settings',
		'default'         => 'uncropped',
		'choices'         => array(
			'cropped'   => esc_html__( 'Display Cropped Image', 'caards' ),
			'uncropped' => esc_html__( 'Display Preview in Original Ratio', 'caards' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'page_header_type',
				'operator' => '==',
				'value'    => 'standard',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'page_comments_simple',
		'label'    => esc_html__( 'Display comments without the View Comments button', 'caards' ),
		'section'  => 'page_settings',
		'default'  => false,
	)
);
