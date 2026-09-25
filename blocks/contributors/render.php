<?php
/**
 * Render Contributors block.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = ! empty( $block->context['postId'] ) ? absint( $block->context['postId'] ) : get_the_ID();

if ( ! $post_id ) {
	return;
}

$ids = vaarta_get_contributor_ids( $post_id );

if ( ! $ids ) {
	return;
}

$heading  = isset( $attributes['heading'] ) ? sanitize_text_field( $attributes['heading'] ) : __( 'Contributors', 'vaarta' );
$layout   = isset( $attributes['layout'] ) ? sanitize_key( $attributes['layout'] ) : 'compact';
$show_bio = ! empty( $attributes['showBio'] );

if ( ! in_array( $layout, array( 'compact', 'profiles' ), true ) ) {
	$layout = 'compact';
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'vaarta-contributors vaarta-contributors--' . $layout,
	)
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $heading ) : ?>
		<h2 class="vaarta-contributors__heading"><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>

	<div class="vaarta-contributors__items">
		<?php foreach ( $ids as $user_id ) : ?>
			<?php
			$user = get_user_by( 'id', $user_id );
			if ( ! $user ) {
				continue;
			}

			$archive_url = get_author_posts_url( $user_id );
			$bio         = get_the_author_meta( 'description', $user_id );
			?>
			<article class="vaarta-contributor">
				<a class="vaarta-contributor__avatar" href="<?php echo esc_url( $archive_url ); ?>" aria-hidden="true" tabindex="-1">
					<?php echo get_avatar( $user_id, 96, '', $user->display_name, array( 'loading' => 'lazy' ) ); ?>
				</a>

				<div class="vaarta-contributor__body">
					<h3 class="vaarta-contributor__name">
						<a href="<?php echo esc_url( $archive_url ); ?>"><?php echo esc_html( $user->display_name ); ?></a>
					</h3>

					<?php if ( $show_bio && $bio ) : ?>
						<p class="vaarta-contributor__bio"><?php echo esc_html( $bio ); ?></p>
					<?php endif; ?>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>
