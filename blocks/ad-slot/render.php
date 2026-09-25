<?php
/**
 * Render Ad Slot.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slot_name  = isset( $attributes['slotName'] ) ? sanitize_key( $attributes['slotName'] ) : 'content-inline';
$min_height = isset( $attributes['minHeight'] ) ? absint( $attributes['minHeight'] ) : 250;
$show_label = ! array_key_exists( 'showLabel', $attributes ) || ! empty( $attributes['showLabel'] );

$min_height = max( 50, min( 600, $min_height ) );

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class'           => 'vaarta-ad-slot',
		'data-vaarta-ad-slot' => $slot_name,
		'style'           => 'min-height:' . $min_height . 'px',
	)
);
?>
<aside <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-label="<?php echo esc_attr__( 'Advertisement', 'vaarta' ); ?>">
	<?php if ( $show_label ) : ?>
		<span class="vaarta-ad-slot__label"><?php esc_html_e( 'Advertisement', 'vaarta' ); ?></span>
	<?php endif; ?>
	<div class="vaarta-ad-slot__mount" data-vaarta-ad-mount="<?php echo esc_attr( $slot_name ); ?>"></div>
</aside>
