<?php
/**
 * Block Custom Link
 *
 * @var $attributes - block attributes
 * @var $options - layout options
 *
 * @package Caards
 */

?>
<div class="<?php echo esc_attr( $attributes['className'] ); ?>">
	<a class="cs-custom-link" target="<?php echo esc_html( $attributes['target'] ); ?>" href="<?php echo esc_url( $attributes['url'] ); ?>">
		<span><?php echo esc_html( $attributes['label'] ); ?></span>
	</a>
</div>
