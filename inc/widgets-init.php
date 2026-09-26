<?php
/**
 * Widgets Init
 *
 * Register sitebar locations for widgets.
 *
 * @package Caards
 */

if ( ! function_exists( 'csco_widgets_init' ) ) {
	/**
	 * Register sidebars
	 */
	function csco_widgets_init() {

		register_sidebar(
			array(
				'name'          => esc_html__( 'Default Sidebar', 'caards' ),
				'id'            => 'sidebar-main',
				'before_widget' => '<div class="widget %1$s %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => csco_layout_heading( null, 'h5', 'before', false, 'sidebar' ),
				'after_title'   => csco_layout_heading( null, 'h5', 'after', false, 'sidebar' ),
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Archives', 'caards' ),
				'id'            => 'sidebar-archive',
				'before_widget' => '<div class="widget %1$s %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => csco_layout_heading( null, 'h5', 'before', false, 'sidebar' ),
				'after_title'   => csco_layout_heading( null, 'h5', 'after', false, 'sidebar' ),
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Auto Loaded Sidebar', 'caards' ),
				'id'            => 'sidebar-loaded',
				'before_widget' => '<div class="widget %1$s %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => csco_layout_heading( null, 'h5', 'before', false, 'sidebar' ),
				'after_title'   => csco_layout_heading( null, 'h5', 'after', false, 'sidebar' ),
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Off-canvas', 'caards' ),
				'id'            => 'sidebar-offcanvas',
				'before_widget' => '<div class="widget %1$s %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => csco_layout_heading( null, 'h5', 'before', false ),
				'after_title'   => csco_layout_heading( null, 'h5', 'after', false ),
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Fullscreen Menu Widgets', 'caards' ),
				'id'            => 'sidebar-fullscreen',
				'before_widget' => '<div class="widget %1$s %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => csco_layout_heading( null, 'h5', 'before', false ),
				'after_title'   => csco_layout_heading( null, 'h5', 'after', false ),
			)
		);

		register_sidebars(
			4, array(
				// Translators: Multi-Column Sidebar Number.
				'name'          => esc_html__( 'Multi-Column Sub-Menu %d', 'caards' ),
				'id'            => 'sidebar-multicolumn',
				'before_widget' => '<div class="widget %1$s %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => csco_layout_heading( null, 'h5', 'before', false, 'sidebar' ),
				'after_title'   => csco_layout_heading( null, 'h5', 'after', false, 'sidebar' ),
			)
		);

		register_sidebars(
			4, array(
				// Translators: Featured Column Sidebar Number.
				'name'          => esc_html__( 'Featured Column %d', 'caards' ),
				'id'            => 'sidebar-featured',
				'before_widget' => '<div class="widget %1$s %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => csco_layout_heading( null, 'h5', 'before', false ),
				'after_title'   => csco_layout_heading( null, 'h5', 'after', false ),
			)
		);
	}
	add_action( 'widgets_init', 'csco_widgets_init' );
}
