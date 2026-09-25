<?php
/**
 * Render Newsletter block.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading          = isset( $attributes['heading'] ) ? sanitize_text_field( $attributes['heading'] ) : __( 'Stay informed.', 'vaarta' );
$description      = isset( $attributes['description'] ) ? sanitize_textarea_field( $attributes['description'] ) : __( 'Get the most important stories delivered to your inbox.', 'vaarta' );
$button_label     = isset( $attributes['buttonLabel'] ) ? sanitize_text_field( $attributes['buttonLabel'] ) : __( 'Subscribe', 'vaarta' );
$form_action      = isset( $attributes['formAction'] ) ? esc_url( $attributes['formAction'] ) : '';
$email_field_name = isset( $attributes['emailFieldName'] ) ? sanitize_key( $attributes['emailFieldName'] ) : 'EMAIL';
$style_variant    = isset( $attributes['styleVariant'] ) ? sanitize_key( $attributes['styleVariant'] ) : 'light';

$allowed_styles = array( 'light', 'dark', 'minimal' );
if ( ! in_array( $style_variant, $allowed_styles, true ) ) {
	$style_variant = 'light';
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'vaarta-newsletter vaarta-newsletter--' . $style_variant,
	)
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="vaarta-newsletter__copy">
		<?php if ( $heading ) : ?>
			<h2 class="vaarta-newsletter__heading"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<p class="vaarta-newsletter__description"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>
	</div>

	<form class="vaarta-newsletter__form" action="<?php echo esc_url( $form_action ); ?>" method="post">
		<label class="screen-reader-text" for="vaarta-newsletter-email-<?php echo esc_attr( wp_unique_id() ); ?>">
			<?php esc_html_e( 'Email address', 'vaarta' ); ?>
		</label>
		<input
			id="vaarta-newsletter-email-<?php echo esc_attr( wp_unique_id() ); ?>"
			class="vaarta-newsletter__email"
			type="email"
			name="<?php echo esc_attr( $email_field_name ); ?>"
			placeholder="<?php echo esc_attr__( 'Email address', 'vaarta' ); ?>"
			autocomplete="email"
			required
		/>
		<button class="vaarta-newsletter__button" type="submit">
			<?php echo esc_html( $button_label ); ?>
		</button>
	</form>
</section>
