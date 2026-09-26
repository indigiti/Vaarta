<?php
/**
 * Archive Settings
 *
 * @package Caards
 */

CSCO_Customizer::add_section(
	'archive_settings',
	array(
		'title' => esc_html__( 'Archive Settings', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'archive_collapsible_common',
		'section'     => 'archive_settings',
		'label'       => esc_html__( 'Common', 'caards' ),
		'input_attrs' => array(
			'collapsed' => true,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'radio',
		'settings' => 'archive_layout',
		'label'    => esc_html__( 'Layout', 'caards' ),
		'section'  => 'archive_settings',
		'default'  => 'list',
		'choices'  => array(
			'list'    => esc_html__( 'List Layout', 'caards' ),
			'grid'    => esc_html__( 'Grid Layout', 'caards' ),
			'masonry' => esc_html__( 'Masonry Layout', 'caards' ),
			'full'    => esc_html__( 'Full Post Layout', 'caards' ),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'radio',
		'settings' => 'archive_sidebar',
		'label'    => esc_html__( 'Sidebar', 'caards' ),
		'section'  => 'archive_settings',
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
		'type'            => 'select',
		'settings'        => 'archive_image_orientation',
		'label'           => esc_html__( 'Image Orientation', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => 'original',
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
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'list',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'grid',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'masonry',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'select',
		'settings'        => 'archive_image_size',
		'label'           => esc_html__( 'Image Size', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => 'csco-thumbnail',
		'choices'         => csco_get_list_available_image_sizes(),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'list',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'grid',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'masonry',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'select',
		'settings'        => 'archive_image_width',
		'label'           => esc_html__( 'Image Width', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => 'half',
		'choices'         => array(
			'one-third' => esc_html__( 'One Third', 'caards' ),
			'half'      => esc_html__( 'Half', 'caards' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'archive_layout',
				'operator' => '==',
				'value'    => 'list',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'multicheck',
		'settings' => 'archive_post_meta',
		'label'    => esc_html__( 'Post Meta', 'caards' ),
		'section'  => 'archive_settings',
		'default'  => array( 'category', 'author', 'date', 'views', 'shares', 'reading_time', 'comments' ),
		'choices'  => apply_filters(
			'csco_post_meta_choices',
			array(
				'category'     => esc_html__( 'Category', 'caards' ),
				'author'       => esc_html__( 'Author', 'caards' ),
				'date'         => esc_html__( 'Date', 'caards' ),
				'views'        => esc_html__( 'Views', 'caards' ),
				'shares'       => esc_html__( 'Shares', 'caards' ),
				'reading_time' => esc_html__( 'Reading Time', 'caards' ),
				'comments'     => esc_html__( 'Comments', 'caards' ),
			)
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'archive_more_button',
		'label'    => esc_html__( 'Display read more button', 'caards' ),
		'section'  => 'archive_settings',
		'default'  => true,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'radio',
		'settings'        => 'archive_media_preview',
		'label'           => esc_html__( 'Post Preview Image Size', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => 'uncropped',
		'choices'         => array(
			'cropped'   => esc_html__( 'Display Cropped Image', 'caards' ),
			'uncropped' => esc_html__( 'Display Preview in Original Ratio', 'caards' ),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'full',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'archive_excerpt',
		'label'    => esc_html__( 'Display excerpt', 'caards' ),
		'section'  => 'archive_settings',
		'default'  => true,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'radio',
		'settings'        => 'archive_summary',
		'label'           => esc_html__( 'Full Post Summary', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => 'summary',
		'choices'         => array(
			'summary' => esc_html__( 'Use Excerpts', 'caards' ),
			'content' => esc_html__( 'Use Read More Tag', 'caards' ),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'full',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'radio',
		'settings' => 'archive_pagination_type',
		'label'    => esc_html__( 'Pagination', 'caards' ),
		'section'  => 'archive_settings',
		'default'  => 'load-more',
		'choices'  => array(
			'standard'  => esc_html__( 'Standard', 'caards' ),
			'load-more' => esc_html__( 'Load More Button', 'caards' ),
			'infinite'  => esc_html__( 'Infinite Load', 'caards' ),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'radio',
		'settings' => 'archive_pagination_type',
		'label'    => esc_html__( 'Pagination', 'caards' ),
		'section'  => 'archive_settings',
		'default'  => 'load-more',
		'choices'  => array(
			'standard'  => esc_html__( 'Standard', 'caards' ),
			'load-more' => esc_html__( 'Load More Button', 'caards' ),
			'infinite'  => esc_html__( 'Infinite Load', 'caards' ),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'checkbox',
		'settings'        => 'archive_widgets',
		'label'           => esc_html__( 'Display widgets in archive', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => false,
		'active_callback' => array(
			array(
				'setting'  => 'archive_layout',
				'operator' => '==',
				'value'    => 'masonry',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'select',
		'settings'        => 'archive_widgets_sidebar',
		'label'           => esc_html__( 'Widget Area', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => 'sidebar-archive',
		'active_callback' => array(
			array(
				'setting'  => 'archive_layout',
				'operator' => '==',
				'value'    => 'masonry',
			),
			array(
				'setting'  => 'archive_widgets',
				'operator' => '==',
				'value'    => true,
			),
		),
		'choices'         => csco_get_registered_sidebars(),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'number',
		'settings'        => 'archive_widgets_after',
		'label'           => esc_html__( 'Display widgets after N-th post', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => 3,
		'active_callback' => array(
			array(
				'setting'  => 'archive_layout',
				'operator' => '==',
				'value'    => 'masonry',
			),
			array(
				'setting'  => 'archive_widgets',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'collapsible',
		'settings'        => 'archive_collapsible_number_of_olumns',
		'section'         => 'archive_settings',
		'label'           => esc_html__( 'Number of Columns', 'caards' ),
		'input_attrs'     => array(
			'collapsed' => false,
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'grid',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'masonry',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'number',
		'settings'        => 'archive_columns_desktop',
		'label'           => esc_html__( 'Desktop', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => 2,
		'input_attrs'     => array(
			'min'  => 1,
			'max'  => 3,
			'step' => 1,
		),
		'output'          => array(
			array(
				'element'  => '.cs-posts-area__archive.cs-posts-area__grid, .cs-posts-area__archive.cs-posts-area__masonry',
				'property' => '--cs-posts-area-grid-columns',
			),
			array(
				'reverse'       => '.cs-posts-area__archive.cs-posts-area__masonry .cs-posts-area__masonry-col-$numb',
				'reverse_max'   => 4,
				'property'      => 'display',
				'value_pattern' => 'none',
			),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'grid',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'masonry',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'number',
		'settings'        => 'archive_columns_laptop',
		'label'           => esc_html__( 'Laptop', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => 2,
		'input_attrs'     => array(
			'min'  => 1,
			'max'  => 4,
			'step' => 1,
		),
		'output'          => array(
			array(
				'element'     => '.cs-posts-area__archive.cs-posts-area__grid, .cs-posts-area__archive.cs-posts-area__masonry',
				'property'    => '--cs-posts-area-grid-columns',
				'media_query' => '@media (max-width: 1583.98px)',
			),
			array(
				'reverse'       => '.cs-posts-area__archive.cs-posts-area__masonry .cs-posts-area__masonry-col-$numb',
				'reverse_max'   => 4,
				'property'      => 'display',
				'value_pattern' => 'none',
				'media_query'   => '@media (max-width: 1583.98px)',
			),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'grid',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'masonry',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'number',
		'settings'        => 'archive_columns_tablet',
		'label'           => esc_html__( 'Tablet', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => 2,
		'input_attrs'     => array(
			'min'  => 1,
			'max'  => 4,
			'step' => 1,
		),
		'output'          => array(
			array(
				'element'     => '.cs-posts-area__archive.cs-posts-area__grid, .cs-posts-area__archive.cs-posts-area__masonry',
				'property'    => '--cs-posts-area-grid-columns',
				'media_query' => '@media (max-width: 1279.98px)',
			),
			array(
				'reverse'       => '.cs-posts-area__archive.cs-posts-area__masonry .cs-posts-area__masonry-col-$numb',
				'reverse_max'   => 4,
				'property'      => 'display',
				'value_pattern' => 'none',
				'media_query'   => '@media (max-width: 1279.98px)',
			),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'grid',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'masonry',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'number',
		'settings'        => 'archive_columns_mobile',
		'label'           => esc_html__( 'Mobile', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => 1,
		'input_attrs'     => array(
			'min'  => 1,
			'max'  => 4,
			'step' => 1,
		),
		'output'          => array(
			array(
				'element'     => '.cs-posts-area__archive.cs-posts-area__grid, .cs-posts-area__archive.cs-posts-area__masonry',
				'property'    => '--cs-posts-area-grid-columns',
				'media_query' => '@media (max-width: 575.98px)',
			),
			array(
				'reverse'       => '.cs-posts-area__archive.cs-posts-area__masonry .cs-posts-area__masonry-col-$numb',
				'reverse_max'   => 4,
				'property'      => 'display',
				'value_pattern' => 'none',
				'media_query'   => '@media (max-width: 575.98px)',
			),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'grid',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'masonry',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'archive_collapsible_gap_between_rows',
		'section'     => 'archive_settings',
		'label'       => esc_html__( 'Gap between Rows', 'caards' ),
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'dimension',
		'settings' => 'archive_gap_between_rows_desktop',
		'label'    => esc_html__( 'Desktop', 'caards' ),
		'section'  => 'archive_settings',
		'default'  => '40px',
		'output'   => array(
			array(
				'element'  => '.cs-posts-area__archive',
				'property' => '--cs-posts-area-grid-row-gap',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'dimension',
		'settings' => 'archive_gap_between_rows_laptop',
		'label'    => esc_html__( 'Laptop', 'caards' ),
		'section'  => 'archive_settings',
		'default'  => '40px',
		'output'   => array(
			array(
				'element'     => '.cs-posts-area__archive',
				'property'    => '--cs-posts-area-grid-row-gap',
				'media_query' => '@media (max-width: 1583.98px)',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'dimension',
		'settings' => 'archive_gap_between_rows_tablet',
		'label'    => esc_html__( 'Tablet', 'caards' ),
		'section'  => 'archive_settings',
		'default'  => '40px',
		'output'   => array(
			array(
				'element'     => '.cs-posts-area__archive',
				'property'    => '--cs-posts-area-grid-row-gap',
				'media_query' => '@media (max-width: 1279.98px)',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'dimension',
		'settings' => 'archive_gap_between_rows_mobile',
		'label'    => esc_html__( 'Mobile', 'caards' ),
		'section'  => 'archive_settings',
		'default'  => '40px',
		'output'   => array(
			array(
				'element'     => '.cs-posts-area__archive',
				'property'    => '--cs-posts-area-grid-row-gap',
				'media_query' => '@media (max-width: 575.98px)',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'collapsible',
		'settings'        => 'archive_collapsible_gap_between_columns',
		'section'         => 'archive_settings',
		'label'           => esc_html__( 'Gap between Columns', 'caards' ),
		'input_attrs'     => array(
			'collapsed' => false,
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'grid',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'masonry',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'dimension',
		'settings'        => 'archive_gap_between_columns_desktop',
		'label'           => esc_html__( 'Desktop', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => '40px',
		'output'          => array(
			array(
				'element'  => '.cs-posts-area__archive.cs-posts-area__grid, .cs-posts-area__archive.cs-posts-area__masonry',
				'property' => '--cs-posts-area-grid-column-gap',
			),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'grid',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'masonry',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'dimension',
		'settings'        => 'archive_gap_between_columns_laptop',
		'label'           => esc_html__( 'Laptop', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => '40px',
		'output'          => array(
			array(
				'element'     => '.cs-posts-area__archive.cs-posts-area__grid, .cs-posts-area__archive.cs-posts-area__masonry',
				'property'    => '--cs-posts-area-grid-column-gap',
				'media_query' => '@media (max-width: 1583.98px)',
			),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'grid',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'masonry',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'dimension',
		'settings'        => 'archive_gap_between_columns_tablet',
		'label'           => esc_html__( 'Tablet', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => '40px',
		'output'          => array(
			array(
				'element'     => '.cs-posts-area__archive.cs-posts-area__grid, .cs-posts-area__archive.cs-posts-area__masonry',
				'property'    => '--cs-posts-area-grid-column-gap',
				'media_query' => '@media (max-width: 1279.98px)',
			),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'grid',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'masonry',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'dimension',
		'settings'        => 'archive_gap_between_columns_mobile',
		'label'           => esc_html__( 'Mobile', 'caards' ),
		'section'         => 'archive_settings',
		'default'         => '40px',
		'output'          => array(
			array(
				'element'     => '.cs-posts-area__archive.cs-posts-area__grid, .cs-posts-area__archive.cs-posts-area__masonry',
				'property'    => '--cs-posts-area-grid-column-gap',
				'media_query' => '@media (max-width: 575.98px)',
			),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'grid',
				),
				array(
					'setting'  => 'archive_layout',
					'operator' => '==',
					'value'    => 'masonry',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'archive_collapsible_title_size',
		'section'     => 'archive_settings',
		'label'       => esc_html__( 'Title Font Size', 'caards' ),
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'dimension',
		'settings' => 'archive_title_size_desktop',
		'label'    => esc_html__( 'Desktop', 'caards' ),
		'section'  => 'archive_settings',
		'output'   => array(
			array(
				'element'  => '.cs-posts-area__archive',
				'property' => '--cs-entry-title-font-size',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'dimension',
		'settings' => 'archive_title_size_laptop',
		'label'    => esc_html__( 'Laptop', 'caards' ),
		'section'  => 'archive_settings',
		'output'   => array(
			array(
				'element'     => '.cs-posts-area__archive',
				'property'    => '--cs-entry-title-font-size',
				'media_query' => '@media (max-width: 1583.98px)',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'dimension',
		'settings' => 'archive_title_size_tablet',
		'label'    => esc_html__( 'Tablet', 'caards' ),
		'section'  => 'archive_settings',
		'output'   => array(
			array(
				'element'     => '.cs-posts-area__archive',
				'property'    => '--cs-entry-title-font-size',
				'media_query' => '@media (max-width: 1279.98px)',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'dimension',
		'settings' => 'archive_title_size_mobile',
		'label'    => esc_html__( 'Mobile', 'caards' ),
		'section'  => 'archive_settings',
		'output'   => array(
			array(
				'element'     => '.cs-posts-area__archive',
				'property'    => '--cs-entry-title-font-size',
				'media_query' => '@media (max-width: 575.98px)',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'archive_collapsible_card_height',
		'section'     => 'archive_settings',
		'label'       => esc_html__( 'Card Min Height', 'caards' ),
		'input_attrs' => array(
			'collapsed' => false,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'dimension',
		'settings' => 'archive_card_min_height_desktop',
		'label'    => esc_html__( 'Desktop', 'caards' ),
		'section'  => 'archive_settings',
		'output'   => array(
			array(
				'element'  => '.cs-posts-area__archive',
				'property' => '--cs-card-min-height',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'dimension',
		'settings' => 'archive_card_min_height_laptop',
		'label'    => esc_html__( 'Laptop', 'caards' ),
		'section'  => 'archive_settings',
		'output'   => array(
			array(
				'element'     => '.cs-posts-area__archive',
				'property'    => '--cs-card-min-height',
				'media_query' => '@media (max-width: 1583.98px)',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'dimension',
		'settings' => 'archive_card_min_height_tablet',
		'label'    => esc_html__( 'Tablet', 'caards' ),
		'section'  => 'archive_settings',
		'output'   => array(
			array(
				'element'     => '.cs-posts-area__archive',
				'property'    => '--cs-card-min-height',
				'media_query' => '@media (max-width: 1279.98px)',
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'dimension',
		'settings' => 'archive_card_min_height_mobile',
		'label'    => esc_html__( 'Mobile', 'caards' ),
		'section'  => 'archive_settings',
		'output'   => array(
			array(
				'element'     => '.cs-posts-area__archive',
				'property'    => '--cs-card-min-height',
				'media_query' => '@media (max-width: 575.98px)',
			),
		),
	)
);
