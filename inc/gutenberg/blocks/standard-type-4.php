<?php
/**
 * Register Standard Type 4.
 *
 * @package Caards
 */

/**
 * Register New Layout
 *
 * @param array $layouts List of layouts.
 */
function csco_canvas_register_layout_standard_type_4( $layouts = array() ) {

	$layout = 'standard-type-4';

	// Add new layout.
	$layouts[ $layout ] = array(
		'location'    => array(),
		'name'        => esc_html__( 'Standard 4', 'caards' ),
		'template'    => get_template_directory() . '/template-parts/blocks/posts-area.php',
		'icon'        => '<svg fill="none" height="44" viewBox="0 0 52 44" width="52" xmlns="http://www.w3.org/2000/svg"><g stroke="#000"><rect height="42" rx="2" stroke-width="1.5" width="50" x="1" y="1"/><rect height="8" rx="1" stroke-width="1.5" width="19" x="28" y="5"/><rect height="8" rx="1" stroke-width="1.5" width="19" x="28" y="24"/><g stroke-linecap="round" stroke-linejoin="round"><path d="m29 16h12"/><path d="m29 35h12"/><path d="m29 20h7"/><path d="m29 39h7"/><path d="m39 20h2"/><path d="m39 39h2"/><path d="m6 16h12"/><path d="m6 35h12"/><path d="m6 20h7"/><path d="m6 39h7"/><path d="m16 20h2"/><path d="m16 39h2"/><path d="m29 18h17"/><path d="m29 37h17"/><path d="m6 18h17"/><path d="m6 37h17"/></g><rect height="8" rx="1" stroke-width="1.5" width="19" x="5" y="5"/><rect height="8" rx="1" stroke-width="1.5" width="19" x="5" y="24"/></g></svg>',
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
					'key'            => 'gap_blocks',
					'label'          => esc_html__( 'Margin Content', 'caards' ),
					'type'           => 'dimension',
					'section'        => 'general',
					'responsive'     => true,
					'default'        => '32px',
					'default_laptop' => '32px',
					'default_tablet' => '32px',
					'default_mobile' => '32px',
					'output'         => array(
						array(
							'element'  => '$ .cs-posts-area__main',
							'property' => '--cs-posts-area-grid-content-gap',
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
					'key'     => 'post_format',
					'label'   => esc_html__( 'Enable post format', 'caards' ),
					'section' => 'general',
					'type'    => 'toggle',
					'default' => true,
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
					'default' => 'original',
					'choices' => array(
						'original'        => esc_html__( 'Original', 'caards' ),
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
				// Color Settings.
				array(
					'key'     => 'color_heading',
					'label'   => esc_html__( 'Heading Color', 'caards' ),
					'section' => 'color',
					'type'    => 'color',
					'output'  => array(
						array(
							'element'  => '$ .cs-entry__title',
							'property' => '--cs-color-link',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'     => 'color_heading_hover',
					'label'   => esc_html__( 'Heading Color Hover', 'caards' ),
					'section' => 'color',
					'type'    => 'color',
					'output'  => array(
						array(
							'element'  => '$ .cs-entry__title',
							'property' => '--cs-color-link-hover',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'             => 'color_excerpt',
					'label'           => esc_html__( 'Excerpt', 'caards' ),
					'section'         => 'color',
					'type'            => 'color',
					'output'          => array(
						array(
							'element'  => '$ .cs-entry__excerpt',
							'property' => '--cs-color-excerpt',
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
				array(
					'key'     => 'color_meta',
					'label'   => esc_html__( 'Post Meta', 'caards' ),
					'section' => 'color',
					'type'    => 'color',
					'output'  => array(
						array(
							'element'  => '$ .cs-entry__post-meta',
							'property' => '--cs-color-post-meta',
							'suffix'   => '!important',
						),
						array(
							'element'  => '$ .cs-entry__footer-item',
							'property' => '--cs-color-post-meta',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'     => 'color_meta_links',
					'label'   => esc_html__( 'Post Meta Links', 'caards' ),
					'section' => 'color',
					'type'    => 'color',
					'output'  => array(
						array(
							'element'  => '$ .cs-entry__post-meta div:not(.cs-meta-category) a',
							'property' => '--cs-color-post-meta-link',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'     => 'color_meta_links_hover',
					'label'   => esc_html__( 'Post Meta Links Hover', 'caards' ),
					'section' => 'color',
					'type'    => 'color',
					'output'  => array(
						array(
							'element'  => '$ .cs-entry__post-meta div:not(.cs-meta-category) a',
							'property' => '--cs-color-post-meta-link-hover',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'     => 'color_categories',
					'label'   => esc_html__( 'Category Color', 'caards' ),
					'section' => 'color',
					'type'    => 'color',
					'output'  => array(
						array(
							'element'  => '$ .cs-entry__post-meta .cs-meta-category a',
							'property' => '--cs-color-entry-category-contrast',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'     => 'color_categories_hover',
					'label'   => esc_html__( 'Category Hover Color', 'caards' ),
					'section' => 'color',
					'type'    => 'color',
					'output'  => array(
						array(
							'element'  => '$ .cs-entry__post-meta .cs-meta-category a',
							'property' => '--cs-color-entry-category-hover-contrast',
							'suffix'   => '!important',
						),
					),
				),
				array(
					'key'             => 'color_more_text',
					'label'           => esc_html__( 'Read More Text Color', 'caards' ),
					'section'         => 'color',
					'type'            => 'color',
					'output'          => array(
						array(
							'element'  => '$ .cs-entry__read-more a',
							'property' => '--cs-color-primary',
							'suffix'   => '!important',
						),
					),
					'active_callback' => array(
						array(
							'field'    => '$#more_button',
							'operator' => '!=',
							'value'    => false,
						),
					),
				),
				array(
					'key'             => 'color_more_text_hover',
					'label'           => esc_html__( 'Read More Text Color Hover', 'caards' ),
					'section'         => 'color',
					'type'            => 'color',
					'output'          => array(
						array(
							'element'  => '$ .cs-entry__read-more a:hover',
							'property' => '--cs-color-primary',
							'suffix'   => '!important',
						),
					),
					'active_callback' => array(
						array(
							'field'    => '$#more_button',
							'operator' => '!=',
							'value'    => false,
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
add_filter( 'canvas_block_layouts_canvas/posts', 'csco_canvas_register_layout_standard_type_4' );
