<?php
/**
 * Render Author Box.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = ! empty( $block->context['postId'] ) ? absint( $block->context['postId'] ) : get_the_ID();

if ( ! $post_id ) {
	echo '<div ' . get_block_wrapper_attributes( array( 'class' => 'vaarta-author-box' ) ) . '>' .
		esc_html__( 'Author information appears in post context.', 'vaarta' ) .
		'</div>';
	return;
}

$author_id         = (int) get_post_field( 'post_author', $post_id );
$show_avatar       = ! array_key_exists( 'showAvatar', $attributes ) || ! empty( $attributes['showAvatar'] );
$show_bio          = ! array_key_exists( 'showBio', $attributes ) || ! empty( $attributes['showBio'] );
$show_archive_link = ! array_key_exists( 'showArchiveLink', $attributes ) || ! empty( $attributes['showArchiveLink'] );

$name = get_the_author_meta( 'display_name', $author_id );
$bio  = get_the_author_meta( 'description', $author_id );
$url  = get_author_posts_url( $author_id );

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'vaarta-author-box' ) );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $show_avatar ) : ?>
		<div class="vaarta-author-box__avatar">
			<?php echo get_avatar( $author_id, 112, '', $name, array( 'loading' => 'lazy' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="vaarta-author-box__body">
		<p class="vaarta-author-box__eyebrow"><?php esc_html_e( 'Written by', 'vaarta' ); ?></p>
		<h2 class="vaarta-author-box__name">
			<?php if ( $show_archive_link ) : ?>
				<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $name ); ?></a>
			<?php else : ?>
				<?php echo esc_html( $name ); ?>
			<?php endif; ?>
		</h2>

		<?php if ( $show_bio && $bio ) : ?>
			<p class="vaarta-author-box__bio"><?php echo esc_html( $bio ); ?></p>
		<?php endif; ?>
	</div>
</section>
