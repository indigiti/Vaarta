<?php
/**
 * Contact form delivery.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the public contact endpoint.
 */
function vaarta_register_contact_route(): void {
	register_rest_route(
		'vaarta/v1',
		'/contact',
		array(
			'methods'             => WP_REST_Server::CREATABLE,
			'permission_callback' => '__return_true',
			'callback'            => 'vaarta_rest_contact',
		)
	);
}
add_action( 'rest_api_init', 'vaarta_register_contact_route' );

/**
 * Return a privacy-preserving client key for basic rate limiting.
 *
 * @return string
 */
function vaarta_contact_client_key(): string {
	$ip = isset( $_SERVER['REMOTE_ADDR'] )
		? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) )
		: 'unknown';

	return 'vaarta_contact_' . substr( hash_hmac( 'sha256', $ip, wp_salt( 'nonce' ) ), 0, 24 );
}

/**
 * Handle public contact submissions.
 *
 * @param WP_REST_Request $request Request object.
 * @return WP_REST_Response|WP_Error
 */
function vaarta_rest_contact( WP_REST_Request $request ) {
	$honeypot = trim( (string) $request->get_param( 'website' ) );

	if ( '' !== $honeypot ) {
		return new WP_Error(
			'vaarta_contact_invalid',
			__( 'Unable to submit this form.', 'vaarta' ),
			array( 'status' => 400 )
		);
	}

	$rate_key = vaarta_contact_client_key();

	if ( get_transient( $rate_key ) ) {
		return new WP_Error(
			'vaarta_contact_rate_limited',
			__( 'Please wait a moment before sending another message.', 'vaarta' ),
			array( 'status' => 429 )
		);
	}

	$name    = sanitize_text_field( (string) $request->get_param( 'name' ) );
	$email   = sanitize_email( (string) $request->get_param( 'email' ) );
	$subject = sanitize_text_field( (string) $request->get_param( 'subject' ) );
	$message = sanitize_textarea_field( (string) $request->get_param( 'message' ) );

	if ( '' === $name || ! is_email( $email ) || '' === $message ) {
		return new WP_Error(
			'vaarta_contact_required',
			__( 'Please complete your name, a valid email address, and your message.', 'vaarta' ),
			array( 'status' => 400 )
		);
	}

	if ( strlen( $name ) > 120 || strlen( $subject ) > 180 || strlen( $message ) > 5000 ) {
		return new WP_Error(
			'vaarta_contact_too_long',
			__( 'One or more fields are too long.', 'vaarta' ),
			array( 'status' => 400 )
		);
	}

	$recipient = apply_filters(
		'vaarta_contact_recipient',
		get_option( 'admin_email' ),
		$request
	);

	$recipient = sanitize_email( (string) $recipient );

	if ( ! is_email( $recipient ) ) {
		return new WP_Error(
			'vaarta_contact_recipient',
			__( 'This contact form is not configured correctly.', 'vaarta' ),
			array( 'status' => 500 )
		);
	}

	$site_name = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$mail_subject = sprintf(
		/* translators: 1: site name, 2: contact subject. */
		__( '[%1$s] %2$s', 'vaarta' ),
		$site_name,
		$subject ?: __( 'New contact message', 'vaarta' )
	);

	$mail_body = sprintf(
		/* translators: 1: sender name, 2: sender email, 3: message body. */
		__( "Name: %1\$s\nEmail: %2\$s\n\nMessage:\n%3\$s", 'vaarta' ),
		$name,
		$email,
		$message
	);

	$headers = array(
		sprintf( 'Reply-To: %s <%s>', $name, $email ),
	);

	$sent = wp_mail(
		$recipient,
		$mail_subject,
		$mail_body,
		$headers
	);

	$sent = (bool) apply_filters(
		'vaarta_contact_sent',
		$sent,
		array(
			'name'    => $name,
			'email'   => $email,
			'subject' => $subject,
			'message' => $message,
		),
		$request
	);

	if ( ! $sent ) {
		return new WP_Error(
			'vaarta_contact_delivery',
			__( 'Your message could not be sent right now. Please try again later.', 'vaarta' ),
			array( 'status' => 500 )
		);
	}

	set_transient( $rate_key, 1, MINUTE_IN_SECONDS );

	return rest_ensure_response(
		array(
			'success' => true,
			'message' => __( 'Thanks. Your message has been sent.', 'vaarta' ),
		)
	);
}
