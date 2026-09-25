<?php
/**
 * Render Story Meta.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id           = get_the_ID();
$show_author       = ! array_key_exists( 'showAuthor', $attributes ) || ! empty( $attributes['showAuthor'] );
$show_date         = ! array_key_exists( 'showDate', $attributes ) || ! empty( $attributes['showDate'] );
$show_reading_time = ! array_key_exists( 'showReadingTime', $attributes ) || ! empty( $attributes['showReadingTime'] );

if ( ! $post_id || ( ! $show_author && ! $show_date && ! $show_reading_time ) ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'vaarta-story-meta' ) );
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $show_author ) : ?>
		<span class="vaarta-story-meta__author">
			<?php
			printf(
				/* translators: %s: author name. */
				esc_html__( 'By %s', 'vaarta' ),
				'<a href="' . esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
			);
			?>
		</span>
	<?php endif; ?>

	<?php if ( $show_date ) : ?>
		<time class="vaarta-story-meta__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $post_id ) ); ?>">
			<?php echo esc_html( get_the_date( '', $post_id ) ); ?>
		</time>
	<?php endif; ?>

	<?php if ( $show_reading_time ) : ?>
		<span class="vaarta-story-meta__reading-time">
			<?php
			printf(
				/* translators: %d: estimated reading time in minutes. */
				esc_html__( '%d min read', 'vaarta' ),
				vaarta_get_reading_time( $post_id )
			);
			?>
		</span>
	<?php endif; ?>
</div>
