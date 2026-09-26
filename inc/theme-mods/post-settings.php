<?php
/**
 * Post Settings
 *
 * @package Caards
 */

CSCO_Customizer::add_section(
	'post_settings',
	array(
		'title' => esc_html__( 'Post Settings', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'        => 'collapsible',
		'settings'    => 'post_collapsible_common',
		'section'     => 'post_settings',
		'label'       => esc_html__( 'Common', 'caards' ),
		'input_attrs' => array(
			'collapsed' => true,
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'radio',
		'settings' => 'post_sidebar',
		'label'    => esc_html__( 'Default Sidebar', 'caards' ),
		'section'  => 'post_settings',
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
		'type'     => 'multicheck',
		'settings' => 'post_meta',
		'label'    => esc_html__( 'Post Meta', 'caards' ),
		'section'  => 'post_settings',
		'default'  => array( 'category', 'date', 'author', 'views', 'shares', 'reading_time' ),
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

CSCO_Customizer::add_field(
	array(
		'type'     => 'radio',
		'settings' => 'post_header_type',
		'label'    => esc_html__( 'Default Page Header Type', 'caards' ),
		'section'  => 'post_settings',
		'default'  => 'standard',
		'choices'  => array(
			'standard' => esc_html__( 'Standard', 'caards' ),
			'large'    => esc_html__( 'Large', 'caards' ),
			'full'     => esc_html__( 'Full', 'caards' ),
			'title'    => esc_html__( 'Page Title Only', 'caards' ),
			'none'     => esc_html__( 'None', 'caards' ),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'radio',
		'settings'        => 'post_media_preview',
		'label'           => esc_html__( 'Standard Page Header Preview', 'caards' ),
		'section'         => 'post_settings',
		'default'         => 'uncropped',
		'choices'         => array(
			'cropped'   => esc_html__( 'Display Cropped Image', 'caards' ),
			'uncropped' => esc_html__( 'Display Preview in Original Ratio', 'caards' ),
		),
		'active_callback' => array(
			array(
				array(
					'setting'  => 'post_header_type',
					'operator' => '==',
					'value'    => 'standard',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'checkbox',
		'settings'        => 'post_subtitle',
		'label'           => esc_html__( 'Display excerpt as post subtitle', 'caards' ),
		'section'         => 'post_settings',
		'default'         => false,
		'active_callback' => array(
			array(
				array(
					'setting'  => 'post_header_type',
					'operator' => '!=',
					'value'    => 'title',
				),
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'post_author',
		'label'    => esc_html__( 'Display post author', 'caards' ),
		'section'  => 'post_settings',
		'default'  => false,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'post_tags',
		'label'    => esc_html__( 'Display tags', 'caards' ),
		'section'  => 'post_settings',
		'default'  => true,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'post_share_link',
		'label'    => esc_html__( 'Display share link', 'caards' ),
		'section'  => 'post_settings',
		'default'  => true,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'post_comments_simple',
		'label'    => esc_html__( 'Display comments without the View Comments button', 'caards' ),
		'section'  => 'post_settings',
		'default'  => false,
	)
);

if ( csco_powerkit_module_enabled( 'opt_in_forms' ) ) {
	CSCO_Customizer::add_field(
		array(
			'type'     => 'collapsible',
			'settings' => 'post_collapsible_subscription_form',
			'section'  => 'post_settings',
			'label'    => esc_html__( 'Subscription Form', 'caards' ),

		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'     => 'checkbox',
			'settings' => 'post_subscribe',
			'label'    => esc_html__( 'Display subscribe section', 'caards' ),
			'section'  => 'post_settings',
			'default'  => false,

		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'            => 'checkbox',
			'settings'        => 'post_subscribe_name',
			'label'           => esc_html__( 'Display first name field', 'caards' ),
			'section'         => 'post_settings',
			'default'         => false,
			'active_callback' => array(
				array(
					'setting'  => 'post_subscribe',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'            => 'text',
			'settings'        => 'post_subscribe_title',
			'label'           => esc_html__( 'Title', 'caards' ),
			'section'         => 'post_settings',
			'default'         => esc_html__( 'Subscribe to our newsletter', 'caards' ),
			'active_callback' => array(
				array(
					'setting'  => 'post_subscribe',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'              => 'text',
			'settings'          => 'post_subscribe_text',
			'label'             => esc_html__( 'Text', 'caards' ),
			'section'           => 'post_settings',
			'default'           => esc_html__( 'Get notified of the best deals on our WordPress themes', 'caards' ),
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => array(
				array(
					'setting'  => 'post_subscribe',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);
}

CSCO_Customizer::add_field(
	array(
		'type'     => 'collapsible',
		'settings' => 'post_collapsible_prev_next',
		'section'  => 'post_settings',
		'label'    => esc_html__( 'Prev Next Links', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'post_prev_next',
		'label'    => esc_html__( 'Display prev next links', 'caards' ),
		'section'  => 'post_settings',
		'default'  => true,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'collapsible',
		'settings' => 'post_collapsible_related_posts',
		'section'  => 'post_settings',
		'label'    => esc_html__( 'Related Posts', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'related',
		'label'    => esc_html__( 'Display related section', 'caards' ),
		'section'  => 'post_settings',
		'default'  => true,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'checkbox',
		'settings'        => 'related_excerpt',
		'label'           => esc_html__( 'Display excerpt', 'caards' ),
		'section'         => 'post_settings',
		'default'         => true,
		'active_callback' => array(
			array(
				'setting'  => 'related',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'select',
		'settings'        => 'related_image_orientation',
		'label'           => esc_html__( 'Image Orientation', 'caards' ),
		'section'         => 'post_settings',
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
				'setting'  => 'related',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'select',
		'settings'        => 'related_image_size',
		'label'           => esc_html__( 'Image Size', 'caards' ),
		'section'         => 'post_settings',
		'default'         => 'csco-thumbnail',
		'choices'         => csco_get_list_available_image_sizes(),
		'active_callback' => array(
			array(
				'setting'  => 'related',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'multicheck',
		'settings'        => 'related_post_meta',
		'label'           => esc_html__( 'Post Meta', 'caards' ),
		'section'         => 'post_settings',
		'default'         => array( 'date', 'views', 'shares', 'reading_time' ),
		'choices'         => apply_filters(
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
		'active_callback' => array(
			array(
				'setting'  => 'related',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

if ( csco_post_views_enabled() ) {

	CSCO_Customizer::add_field(
		array(
			'type'            => 'radio',
			'settings'        => 'related_orderby',
			'label'           => esc_html__( 'Order posts by', 'caards' ),
			'section'         => 'post_settings',
			'default'         => 'rand',
			'choices'         => array(
				'rand'       => esc_html__( 'Rand', 'caards' ),
				'date'       => esc_html__( 'Date', 'caards' ),
				'post_views' => esc_html__( 'Views', 'caards' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'related',
					'operator' => '==',
					'value'    => true,
				),
			),
		)
	);

	CSCO_Customizer::add_field(
		array(
			'type'            => 'text',
			'settings'        => 'related_time_frame',
			'label'           => esc_html__( 'Time Frame', 'caards' ),
			'description'     => esc_html__( 'Add period of posts in English. For example: &laquo;2 months&raquo;, &laquo;14 days&raquo; or even &laquo;1 year&raquo;', 'caards' ),
			'section'         => 'post_settings',
			'default'         => '',
			'active_callback' => array(
				array(
					'setting'  => 'related',
					'operator' => '==',
					'value'    => true,
				),
				array(
					'setting'  => 'related_orderby',
					'operator' => '==',
					'value'    => 'post_views',
				),
			),
		)
	);
}

CSCO_Customizer::add_field(
	array(
		'type'     => 'collapsible',
		'settings' => 'post_collapsible_load_nextpost',
		'section'  => 'post_settings',
		'label'    => esc_html__( 'Auto Load Next Post', 'caards' ),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'     => 'checkbox',
		'settings' => 'post_load_nextpost',
		'label'    => esc_html__( 'Enable the Auto Load Next Post feature', 'caards' ),
		'section'  => 'post_settings',
		'default'  => false,
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'checkbox',
		'settings'        => 'post_load_nextpost_same_category',
		'label'           => esc_html__( 'Auto load posts from the same category only', 'caards' ),
		'section'         => 'post_settings',
		'default'         => false,
		'active_callback' => array(
			array(
				'setting'  => 'post_load_nextpost',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Customizer::add_field(
	array(
		'type'            => 'checkbox',
		'settings'        => 'post_load_nextpost_reverse',
		'label'           => esc_html__( 'Auto load previous posts instead of next ones', 'caards' ),
		'section'         => 'post_settings',
		'default'         => false,
		'active_callback' => array(
			array(
				'setting'  => 'post_load_nextpost',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
