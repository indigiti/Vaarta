<?php
/**
 * Vaarta template rendering facade.
 *
 * The current visual system still uses the proven legacy PHP template parts.
 * Routing them through Vaarta-owned functions gives the theme one stable seam
 * for future block-template or pattern-backed rendering without changing the
 * existing DOM contract today.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the active site header template part.
 *
 * @return void
 */
function vaarta_render_site_header() {
	$layout = function_exists( 'csco_get_header_layout_type' )
		? csco_get_header_layout_type()
		: vaarta_get_header_layout();

	get_template_part( 'template-parts/headers/header', $layout );
}

/**
 * Render the active site footer template part.
 *
 * @return void
 */
function vaarta_render_site_footer() {
	$layout = function_exists( 'csco_get_footer_layout_type' )
		? csco_get_footer_layout_type()
		: vaarta_get_footer_layout();

	get_template_part( 'template-parts/footers/footer', $layout );
}
