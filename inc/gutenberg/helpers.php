<?php
/**
 * Helpers Gutenberg.
 *
 * @package Caards
 */

if ( ! function_exists( 'csco_get_gutenberg_posts_hide_fields' ) ) {
	/**
	 * Get hide fields array for posts
	 */
	function csco_get_gutenberg_posts_hide_fields() {
		return array(
			'imageSize',
			'postsCount',
			'showPagination',
			'showMetaCategory',
			'showMetaAuthor',
			'showMetaDate',
			'showMetaComments',
			'showMetaViews',
			'showMetaReadingTime',
			'showMetaShares',
			'showExcerpt',
			'showViewPostButton',
			'colorText',
			'colorHeading',
			'colorHeadingHover',
			'colorText',
			'colorMeta',
			'colorMetaHover',
			'colorMetaLinks',
			'colorMetaLinksHover',
		);
	}
}

if ( ! function_exists( 'csco_get_gutenberg_pagination_fields' ) ) {
	/**
	 * Get fields array for pagination
	 */
	function csco_get_gutenberg_pagination_fields() {
		// Set fields.
		$fields = array(
			array(
				'key'             => 'paginationType',
				'label'           => esc_html__( 'Pagination type', 'caards' ),
				'section'         => 'general',
				'type'            => 'select',
				'multiple'        => false,
				'choices'         => array(
					'none'     => esc_html__( 'None', 'caards' ),
					'standard' => esc_html__( 'Standard', 'caards' ),
					'ajax'     => esc_html__( 'Load More', 'caards' ),
					'infinite' => esc_html__( 'Infinite Load', 'caards' ),
				),
				'default'         => 'none',
				'active_callback' => array(
					array(
						'field'    => 'relatedPosts',
						'operator' => '==',
						'value'    => false,
					),
					array(
						array(
							array(
								'field'    => 'query.categories',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.tags',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.orderby',
								'operator' => '===',
								'value'    => 'date',
							),
							array(
								'field'    => 'query.order',
								'operator' => '===',
								'value'    => 'DESC',
							),
							array(
								'field'    => 'query.posts_type',
								'operator' => '===',
								'value'    => 'post',
							),
							array(
								'field'    => 'query.formats',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.posts',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.offset',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'avoidDuplicatePosts',
								'operator' => '===',
								'value'    => false,
							),
						),
						array(
							array(
								'field'    => 'query.categories',
								'operator' => '!==',
								'value'    => '',
							),
							array(
								'field'    => 'query.categories',
								'count'    => ',',
								'operator' => '==',
								'value'    => 0,
							),
							array(
								'field'    => 'query.tags',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.orderby',
								'operator' => '===',
								'value'    => 'date',
							),
							array(
								'field'    => 'query.order',
								'operator' => '===',
								'value'    => 'DESC',
							),
							array(
								'field'    => 'query.posts_type',
								'operator' => '===',
								'value'    => 'post',
							),
							array(
								'field'    => 'query.formats',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.posts',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.offset',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'avoidDuplicatePosts',
								'operator' => '===',
								'value'    => false,
							),
						),
						array(
							array(
								'field'    => 'query.tags',
								'count'    => ',',
								'operator' => '==',
								'value'    => 0,
							),
							array(
								'field'    => 'query.categories',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.orderby',
								'operator' => '===',
								'value'    => 'date',
							),
							array(
								'field'    => 'query.order',
								'operator' => '===',
								'value'    => 'DESC',
							),
							array(
								'field'    => 'query.posts_type',
								'operator' => '===',
								'value'    => 'post',
							),
							array(
								'field'    => 'query.formats',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.posts',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.offset',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'avoidDuplicatePosts',
								'operator' => '===',
								'value'    => false,
							),
						),
					),
				),
			),
			array(
				'key'             => 'paginationTypeAlt',
				'label'           => esc_html__( 'Pagination type', 'caards' ),
				'section'         => 'general',
				'type'            => 'select',
				'multiple'        => false,
				'choices'         => array(
					'none'     => esc_html__( 'None', 'caards' ),
					'ajax'     => esc_html__( 'Load More', 'caards' ),
					'infinite' => esc_html__( 'Infinite Load', 'caards' ),
				),
				'default'         => 'none',
				'active_callback' => array(
					array(
						'field'    => 'relatedPosts',
						'operator' => '==',
						'value'    => false,
					),
					array(
						array(
							'field'    => 'query.orderby',
							'operator' => '!==',
							'value'    => 'date',
						),
						array(
							'field'    => 'query.order',
							'operator' => '!==',
							'value'    => 'DESC',
						),
						array(
							'field'    => 'query.posts_type',
							'operator' => '!==',
							'value'    => 'post',
						),
						array(
							'field'    => 'query.formats',
							'operator' => '!==',
							'value'    => '',
						),
						array(
							'field'    => 'query.posts',
							'operator' => '!==',
							'value'    => '',
						),
						array(
							'field'    => 'query.offset',
							'operator' => '!==',
							'value'    => '',
						),
						array(
							'field'    => 'avoidDuplicatePosts',
							'operator' => '!==',
							'value'    => false,
						),
						array(
							array(
								'field'    => 'query.categories',
								'operator' => '!==',
								'value'    => '',
							),
							array(
								'field'    => 'query.tags',
								'operator' => '!==',
								'value'    => '',
							),
						),
						array(
							array(
								'field'    => 'query.categories',
								'operator' => '!==',
								'value'    => '',
							),
							array(
								'field'    => 'query.categories',
								'count'    => ',',
								'operator' => '>=',
								'value'    => 1,
							),
						),
						array(
							array(
								'field'    => 'query.tags',
								'operator' => '!==',
								'value'    => '',
							),
							array(
								'field'    => 'query.tags',
								'count'    => ',',
								'operator' => '>=',
								'value'    => 1,
							),
						),
					),
				),
			),
			array(
				'key'             => 'areaPostsCount',
				'label'           => esc_html__( 'Posts Count', 'caards' ),
				'section'         => 'general',
				'type'            => 'number',
				'default'         => 1,
				'min'             => 1,
				'max'             => 100,
				'active_callback' => array(
					array(
						array(
							array(
								'field'    => '$#paginationType',
								'operator' => '!=',
								'value'    => 'standard',
							),
							array(
								'field'    => 'query.categories',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.tags',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.orderby',
								'operator' => '===',
								'value'    => 'date',
							),
							array(
								'field'    => 'query.order',
								'operator' => '===',
								'value'    => 'DESC',
							),
							array(
								'field'    => 'query.posts_type',
								'operator' => '===',
								'value'    => 'post',
							),
							array(
								'field'    => 'query.formats',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.posts',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.offset',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'avoidDuplicatePosts',
								'operator' => '===',
								'value'    => false,
							),
						),
						array(
							array(
								'field'    => '$#paginationType',
								'operator' => '!=',
								'value'    => 'standard',
							),
							array(
								'field'    => 'query.categories',
								'operator' => '!==',
								'value'    => '',
							),
							array(
								'field'    => 'query.categories',
								'count'    => ',',
								'operator' => '==',
								'value'    => 0,
							),
							array(
								'field'    => 'query.tags',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.orderby',
								'operator' => '===',
								'value'    => 'date',
							),
							array(
								'field'    => 'query.order',
								'operator' => '===',
								'value'    => 'DESC',
							),
							array(
								'field'    => 'query.posts_type',
								'operator' => '===',
								'value'    => 'post',
							),
							array(
								'field'    => 'query.formats',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.posts',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.offset',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'avoidDuplicatePosts',
								'operator' => '===',
								'value'    => false,
							),
						),
						array(
							array(
								'field'    => '$#paginationType',
								'operator' => '!=',
								'value'    => 'standard',
							),
							array(
								'field'    => 'query.tags',
								'count'    => ',',
								'operator' => '==',
								'value'    => 0,
							),
							array(
								'field'    => 'query.categories',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.orderby',
								'operator' => '===',
								'value'    => 'date',
							),
							array(
								'field'    => 'query.order',
								'operator' => '===',
								'value'    => 'DESC',
							),
							array(
								'field'    => 'query.posts_type',
								'operator' => '===',
								'value'    => 'post',
							),
							array(
								'field'    => 'query.formats',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.posts',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'query.offset',
								'operator' => '===',
								'value'    => '',
							),
							array(
								'field'    => 'avoidDuplicatePosts',
								'operator' => '===',
								'value'    => false,
							),
						),
						array(
							'field'    => 'query.orderby',
							'operator' => '!==',
							'value'    => 'date',
						),
						array(
							'field'    => 'query.order',
							'operator' => '!==',
							'value'    => 'DESC',
						),
						array(
							'field'    => 'query.posts_type',
							'operator' => '!==',
							'value'    => 'post',
						),
						array(
							'field'    => 'query.formats',
							'operator' => '!==',
							'value'    => '',
						),
						array(
							'field'    => 'query.posts',
							'operator' => '!==',
							'value'    => '',
						),
						array(
							'field'    => 'query.offset',
							'operator' => '!==',
							'value'    => '',
						),
						array(
							'field'    => 'avoidDuplicatePosts',
							'operator' => '!==',
							'value'    => false,
						),
						array(
							array(
								'field'    => 'query.categories',
								'operator' => '!==',
								'value'    => '',
							),
							array(
								'field'    => 'query.tags',
								'operator' => '!==',
								'value'    => '',
							),
						),
						array(
							array(
								'field'    => 'query.categories',
								'operator' => '!==',
								'value'    => '',
							),
							array(
								'field'    => 'query.categories',
								'count'    => ',',
								'operator' => '>=',
								'value'    => 1,
							),
						),
						array(
							array(
								'field'    => 'query.tags',
								'operator' => '!==',
								'value'    => '',
							),
							array(
								'field'    => 'query.tags',
								'count'    => ',',
								'operator' => '>=',
								'value'    => 1,
							),
						),
					),
				),
			),
		);

		return $fields;
	}
}

if ( ! function_exists( 'csco_get_gutenberg_meta_fields' ) ) {
	/**
	 * Get fields array for Meta
	 *
	 * @param array $settings The settings.
	 */
	function csco_get_gutenberg_meta_fields( $settings ) {

		$settings = array_merge( array(
			'field_prefix'    => '',
			'section_name'    => '',
			'meta_compact'    => false,
			'active_callback' => array(),
			'exclude'         => array(),
			'default'         => array(
				'category'     => true,
				'author'       => true,
				'date'         => true,
				'comments'     => false,
				'views'        => false,
				'reading_time' => false,
				'shares'       => false,
			),
		), $settings );

		$settings['field_prefix'] = $settings['field_prefix'] ? sprintf( '%s_', $settings['field_prefix'] ) : null;

		// Set fields.
		$fields = array(
			array(
				'key'             => $settings['field_prefix'] . 'display_meta_category',
				'label'           => esc_html__( 'Category', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'toggle',
				'default'         => $settings['default']['category'],
				'active_callback' => $settings['active_callback'],
			),
			array(
				'key'             => $settings['field_prefix'] . 'display_meta_author',
				'label'           => esc_html__( 'Author', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'toggle',
				'default'         => $settings['default']['author'],
				'active_callback' => $settings['active_callback'],
			),
			array(
				'key'             => $settings['field_prefix'] . 'display_meta_date',
				'label'           => esc_html__( 'Date', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'toggle',
				'default'         => $settings['default']['date'],
				'active_callback' => $settings['active_callback'],
			),
			array(
				'key'             => $settings['field_prefix'] . 'display_meta_comments',
				'label'           => esc_html__( 'Comments', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'toggle',
				'default'         => $settings['default']['comments'],
				'active_callback' => $settings['active_callback'],
			),
			csco_post_views_enabled() ? array(
				'key'             => $settings['field_prefix'] . 'display_meta_views',
				'label'           => esc_html__( 'Views', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'toggle',
				'default'         => $settings['default']['views'],
				'active_callback' => $settings['active_callback'],
			) : array(),
			csco_powerkit_module_enabled( 'reading_time' ) ? array(
				'key'             => $settings['field_prefix'] . 'display_meta_reading_time',
				'label'           => esc_html__( 'Reading Time', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'toggle',
				'default'         => $settings['default']['reading_time'],
				'active_callback' => $settings['active_callback'],
			) : array(),
			function_exists( 'powerkit_share_buttons_exists' ) && powerkit_share_buttons_exists( 'block-posts' ) ? array(
				'key'             => $settings['field_prefix'] . 'display_meta_shares',
				'label'           => esc_html__( 'Shares', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'toggle',
				'default'         => $settings['default']['shares'],
				'active_callback' => $settings['active_callback'],
			) : array(),
			array(
				'key'             => uniqid(),
				'section'         => $settings['section_name'],
				'type'            => 'separator',
				'active_callback' => $settings['active_callback'],
			),
			array(
				'key'             => $settings['field_prefix'] . 'display_meta_compact',
				'label'           => esc_html__( 'Display compact post meta', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'toggle',
				'default'         => $settings['meta_compact'],
				'active_callback' => $settings['active_callback'],
			),
		);

		if ( $settings['exclude'] ) {
			foreach ( $settings['exclude'] as $name => $meta ) {
				unset( $fields[ $meta ] );
			}
		}

		return $fields;
	}
}

if ( ! function_exists( 'csco_get_gutenberg_excerpt_fields' ) ) {
	/**
	 * Get fields array for Excerpt
	 *
	 * @param array $settings The settings.
	 */
	function csco_get_gutenberg_excerpt_fields( $settings ) {

		$settings = array_merge( array(
			'field_prefix'    => '',
			'section_name'    => '',
			'active_callback' => array(),
			'sep'             => true,
			'default'         => false,
		), $settings );

		$settings['field_prefix'] = $settings['field_prefix'] ? sprintf( '%s_', $settings['field_prefix'] ) : null;

		// Set fields.
		$fields = array(
			$settings['sep'] ? array(
				'key'             => uniqid(),
				'section'         => $settings['section_name'],
				'type'            => 'separator',
				'active_callback' => $settings['active_callback'],
			) : array(),
			array(
				'key'             => $settings['field_prefix'] . 'display_excerpt',
				'label'           => esc_html__( 'Display post excerpt', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'toggle',
				'default'         => $settings['default'],
				'active_callback' => $settings['active_callback'],
			),
			array(
				'key'             => $settings['field_prefix'] . 'excerpt_length',
				'label'           => esc_html__( 'Excerpt length', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'toggle',
				'type'            => 'number',
				'step'            => 1,
				'min'             => 1,
				'max'             => 1000,
				'default'         => 100,
				'active_callback' => array_merge(
					array(
						array(
							'field'    => '$#' . $settings['field_prefix'] . 'display_excerpt',
							'operator' => '==',
							'value'    => true,
						),
					),
					$settings['active_callback']
				),
			),
		);

		return $fields;
	}
}

if ( ! function_exists( 'csco_get_gutenberg_view_link_fields' ) ) {
	/**
	 * Get fields array for View Link
	 *
	 * @param array $settings The settings.
	 */
	function csco_get_gutenberg_view_link_fields( $settings ) {

		$settings = array_merge( array(
			'field_prefix'    => '',
			'section_name'    => '',
			'active_callback' => array(),
			'sep'             => true,
			'default'         => false,
		), $settings );

		$settings['field_prefix'] = $settings['field_prefix'] ? sprintf( '%s_', $settings['field_prefix'] ) : null;

		// Set fields.
		$fields = array(
			$settings['sep'] ? array(
				'key'             => uniqid(),
				'section'         => $settings['section_name'],
				'type'            => 'separator',
				'active_callback' => $settings['active_callback'],
			) : array(),
			array(
				'key'             => $settings['field_prefix'] . 'display_view_link',
				'label'           => esc_html__( 'Display view post link', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'toggle',
				'default'         => $settings['default'],
				'active_callback' => $settings['active_callback'],
			),
			array(
				'key'             => $settings['field_prefix'] . 'view_link_label',
				'label'           => esc_html__( 'View Post Link Label', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'text',
				'default'         => '',
				'active_callback' => array_merge(
					array(
						array(
							'field'    => '$#' . $settings['field_prefix'] . 'display_view_link',
							'operator' => '==',
							'value'    => true,
						),
					),
					$settings['active_callback']
				),
			),
		);

		return $fields;
	}
}

if ( ! function_exists( 'csco_get_gutenberg_more_button_fields' ) ) {
	/**
	 * Get fields array for More Button
	 *
	 * @param array $settings The settings.
	 */
	function csco_get_gutenberg_more_button_fields( $settings ) {

		$settings = array_merge( array(
			'field_prefix'    => '',
			'section_name'    => '',
			'active_callback' => array(),
			'sep'             => true,
			'default'         => false,
		), $settings );

		$settings['field_prefix'] = $settings['field_prefix'] ? sprintf( '%s_', $settings['field_prefix'] ) : null;

		// Set fields.
		$fields = array(
			$settings['sep'] ? array(
				'key'             => uniqid(),
				'section'         => $settings['section_name'],
				'type'            => 'separator',
				'active_callback' => $settings['active_callback'],
			) : array(),
			array(
				'key'             => $settings['field_prefix'] . 'display_more_button',
				'label'           => esc_html__( 'Display read more button', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'toggle',
				'default'         => $settings['default'],
				'active_callback' => $settings['active_callback'],
			),
			array(
				'key'             => $settings['field_prefix'] . 'more_button_label',
				'label'           => esc_html__( 'More Button Label', 'caards' ),
				'section'         => $settings['section_name'],
				'type'            => 'text',
				'default'         => '',
				'active_callback' => array_merge(
					array(
						array(
							'field'    => '$#' . $settings['field_prefix'] . 'display_more_button',
							'operator' => '==',
							'value'    => true,
						),
					),
					$settings['active_callback']
				),
			),
		);

		return $fields;
	}
}
