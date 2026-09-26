<?php
/**
 * Theme Demos
 *
 * @package Caards
 */

/**
 * Register Demos of Theme
 */
function csco_demos_list() {

	$plugins = array(
		array(
			'name'     => 'Canvas',
			'slug'     => 'canvas',
			'path'     => 'canvas/canvas.php',
			'required' => true,
			'desc'     => esc_html__( 'A revolutionary block-based page builder used for building layouts, an interplay of the WordPress block editor features and exceptional UI design.', 'caards' ),
		),
		array(
			'name'     => 'Powerkit',
			'slug'     => 'powerkit',
			'path'     => 'powerkit/powerkit.php',
			'required' => false,
			'desc'     => esc_html__( 'Powerkit – essential components for every WordPress site.', 'caards' ),
		),
		array(
			'name'     => 'Absolute Reviews',
			'slug'     => 'absolute-reviews',
			'path'     => 'absolute-reviews/absolute-reviews.php',
			'required' => false,
			'desc'     => esc_html__( 'Add beautiful responsive and modern review boxes with valid JSON-LD schema to your posts with the "Advanced Reviews" plugin.', 'caards' ),
		),
		array(
			'name'     => 'Advanced Popups',
			'slug'     => 'advanced-popups',
			'path'     => 'advanced-popups/advanced-popups.php',
			'required' => false,
			'desc'     => esc_html__( 'Display high-converting newsletter popups, a cookie notice, or a notification with the light-weight yet feature-rich plugin.', 'caards' ),
		),
		array(
			'name'     => 'Regenerate Thumbnails',
			'slug'     => 'regenerate-thumbnails',
			'path'     => 'regenerate-thumbnails/regenerate-thumbnails.php',
			'required' => false,
			'desc'     => esc_html__( 'Regenerate the thumbnails for one or more of your image uploads. Useful when changing their sizes or your theme.', 'caards' ),
		),
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'path'     => 'contact-form-7/wp-contact-form-7.php',
			'required' => false,
			'desc'     => esc_html__( 'Just another contact form plugin. Simple but flexible.', 'caards' ),
		),
	);

	$demos = array(
		'caards'      => array(
			'name'      => esc_html__( 'Caards', 'caards' ),
			'preview'   => 'https://caards.codesupply.co/caards/',
			'thumbnail' => get_template_directory_uri() . '/import/caards-thumbnail.jpg',
			'plugins'   => $plugins,
			'import'    => array(
				'customizer' => 'https://cloud.codesupply.co/import/caards/caards-customizer.dat',
				'widgets'    => 'https://cloud.codesupply.co/import/caards/widgets.wie',
				'content'    => array(
					array(
						'label' => esc_html__( 'Homepage', 'caards' ),
						'url'   => 'https://cloud.codesupply.co/import/caards/caards-homepage.xml',
						'type'  => 'homepage',
					),
					array(
						'label' => esc_html__( 'Demo Content', 'caards' ),
						'url'   => 'https://cloud.codesupply.co/import/caards/content.xml',
						'desc'  => esc_html__( 'Enabling this option will import demo posts, categories, and secondary pages. It\'s recommended to disable this option for existing', 'caards' ),
					),
				),
			),
		),
		'firmware'    => array(
			'name'      => esc_html__( 'Firmware', 'caards' ),
			'preview'   => 'https://caards.codesupply.co/firmware/',
			'thumbnail' => get_template_directory_uri() . '/import/firmware-thumbnail.jpg',
			'plugins'   => $plugins,
			'import'    => array(
				'customizer' => 'https://cloud.codesupply.co/import/caards/firmware-customizer.dat',
				'widgets'    => 'https://cloud.codesupply.co/import/caards/widgets.wie',
				'content'    => array(
					array(
						'label' => esc_html__( 'Homepage', 'caards' ),
						'url'   => 'https://cloud.codesupply.co/import/caards/firmware-homepage.xml',
					),
					array(
						'label' => esc_html__( 'Demo Content', 'caards' ),
						'url'   => 'https://cloud.codesupply.co/import/caards/content.xml',
						'desc'  => esc_html__( 'Enabling this option will import demo posts, categories, and secondary pages. It\'s recommended to disable this option for existing', 'caards' ),
					),
				),
			),
		),
		'datacrunch'  => array(
			'name'      => esc_html__( 'Datacrunch', 'caards' ),
			'preview'   => 'https://caards.codesupply.co/datacrunch/',
			'thumbnail' => get_template_directory_uri() . '/import/datacrunch-thumbnail.jpg',
			'plugins'   => $plugins,
			'import'    => array(
				'customizer' => 'https://cloud.codesupply.co/import/caards/datacrunch-customizer.dat',
				'widgets'    => 'https://cloud.codesupply.co/import/caards/widgets.wie',
				'content'    => array(
					array(
						'label' => esc_html__( 'Homepage', 'caards' ),
						'url'   => 'https://cloud.codesupply.co/import/caards/datacrunch-homepage.xml',
					),
					array(
						'label' => esc_html__( 'Demo Content', 'caards' ),
						'url'   => 'https://cloud.codesupply.co/import/caards/content.xml',
						'desc'  => esc_html__( 'Enabling this option will import demo posts, categories, and secondary pages. It\'s recommended to disable this option for existing', 'caards' ),
					),
				),
			),
		),
		'foundr'      => array(
			'name'      => esc_html__( 'Foundr', 'caards' ),
			'preview'   => 'https://caards.codesupply.co/foundr/',
			'thumbnail' => get_template_directory_uri() . '/import/foundr-thumbnail.jpg',
			'plugins'   => $plugins,
			'import'    => array(
				'customizer' => 'https://cloud.codesupply.co/import/caards/foundr-customizer.dat',
				'widgets'    => 'https://cloud.codesupply.co/import/caards/widgets.wie',
				'content'    => array(
					array(
						'label' => esc_html__( 'Homepage', 'caards' ),
						'url'   => 'https://cloud.codesupply.co/import/caards/foundr-homepage.xml',
					),
					array(
						'label' => esc_html__( 'Demo Content', 'caards' ),
						'url'   => 'https://cloud.codesupply.co/import/caards/content.xml',
						'desc'  => esc_html__( 'Enabling this option will import demo posts, categories, and secondary pages. It\'s recommended to disable this option for existing', 'caards' ),
					),
				),
			),
		),
		'artboard'    => array(
			'name'      => esc_html__( 'Artboard', 'caards' ),
			'preview'   => 'https://caards.codesupply.co/artboard/',
			'thumbnail' => get_template_directory_uri() . '/import/artboard-thumbnail.jpg',
			'plugins'   => $plugins,
			'import'    => array(
				'customizer' => 'https://cloud.codesupply.co/import/caards/artboard-customizer.dat',
				'widgets'    => 'https://cloud.codesupply.co/import/caards/widgets.wie',
				'content'    => array(
					array(
						'label' => esc_html__( 'Homepage', 'caards' ),
						'url'   => 'https://cloud.codesupply.co/import/caards/artboard-homepage.xml',
					),
					array(
						'label' => esc_html__( 'Demo Content', 'caards' ),
						'url'   => 'https://cloud.codesupply.co/import/caards/content.xml',
						'desc'  => esc_html__( 'Enabling this option will import demo posts, categories, and secondary pages. It\'s recommended to disable this option for existing', 'caards' ),
					),
				),
			),
		),
		'design-loft' => array(
			'name'      => esc_html__( 'Design Loft', 'caards' ),
			'preview'   => 'https://caards.codesupply.co/design-loft/',
			'thumbnail' => get_template_directory_uri() . '/import/design-loft-thumbnail.jpg',
			'plugins'   => $plugins,
			'import'    => array(
				'customizer' => 'https://cloud.codesupply.co/import/caards/design-loft-customizer.dat',
				'widgets'    => 'https://cloud.codesupply.co/import/caards/widgets.wie',
				'content'    => array(
					array(
						'label' => esc_html__( 'Homepage', 'caards' ),
						'url'   => 'https://cloud.codesupply.co/import/caards/design-loft-homepage.xml',
					),
					array(
						'label' => esc_html__( 'Demo Content', 'caards' ),
						'url'   => 'https://cloud.codesupply.co/import/caards/content.xml',
						'desc'  => esc_html__( 'Enabling this option will import demo posts, categories, and secondary pages. It\'s recommended to disable this option for existing', 'caards' ),
					),
				),
			),
		),
	);

	return $demos;
}
add_filter( 'csco_register_demos_list', 'csco_demos_list' );

/**
 * Import Homepage
 *
 * @param int   $post_id New post ID.
 * @param array $data    Raw data imported for the post.
 */
function csco_hook_import_homepage( $post_id, $data ) {
	if ( isset( $data['post_title'] ) && 'Homepage' === $data['post_title'] ) {
		// Set show_on_front.
		update_option( 'show_on_front', 'page' );

		// Set page_on_front.
		update_option( 'page_on_front', (int) $post_id );
	}

	if ( isset( $data['post_title'] ) && 'Blog' === $data['post_title'] ) {
		// Set show_on_front.
		update_option( 'show_on_front', 'page' );

		// Set page_on_front.
		update_option( 'page_for_posts', (int) $post_id );
	}
}
add_action( 'wxr_importer.db.post', 'csco_hook_import_homepage', 10, 2 );

/**
 * Finish Import
 */
function csco_hook_finish_import() {

	$nav_menu_locations = array();

	$main_menu = get_term_by( 'name', 'Primary', 'nav_menu' );
	if ( $main_menu ) {
		$nav_menu_locations['primary']    = $main_menu->term_id;
		$nav_menu_locations['fullscreen'] = $main_menu->term_id;
		$nav_menu_locations['mobile']     = $main_menu->term_id;
	}

	$footer_menu = get_term_by( 'name', 'Footer', 'nav_menu' );
	if ( $footer_menu ) {
		$nav_menu_locations['footer'] = $footer_menu->term_id;
	}

	$footer_col_1 = get_term_by( 'name', 'Demos', 'nav_menu' );
	if ( $footer_col_1 ) {
		$nav_menu_locations['footer-col-1'] = $footer_col_1->term_id;
	}

	$footer_col_2 = get_term_by( 'name', 'Categories', 'nav_menu' );
	if ( $footer_col_2 ) {
		$nav_menu_locations['footer-col-2'] = $footer_col_2->term_id;
	}

	$footer_additional = get_term_by( 'name', 'Footer Additional', 'nav_menu' );
	if ( $footer_additional ) {
		$nav_menu_locations['footer-additional'] = $footer_additional->term_id;
	}

	if ( $nav_menu_locations ) {
		set_theme_mod( 'nav_menu_locations', $nav_menu_locations );
	}
}
add_action( 'csco_finish_import', 'csco_hook_finish_import' );
