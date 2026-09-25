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

/**
 * Add a stable skip-link target to the first semantic main element.
 *
 * This works for template markup and main elements supplied by reusable
 * patterns, so new page compositions inherit the landmark automatically.
 *
 * @param string $block_content Rendered block HTML.
 * @return string
 */
function vaarta_add_main_content_target( string $block_content ): string {
	static $target_added = false;

	if ( $target_added || false === stripos( $block_content, '<main' ) ) {
		return $block_content;
	}

	if ( ! class_exists( 'WP_HTML_Tag_Processor' ) ) {
		return preg_replace(
			'/<main(?![^>]*\sid=)([^>]*)>/i',
			'<main id="main-content"$1>',
			$block_content,
			1
		) ?: $block_content;
	}

	$processor = new WP_HTML_Tag_Processor( $block_content );

	if ( $processor->next_tag( 'main' ) ) {
		if ( ! $processor->get_attribute( 'id' ) ) {
			$processor->set_attribute( 'id', 'main-content' );
		}

		$target_added = true;
		return $processor->get_updated_html();
	}

	return $block_content;
}
add_filter( 'render_block', 'vaarta_add_main_content_target', 20 );
