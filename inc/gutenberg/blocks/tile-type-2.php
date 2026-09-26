<?php
/**
 * Register Tile Type 2.
 *
 * @package Caards
 */

/**
 * Register New Layout
 *
 * @param array $layouts List of layouts.
 */
function csco_canvas_register_layout_tile_type_2( $layouts = array() ) {

	$layout = 'tile-type-2';

	// Add new layout.
	$layouts[ $layout ] = array(
		'location'    => array(),
		'name'        => esc_html__( 'Tile 2', 'caards' ),
		'template'    => get_template_directory() . '/template-parts/blocks/posts-area.php',
		'icon'        => '<svg fill="none" height="44" viewBox="0 0 52 44" width="52" xmlns="http://www.w3.org/2000/svg"><g stroke="#000"><rect height="42" rx="2" stroke-width="1.5" width="50" x="1" y="1"/><g stroke-linecap="round" stroke-linejoin="round"><path d="m5 5h12"/><path d="m31 5h12"/><path d="m5 35h7"/><path d="m31 35h7"/><path d="m5 37h16"/><path d="m31 37h16"/><path d="m5 39h7"/><path d="m31 39h7"/></g><path d="m26.75 1v42" stroke-width="1.5"/></g></svg>',
		'sections'    => array(
			'general'    => array(
				'title'    => esc_html__( 'Block Settings', 'caards' ),
				'priority' => 5,
				'open'     => true,
			),
			'post-meta'  => array(
				'title'    => esc_html__( 'Meta Settings', 'caards' ),
				'priority' => 10,
			),
			'typography' => array(
				'title'    => esc_html__( 'Typography Settings', 'caards' ),
				'priority' => 10,
			),
		),
		'hide_fields' => csco_get_gutenberg_posts_hide_fields(),
		'fields'      => array_merge(
			csco_get_gutenberg_pagination_fields(),

			array(
				array(
					'key'            => 'columns',
					'label'          => esc_html__( 'Number of Columns', 'caards' ),
					'section'        => 'general',
					'type'           => 'number',
					'min'            => 1,
					'max'            => 6,
					'default'        => 1,
					'default_laptop' => 1,
					'default_tablet' => 1,
					'default_mobile' => 1,
					'responsive'     => true,
					'output'         => array(
						array(
							'element'  => '$ .cs-posts-area__main',
							'property' => '--cs-posts-area-grid-columns',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'            => 'gap_between_columns',
					'label'          => esc_html__( 'Gap between Columns', 'caards' ),
					'type'           => 'dimension',
					'section'        => 'general',
					'responsive'     => true,
					'default'        => '40px',
					'default_laptop' => '40px',
					'default_tablet' => '40px',
					'default_mobile' => '40px',
					'output'         => array(
						array(
							'element'  => '$ .cs-posts-area__main',
							'property' => '--cs-posts-area-grid-column-gap',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'            => 'gap_between_rows',
					'label'          => esc_html__( 'Gap between Rows', 'caards' ),
					'type'           => 'dimension',
					'section'        => 'general',
					'responsive'     => true,
					'default'        => '40px',
					'default_laptop' => '40px',
					'default_tablet' => '40px',
					'default_mobile' => '40px',
					'output'         => array(
						array(
							'element'  => '$ .cs-posts-area__main',
							'property' => '--cs-posts-area-grid-row-gap',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'     => 'border_radius',
					'label'   => esc_html__( 'Border Radius', 'caards' ),
					'type'    => 'dimension',
					'section' => 'general',
					'default' => '12px',
					'output'  => array(
						array(
							'element'  => '$ .cs-posts-area__main',
							'property' => '--cs-image-border-radius',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'        => 'card_min_height',
					'label'      => esc_html__( 'Card Min Height', 'caards' ),
					'type'       => 'dimension',
					'section'    => 'general',
					'responsive' => true,
					'output'     => array(
						array(
							'element'  => '$ .cs-posts-area__main',
							'property' => '--cs-card-min-height',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'     => 'video',
					'label'   => esc_html__( 'Enable video backgrounds', 'caards' ),
					'section' => 'general',
					'type'    => 'toggle',
					'default' => false,
				),
				array(
					'key'             => 'video_controls',
					'label'           => esc_html__( 'Enable video controls', 'caards' ),
					'section'         => 'general',
					'type'            => 'toggle',
					'default'         => false,
					'active_callback' => array(
						array(
							'field'    => '$#video',
							'operator' => '==',
							'value'    => true,
						),
					),
				),

				// Post Meta.
				array(
					'key'     => 'top_meta',
					'label'   => esc_html__( 'Top Meta Type', 'caards' ),
					'section' => 'post-meta',
					'type'    => 'select',
					'default' => 'author',
					'choices' => array(
						'none'     => esc_html__( 'None', 'caards' ),
						'author'   => esc_html__( 'Author', 'caards' ),
						'category' => esc_html__( 'Category', 'caards' ),
						'count'    => esc_html__( 'Count', 'caards' ),
					),
				),

				// Thumbnail.
				array(
					'key'     => 'image_orientation',
					'label'   => esc_html__( 'Image Orientation', 'caards' ),
					'section' => 'thumbnail',
					'type'    => 'select',
					'default' => 'stretch',
					'choices' => array(
						'stretch'         => esc_html__( 'Stretch', 'caards' ),
						'landscape'       => esc_html__( 'Landscape 4:3', 'caards' ),
						'landscape-3-2'   => esc_html__( 'Landscape 3:2', 'caards' ),
						'landscape-16-9'  => esc_html__( 'Landscape 16:9', 'caards' ),
						'landscape-21-10' => esc_html__( 'Landscape 21:10', 'caards' ),
						'portrait'        => esc_html__( 'Portrait 3:4', 'caards' ),
						'portrait-2-3'    => esc_html__( 'Portrait 2:3', 'caards' ),
						'square'          => esc_html__( 'Square', 'caards' ),
					),
				),
				array(
					'key'     => 'image_size',
					'label'   => esc_html__( 'Images Size', 'caards' ),
					'section' => 'thumbnail',
					'type'    => 'select',
					'default' => 'medium_large',
					'choices' => csco_get_list_available_image_sizes(),
				),
				// Typography.
				array(
					'key'        => 'typography_heading',
					'label'      => esc_html__( 'Heading Font Size', 'caards' ),
					'section'    => 'typography',
					'type'       => 'dimension',
					'default'    => '1.5rem',
					'responsive' => true,
					'output'     => array(
						array(
							'element'  => '$ .cs-entry__title',
							'property' => '--cs-entry-title-font-size',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'     => 'typography_heading_tag',
					'label'   => esc_html__( 'Heading Tag', 'caards' ),
					'section' => 'typography',
					'type'    => 'select',
					'default' => 'h2',
					'choices' => array(
						'h1'  => esc_html__( 'H1', 'caards' ),
						'h2'  => esc_html__( 'H2', 'caards' ),
						'h3'  => esc_html__( 'H3', 'caards' ),
						'h4'  => esc_html__( 'H4', 'caards' ),
						'h5'  => esc_html__( 'H5', 'caards' ),
						'h6'  => esc_html__( 'H6', 'caards' ),
						'p'   => esc_html__( 'P', 'caards' ),
						'div' => esc_html__( 'DIV', 'caards' ),
					),
				),
				array(
					'key'             => 'typography_excerpt',
					'label'           => esc_html__( 'Excerpt Font Size', 'caards' ),
					'section'         => 'typography',
					'type'            => 'dimension',
					'default'         => '0.875rem',
					'responsive'      => true,
					'output'          => array(
						array(
							'element'  => '$ .cs-entry__excerpt',
							'property' => '--cs-font-entry-excerpt-size',
							'suffix'   => '!important',
						),
					),
					'active_callback' => array(
						array(
							'field'    => '$#display_excerpt',
							'operator' => '===',
							'value'    => true,
						),
					),
				),
			),
			// Primary Meta.
			csco_get_gutenberg_meta_fields(
				array(
					'section_name' => 'post-meta',
					'default'      => array(
						'category'     => true,
						'author'       => true,
						'date'         => true,
						'comments'     => false,
						'views'        => true,
						'reading_time' => true,
						'shares'       => true,
					),
				)
			),
			csco_get_gutenberg_excerpt_fields(
				array(
					'section_name' => 'post-meta',
					'default'      => true,
				)
			),
			csco_get_gutenberg_more_button_fields(
				array(
					'section_name' => 'post-meta',
					'default'      => true,
				)
			)
		),
	);

	return $layouts;
}
add_filter( 'canvas_block_layouts_canvas/posts', 'csco_canvas_register_layout_tile_type_2' );
