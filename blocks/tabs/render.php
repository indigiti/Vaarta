<?php
/**
 * Render Tabs/Pills block.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$style_variant = isset( $attributes['styleVariant'] ) ? sanitize_key( $attributes['styleVariant'] ) : 'tabs';

if ( ! in_array( $style_variant, array( 'tabs', 'pills' ), true ) ) {
	$style_variant = 'tabs';
}

$inner_blocks = isset( $block->parsed_block['innerBlocks'] ) && is_array( $block->parsed_block['innerBlocks'] )
	? array_values(
		array_filter(
			$block->parsed_block['innerBlocks'],
			static fn ( array $inner_block ): bool => 'vaarta/tab' === ( $inner_block['blockName'] ?? '' )
		)
	)
	: array();

if ( ! $inner_blocks ) {
	return;
}

$instance_id = wp_unique_id( 'vaarta-tabs-' );
$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'vaarta-tabs vaarta-tabs--' . $style_variant,
	)
);
?>
<div
	<?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	data-wp-interactive="vaarta/tabs"
>
	<div class="vaarta-tabs__list" role="tablist" aria-label="<?php echo esc_attr__( 'Tabbed content', 'vaarta' ); ?>">
		<?php foreach ( $inner_blocks as $index => $inner_block ) : ?>
			<?php
			$title    = isset( $inner_block['attrs']['title'] ) ? sanitize_text_field( $inner_block['attrs']['title'] ) : sprintf( __( 'Tab %d', 'vaarta' ), $index + 1 );
			$tab_id   = $instance_id . '-tab-' . $index;
			$panel_id = $instance_id . '-panel-' . $index;
			?>
			<button
				id="<?php echo esc_attr( $tab_id ); ?>"
				class="vaarta-tabs__tab"
				type="button"
				role="tab"
				aria-controls="<?php echo esc_attr( $panel_id ); ?>"
				aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
				tabindex="<?php echo 0 === $index ? '0' : '-1'; ?>"
				data-vaarta-tab-index="<?php echo esc_attr( (string) $index ); ?>"
				data-wp-on--click="actions.activate"
			>
				<?php echo esc_html( $title ); ?>
			</button>
		<?php endforeach; ?>
	</div>

	<div class="vaarta-tabs__panels">
		<?php foreach ( $inner_blocks as $index => $inner_block ) : ?>
			<?php
			$tab_id   = $instance_id . '-tab-' . $index;
			$panel_id = $instance_id . '-panel-' . $index;
			?>
			<div
				id="<?php echo esc_attr( $panel_id ); ?>"
				class="vaarta-tabs__panel"
				role="tabpanel"
				aria-labelledby="<?php echo esc_attr( $tab_id ); ?>"
				<?php echo 0 === $index ? '' : 'hidden'; ?>
			>
				<?php echo render_block( $inner_block ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
