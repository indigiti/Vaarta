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
 * Typed settings adopted by the site shell.
 */
require_once get_theme_file_path( '/inc/vaarta-shell-settings.php' );

/**
 * Return the registered site-shell layouts.
 *
 * The registry keeps template routing explicit while preserving the existing
 * header/footer template files and layout keys.
 *
 * @return array<string,array<string,array<string,string>>>
 */
function vaarta_get_site_shell_registry() {
	$registry = array(
		'header' => array(
			'one' => array(
				'slug' => 'template-parts/headers/header',
				'name' => 'one',
			),
			'two' => array(
				'slug' => 'template-parts/headers/header',
				'name' => 'two',
			),
			'three' => array(
				'slug' => 'template-parts/headers/header',
				'name' => 'three',
			),
			'four' => array(
				'slug' => 'template-parts/headers/header',
				'name' => 'four',
			),
		),
		'footer' => array(
			'one' => array(
				'slug' => 'template-parts/footers/footer',
				'name' => 'one',
			),
			'two' => array(
				'slug' => 'template-parts/footers/footer',
				'name' => 'two',
			),
			'three' => array(
				'slug' => 'template-parts/footers/footer',
				'name' => 'three',
			),
			'four' => array(
				'slug' => 'template-parts/footers/footer',
				'name' => 'four',
			),
		),
	);

	/**
	 * Filter Vaarta's site-shell template registry.
	 *
	 * Child themes can add a layout without replacing the routing facade.
	 * Existing csco_header_layout_type/csco_footer_layout_type filters remain
	 * supported by the layout accessors.
	 *
	 * @param array $registry Registered header/footer layouts.
	 */
	return apply_filters( 'vaarta_site_shell_registry', $registry );
}

/**
 * Return the active layout key for one shell region.
 *
 * @param string $area Header or footer.
 * @return string
 */
function vaarta_get_site_shell_layout( $area ) {
	$area = sanitize_key( $area );

	if ( 'header' === $area ) {
		$layout = vaarta_get_header_layout();
	} elseif ( 'footer' === $area ) {
		$layout = vaarta_get_footer_layout();
	} else {
		return '';
	}

	$layout   = is_scalar( $layout ) ? sanitize_key( (string) $layout ) : '';
	$registry = vaarta_get_site_shell_registry();

	if ( isset( $registry[ $area ][ $layout ] ) ) {
		return $layout;
	}

	// Preserve legacy child-theme layouts selected through the existing csco_*
	// filters when a matching template part actually exists.
	$legacy_slug = 'header' === $area
		? 'template-parts/headers/header'
		: 'template-parts/footers/footer';

	if ( $layout && locate_template( $legacy_slug . '-' . $layout . '.php', false, false ) ) {
		return $layout;
	}

	return 'one';
}

/**
 * Resolve the active shell region to a concrete template-part descriptor.
 *
 * @param string $area Header or footer.
 * @return array<string,string>|null
 */
function vaarta_get_site_shell_part( $area ) {
	$area = sanitize_key( $area );

	if ( ! in_array( $area, array( 'header', 'footer' ), true ) ) {
		return null;
	}

	$layout   = vaarta_get_site_shell_layout( $area );
	$registry = vaarta_get_site_shell_registry();

	if ( isset( $registry[ $area ][ $layout ] ) && is_array( $registry[ $area ][ $layout ] ) ) {
		$part = $registry[ $area ][ $layout ];
	} else {
		$part = array(
			'slug' => 'header' === $area ? 'template-parts/headers/header' : 'template-parts/footers/footer',
			'name' => $layout,
		);
	}

	$part = array(
		'area'   => $area,
		'layout' => $layout,
		'slug'   => isset( $part['slug'] ) && is_string( $part['slug'] ) ? $part['slug'] : '',
		'name'   => isset( $part['name'] ) && is_string( $part['name'] ) ? $part['name'] : $layout,
	);

	/**
	 * Filter one resolved site-shell template part.
	 *
	 * @param array  $part Resolved template-part descriptor.
	 * @param string $area Header or footer.
	 */
	$part = apply_filters( 'vaarta_site_shell_part', $part, $area );

	if ( ! is_array( $part ) || empty( $part['slug'] ) || ! isset( $part['name'] ) ) {
		return null;
	}

	return $part;
}

/**
 * Render one Vaarta-owned site-shell region.
 *
 * @param string $area Header or footer.
 * @return void
 */
function vaarta_render_site_shell_part( $area ) {
	$part = vaarta_get_site_shell_part( $area );

	if ( ! $part ) {
		return;
	}

	/**
	 * Fires immediately before a Vaarta site-shell template part renders.
	 *
	 * @param string $area Header or footer.
	 * @param array  $part Resolved template-part descriptor.
	 */
	do_action( 'vaarta_site_shell_before', $part['area'], $part );

	get_template_part(
		$part['slug'],
		$part['name'],
		array(
			'vaarta_site_shell' => $part,
		)
	);

	/**
	 * Fires immediately after a Vaarta site-shell template part renders.
	 *
	 * @param string $area Header or footer.
	 * @param array  $part Resolved template-part descriptor.
	 */
	do_action( 'vaarta_site_shell_after', $part['area'], $part );
}

/**
 * Render the active site header template part.
 *
 * @return void
 */
function vaarta_render_site_header() {
	vaarta_render_site_shell_part( 'header' );
}

/**
 * Render the active site footer template part.
 *
 * @return void
 */
function vaarta_render_site_footer() {
	vaarta_render_site_shell_part( 'footer' );
}
