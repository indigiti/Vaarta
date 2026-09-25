<?php
/**
 * Bootstrap a deterministic Vaarta demo site.
 *
 * Usage from the WordPress root:
 * wp eval-file wp-content/themes/vaarta/tools/setup-demo-site.php
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	wp_die( esc_html__( 'This setup script must be run with WP-CLI.', 'vaarta' ) );
}

require __DIR__ . '/seed-demo.php';

$demo_page_key = '_vaarta_demo_page';

$pages = array(
	'tech' => array(
		'title'    => 'Tech',
		'pattern'  => 'vaarta/tech-home',
		'template' => 'page-demo',
	),
	'firmware' => array(
		'title'    => 'Firmware',
		'pattern'  => 'vaarta/home-firmware',
		'template' => 'page-demo',
	),
	'datacrunch' => array(
		'title'    => 'Datacrunch',
		'pattern'  => 'vaarta/home-datacrunch',
		'template' => 'page-demo',
	),
	'foundr' => array(
		'title'    => 'Foundr',
		'pattern'  => 'vaarta/home-foundr',
		'template' => 'page-demo',
	),
	'artboard' => array(
		'title'    => 'Artboard',
		'pattern'  => 'vaarta/home-artboard',
		'template' => 'page-demo',
	),
	'design-loft' => array(
		'title'    => 'Design Loft',
		'pattern'  => 'vaarta/home-design-loft',
		'template' => 'page-demo',
	),
);

$page_ids = array();

foreach ( $pages as $slug => $config ) {
	$existing = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'meta_key'       => $demo_page_key,
			'meta_value'     => $slug,
			'fields'         => 'ids',
		)
	);

	$postarr = array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => $config['title'],
		'post_name'    => $slug,
		'post_content' => sprintf(
			'<!-- wp:pattern {"slug":"%s"} /-->',
			esc_attr( $config['pattern'] )
		),
		'meta_input'   => array(
			$demo_page_key => $slug,
		),
	);

	if ( $existing ) {
		$postarr['ID'] = (int) $existing[0];
		$page_id       = wp_update_post( $postarr, true );
	} else {
		$page_id = wp_insert_post( $postarr, true );
	}

	if ( is_wp_error( $page_id ) ) {
		WP_CLI::warning(
			sprintf(
				'Could not create %1$s: %2$s',
				$config['title'],
				$page_id->get_error_message()
			)
		);
		continue;
	}

	update_post_meta( $page_id, '_wp_page_template', $config['template'] );
	$page_ids[ $slug ] = (int) $page_id;
}

$blog_existing = get_posts(
	array(
		'post_type'      => 'page',
		'post_status'    => 'any',
		'posts_per_page' => 1,
		'meta_key'       => $demo_page_key,
		'meta_value'     => 'blog',
		'fields'         => 'ids',
	)
);

$blog_postarr = array(
	'post_type'   => 'page',
	'post_status' => 'publish',
	'post_title'  => 'Blog',
	'post_name'   => 'blog',
	'meta_input'  => array(
		$demo_page_key => 'blog',
	),
);

if ( $blog_existing ) {
	$blog_postarr['ID'] = (int) $blog_existing[0];
	$blog_id             = wp_update_post( $blog_postarr, true );
} else {
	$blog_id = wp_insert_post( $blog_postarr, true );
}

if ( isset( $page_ids['tech'] ) ) {
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $page_ids['tech'] );
}

if ( ! is_wp_error( $blog_id ) ) {
	update_option( 'page_for_posts', (int) $blog_id );
}

flush_rewrite_rules();

WP_CLI::log( 'Vaarta demo pages:' );

foreach ( $page_ids as $slug => $page_id ) {
	WP_CLI::log(
		sprintf(
			'  %-14s %s',
			$slug,
			get_permalink( $page_id )
		)
	);
}

if ( ! is_wp_error( $blog_id ) ) {
	WP_CLI::log( '  blog           ' . get_permalink( $blog_id ) );
}

WP_CLI::success( 'Vaarta demo site bootstrapped. Choose the desired Global Style variation in Appearance → Editor → Styles.' );
