<?php
/**
 * Render Ad Slot.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slot_name           = isset( $attributes['slotName'] ) ? sanitize_key( $attributes['slotName'] ) : 'content-inline';
$min_height          = isset( $attributes['minHeight'] ) ? absint( $attributes['minHeight'] ) : 250;
$show_label          = ! array_key_exists( 'showLabel', $attributes ) || ! empty( $attributes['showLabel'] );
$collapse_when_empty = ! array_key_exists( 'collapseWhenEmpty', $attributes ) || ! empty( $attributes['collapseWhenEmpty'] );
$provider_html       = vaarta_get_ad_slot_html( $slot_name, $attributes );
$is_editor_preview   = defined( 'REST_REQUEST' ) && REST_REQUEST && current_user_can( 'edit_posts' );

$min_height = max( 50, min( 600, $min_height ) );

if ( $collapse_when_empty && ! $provider_html && ! $is_editor_preview ) {
	return;
}

$classes = 'vaarta-ad-slot';
if ( ! $provider_html ) {
	$classes .= ' is-empty';
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class'                => $classes,
		'data-vaarta-ad-slot'  => $slot_name,
		'data-provider-active' => $provider_html ? 'true' : 'false',
		'style'                => 'min-height:' . $min_height . 'px',
	)
);
?>
<aside <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-label="<?php echo esc_attr__( 'Advertisement', 'vaarta' ); ?>">
	<?php if ( $show_label ) : ?>
		<span class="vaarta-ad-slot__label"><?php esc_html_e( 'Advertisement', 'vaarta' ); ?></span>
	<?php endif; ?>

	<div class="vaarta-ad-slot__mount" data-vaarta-ad-mount="<?php echo esc_attr( $slot_name ); ?>">
		<?php
		if ( $provider_html ) {
			echo wp_kses_post( $provider_html );
		} elseif ( $is_editor_preview ) {
			printf(
				'<span class="vaarta-ad-slot__preview">%s</span>',
				esc_html(
					sprintf(
						/* translators: %s: advertising slot name. */
						__( 'Ad slot: %s', 'vaarta' ),
						$slot_name
					)
				)
			);
		}
		?>
	</div>
</aside>
