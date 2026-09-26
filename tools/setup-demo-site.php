<?php
/**
 * Bootstrap a deterministic Vaarta demo site with WP-CLI.
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

$result = vaarta_install_demo_site();

WP_CLI::log( 'Vaarta demo pages:' );
foreach ( $result['pages'] as $slug => $page_id ) {
	WP_CLI::log( sprintf( '  %-14s %s', $slug, get_permalink( $page_id ) ) );
}
if ( $result['blog'] ) {
	WP_CLI::log( '  blog           ' . get_permalink( $result['blog'] ) );
}
WP_CLI::success( 'Vaarta demo site bootstrapped. Choose the desired Global Style variation in Appearance → Editor → Styles.' );
