<?php
/**
 * Render Theme Toggle.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$show_label = ! empty( $attributes['showLabel'] );
$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'vaarta-theme-toggle' ) );
?>
<div
	<?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	data-wp-interactive="vaarta/theme-toggle"
>
	<button
		class="vaarta-theme-toggle__button"
		type="button"
		aria-label="<?php echo esc_attr__( 'Toggle light and dark appearance', 'vaarta' ); ?>"
		aria-pressed="false"
		data-wp-on--click="actions.toggle"
		data-wp-init="callbacks.sync"
	>
		<span class="vaarta-theme-toggle__icon" aria-hidden="true">◐</span>
		<?php if ( $show_label ) : ?>
			<span class="vaarta-theme-toggle__label"><?php esc_html_e( 'Appearance', 'vaarta' ); ?></span>
		<?php endif; ?>
	</button>
</div>
