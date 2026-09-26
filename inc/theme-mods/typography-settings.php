<?php
/**
 * Typography
 *
 * @package Caards
 */

CSCO_Customizer::add_panel(
	'typography',
	array(
		'title' => esc_html__( 'Typography', 'caards' ),
	)
);

CSCO_Customizer::add_section(
	'typography_general',
	array(
		'title' => esc_html__( 'General', 'caards' ),
		'panel' => 'typography',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'typography_collapsible_general',
		'section'     => 'typography_general',
		'label'       => esc_html__( 'General', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_base',
		'label'    => esc_html__( 'Base Font', 'caards' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'Manrope',
			'font-size'      => '1rem',
			'variant'        => 'regular',
			'letter-spacing' => 'normal',
			'line-height'    => '1.5',
			'subsets'        => array( 'latin' ),
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'italic',
				'700',
				'700italic',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_primary',
		'label'    => esc_html__( 'Primary Font', 'caards' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.75rem',
			'variant'        => '600',
			'letter-spacing' => 'normal',
			'text-transform' => 'uppercase',
			'subsets'        => array( 'latin' ),
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'600',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'font_secondary',
		'label'       => esc_html__( 'Secondary Font', 'caards' ),
		'description' => esc_html__( 'Used for image captions and other secondary elements.', 'caards' ),
		'section'     => 'typography_general',
		'default'     => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.75rem',
			'variant'        => '600',
			'letter-spacing' => 'normal',
			'text-transform' => 'none',
			'subsets'        => array( 'latin' ),
		),
		'choices'     => array(
			'variant' => array(
				'regular',
				'600',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'typography_collapsible_elements',
		'section'     => 'typography_general',
		'label'       => esc_html__( 'Elements', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_post_meta',
		'label'    => esc_html__( 'Post Meta Font', 'caards' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'Manrope',
			'variant'        => '600',
			'subsets'        => array( 'latin' ),
			'font-size'      => '0.75rem',
			'letter-spacing' => '0.0125rem',
			'text-transform' => 'none',
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'600',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_details',
		'label'    => esc_html__( 'Details Font', 'caards' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.75rem',
			'variant'        => '600',
			'letter-spacing' => '0.0125rem',
			'text-transform' => 'uppercase',
			'subsets'        => array( 'latin' ),
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'600',
				'700',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_excerpt',
		'label'    => esc_html__( 'Excerpt Font', 'caards' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.875rem',
			'line-height'    => '1.75',
			'letter-spacing' => '-0.0125rem',
			'subsets'        => array( 'latin' ),
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'500',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_category',
		'label'    => esc_html__( 'Category Font', 'caards' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.75rem',
			'variant'        => '500',
			'letter-spacing' => '-0.025em',
			'text-transform' => 'uppercase',
			'subsets'        => array( 'latin' ),
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'500',
				'600',
				'700',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_category_letter',
		'label'    => esc_html__( 'Category Latter Font', 'caards' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'Manrope',
			'font-size'      => '1.25rem',
			'variant'        => '600',
			'letter-spacing' => 'normal',
			'text-transform' => 'uppercase',
			'subsets'        => array( 'latin' ),
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'500',
				'600',
				'700',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_post_number',
		'label'    => esc_html__( 'Post Number Font', 'caards' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'Manrope',
			'font-size'      => '1.25rem',
			'variant'        => '600',
			'letter-spacing' => 'normal',
			'text-transform' => 'uppercase',
			'subsets'        => array( 'latin' ),
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'500',
				'600',
				'700',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_tag',
		'label'    => esc_html__( 'Tags Font', 'caards' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.875rem',
			'variant'        => '600',
			'letter-spacing' => '-0.025em',
			'text-transform' => 'none',
			'subsets'        => array( 'latin' ),
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'600',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'typography_collapsible_post',
		'section'     => 'typography_general',
		'label'       => esc_html__( 'Post', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);


CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_post_subtitle',
		'label'    => esc_html__( 'Post Subtitle Font', 'caards' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'Manrope',
			'subsets'        => array( 'latin' ),
			'font-size'      => '1.75rem',
			'letter-spacing' => 'normal',
			'line-height'    => '1.25',
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'italic',
				'600',
				'700',
				'700italic',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_post_content',
		'label'    => esc_html__( 'Post Content Font', 'caards' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'Manrope',
			'subsets'        => array( 'latin' ),
			'font-size'      => '1.125rem',
			'line-height'    => '1.65',
			'letter-spacing' => '-0.0125rem',
		),
		'choices'  => array(
			'variant' => array(
				'regular',
				'italic',
				'500',
			),
		),

	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'typography_collapsible_forms',
		'section'     => 'typography_general',
		'label'       => esc_html__( 'Forms', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_input',
		'label'    => esc_html__( 'Input Font', 'caards' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'Manrope',
			'variant'        => '600',
			'font-size'      => '0.75rem',
			'letter-spacing' => 'normal',
			'text-transform' => 'none',
			'line-height'    => '1.625rem',
			'subsets'        => array( 'latin' ),
		),
		'choices'  => array(),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'font_button',
		'label'       => esc_html__( 'Button Font', 'caards' ),
		'description' => esc_html__( 'Used for buttons and other actionable elements.', 'caards' ),
		'section'     => 'typography_general',
		'default'     => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.875rem',
			'variant'        => '600',
			'letter-spacing' => 'normal',
			'text-transform' => 'none',
			'subsets'        => array( 'latin' ),
		),
		'choices'     => array(
			'variant' => array(
				'regular',
				'600',
			),
		),
	)
);

CSCO_Customizer::add_section(
	'typography_logos',
	array(
		'title' => esc_html__( 'Logos', 'caards' ),
		'panel' => 'typography',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'typography',
		'settings'        => 'font_main_logo',
		'label'           => esc_html__( 'Main Logo', 'caards' ),
		'description'     => esc_html__( 'The main logo is used in the navigation bar and mobile view of your website.', 'caards' ),
		'section'         => 'typography_logos',
		'default'         => array(
			'font-family'    => 'Manrope',
			'font-size'      => '1.5rem',
			'variant'        => '700',
			'letter-spacing' => '-0.075em',
			'text-transform' => 'none',
			'subsets'        => array( 'latin' ),
		),
		'choices'         => array(),
		'active_callback' => array(
			array(
				'setting'  => 'logo',
				'operator' => '==',
				'value'    => '',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'typography',
		'settings'        => 'font_large_logo',
		'label'           => esc_html__( 'Large Logo', 'caards' ),
		'section'         => 'typography_logos',
		'default'         => array(
			'font-family'    => 'Manrope',
			'font-size'      => '1.75rem',
			'variant'        => '700',
			'subsets'        => array( 'latin' ),
			'letter-spacing' => '-0.075em',
			'text-transform' => 'none',
		),
		'description'     => esc_html__( 'The large logo is used in the site header in desktop view.', 'caards' ),
		'choices'         => array(),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'four',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'font_tagline',
		'label'       => esc_html__( 'Tagline', 'caards' ),
		'description' => esc_html__( 'The tagline is used in the site header in desktop view.', 'caards' ),
		'section'     => 'typography_logos',
		'default'     => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.75rem',
			'variant'        => '600',
			'letter-spacing' => 'normal',
			'line-height'    => '1.5',
			'text-transform' => 'none',
			'subsets'        => array( 'latin' ),
		),
		'choices'     => array(),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'typography',
		'settings'        => 'font_footer_logo',
		'label'           => esc_html__( 'Footer Logo', 'caards' ),
		'description'     => esc_html__( 'The footer logo is used in the site footer in desktop and mobile view.', 'caards' ),
		'section'         => 'typography_logos',
		'default'         => array(
			'font-family'    => 'Manrope',
			'font-size'      => '1.5rem',
			'variant'        => '700',
			'subsets'        => array( 'latin' ),
			'letter-spacing' => '-0.075em',
			'text-transform' => 'none',
		),
		'choices'         => array(),
		'active_callback' => array(
			array(
				'setting'  => 'footer_logo',
				'operator' => '==',
				'value'    => '',
			),
		),
	)
);

CSCO_Customizer::add_section(
	'typography_headings',
	array(
		'title' => esc_html__( 'Headings', 'caards' ),
		'panel' => 'typography',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_headings',
		'label'    => esc_html__( 'Headings', 'caards' ),
		'section'  => 'typography_headings',
		'default'  => array(
			'font-family'    => 'Manrope',
			'font-size'      => '1.5rem',
			'variant'        => '800',
			'line-height'    => '1.14',
			'subsets'        => array( 'latin' ),
			'letter-spacing' => '-0.0125em',
			'text-transform' => 'none',
		),
		'choices'  => array(),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'typography',
		'settings' => 'font_headings_sidebar',
		'label'    => esc_html__( 'Headings of Sidebar', 'caards' ),
		'section'  => 'typography_headings',
		'default'  => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.75rem',
			'variant'        => '600',
			'letter-spacing' => 'normal',
			'text-transform' => 'uppercase',
			'subsets'        => array( 'latin' ),
		),
		'choices'  => array(),
	)
);

CSCO_Customizer::add_section(
	'typography_section_headings',
	array(
		'title' => esc_html__( 'Section Headings', 'caards' ),
		'panel' => 'typography',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'      => 'typography',
		'settings'  => 'section_heading_font',
		'label'     => esc_html__( 'Default Font', 'caards' ),
		'section'   => 'typography_section_headings',
		'default'   => array(
			'font-family'    => 'Manrope',
			'font-size'      => '2rem',
			'variant'        => '800',
			'letter-spacing' => 'normal',
			'text-transform' => 'none',
			'subsets'        => array( 'latin' ),
		),
		'choices'   => array(),
		'transport' => 'auto',
	)
);

if ( function_exists( 'cnvs' ) ) {
	CSCO_Customizer::add_field(
		array(
			'type'     => 'select',
			'settings' => 'section_heading',
			'label'    => esc_html__( 'Default Style', 'caards' ),
			'section'  => 'typography_section_headings',
			'default'  => 'style-1',
			'choices'  => array(
				'style-1'  => esc_html__( 'Plain', 'caards' ),
				'style-2'  => esc_html__( 'Thin Bottom Line', 'caards' ),
				'style-3'  => esc_html__( 'Thick Bottom Line', 'caards' ),
				'style-4'  => esc_html__( 'Thin Side Line', 'caards' ),
				'style-5'  => esc_html__( 'Thick Side Line', 'caards' ),
				'style-6'  => esc_html__( 'Top Line', 'caards' ),
				'style-7'  => esc_html__( 'Bottom Line, Medium Length', 'caards' ),
				'style-8'  => esc_html__( 'Side Line with Angle', 'caards' ),
				'style-9'  => esc_html__( 'Cross Icon', 'caards' ),
				'style-10' => esc_html__( 'Scewed Background', 'caards' ),
				'style-11' => esc_html__( 'Scewed Background, Side Line', 'caards' ),
				'style-12' => esc_html__( 'Solid Background', 'caards' ),
				'style-13' => esc_html__( 'Bordered', 'caards' ),
				'style-14' => esc_html__( 'Solid Background, Fullwidth', 'caards' ),
				'style-15' => esc_html__( 'Bordered, Fullwidth', 'caards' ),
				'style-16' => esc_html__( 'Double Line with Angle', 'caards' ),
				'style-17' => esc_html__( 'Bottom Line, Short Length', 'caards' ),
			),
		)
	);
}

CSCO_Customizer::add_field(
	array(
		'type'     => 'select',
		'settings' => 'section_heading_align',
		'label'    => esc_html__( 'Default Align', 'caards' ),
		'section'  => 'typography_section_headings',
		'default'  => 'halignleft',
		'choices'  => array(
			'halignleft'   => esc_html__( 'Align Text Left', 'caards' ),
			'haligncenter' => esc_html__( 'Align Text Center', 'caards' ),
			'halignright'  => esc_html__( 'Align Text Right', 'caards' ),
		),
	)
);

if ( function_exists( 'cnvs' ) ) {
	CSCO_Customizer::add_field(
		array(
			'type'     => 'select',
			'settings' => 'section_heading_tag',
			'label'    => esc_html__( 'Default Tag', 'caards' ),
			'section'  => 'typography_section_headings',
			'default'  => 'h5',
			'choices'  => array(
				'h1'  => esc_html__( 'H1', 'caards' ),
				'h2'  => esc_html__( 'H2', 'caards' ),
				'h3'  => esc_html__( 'H3', 'caards' ),
				'h4'  => esc_html__( 'H4', 'caards' ),
				'h5'  => esc_html__( 'H5', 'caards' ),
				'h6'  => esc_html__( 'H6', 'caards' ),
				'p'   => esc_html__( 'P', 'caards' ),
				'div' => esc_html__( 'DIV', 'caards' ),
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'     => 'color',
			'settings' => 'section_heading_color_border',
			'label'    => esc_html__( 'Border Color', 'caards' ),
			'section'  => 'typography_section_headings',
			'choices'  => array(
				'alpha' => true,
			),
			'output'   => apply_filters(
				'csco_section_heading_color_border',
				array(
					array(
						'element'  => ':root .cnvs-block-section-heading, [data-scheme="default"] .cnvs-block-section-heading, [data-scheme="dark"] [data-scheme="default"] .cnvs-block-section-heading',
						'property' => '--cnvs-section-heading-border-color',
						'context'  => array( 'editor', 'front' ),
					),
				)
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'     => 'color',
			'settings' => 'section_heading_color_border_dark',
			'label'    => esc_html__( 'Dark Border Color', 'caards' ),
			'section'  => 'typography_section_headings',
			'choices'  => array(
				'alpha' => true,
			),
			'output'   => apply_filters(
				'csco_section_heading_color_border',
				array(
					array(
						'element'  => '[data-scheme="dark"] .cnvs-block-section-heading',
						'property' => '--cnvs-section-heading-border-color',
						'context'  => array( 'editor', 'front' ),
					),
				)
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'     => 'color',
			'settings' => 'section_heading_color_accent',
			'label'    => esc_html__( 'Accent Color', 'caards' ),
			'section'  => 'typography_section_headings',
			'choices'  => array(
				'alpha' => true,
			),
			'output'   => apply_filters(
				'csco_section_heading_color_accent',
				array(
					array(
						'element'  => ':root .cnvs-block-section-heading, [data-scheme="default"] .cnvs-block-section-heading, [data-scheme="dark"] [data-scheme="default"] .cnvs-block-section-heading',
						'property' => '--cnvs-section-heading-icon-color',
						'context'  => array( 'editor', 'front' ),
					),
					array(
						'element'  => ':root .cnvs-block-section-heading, [data-scheme="default"] .cnvs-block-section-heading, [data-scheme="dark"] [data-scheme="default"] .cnvs-block-section-heading',
						'property' => '--cnvs-section-heading-accent-block-backround',
						'context'  => array( 'editor', 'front' ),
					),
				)
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'     => 'color',
			'settings' => 'section_heading_color_accent_dark',
			'label'    => esc_html__( 'Dark Accent Color', 'caards' ),
			'section'  => 'typography_section_headings',
			'choices'  => array(
				'alpha' => true,
			),
			'output'   => apply_filters(
				'csco_section_heading_color_accent',
				array(
					array(
						'element'  => '[data-scheme="dark"] .cnvs-block-section-heading',
						'property' => '--cnvs-section-heading-icon-color',
						'context'  => array( 'editor', 'front' ),
					),
					array(
						'element'  => '[data-scheme="dark"] .cnvs-block-section-heading',
						'property' => '--cnvs-section-heading-accent-block-backround',
						'context'  => array( 'editor', 'front' ),
					),
				)
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'     => 'color',
			'settings' => 'section_heading_color_accent_contrast',
			'label'    => esc_html__( 'Accent Contrast Color', 'caards' ),
			'section'  => 'typography_section_headings',
			'choices'  => array(
				'alpha' => true,
			),
			'output'   => apply_filters(
				'csco_section_heading_color_accent',
				array(
					array(
						'element'  => ':root .cnvs-block-section-heading, [data-scheme="default"] .cnvs-block-section-heading, [data-scheme="dark"] [data-scheme="default"] .cnvs-block-section-heading',
						'property' => '--cnvs-section-heading-accent-block-color',
						'context'  => array( 'editor', 'front' ),
					),
				)
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'     => 'color',
			'settings' => 'section_heading_color_accent_contrast_dark',
			'label'    => esc_html__( 'Dark Accent Contrast Color', 'caards' ),
			'section'  => 'typography_section_headings',

			'choices'  => array(
				'alpha' => true,
			),
			'output'   => apply_filters(
				'csco_section_heading_color_accent',
				array(
					array(
						'element'  => '[data-scheme="dark"] .cnvs-block-section-heading',
						'property' => '--cnvs-section-heading-accent-block-color',
						'context'  => array( 'editor', 'front' ),
					),
				)
			),
		)
	);
}

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'section_heading_color_text',
		'label'    => esc_html__( 'Text Color', 'caards' ),
		'section'  => 'typography_section_headings',
		'choices'  => array(
			'alpha' => true,
		),
		'output'   => apply_filters(
			'csco_section_heading_color_text',
			array(
				array(
					'element'  => ':root .cnvs-block-section-heading, [data-scheme="default"] .cnvs-block-section-heading, [data-scheme="dark"] [data-scheme="default"] .cnvs-block-section-heading',
					'property' => '--cnvs-section-heading-color',
					'context'  => array( 'editor', 'front' ),
				),
			)
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'section_heading_color_text_dark',
		'label'    => esc_html__( 'Dark Text Color', 'caards' ),
		'section'  => 'typography_section_headings',
		'choices'  => array(
			'alpha' => true,
		),
		'output'   => apply_filters(
			'csco_section_heading_color_text',
			array(
				array(
					'element'  => '[data-scheme="dark"] .cnvs-block-section-heading',
					'property' => '--cnvs-section-heading-color',
					'context'  => array( 'editor', 'front' ),
				),
			)
		),
	)
);

CSCO_Customizer::add_section(
	'typography_navigation',
	array(
		'title' => esc_html__( 'Navigation', 'caards' ),
		'panel' => 'typography',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'font_menu',
		'label'       => esc_html__( 'Menu Font', 'caards' ),
		'description' => esc_html__( 'Used for main top level menu elements.', 'caards' ),
		'section'     => 'typography_navigation',
		'default'     => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.875rem',
			'variant'        => '600',
			'letter-spacing' => '-0.0125em',
			'text-transform' => 'none',
			'subsets'        => array( 'latin' ),
		),
		'choices'     => array(
			'variant' => array(
				'regular',
				'600',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'font_submenu',
		'label'       => esc_html__( 'Submenu Font', 'caards' ),
		'description' => esc_html__( 'Used for submenu elements.', 'caards' ),
		'section'     => 'typography_navigation',
		'default'     => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.875rem',
			'variant'        => '600',
			'letter-spacing' => 'normal',
			'text-transform' => 'uppercase',
			'subsets'        => array( 'latin' ),
		),
		'choices'     => array(
			'variant' => array(
				'regular',
				'italic',
				'700',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'font_fullscreen_menu',
		'label'       => esc_html__( 'Fullscreen Menu Font', 'caards' ),
		'description' => esc_html__( 'Used for Fullscreen top level menu elements.', 'caards' ),
		'section'     => 'typography_navigation',
		'default'     => array(
			'font-family'    => 'Manrope',
			'font-size'      => '2.625rem',
			'variant'        => '800',
			'line-height'    => '1',
			'letter-spacing' => '-0.025em',
			'text-transform' => 'none',
			'subsets'        => array( 'latin' ),
		),
		'choices'     => array(
			'variant' => array(
				'regular',
				'800',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'font_fullscreen_submenu',
		'label'       => esc_html__( 'Fullscreen Submenu Font', 'caards' ),
		'description' => esc_html__( 'Used for Fullscreen submenu elements.', 'caards' ),
		'section'     => 'typography_navigation',
		'default'     => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.875rem',
			'variant'        => '600',
			'line-height'    => '1.2',
			'letter-spacing' => 'normal',
			'text-transform' => 'none',
			'subsets'        => array( 'latin' ),
		),
		'choices'     => array(
			'variant' => array(
				'regular',
				'italic',
				'600',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'font_featured_menu',
		'label'       => esc_html__( 'Featured Menu Font', 'caards' ),
		'description' => esc_html__( 'Used for Featured top level menu elements.', 'caards' ),
		'section'     => 'typography_navigation',
		'default'     => array(
			'font-family'    => 'Manrope',
			'font-size'      => '1rem',
			'variant'        => '800',
			'letter-spacing' => '-0.025em',
			'text-transform' => 'none',
			'subsets'        => array( 'latin' ),
		),
		'choices'     => array(
			'variant' => array(
				'regular',
				'italic',
				'800',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'font_featured_submenu',
		'label'       => esc_html__( 'Featured Submenu Font', 'caards' ),
		'description' => esc_html__( 'Used for Featured submenu elements.', 'caards' ),
		'section'     => 'typography_navigation',
		'default'     => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.875rem',
			'variant'        => '600',
			'letter-spacing' => 'normal',
			'text-transform' => 'none',
			'subsets'        => array( 'latin' ),
		),
		'choices'     => array(
			'variant' => array(
				'regular',
				'italic',
				'600',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'font_footer_menu',
		'label'       => esc_html__( 'Footer Menu Font', 'caards' ),
		'description' => esc_html__( 'Used for Footer top level menu elements.', 'caards' ),
		'section'     => 'typography_navigation',
		'default'     => array(
			'font-family'    => 'Manrope',
			'font-size'      => '1.5rem',
			'variant'        => '800',
			'line-height'    => '1',
			'letter-spacing' => '-0.025em',
			'text-transform' => 'none',
			'subsets'        => array( 'latin' ),
		),
		'choices'     => array(
			'variant' => array(
				'regular',
				'800',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'font_footer_submenu',
		'label'       => esc_html__( 'Footer Submenu Font', 'caards' ),
		'description' => esc_html__( 'Used for Footer submenu elements.', 'caards' ),
		'section'     => 'typography_navigation',
		'default'     => array(
			'font-family'    => 'Manrope',
			'font-size'      => '0.875rem',
			'variant'        => '600',
			'line-height'    => '1',
			'letter-spacing' => 'normal',
			'text-transform' => 'none',
			'subsets'        => array( 'latin' ),
		),
		'choices'     => array(
			'variant' => array(
				'regular',
				'italic',
				'600',
			),
		),
	)
);

CSCO_Customizer::add_section(
	'typography_navigation',
	array(
		'title' => esc_html__( 'Navigation', 'caards' ),
		'panel' => 'typography',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'font_menu',
		'label'       => esc_html__( 'Menu Font', 'caards' ),
		'description' => esc_html__( 'Used for main top level menu elements.', 'caards' ),
		'section'     => 'typography_navigation',
		'default'     => array(
			'font-family'    => 'Manrope',
			'variant'        => '400',
			'subsets'        => array( 'latin' ),
			'font-size'      => '0.875rem',
			'letter-spacing' => '-0.0125em',
			'text-transform' => 'none',
		),
		'choices'     => array(),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'font_submenu',
		'label'       => esc_html__( 'Submenu Font', 'caards' ),
		'description' => esc_html__( 'Used for submenu elements.', 'caards' ),
		'section'     => 'typography_navigation',
		'default'     => array(
			'font-family'    => 'Manrope',
			'subsets'        => array( 'latin' ),
			'variant'        => '400',
			'font-size'      => '0.75rem',
			'letter-spacing' => '0',
			'text-transform' => 'none',
		),
		'choices'     => array(),
	)
);
