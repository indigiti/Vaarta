<?php
/**
 * Register Horizontal Type 4.
 *
 * @package Caards
 */

/**
 * Register New Layout
 *
 * @param array $layouts List of layouts.
 */
function csco_canvas_register_layout_horizontal_type_4( $layouts = array() ) {

	$layout = 'horizontal-type-4';

	// Add new layout.
	$layouts[ $layout ] = array(
		'location'    => array(),
		'name'        => esc_html__( 'Horizontal 4', 'caards' ),
		'template'    => get_template_directory() . '/template-parts/blocks/posts-area.php',
		'icon'        => '<svg fill="none" height="44" viewBox="0 0 52 44" width="52" xmlns="http://www.w3.org/2000/svg"><g stroke="#000"><rect height="42" rx="2" stroke-width="1.5" width="50" x="1" y="1"/><g stroke-linecap="round" stroke-linejoin="round"><path d="m21 6h12"/><path d="m21 18h12"/><path d="m21 30h12"/><path d="m21 10h17"/><path d="m21 22h17"/><path d="m21 34h17"/><path d="m21 12h7"/><path d="m21 24h10"/><path d="m21 36h7"/><path d="m21 8h26"/><path d="m21 20h26"/><path d="m21 32h26"/></g><rect height="8" rx="1" stroke-width="1.5" width="12" x="5" y="6"/><rect height="8" rx="1" stroke-width="1.5" width="12" x="5" y="18"/><rect height="8" rx="1" stroke-width="1.5" width="12" x="5" y="30"/></g></svg>',
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
				// Typography.
				array(
					'key'        => 'typography_heading',
					'label'      => esc_html__( 'Heading Font Size', 'caards' ),
					'section'    => 'typography',
					'type'       => 'dimension',
					'default'    => '1rem',
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
					'key'     => 'color_border',
					'label'   => esc_html__( 'Border Color', 'caards' ),
					'section' => 'color',
					'type'    => 'color',
					'output'  => array(
						array(
							'element'  => '$',
							'property' => '--cs-posts-border-color',
							'suffix'   => '!important',
						),
					),
				),
			),
			// Primary Meta.
			csco_get_gutenberg_meta_fields(
				array(
					'section_name' => 'post-meta',
					'default'      => array(
						'category'     => false,
						'author'       => true,
						'date'         => true,
						'comments'     => false,
						'views'        => false,
						'reading_time' => false,
						'shares'       => false,
					),
				)
			),
			csco_get_gutenberg_excerpt_fields(
				array(
					'section_name' => 'post-meta',
					'default'      => false,
				)
			),
		),
	);

	return $layouts;
}
add_filter( 'canvas_block_layouts_canvas/posts', 'csco_canvas_register_layout_horizontal_type_4' );
