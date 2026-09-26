<?php
/**
 * Block Carousel Type 2
 *
 * @package Caards
 */

/**
 * Register New Layout
 *
 * @param array $layouts List of layouts.
 */
function csco_canvas_register_layout_carousel_type_2( $layouts = array() ) {

	$layout = 'carousel-type-2';

	// Add new layout.
	$layouts[ $layout ] = array(
		'location'    => array(),
		'name'        => esc_html__( 'Carousel 2', 'caards' ),
		'template'    => get_template_directory() . "/template-parts/blocks/{$layout}.php",
		'icon'        => '<svg fill="none" height="44" viewBox="0 0 52 44" width="52" xmlns="http://www.w3.org/2000/svg"><g stroke="#000"><rect height="42" rx="2" stroke-width="1.5" width="50" x="1" y="1"/><path d="m5 5h12" stroke-linecap="round" stroke-linejoin="round"/><path d="m5 20h7" stroke-linecap="round" stroke-linejoin="round"/><path d="m1 31h50" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/><path d="m5 22h19" stroke-linecap="round" stroke-linejoin="round"/><path d="m22 35-2 2 2 2" stroke-linecap="round" stroke-linejoin="round"/><path d="m30 39 2-2-2-2" stroke-linecap="round" stroke-linejoin="round"/></g><circle cx="10" cy="26" fill="#000" r="1"/><circle cx="14" cy="26" fill="#000" r="1"/><circle cx="6" cy="26" r="1" stroke="#000"/></svg>',
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
			array(
				array(
					'key'     => 'areaPostsCount',
					'label'   => esc_html__( 'Slides', 'caards' ),
					'section' => 'general',
					'type'    => 'number',
					'default' => 6,
					'min'     => 1,
					'max'     => 100,
				),
				array(
					'key'     => 'autoplay',
					'label'   => esc_html__( 'Enable autoplay', 'caards' ),
					'section' => 'general',
					'type'    => 'toggle',
					'default' => true,
				),
				array(
					'key'     => 'pagedots',
					'label'   => esc_html__( 'Enable bullets', 'caards' ),
					'section' => 'general',
					'type'    => 'toggle',
					'default' => true,
				),
				array(
					'key'     => 'wraparound',
					'label'   => esc_html__( 'Enable wrap-around', 'caards' ),
					'help'    => esc_html__( 'At the end of items, wrap-around to the other end for infinite scrolling.', 'caards' ),
					'section' => 'general',
					'type'    => 'toggle',
					'default' => true,
				),
				array(
					'key'            => 'columns',
					'label'          => esc_html__( 'Number of Columns', 'caards' ),
					'section'        => 'general',
					'type'           => 'number',
					'min'            => 1,
					'max'            => 6,
					'default'        => 4,
					'default_laptop' => 4,
					'default_tablet' => 3,
					'default_mobile' => 1,
					'responsive'     => true,
					'output'         => array(
						array(
							'element'  => '$',
							'property' => '--cs-carousel-columns',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'            => 'gap_posts',
					'label'          => esc_html__( 'Gap between Posts', 'caards' ),
					'type'           => 'dimension',
					'section'        => 'general',
					'responsive'     => true,
					'default'        => '40px',
					'default_laptop' => '40px',
					'default_tablet' => '40px',
					'default_mobile' => '40px',
					'output'         => array(
						array(
							'element'  => '$',
							'property' => '--cs-carousel-gap',
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
							'element'  => '$',
							'property' => '--cs-card-min-height',
							'suffix'   => '!important',
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
				array(
					'key'     => 'image_border_radius',
					'label'   => esc_html__( 'Image Border Radius', 'caards' ),
					'section' => 'thumbnail',
					'type'    => 'dimension',
					'output'  => array(
						array(
							'element'  => '$',
							'property' => '--cs-image-border-radius',
						),
					),
				),
				// Typography.
				array(
					'key'        => 'typography_heading',
					'label'      => esc_html__( 'Heading Font Size', 'caards' ),
					'section'    => 'typography',
					'type'       => 'dimension',
					'default'    => '1.25rem',
					'responsive' => true,
					'output'     => array(
						array(
							'element'  => '$ .cs-entry__title',
							'property' => 'font-size',
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
							'property' => 'font-size',
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
add_filter( 'canvas_block_layouts_canvas/posts', 'csco_canvas_register_layout_carousel_type_2' );
