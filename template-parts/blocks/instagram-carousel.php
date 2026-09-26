<?php
/**
 * Instagram carousel template
 *
 * @var        $attributes - block attributes
 * @var        $options - layout options
 *
 * @link       https://codesupply.co
 * @since      1.0.0
 *
 * @package    PowerKit
 * @subpackage PowerKit/templates
 */

$params = array(
	'header'      => $attributes['showHeader'],
	'button'      => $attributes['showFollowButton'],
	'number'      => $attributes['number'],
	'size'        => $attributes['size'],
	'target'      => $attributes['target'],
	'template'    => $attributes['layout'],
	'is_block'    => true,
	'block_attrs' => $attributes,
);

$scheme_attr = '';
if ( 'carousel-full' === $attributes['layout'] ) {
	$scheme_attr = ' data-scheme="inverse"';
}

echo '<div class="' . esc_attr( $attributes['className'] ) . '" ' . ( isset( $attributes['anchor'] ) ? ' id="' . esc_attr( $attributes['anchor'] ) . '"' : '' ) . wp_kses( $scheme_attr, 'csco' ) . '>';

powerkit_instagram_get_recent( $params );

echo '</div>';
