<?php
/**
 * Miscellaneous Settings
 *
 * @package Caards
 */

CSCO_Customizer::add_section(
	'miscellaneous',
	array(
		'title' => esc_html__( 'Miscellaneous Settings', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'misc_published_date',
		'label'    => esc_html__( 'Display published date instead of modified date', 'caards' ),
		'section'  => 'miscellaneous',
		'default'  => true,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'text',
		'settings' => 'misc_search_placeholder',
		'label'    => esc_html__( 'Search Form Placeholder', 'caards' ),
		'section'  => 'miscellaneous',
		'default'  => esc_html__( 'Enter keyword', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'text',
		'settings' => 'misc_label_more',
		'label'    => esc_html__( '"Read More" Button Label', 'caards' ),
		'section'  => 'miscellaneous',
		'default'  => esc_html__( 'Read More', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'misc_sticky_sidebar',
		'label'    => esc_html__( 'Sticky Sidebar', 'caards' ),
		'section'  => 'miscellaneous',
		'default'  => true,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'radio',
		'settings'        => 'misc_sticky_sidebar_method',
		'label'           => esc_html__( 'Sticky Method', 'caards' ),
		'section'         => 'miscellaneous',
		'default'         => 'cs-stick-to-top',
		'choices'         => array(
			'cs-stick-to-top'    => esc_html__( 'Sidebar top edge', 'caards' ),
			'cs-stick-to-bottom' => esc_html__( 'Sidebar bottom edge', 'caards' ),
			'cs-stick-last'      => esc_html__( 'Last widget top edge', 'caards' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'misc_sticky_sidebar',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
