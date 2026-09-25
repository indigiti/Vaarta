<?php
/**
 * Accessibility helpers.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Print a keyboard-accessible skip link immediately after the body opens.
 */
function vaarta_skip_link(): void {
	?>
	<a class="vaarta-skip-link screen-reader-text" href="#main-content">
		<?php esc_html_e( 'Skip to content', 'vaarta' ); ?>
	</a>
	<?php
}
add_action( 'wp_body_open', 'vaarta_skip_link', 5 );
