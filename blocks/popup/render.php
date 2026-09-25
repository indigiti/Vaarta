<?php
/**
 * Render Popup block.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$trigger          = isset( $attributes['trigger'] ) ? sanitize_key( $attributes['trigger'] ) : 'button';
$button_label     = isset( $attributes['buttonLabel'] ) ? sanitize_text_field( $attributes['buttonLabel'] ) : __( 'Open', 'vaarta' );
$delay_ms         = isset( $attributes['delayMs'] ) ? absint( $attributes['delayMs'] ) : 5000;
$scroll_percent   = isset( $attributes['scrollPercent'] ) ? absint( $attributes['scrollPercent'] ) : 50;
$once_per_session = ! array_key_exists( 'oncePerSession', $attributes ) || ! empty( $attributes['oncePerSession'] );
$size             = isset( $attributes['size'] ) ? sanitize_key( $attributes['size'] ) : 'medium';

if ( ! in_array( $trigger, array( 'button', 'delay', 'scroll' ), true ) ) {
	$trigger = 'button';
}

if ( ! in_array( $size, array( 'small', 'medium', 'large' ), true ) ) {
	$size = 'medium';
}

$delay_ms       = max( 1000, min( 30000, $delay_ms ) );
$scroll_percent = max( 10, min( 90, $scroll_percent ) );
$popup_key      = 'popup-' . substr(
	md5( wp_json_encode( $attributes ) . '|' . wp_strip_all_tags( $content ) ),
	0,
	12
);

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'vaarta-popup vaarta-popup--' . $size,
	)
);
?>
<div
	<?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	data-wp-interactive="vaarta/popup"
	data-wp-init="callbacks.init"
	data-wp-on-document--keydown="actions.keydown"
	data-trigger="<?php echo esc_attr( $trigger ); ?>"
	data-delay-ms="<?php echo esc_attr( (string) $delay_ms ); ?>"
	data-scroll-percent="<?php echo esc_attr( (string) $scroll_percent ); ?>"
	data-once-per-session="<?php echo $once_per_session ? 'true' : 'false'; ?>"
	data-popup-key="<?php echo esc_attr( $popup_key ); ?>"
>
	<?php if ( 'button' === $trigger ) : ?>
		<button class="vaarta-popup__trigger" type="button" data-wp-on--click="actions.open">
			<?php echo esc_html( $button_label ); ?>
		</button>
	<?php endif; ?>

	<div
		class="vaarta-popup__dialog"
		role="dialog"
		aria-modal="true"
		aria-label="<?php echo esc_attr__( 'Popup', 'vaarta' ); ?>"
		data-wp-on--click="actions.backdrop"
		hidden
	>
		<div class="vaarta-popup__panel">
			<button
				class="vaarta-popup__close"
				type="button"
				aria-label="<?php echo esc_attr__( 'Close popup', 'vaarta' ); ?>"
				data-wp-on--click="actions.close"
			>×</button>
			<div class="vaarta-popup__content">
				<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</div>
</div>
