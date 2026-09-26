<?php
/**
 * Design
 *
 * @package Caards
 */

CSCO_Customizer::add_panel(
	'colors',
	array(
		'title' => esc_html__( 'Colors', 'caards' ),
	)
);

CSCO_Customizer::add_section(
	'colors_dark_mode',
	array(
		'title' => esc_html__( 'Dark Mode', 'caards' ),
		'panel' => 'colors',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'design_collapsible_dark_mode',
		'section'     => 'colors_dark_mode',
		'label'       => esc_html__( 'Dark Mode', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => true,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'radio',
		'settings' => 'color_scheme',
		'label'    => esc_html__( 'Site Color Scheme', 'caards' ),
		'section'  => 'colors_dark_mode',
		'default'  => 'system',
		'choices'  => array(
			'system' => esc_html__( 'User’s system preference', 'caards' ),
			'light'  => esc_html__( 'Light', 'caards' ),
			'dark'   => esc_html__( 'Dark', 'caards' ),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'color_scheme_toggle',
		'label'    => esc_html__( 'Enable dark/light mode toggle', 'caards' ),
		'section'  => 'colors_dark_mode',
		'default'  => true,
	)
);

CSCO_Customizer::add_section(
	'colors_light_scheme',
	array(
		'title' => esc_html__( 'Light Scheme', 'caards' ),
		'panel' => 'colors',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'colors_light_collapsible_common',
		'section'     => 'colors_light_scheme',
		'label'       => esc_html__( 'Common', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => true,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_primary',
		'label'    => esc_html__( 'Primary Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#2F323D',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-primary',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-palette-color-primary',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_secondary',
		'label'    => esc_html__( 'Secondary Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#67717a',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-secondary',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-palette-color-secondary',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_accent',
		'label'    => esc_html__( 'Accent Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#2d5de0',
		'context'  => array( 'editor', 'front' ),
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-accent',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-accent-rgb',
				'context'  => array( 'editor', 'front' ),
				'convert'  => 'rgb',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'divider',
		'settings' => wp_unique_id( 'divider' ),
		'section'  => 'colors_light_scheme',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_header_background',
		'label'    => esc_html__( 'Header Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-site-scheme="default"]',
				'property' => '--cs-color-header-background',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_footer_background',
		'label'    => esc_html__( 'Footer Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-site-scheme="default"]',
				'property' => '--cs-color-footer-background',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_search_background',
		'label'    => esc_html__( 'Site Search Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => 'rgba(246,247,248,0.8)',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-site-scheme="default"]',
				'property' => '--cs-color-search-background',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_overlay',
		'label'    => esc_html__( 'Overlay Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => 'rgba(0,0,0,0.5)',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-overlay-background',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'color',
		'settings'    => 'color_site_elements_background',
		'label'       => esc_html__( 'Site Elements Background', 'caards' ),
		'description' => esc_html__( 'Background color for Fullscreen Menu, Widgets, Elements.', 'caards' ),
		'section'     => 'colors_light_scheme',
		'priority'    => 10,
		'default'     => '#ffffff',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element'  => ':root, [data-site-scheme="default"]',
				'property' => '--cs-color-layout-elements-background',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => ':root, [data-site-scheme="default"]',
				'property' => '--cs-color-featured-column-link-background',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => ':root, [data-site-scheme="default"]',
				'property' => '--cs-color-widgets-background',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => ':root, [data-site-scheme="default"]',
				'property' => '--cs-color-submenu-link-background',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'color',
		'settings'    => 'color_site_secondary_elements_background',
		'label'       => null,
		'description' => esc_html__( 'Background color for Submenu, Header Featured and Multi Columns.', 'caards' ),
		'section'     => 'colors_light_scheme',
		'priority'    => 10,
		'default'     => '#f6f7f8',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element'  => ':root, [data-site-scheme="default"]',
				'property' => '--cs-color-submenu-background',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => ':root, [data-site-scheme="default"]',
				'property' => '--cs-color-featured-column-background',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => ':root, [data-site-scheme="default"]',
				'property' => '--cs-color-multi-column-background',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => ':root, [data-site-scheme="default"]',
				'property' => '--cs-color-fullscreen-menu-link-background',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'colors_light_collapsible_site_background',
		'section'     => 'colors_light_scheme',
		'label'       => esc_html__( 'Site Background', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'group-background',
		'settings' => 'site_background',
		'label'    => null,
		'section'  => 'colors_light_scheme',
		'default'  => array(
			'background-color'      => '#f6f7f8',
			'background-image'      => '',
			'background-repeat'     => 'no-repeat',
			'background-position'   => 'center top',
			'background-size'       => 'contain',
			'background-attachment' => 'scroll',
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'site_background_front_only',
		'label'    => esc_html__( 'Display background image only front page', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => true,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'colors_light_collapsible_fullscreen_background',
		'section'     => 'colors_light_scheme',
		'label'       => esc_html__( 'Fullscreen Menu Background', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'group-background',
		'settings' => 'fullscreen_background',
		'label'    => null,
		'section'  => 'colors_light_scheme',
		'default'  => array(
			'background-color'      => '#ffffff',
			'background-image'      => '',
			'background-repeat'     => 'no-repeat',
			'background-position'   => 'center top',
			'background-size'       => 'contain',
			'background-attachment' => 'scroll',
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'colors_light_collapsible_elements',
		'section'     => 'colors_light_scheme',
		'label'       => esc_html__( 'Elements', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_link',
		'label'    => esc_html__( 'Post Content Link Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#2f323d',
		'context'  => array( 'editor', 'front' ),
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root .entry-content:not(.canvas-content), [data-scheme="default"] .entry-content:not(.canvas-content)',
				'property' => '--cs-color-link',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_link_hover',
		'label'    => esc_html__( 'Post Content Link Hover Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#2d5de0',
		'context'  => array( 'editor', 'front' ),
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root .entry-content:not(.canvas-content), [data-scheme="default"] .entry-content:not(.canvas-content)',
				'property' => '--cs-color-link-hover',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'divider',
		'settings' => wp_unique_id( 'divider' ),
		'section'  => 'colors_light_scheme',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_button',
		'label'    => esc_html__( 'Button Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#2d5de0',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-button',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_button_contrast',
		'label'    => esc_html__( 'Button Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-button-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_button_hover',
		'label'    => esc_html__( 'Button Hover Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#1048de',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-button-hover',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_button_hover_contrast',
		'label'    => esc_html__( 'Button Hover Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-button-hover-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'divider',
		'settings' => wp_unique_id( 'divider' ),
		'section'  => 'colors_light_scheme',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_category',
		'label'    => esc_html__( 'Category Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#2f323d',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-entry-category-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_category_hover',
		'label'    => esc_html__( 'Category Hover Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#818181',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-entry-category-hover-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'divider',
		'settings' => wp_unique_id( 'divider' ),
		'section'  => 'colors_light_scheme',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_tags_background',
		'label'    => esc_html__( 'Tags Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-tags',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_tags',
		'label'    => esc_html__( 'Tags Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#2f323d',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-tags-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_tags_background_hover',
		'label'    => esc_html__( 'Tags Hover Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#2D5DE0',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-tags-hover',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_tags_hover',
		'label'    => esc_html__( 'Tags Hover Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-tags-hover-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'divider',
		'settings' => wp_unique_id( 'divider' ),
		'section'  => 'colors_light_scheme',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_meta',
		'label'    => esc_html__( 'Post Meta Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#67717a',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-post-meta',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_meta_link',
		'label'    => esc_html__( 'Post Meta Link Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#2f323d',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-post-meta-link',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_meata_link_hover',
		'label'    => esc_html__( 'Post Meta Link Hover Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#1b50e0',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-post-meta-link-hover',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'divider',
		'settings' => wp_unique_id( 'divider' ),
		'section'  => 'colors_light_scheme',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_excerpt',
		'label'    => esc_html__( 'Excerpt Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#67717a',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-excerpt',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'colors_light_collapsible_badges',
		'section'     => 'colors_light_scheme',
		'label'       => esc_html__( 'Badges', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_primary_background',
		'label'    => esc_html__( 'Badge Primary Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#2d5de0',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-primary',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_primary_is_contrast',
		'label'    => esc_html__( 'Badge Primary Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-primary-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_secodary_background',
		'label'    => esc_html__( 'Badge Secondary Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ededed',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-secondary',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_secondary_is_contrast',
		'label'    => esc_html__( 'Badge Secondary Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#000000',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-secondary-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_success_background',
		'label'    => esc_html__( 'Badge Success Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#28a745',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-success',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_success_is_contrast',
		'label'    => esc_html__( 'Badge Success Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-success-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_danger_background',
		'label'    => esc_html__( 'Badge Danger Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#dc3546',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-danger',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_danger_is_contrast',
		'label'    => esc_html__( 'Badge Danger Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-danger-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_warning_background',
		'label'    => esc_html__( 'Badge Warning Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#fdb013',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-warning',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_warning_is_contrast',
		'label'    => esc_html__( 'Badge Warning Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-warning-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_info_background',
		'label'    => esc_html__( 'Badge Info Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#dfeef9',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-info',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_info_is_contrast',
		'label'    => esc_html__( 'Badge Info Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#2D5DE0',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-info-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_dark_background',
		'label'    => esc_html__( 'Badge Dark Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#000000',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-dark',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_dark_is_contrast',
		'label'    => esc_html__( 'Badge Dark Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-dark-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);


CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_light_background',
		'label'    => esc_html__( 'Badge Light Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#fafafa',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-light',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_light_is_contrast',
		'label'    => esc_html__( 'Badge Light Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#000000',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => ':root, [data-scheme="default"]',
				'property' => '--cs-color-badge-light-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_section(
	'colors_dark_scheme',
	array(
		'title' => esc_html__( 'Dark Scheme', 'caards' ),
		'panel' => 'colors',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'colors_dark_collapsible_common',
		'section'     => 'colors_dark_scheme',
		'label'       => esc_html__( 'Common', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => true,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_primary_dark',
		'label'    => esc_html__( 'Primary Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-primary',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-palette-color-primary',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_secondary_dark',
		'label'    => esc_html__( 'Secondary Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#78848F',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-secondary',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-palette-color-secondary',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_accent_dark',
		'label'    => esc_html__( 'Accent Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#2d5de0',
		'context'  => array( 'editor', 'front' ),
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-accent',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-accent-rgb',
				'context'  => array( 'editor', 'front' ),
				'convert'  => 'rgb',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'divider',
		'settings' => wp_unique_id( 'divider' ),
		'section'  => 'colors_dark_scheme',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_header_background_dark',
		'label'    => esc_html__( 'Header Background', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#1b1c1f',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-site-scheme="dark"]',
				'property' => '--cs-color-header-background',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_footer_background_dark',
		'label'    => esc_html__( 'Footer Background', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#1b1c1f',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-site-scheme="dark"]',
				'property' => '--cs-color-footer-background',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_search_background_dark',
		'label'    => esc_html__( 'Site Search Background', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => 'rgba(28,28,28, 0.8)',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-site-scheme="dark"]',
				'property' => '--cs-color-search-background',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_overlay_dark',
		'label'    => esc_html__( 'Overlay Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => 'rgba(0,0,0,0.5)',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-site-scheme="dark"]',
				'property' => '--cs-color-overlay-background',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'color',
		'settings'    => 'color_site_elements_background_dark',
		'label'       => esc_html__( 'Site Elements Background', 'caards' ),
		'description' => esc_html__( 'Background color for Fullscreen Menu and Widgets.', 'caards' ),
		'section'     => 'colors_dark_scheme',
		'priority'    => 10,
		'default'     => '#1b1c1f',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element'  => '[data-site-scheme="dark"]',
				'property' => '--cs-color-layout-elements-background',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => '[data-site-scheme="dark"]',
				'property' => '--cs-color-featured-column-link-background',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => '[data-site-scheme="dark"]',
				'property' => '--cs-color-widgets-background',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => '[data-site-scheme="dark"]',
				'property' => '--cs-color-submenu-link-background',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'color',
		'settings'    => 'color_site_secondary_elements_background_dark',
		'label'       => null,
		'description' => esc_html__( 'Background color for Submenu, Header Featured and Multi Columns.', 'caards' ),
		'section'     => 'colors_dark_scheme',
		'priority'    => 10,
		'default'     => '#50525C',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element'  => '[data-site-scheme="dark"]',
				'property' => '--cs-color-submenu-background',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => '[data-site-scheme="dark"]',
				'property' => '--cs-color-featured-column-background',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => '[data-site-scheme="dark"]',
				'property' => '--cs-color-multi-column-background',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => '[data-site-scheme="dark"]',
				'property' => '--cs-color-fullscreen-menu-link-background',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'colors_dark_collapsible_site_background',
		'section'     => 'colors_dark_scheme',
		'label'       => esc_html__( 'Site Background', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'group-background',
		'settings' => 'site_background_dark',
		'label'    => null,
		'section'  => 'colors_dark_scheme',
		'default'  => array(
			'background-color'      => '#30323e',
			'background-image'      => '',
			'background-repeat'     => 'no-repeat',
			'background-position'   => 'center top',
			'background-size'       => 'contain',
			'background-attachment' => 'scroll',
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'site_background_front_only_dark',
		'label'    => esc_html__( 'Display background image only front page', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => true,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'colors_dark_collapsible_fullscreen_background',
		'section'     => 'colors_dark_scheme',
		'label'       => esc_html__( 'Fullscreen Menu Background', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'group-background',
		'settings' => 'fullscreen_background_dark',
		'label'    => null,
		'section'  => 'colors_dark_scheme',
		'default'  => array(
			'background-color'      => '#30323e',
			'background-image'      => '',
			'background-repeat'     => 'no-repeat',
			'background-position'   => 'center top',
			'background-size'       => 'contain',
			'background-attachment' => 'scroll',
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'colors_dark_collapsible_elements',
		'section'     => 'colors_dark_scheme',
		'label'       => esc_html__( 'Elements', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_link_dark',
		'label'    => esc_html__( 'Post Content Link Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#ffffff',
		'context'  => array( 'editor', 'front' ),
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="inverse"] .entry-content:not(.canvas-content), [data-scheme="dark"] .entry-content:not(.canvas-content)',
				'property' => '--cs-color-link',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_link_hover_dark',
		'label'    => esc_html__( 'Post Content Link Hover Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#2d5de0',
		'context'  => array( 'editor', 'front' ),
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="inverse"] .entry-content:not(.canvas-content), [data-scheme="dark"] .entry-content:not(.canvas-content)',
				'property' => '--cs-color-link-hover',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'divider',
		'settings' => wp_unique_id( 'divider' ),
		'section'  => 'colors_dark_scheme',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_button_dark',
		'label'    => esc_html__( 'Button Background', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#2d5de0',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-button',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_button_contrast_dark',
		'label'    => esc_html__( 'Button Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-button-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_button_hover_dark',
		'label'    => esc_html__( 'Button Hover Background', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#1048de',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-button-hover',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_button_hover_contrast_dark',
		'label'    => esc_html__( 'Button Hover Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-button-hover-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'divider',
		'settings' => wp_unique_id( 'divider' ),
		'section'  => 'colors_dark_scheme',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_category_dark',
		'label'    => esc_html__( 'Category Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#818181',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-entry-category-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_category_hover_dark',
		'label'    => esc_html__( 'Category Hover Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#bcbcbc',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-entry-category-hover-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_tags_background',
		'label'    => esc_html__( 'Tags Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#50525C',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="inverse"], [data-scheme="dark"]',
				'property' => '--cs-color-tags',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_tags',
		'label'    => esc_html__( 'Tags Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="inverse"], [data-scheme="dark"]',
				'property' => '--cs-color-tags-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_tags_background_hover',
		'label'    => esc_html__( 'Tags Hover Background', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="inverse"], [data-scheme="dark"]',
				'property' => '--cs-color-tags-hover',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_tags_hover',
		'label'    => esc_html__( 'Tags Hover Color', 'caards' ),
		'section'  => 'colors_light_scheme',
		'default'  => '#2f323d',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="inverse"], [data-scheme="dark"]',
				'property' => '--cs-color-tags-hover-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'divider',
		'settings' => wp_unique_id( 'divider' ),
		'section'  => 'colors_dark_scheme',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_meta_dark',
		'label'    => esc_html__( 'Post Meta Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-post-meta',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_meta_link_dark',
		'label'    => esc_html__( 'Post Meta Link Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-post-meta-link',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_meata_link_hover_dark',
		'label'    => esc_html__( 'Post Meta Link Hover Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#1b50e0',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-post-meta-link-hover',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'divider',
		'settings' => wp_unique_id( 'divider' ),
		'section'  => 'colors_dark_scheme',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color',
		'settings' => 'color_excerpt_dark',
		'label'    => esc_html__( 'Excerpt Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-excerpt',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'colors_dark_collapsible_badges',
		'section'     => 'colors_dark_scheme',
		'label'       => esc_html__( 'Badges', 'caards' ),
		'priority'    => 10,
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_primary_background_dark',
		'label'    => esc_html__( 'Badge Primary Background', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#000000',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-primary',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);


CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_primary_dark_is_contrast',
		'label'    => esc_html__( 'Badge Primary Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-primary-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_secodary_background_dark',
		'label'    => esc_html__( 'Badge Secondary Background', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#ededed',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-secondary',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_secondary_dark_is_contrast',
		'label'    => esc_html__( 'Badge Secondary Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#000000',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-secondary-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_success_background_dark',
		'label'    => esc_html__( 'Badge Success Background', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#28a745',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-success',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_success_dark_is_contrast',
		'label'    => esc_html__( 'Badge Success Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-success-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_danger_background_dark',
		'label'    => esc_html__( 'Badge Danger Background', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#dc3546',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-danger',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_danger_dark_is_contrast',
		'label'    => esc_html__( 'Badge Danger Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-danger-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_warning_background_dark',
		'label'    => esc_html__( 'Badge Warning Background', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#fdb013',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-warning',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_warning_dark_is_contrast',
		'label'    => esc_html__( 'Badge Warning Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-warning-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_info_background_dark',
		'label'    => esc_html__( 'Badge Info Background', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#dfeef9',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-info',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_info_dark_is_contrast',
		'label'    => esc_html__( 'Badge Info Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#2D5DE0',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-info-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_dark_background_dark',
		'label'    => esc_html__( 'Badge Dark Background', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => 'rgba(255,255,255,0.7)',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-dark',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_dark_dark_is_contrast',
		'label'    => esc_html__( 'Badge Dark Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#ffffff',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-dark-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_light_background_dark',
		'label'    => esc_html__( 'Badge Light Background', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => 'rgb(238,238,238)',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-light',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'color-alpha',
		'settings' => 'color_badge_light_dark_is_contrast',
		'label'    => esc_html__( 'Badge Light Color', 'caards' ),
		'section'  => 'colors_dark_scheme',
		'default'  => '#020202',
		'alpha'    => true,
		'output'   => array(
			array(
				'element'  => '[data-scheme="dark"]',
				'property' => '--cs-color-badge-light-contrast',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_section(
	'colors_border_radius',
	array(
		'title' => esc_html__( 'Border Radius', 'caards' ),
		'panel' => 'colors',
	)
);

CSCO_Customizer::add_field(
	array(
		'type'              => 'dimension',
		'settings'          => 'design_layout_elements_border_radius',
		'label'             => esc_html__( 'Layout Elements', 'caards' ),
		'section'           => 'colors_border_radius',
		'default'           => '12px',
		'priority'          => 10,
		'sanitize_callback' => 'esc_html',
		'output'            => array(
			array(
				'element'  => ':root',
				'property' => '--cs-layout-elements-border-radius',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'              => 'dimension',
		'settings'          => 'design_image_border_radius',
		'label'             => esc_html__( 'Image Border Radius', 'caards' ),
		'section'           => 'colors_border_radius',
		'default'           => '12px',
		'priority'          => 10,
		'sanitize_callback' => 'esc_html',
		'output'            => array(
			array(
				'element'  => ':root',
				'property' => '--cs-image-border-radius',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'              => 'dimension',
		'settings'          => 'design_button_border_radius',
		'label'             => esc_html__( 'Button Border Radius', 'caards' ),
		'section'           => 'colors_border_radius',
		'default'           => '6px',
		'priority'          => 10,
		'sanitize_callback' => 'esc_html',
		'output'            => array(
			array(
				'element'  => ':root',
				'property' => '--cs-button-border-radius',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => ':root',
				'property' => '--cnvs-tabs-border-radius',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'              => 'dimension',
		'settings'          => 'design_input_border_radius',
		'label'             => esc_html__( 'Form Input Border Radius', 'caards' ),
		'section'           => 'colors_border_radius',
		'default'           => '6px',
		'priority'          => 10,
		'sanitize_callback' => 'esc_html',
		'output'            => array(
			array(
				'element'  => ':root',
				'property' => '--cs-input-border-radius',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'              => 'dimension',
		'settings'          => 'design_badge_border_radius',
		'label'             => esc_html__( 'Badge, Tag & Category Label Border Radius', 'caards' ),
		'section'           => 'colors_border_radius',
		'default'           => '6px',
		'priority'          => 10,
		'sanitize_callback' => 'esc_html',
		'output'            => array(
			array(
				'element'  => ':root',
				'property' => '--cs-badge-border-radius',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => ':root',
				'property' => '--cs-tag-border-radius',
				'context'  => array( 'editor', 'front' ),
			),
			array(
				'element'  => ':root',
				'property' => '--cs-category-label-border-radius',
				'context'  => array( 'editor', 'front' ),
			),
		),
	)
);
