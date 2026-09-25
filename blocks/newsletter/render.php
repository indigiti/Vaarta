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
$field_id         = wp_unique_id( 'vaarta-newsletter-email-' );

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

	<?php if ( $form_action ) : ?>
		<form class="vaarta-newsletter__form" action="<?php echo esc_url( $form_action ); ?>" method="post">
			<label class="screen-reader-text" for="<?php echo esc_attr( $field_id ); ?>">
				<?php esc_html_e( 'Email address', 'vaarta' ); ?>
			</label>
			<input
				id="<?php echo esc_attr( $field_id ); ?>"
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
	<?php else : ?>
		<div class="vaarta-newsletter__form vaarta-newsletter__form--disabled" aria-label="<?php echo esc_attr__( 'Newsletter form preview', 'vaarta' ); ?>">
			<input class="vaarta-newsletter__email" type="email" placeholder="<?php echo esc_attr__( 'Email address', 'vaarta' ); ?>" disabled />
			<button class="vaarta-newsletter__button" type="button" disabled><?php echo esc_html( $button_label ); ?></button>
		</div>
	<?php endif; ?>
</section>
