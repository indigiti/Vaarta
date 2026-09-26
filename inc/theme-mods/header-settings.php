<?php
/**
 * Header Settings
 *
 * @package Caards
 */

CSCO_Customizer::add_section(
	'header',
	array(
		'title' => esc_html__( 'Header Settings', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'header_collapsible_common',
		'section'     => 'header',
		'label'       => esc_html__( 'Common', 'caards' ),
		'input_attrs' => array(
			'collapsed' => true,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'radio',
		'settings' => 'header_layout',
		'label'    => esc_html__( 'Layout', 'caards' ),
		'section'  => 'header',
		'default'  => 'one',
		'choices'  => apply_filters( 'csco_header_layouts', array(
			'one'   => esc_html__( 'Header 1', 'caards' ),
			'two'   => esc_html__( 'Header 2', 'caards' ),
			'three' => esc_html__( 'Header 3', 'caards' ),
			'four'  => esc_html__( 'Header 4', 'caards' ),
		) ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'dimension',
		'settings'        => 'header_topbar_height',
		'label'           => esc_html__( 'Topbar Height', 'caards' ),
		'section'         => 'header',
		'default'         => '115px',
		'output'          => array(
			array(
				'element'  => ':root',
				'property' => '--cs-header-topbar-height',
			),
		),
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
		'type'     => 'dimension',
		'settings' => 'header_initial_height',
		'label'    => esc_html__( 'Header Initial Height', 'caards' ),
		'section'  => 'header',
		'default'  => '80px',
		'output'   => array(
			array(
				'element'  => ':root',
				'property' => '--cs-header-initial-height',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'dimension',
		'settings' => 'header_height',
		'label'    => esc_html__( 'Header Height', 'caards' ),
		'section'  => 'header',
		'default'  => '80px',
		'output'   => array(
			array(
				'element'  => ':root',
				'property' => '--cs-header-height',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'checkbox',
		'settings'    => 'navbar_sticky',
		'label'       => esc_html__( 'Make navigation bar sticky', 'caards' ),
		'description' => esc_html__( 'Enabling this option will make navigation bar visible when scrolling.', 'caards' ),
		'section'     => 'header',
		'default'     => true,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'checkbox',
		'settings'        => 'navbar_smart_sticky',
		'label'           => esc_html__( 'Enable the smart sticky feature', 'caards' ),
		'description'     => esc_html__( 'Enabling this option will reveal navigation bar when scrolling up and hide it when scrolling down.', 'caards' ),
		'section'         => 'header',
		'default'         => true,
		'active_callback' => array(
			array(
				'setting'  => 'navbar_sticky',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'checkbox',
		'settings'        => 'header_navigation_menu',
		'label'           => esc_html__( 'Display navigation menu', 'caards' ),
		'section'         => 'header',
		'default'         => true,
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '!=',
				'value'    => 'two',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'collapsible',
		'settings' => 'header_collapsible_search',
		'section'  => 'header',
		'label'    => esc_html__( 'Search', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'checkbox',
		'settings'        => 'header_search_button',
		'label'           => esc_html__( 'Display search button', 'caards' ),
		'section'         => 'header',
		'default'         => true,
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '!=',
				'value'    => 'cs-header-two',
			),
			array(
				'setting'  => 'header_layout',
				'operator' => '!=',
				'value'    => 'cs-header-three',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'radio',
		'settings'        => 'header_search_type',
		'label'           => esc_html__( 'Search Type', 'caards' ),
		'section'         => 'header',
		'default'         => 'one',
		'choices'         => apply_filters( 'csco_header_search_type', array(
			'one' => esc_html__( 'Type 1', 'caards' ),
			'two' => esc_html__( 'Type 2', 'caards' ),
		) ),
		'active_callback' => array(
			array(
				'setting'  => 'header_search_button',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

if ( csco_powerkit_module_enabled( 'social_links' ) ) {
	CSCO_Customizer::add_field(
		array(
			'type'     => 'collapsible',
			'settings' => 'header_collapsible_social_links',
			'section'  => 'header',
			'label'    => esc_html__( 'Social Links', 'caards' ),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'     => 'checkbox',
			'settings' => 'header_social_links',
			'label'    => esc_html__( 'Display social links', 'caards' ),
			'section'  => 'header',
			'default'  => false,
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'            => 'select',
			'settings'        => 'header_social_links_scheme',
			'label'           => esc_html__( 'Color scheme', 'caards' ),
			'section'         => 'header',
			'default'         => 'light',
			'choices'         => array(
				'light' => esc_html__( 'Light', 'caards' ),
				'bold'  => esc_html__( 'Bold', 'caards' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'header_social_links',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'            => 'number',
			'settings'        => 'header_social_links_maximum',
			'label'           => esc_html__( 'Maximum Number of Social Links', 'caards' ),
			'section'         => 'header',
			'default'         => 3,
			'active_callback' => array(
				array(
					'setting'  => 'header_social_links',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'            => 'checkbox',
			'settings'        => 'header_social_links_counts',
			'label'           => esc_html__( 'Display social counts', 'caards' ),
			'section'         => 'header',
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => 'header_social_links',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
}

CSCO_Customizer::add_field(
	array(
		'type'            => 'collapsible',
		'settings'        => 'header_collapsible_button',
		'section'         => 'header',
		'label'           => esc_html__( 'Custom Button', 'caards' ),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'in',
				'value'    => array( 'two', 'three' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'              => 'text',
		'settings'          => 'header_button_label',
		'label'             => esc_html__( 'Button Label', 'caards' ),
		'section'           => 'header',
		'default'           => esc_html__( 'Buy Now', 'caards' ),
		'sanitize_callback' => 'csco_kses',
		'active_callback'   => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'in',
				'value'    => array( 'two', 'three' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'text',
		'settings'        => 'header_button_link',
		'label'           => esc_html__( 'Button Link', 'caards' ),
		'section'         => 'header',
		'default'         => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => 'in',
				'value'    => array( 'two', 'three' ),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'header_button_target',
		'label'    => esc_html__( 'Open button link in new tab', 'caards' ),
		'section'  => 'header',
		'default'  => false,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'collapsible',
		'settings' => 'header_collapsible_multi_column',
		'section'  => 'header',
		'label'    => esc_html__( 'Multi-Column Sub-Menu', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'header_multi_column_display',
		'label'    => esc_html__( 'Display multi-column sub-menu', 'caards' ),
		'section'  => 'header',
		'default'  => false,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'checkbox',
		'settings'        => 'header_multi_column_posts',
		'label'           => esc_html__( 'Display posts', 'caards' ),
		'section'         => 'header',
		'default'         => true,
		'active_callback' => array(
			array(
				'setting'  => 'header_multi_column_display',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'text',
		'settings'        => 'header_multi_column_posts_heading',
		'label'           => esc_html__( 'Heading', 'caards' ),
		'section'         => 'header',
		'default'         => esc_html__( 'Popular', 'caards' ),
		'active_callback' => array(
			array(
				'setting'  => 'header_multi_column_display',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'header_multi_column_posts',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'select',
		'settings'        => 'header_multi_column_image_orientation',
		'label'           => esc_html__( 'Image Orientation', 'caards' ),
		'section'         => 'header',
		'default'         => 'landscape-16-9',
		'choices'         => array(
			'original'        => esc_html__( 'Original', 'caards' ),
			'landscape'       => esc_html__( 'Landscape 4:3', 'caards' ),
			'landscape-3-2'   => esc_html__( 'Landscape 3:2', 'caards' ),
			'landscape-16-9'  => esc_html__( 'Landscape 16:9', 'caards' ),
			'landscape-21-10' => esc_html__( 'Landscape 21:10', 'caards' ),
			'portrait'        => esc_html__( 'Portrait 3:4', 'caards' ),
			'portrait-2-3'    => esc_html__( 'Portrait 2:3', 'caards' ),
			'square'          => esc_html__( 'Square', 'caards' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_multi_column_display',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'header_multi_column_posts',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'select',
		'settings'        => 'header_multi_column_image_size',
		'label'           => esc_html__( 'Image Size', 'caards' ),
		'section'         => 'header',
		'default'         => 'csco-thumbnail',
		'choices'         => csco_get_list_available_image_sizes(),
		'active_callback' => array(
			array(
				'setting'  => 'header_multi_column_display',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'header_multi_column_posts',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'dimension',
		'settings'        => 'header_multi_column_border_radius',
		'label'           => esc_html__( 'Image Border Radius', 'caards' ),
		'section'         => 'header',
		'default'         => '',
		'output'          => array(
			array(
				'element'  => '.cs-header__multi-column-posts .cs-entry__outer',
				'property' => '--cs-image-border-radius',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_multi_column_display',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'header_multi_column_posts',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'multicheck',
		'settings'        => 'header_multi_column_posts_meta',
		'label'           => esc_html__( 'Post Meta', 'caards' ),
		'section'         => 'header',
		'default'         => array( 'date', 'views', 'shares', 'reading_time' ),
		'choices'         => apply_filters(
			'csco_post_meta_choices',
			array(
				'category'     => esc_html__( 'Category', 'caards' ),
				'date'         => esc_html__( 'Date', 'caards' ),
				'author'       => esc_html__( 'Author', 'caards' ),
				'views'        => esc_html__( 'Views', 'caards' ),
				'shares'       => esc_html__( 'Shares', 'caards' ),
				'comments'     => esc_html__( 'Comments', 'caards' ),
				'reading_time' => esc_html__( 'Reading Time', 'caards' ),
			)
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_multi_column_display',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'header_multi_column_posts',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'text',
		'settings'        => 'header_multi_column_filter_posts',
		'label'           => esc_html__( 'Filter by Posts', 'caards' ),
		'description'     => esc_html__( 'Add comma-separated list of post IDs. For example: 12, 34, 145. Leave empty for all posts.', 'caards' ),
		'section'         => 'header',
		'default'         => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_multi_column_display',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'header_multi_column_posts',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'text',
		'settings'        => 'header_multi_column_filter_categories',
		'label'           => esc_html__( 'Filter by Categories', 'caards' ),
		'description'     => esc_html__( 'Add comma-separated list of category slugs. For example: &laquo;travel, lifestyle, food&raquo;. Leave empty for all categories.', 'caards' ),
		'section'         => 'header',
		'default'         => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_multi_column_display',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'header_multi_column_posts',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'text',
		'settings'        => 'header_multi_column_filter_tags',
		'label'           => esc_html__( 'Filter by Tags', 'caards' ),
		'description'     => esc_html__( 'Add comma-separated list of tag slugs. For example: &laquo;worth-reading, top-5, playlists&raquo;. Leave empty for all tags.', 'caards' ),
		'section'         => 'header',
		'default'         => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_multi_column_display',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'header_multi_column_posts',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'radio',
		'settings'        => 'header_multi_column_posts_orderby',
		'label'           => esc_html__( 'Order posts by', 'caards' ),
		'section'         => 'header',
		'default'         => 'date',
		'choices'         => array(
			'date'       => esc_html__( 'Date', 'caards' ),
			'rand'       => esc_html__( 'Random', 'caards' ),
			'name'       => esc_html__( 'Name', 'caards' ),
			'post_views' => esc_html__( 'Views', 'caards' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_multi_column_display',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'header_multi_column_posts',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'text',
		'settings'        => 'header_multi_column_time_frame',
		'label'           => esc_html__( 'Filter by Time Frame', 'caards' ),
		'description'     => esc_html__( 'Add period of posts in English. For example: &laquo;2 months&raquo;, &laquo;14 days&raquo; or even &laquo;1 year&raquo;', 'caards' ),
		'section'         => 'header',
		'default'         => '',
		'active_callback' => array(
			array(
				'setting'  => 'header_multi_column_display',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'header_multi_column_posts',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'radio',
		'settings'        => 'header_multi_column_posts_order',
		'label'           => esc_html__( 'Order posts', 'caards' ),
		'section'         => 'header',
		'default'         => 'DESC',
		'choices'         => array(
			'ASC'  => esc_html__( 'ASC', 'caards' ),
			'DESC' => esc_html__( 'DESC', 'caards' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_multi_column_display',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'header_multi_column_posts',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'collapsible',
		'settings' => 'header_collapsible_featured_columns',
		'section'  => 'header',
		'label'    => esc_html__( 'Featured Columns', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'header_featured_columns',
		'label'    => esc_html__( 'Display featured columns', 'caards' ),
		'section'  => 'header',
		'default'  => true,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'text',
		'settings'        => 'header_featured_columns_title',
		'label'           => esc_html__( 'Featured Title', 'caards' ),
		'section'         => 'header',
		'default'         => esc_html__( 'Features', 'caards' ),
		'active_callback' => array(
			array(
				'setting'  => 'header_featured_columns',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'              => 'text',
		'settings'          => 'header_featured_columns_icon',
		'label'             => esc_html__( 'Icon', 'caards' ),
		'section'           => 'header',
		'default'           => '<i class="cs-icon cs-icon-flashlight"></i>',
		'sanitize_callback' => 'csco_kses',
		'active_callback'   => array(
			array(
				'setting'  => 'header_featured_columns',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'collapsible',
		'settings' => 'header_collapsible_fullscreen_menu',
		'section'  => 'header',
		'label'    => esc_html__( 'Fullscreen Menu', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'header_fullscreen_menu',
		'label'    => esc_html__( 'Display fullscreen menu toggle button', 'caards' ),
		'section'  => 'header',
		'default'  => false,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'collapsible',
		'settings' => 'header_collapsible_mega_menu',
		'section'  => 'header',
		'label'    => esc_html__( 'Mega Menu', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'select',
		'settings' => 'mega_menu_image_orientation',
		'label'    => esc_html__( 'Image Orientation', 'caards' ),
		'section'  => 'header',
		'default'  => 'landscape-16-9',
		'choices'  => array(
			'original'        => esc_html__( 'Original', 'caards' ),
			'landscape'       => esc_html__( 'Landscape 4:3', 'caards' ),
			'landscape-3-2'   => esc_html__( 'Landscape 3:2', 'caards' ),
			'landscape-16-9'  => esc_html__( 'Landscape 16:9', 'caards' ),
			'landscape-21-10' => esc_html__( 'Landscape 21:10', 'caards' ),
			'portrait'        => esc_html__( 'Portrait 3:4', 'caards' ),
			'portrait-2-3'    => esc_html__( 'Portrait 2:3', 'caards' ),
			'square'          => esc_html__( 'Square', 'caards' ),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'select',
		'settings' => 'mega_menu_image_size',
		'label'    => esc_html__( 'Image Size', 'caards' ),
		'section'  => 'header',
		'default'  => 'csco-thumbnail',
		'choices'  => csco_get_list_available_image_sizes(),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'multicheck',
		'settings' => 'mega_menu_post_meta',
		'label'    => esc_html__( 'Post Meta', 'caards' ),
		'section'  => 'header',
		'default'  => array( 'date', 'views', 'reading_time' ),
		'choices'  => apply_filters(
			'csco_post_meta_choices',
			array(
				'category'     => esc_html__( 'Category', 'caards' ),
				'date'         => esc_html__( 'Date', 'caards' ),
				'author'       => esc_html__( 'Author', 'caards' ),
				'views'        => esc_html__( 'Views', 'caards' ),
				'shares'       => esc_html__( 'Shares', 'caards' ),
				'reading_time' => esc_html__( 'Reading Time', 'caards' ),
				'comments'     => esc_html__( 'Comments', 'caards' ),
			)
		),
	)
);
