<?php
/**
 * Render Auto-load Next Articles.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id   = ! empty( $block->context['postId'] ) ? absint( $block->context['postId'] ) : get_the_ID();
$enabled   = ! array_key_exists( 'enabled', $attributes ) || ! empty( $attributes['enabled'] );
$max_posts = isset( $attributes['maxPosts'] ) ? absint( $attributes['maxPosts'] ) : 3;

if ( ! $enabled || ! $post_id || 'post' !== get_post_type( $post_id ) ) {
	return;
}

$max_posts = max( 1, min( 10, $max_posts ) );

wp_interactivity_config(
	'vaarta/auto-load-posts',
	array(
		'restUrl' => esc_url_raw( rest_url( 'vaarta/v1/next-post' ) ),
	)
);

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'vaarta-auto-load' ) );
?>
<div
	<?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	data-wp-interactive="vaarta/auto-load-posts"
	data-wp-init="callbacks.init"
	data-current-post="<?php echo esc_attr( (string) $post_id ); ?>"
	data-loaded="0"
	data-max-posts="<?php echo esc_attr( (string) $max_posts ); ?>"
	data-loading="false"
	data-done="false"
>
	<div class="vaarta-auto-load__items"></div>
	<div class="vaarta-auto-load__sentinel" aria-hidden="true"></div>
	<p class="vaarta-auto-load__loading" aria-live="polite">
		<?php esc_html_e( 'Loading next story…', 'vaarta' ); ?>
	</p>
</div>
