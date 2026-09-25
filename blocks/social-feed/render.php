<?php
/**
 * Render Social Feed.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading       = isset( $attributes['heading'] ) ? sanitize_text_field( $attributes['heading'] ) : __( 'Let’s Get Social', 'vaarta' );
$network       = isset( $attributes['network'] ) ? sanitize_key( $attributes['network'] ) : 'instagram';
$layout        = isset( $attributes['layout'] ) ? sanitize_key( $attributes['layout'] ) : 'grid';
$profile_url   = isset( $attributes['profileUrl'] ) ? esc_url( $attributes['profileUrl'] ) : '';
$profile_label = isset( $attributes['profileLabel'] ) ? sanitize_text_field( $attributes['profileLabel'] ) : __( 'Follow', 'vaarta' );

if ( ! in_array( $network, array( 'instagram', 'x', 'facebook', 'pinterest', 'mixed' ), true ) ) {
	$network = 'mixed';
}

if ( ! in_array( $layout, array( 'grid', 'strip', 'list' ), true ) ) {
	$layout = 'grid';
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => sprintf( 'vaarta-social-feed vaarta-social-feed--%s vaarta-social-feed--%s', $network, $layout ),
	)
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="vaarta-social-feed__header">
		<?php if ( $heading ) : ?>
			<h2 class="vaarta-social-feed__heading"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( $profile_url ) : ?>
			<a class="vaarta-social-feed__profile" href="<?php echo esc_url( $profile_url ); ?>" rel="me noopener">
				<?php echo esc_html( $profile_label ); ?>
			</a>
		<?php endif; ?>
	</div>

	<div class="vaarta-social-feed__items">
		<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</section>
