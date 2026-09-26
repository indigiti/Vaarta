<?php
/**
 * Footer Settings
 *
 * @package Caards
 */

CSCO_Customizer::add_section(
	'footer',
	array(
		'title' => esc_html__( 'Footer Settings', 'caards' ),
	)
);


CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'footer_collapsible_common',
		'label'       => esc_html__( 'Common', 'caards' ),
		'section'     => 'footer',
		'input_attrs' => array(
			'collapsed' => true,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'radio',
		'settings' => 'footer_layout',
		'label'    => esc_html__( 'Layout', 'caards' ),
		'section'  => 'footer',
		'default'  => 'one',
		'choices'  => apply_filters( 'csco_footer_layouts', array(
			'one'   => esc_html__( 'Footer 1', 'caards' ),
			'two'   => esc_html__( 'Footer 2', 'caards' ),
			'three' => esc_html__( 'Footer 3', 'caards' ),
			'four'  => esc_html__( 'Footer 4', 'caards' ),
		) ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'              => 'textarea',
		'settings'          => 'footer_description',
		'label'             => esc_html__( 'Footer Description', 'caards' ),
		'section'           => 'footer',
		'sanitize_callback' => 'csco_kses',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'              => 'textarea',
		'settings'          => 'footer_copyright',
		'label'             => esc_html__( 'Footer Copyright', 'caards' ),
		'section'           => 'footer',
		/* translators: %s: Author name. */
		'default'           => sprintf( esc_html__( 'All Rights Reserved © %s Caards %s', 'caards' ), date( 'Y' ), '<a href="' . esc_url( csco_get_theme_data( 'AuthorURI' ) ) . '">Code Supply Co.</a>' ),
		'sanitize_callback' => 'csco_kses',
		'active_callback'   => array(
			array(
				'setting'  => 'footer_layout',
				'operator' => '!=',
				'value'    => 'two',
			),
		),
	)
);

if ( csco_powerkit_module_enabled( 'social_links' ) ) {
	CSCO_Customizer::add_field(
		array(
			'type'            => 'collapsible',
			'settings'        => 'footer_collapsible_social',
			'label'           => esc_html__( 'Social Links', 'caards' ),
			'section'         => 'footer',
			'active_callback' => array(
				array(
					'setting'  => 'footer_layout',
					'operator' => '!=',
					'value'    => 'four',
				),
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'            => 'checkbox',
			'settings'        => 'footer_social_links',
			'label'           => esc_html__( 'Display social links', 'caards' ),
			'section'         => 'footer',
			'default'         => false,
			'active_callback' => array(
				array(
					'setting'  => 'footer_layout',
					'operator' => '!=',
					'value'    => 'four',
				),
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'            => 'select',
			'settings'        => 'footer_social_links_scheme',
			'label'           => esc_html__( 'Color scheme', 'caards' ),
			'section'         => 'footer',
			'default'         => 'light',
			'choices'         => array(
				'light' => esc_html__( 'Light', 'caards' ),
				'bold'  => esc_html__( 'Bold', 'caards' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'footer_layout',
					'operator' => '!=',
					'value'    => 'four',
				),
				array(
					'setting'  => 'footer_social_links',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'            => 'number',
			'settings'        => 'footer_social_links_maximum',
			'label'           => esc_html__( 'Maximum Number of Social Links', 'caards' ),
			'section'         => 'footer',
			'default'         => 4,
			'active_callback' => array(
				array(
					'setting'  => 'footer_layout',
					'operator' => '!=',
					'value'    => 'four',
				),
				array(
					'setting'  => 'footer_social_links',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'            => 'checkbox',
			'settings'        => 'footer_social_links_counts',
			'label'           => esc_html__( 'Display counts', 'caards' ),
			'section'         => 'footer',
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'footer_layout',
					'operator' => '!=',
					'value'    => 'four',
				),
				array(
					'setting'  => 'footer_social_links',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
}

if ( csco_powerkit_module_enabled( 'opt_in_forms' ) ) {
	CSCO_Customizer::add_field(
		array(
			'type'     => 'collapsible',
			'settings' => 'footer_collapsible_subscription',
			'label'    => esc_html__( 'Subscription Form', 'caards' ),
			'section'  => 'footer',

		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'     => 'checkbox',
			'settings' => 'footer_subscribe',
			'label'    => esc_html__( 'Display subscribe section', 'caards' ),
			'section'  => 'footer',
			'default'  => false,

		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'            => 'checkbox',
			'settings'        => 'footer_subscribe_name',
			'label'           => esc_html__( 'Display first name field', 'caards' ),
			'section'         => 'footer',
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'footer_subscribe',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'              => 'text',
			'settings'          => 'footer_subscribe_title',
			'label'             => esc_html__( 'Title', 'caards' ),
			'section'           => 'footer',
			'default'           => esc_html__( 'Subscribe to our newsletter', 'caards' ),
			'sanitize_callback' => 'csco_kses',
			'active_callback'   => array(
				array(
					'setting'  => 'footer_subscribe',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'              => 'text',
			'settings'          => 'footer_subscribe_text',
			'label'             => esc_html__( 'Text', 'caards' ),
			'section'           => 'footer',
			'default'           => esc_html__( 'Get notified of the best deals on our WordPress themes.', 'caards' ),
			'sanitize_callback' => 'csco_kses',
			'active_callback'   => array(
				array(
					'setting'  => 'footer_subscribe',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
}
