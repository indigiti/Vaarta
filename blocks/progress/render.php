<?php
/**
 * Render Progress block.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$label      = isset( $attributes['label'] ) ? sanitize_text_field( $attributes['label'] ) : __( 'Progress', 'vaarta' );
$value      = isset( $attributes['value'] ) ? (float) $attributes['value'] : 75;
$show_value = ! array_key_exists( 'showValue', $attributes ) || ! empty( $attributes['showValue'] );

$value = max( 0, min( 100, $value ) );

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'vaarta-progress' ) );
?>
<div
	<?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	role="progressbar"
	aria-valuemin="0"
	aria-valuemax="100"
	aria-valuenow="<?php echo esc_attr( (string) $value ); ?>"
	aria-label="<?php echo esc_attr( $label ); ?>"
>
	<div class="vaarta-progress__header">
		<span class="vaarta-progress__label"><?php echo esc_html( $label ); ?></span>
		<?php if ( $show_value ) : ?>
			<span class="vaarta-progress__value"><?php echo esc_html( number_format_i18n( $value, 0 ) ); ?>%</span>
		<?php endif; ?>
	</div>
	<div class="vaarta-progress__track" aria-hidden="true">
		<span class="vaarta-progress__fill" style="width:<?php echo esc_attr( (string) $value ); ?>%"></span>
	</div>
</div>
