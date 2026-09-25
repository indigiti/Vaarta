<?php
/**
 * Render Search Overlay.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$button_label      = isset( $attributes['buttonLabel'] ) ? sanitize_text_field( $attributes['buttonLabel'] ) : __( 'Search', 'vaarta' );
$placeholder       = isset( $attributes['placeholder'] ) ? sanitize_text_field( $attributes['placeholder'] ) : __( 'Search stories…', 'vaarta' );
$results_limit     = isset( $attributes['resultsLimit'] ) ? absint( $attributes['resultsLimit'] ) : 6;
$show_button_label = ! empty( $attributes['showButtonLabel'] );
$input_id          = wp_unique_id( 'vaarta-search-input-' );

$results_limit = max( 3, min( 10, $results_limit ) );

wp_interactivity_config(
	'vaarta/search-overlay',
	array(
		'restUrl'  => esc_url_raw( rest_url( 'vaarta/v1/search' ) ),
		'minChars' => 2,
	)
);

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'vaarta-search-overlay' ) );
?>
<div
	<?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	data-wp-interactive="vaarta/search-overlay"
	data-results-limit="<?php echo esc_attr( (string) $results_limit ); ?>"
	data-wp-on-document--keydown="actions.keydown"
>
	<button
		class="vaarta-search-overlay__trigger"
		type="button"
		aria-label="<?php echo esc_attr( $button_label ); ?>"
		data-wp-on--click="actions.open"
	>
		<span class="vaarta-search-overlay__icon" aria-hidden="true">⌕</span>
		<?php if ( $show_button_label ) : ?>
			<span><?php echo esc_html( $button_label ); ?></span>
		<?php endif; ?>
	</button>

	<div
		class="vaarta-search-overlay__dialog"
		role="dialog"
		aria-modal="true"
		aria-labelledby="<?php echo esc_attr( $input_id ); ?>-label"
		hidden
	>
		<div class="vaarta-search-overlay__panel">
			<div class="vaarta-search-overlay__header">
				<label id="<?php echo esc_attr( $input_id ); ?>-label" class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>">
					<?php esc_html_e( 'Search stories', 'vaarta' ); ?>
				</label>
				<input
					id="<?php echo esc_attr( $input_id ); ?>"
					class="vaarta-search-overlay__input"
					type="search"
					placeholder="<?php echo esc_attr( $placeholder ); ?>"
					autocomplete="off"
					data-wp-on--input="actions.search"
				/>
				<button
					class="vaarta-search-overlay__close"
					type="button"
					aria-label="<?php echo esc_attr__( 'Close search', 'vaarta' ); ?>"
					data-wp-on--click="actions.close"
				>×</button>
			</div>

			<p class="vaarta-search-overlay__status" aria-live="polite"></p>
			<div class="vaarta-search-overlay__results"></div>
		</div>
	</div>
</div>
