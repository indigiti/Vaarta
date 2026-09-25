<?php
/**
 * Render Social Share block.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = ! empty( $block->context['postId'] ) ? absint( $block->context['postId'] ) : get_the_ID();

$networks      = isset( $attributes['networks'] ) && is_array( $attributes['networks'] ) ? $attributes['networks'] : array( 'facebook', 'x', 'linkedin', 'email' );
$show_label    = ! array_key_exists( 'showLabel', $attributes ) || ! empty( $attributes['showLabel'] );
$style_variant = isset( $attributes['styleVariant'] ) ? sanitize_key( $attributes['styleVariant'] ) : 'light';

if ( ! in_array( $style_variant, array( 'light', 'bold', 'minimal', 'rail' ), true ) ) {
	$style_variant = 'light';
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'vaarta-social-share vaarta-social-share--' . $style_variant,
	)
);

if ( ! $post_id ) {
	?>
	<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php esc_html_e( 'Share links appear in post context.', 'vaarta' ); ?>
	</div>
	<?php
	return;
}

$url   = get_permalink( $post_id );
$title = get_the_title( $post_id );

$share_urls = array(
	'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $url ),
	'x'        => 'https://twitter.com/intent/tweet?url=' . rawurlencode( $url ) . '&text=' . rawurlencode( $title ),
	'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $url ),
	'whatsapp' => 'https://wa.me/?text=' . rawurlencode( $title . ' ' . $url ),
	'email'    => 'mailto:?subject=' . rawurlencode( $title ) . '&body=' . rawurlencode( $url ),
);

$labels = array(
	'facebook' => 'Facebook',
	'x'        => 'X',
	'linkedin' => 'LinkedIn',
	'whatsapp' => 'WhatsApp',
	'email'    => __( 'Email', 'vaarta' ),
);
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $show_label ) : ?>
		<span class="vaarta-social-share__label"><?php esc_html_e( 'Share', 'vaarta' ); ?></span>
	<?php endif; ?>

	<div class="vaarta-social-share__links">
		<?php foreach ( $networks as $network ) : ?>
			<?php
			$network = sanitize_key( $network );
			if ( ! isset( $share_urls[ $network ], $labels[ $network ] ) ) {
				continue;
			}
			$is_email = 'email' === $network;
			?>
			<a
				class="vaarta-social-share__link vaarta-social-share__link--<?php echo esc_attr( $network ); ?>"
				href="<?php echo esc_url( $share_urls[ $network ] ); ?>"
				<?php if ( ! $is_email ) : ?>
					target="_blank"
					rel="noopener noreferrer"
				<?php endif; ?>
			>
				<span class="vaarta-social-share__link-label"><?php echo esc_html( $labels[ $network ] ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</div>
