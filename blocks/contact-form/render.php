<?php
/**
 * Render Contact Form.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading      = isset( $attributes['heading'] ) ? sanitize_text_field( $attributes['heading'] ) : __( 'Send a message', 'vaarta' );
$description  = isset( $attributes['description'] ) ? sanitize_textarea_field( $attributes['description'] ) : '';
$button_label = isset( $attributes['buttonLabel'] ) ? sanitize_text_field( $attributes['buttonLabel'] ) : __( 'Send message', 'vaarta' );
$show_subject = ! array_key_exists( 'showSubject', $attributes ) || ! empty( $attributes['showSubject'] );
$instance_id  = wp_unique_id( 'vaarta-contact-' );

wp_interactivity_config(
	'vaarta/contact-form',
	array(
		'restUrl' => esc_url_raw( rest_url( 'vaarta/v1/contact' ) ),
	)
);

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'vaarta-contact-form' ) );
?>
<section
	<?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	data-wp-interactive="vaarta/contact-form"
	data-submitting="false"
>
	<?php if ( $heading ) : ?>
		<h2 class="vaarta-contact-form__heading"><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>

	<?php if ( $description ) : ?>
		<p class="vaarta-contact-form__description"><?php echo esc_html( $description ); ?></p>
	<?php endif; ?>

	<form class="vaarta-contact-form__form" data-wp-on--submit="actions.submit">
		<div class="vaarta-contact-form__field">
			<label for="<?php echo esc_attr( $instance_id ); ?>-name"><?php esc_html_e( 'Name', 'vaarta' ); ?></label>
			<input id="<?php echo esc_attr( $instance_id ); ?>-name" type="text" name="name" autocomplete="name" maxlength="120" required />
		</div>

		<div class="vaarta-contact-form__field">
			<label for="<?php echo esc_attr( $instance_id ); ?>-email"><?php esc_html_e( 'Email', 'vaarta' ); ?></label>
			<input id="<?php echo esc_attr( $instance_id ); ?>-email" type="email" name="email" autocomplete="email" maxlength="254" required />
		</div>

		<?php if ( $show_subject ) : ?>
			<div class="vaarta-contact-form__field">
				<label for="<?php echo esc_attr( $instance_id ); ?>-subject"><?php esc_html_e( 'Subject', 'vaarta' ); ?></label>
				<input id="<?php echo esc_attr( $instance_id ); ?>-subject" type="text" name="subject" maxlength="180" />
			</div>
		<?php endif; ?>

		<div class="vaarta-contact-form__field vaarta-contact-form__field--full">
			<label for="<?php echo esc_attr( $instance_id ); ?>-message"><?php esc_html_e( 'Message', 'vaarta' ); ?></label>
			<textarea id="<?php echo esc_attr( $instance_id ); ?>-message" name="message" rows="7" maxlength="5000" required></textarea>
		</div>

		<div class="vaarta-contact-form__honeypot" aria-hidden="true">
			<label for="<?php echo esc_attr( $instance_id ); ?>-website"><?php esc_html_e( 'Website', 'vaarta' ); ?></label>
			<input id="<?php echo esc_attr( $instance_id ); ?>-website" type="text" name="website" tabindex="-1" autocomplete="off" />
		</div>

		<div class="vaarta-contact-form__actions vaarta-contact-form__field--full">
			<button class="vaarta-contact-form__submit" type="submit"><?php echo esc_html( $button_label ); ?></button>
			<p class="vaarta-contact-form__status" aria-live="polite"></p>
		</div>
	</form>
</section>
