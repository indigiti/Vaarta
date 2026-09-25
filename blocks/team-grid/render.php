<?php
/**
 * Render Team Grid.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading         = isset( $attributes['heading'] ) ? sanitize_text_field( $attributes['heading'] ) : __( 'Meet the Team', 'vaarta' );
$description     = isset( $attributes['description'] ) ? sanitize_textarea_field( $attributes['description'] ) : '';
$user_ids        = isset( $attributes['userIds'] ) && is_array( $attributes['userIds'] )
	? array_values( array_unique( array_filter( array_map( 'absint', $attributes['userIds'] ) ) ) )
	: array();
$max_members     = isset( $attributes['maxMembers'] ) ? absint( $attributes['maxMembers'] ) : 8;
$columns         = isset( $attributes['columns'] ) ? absint( $attributes['columns'] ) : 4;
$show_bio        = ! array_key_exists( 'showBio', $attributes ) || ! empty( $attributes['showBio'] );
$show_post_count = ! empty( $attributes['showPostCount'] );

$max_members = max( 2, min( 16, $max_members ) );
$columns     = in_array( $columns, array( 2, 3, 4 ), true ) ? $columns : 4;

$args = array(
	'number'  => $max_members,
	'orderby' => 'display_name',
	'order'   => 'ASC',
	'who'     => 'authors',
);

if ( $user_ids ) {
	$args['include'] = array_slice( $user_ids, 0, $max_members );
	$args['orderby'] = 'include';
	unset( $args['who'] );
}

$users = get_users( $args );

if ( ! $users ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'vaarta-team-grid vaarta-team-grid--columns-' . $columns,
	)
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="vaarta-team-grid__header">
		<?php if ( $heading ) : ?>
			<h2 class="vaarta-team-grid__heading"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<p class="vaarta-team-grid__description"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>
	</div>

	<div class="vaarta-team-grid__items">
		<?php foreach ( $users as $user ) : ?>
			<?php
			$archive_url = get_author_posts_url( $user->ID );
			$bio         = get_the_author_meta( 'description', $user->ID );
			$post_count  = count_user_posts( $user->ID, 'post', true );
			?>
			<article class="vaarta-team-member">
				<a class="vaarta-team-member__avatar" href="<?php echo esc_url( $archive_url ); ?>" aria-label="<?php echo esc_attr( $user->display_name ); ?>">
					<?php echo get_avatar( $user->ID, 480, '', $user->display_name, array( 'loading' => 'lazy' ) ); ?>
				</a>

				<div class="vaarta-team-member__body">
					<h3 class="vaarta-team-member__name">
						<a href="<?php echo esc_url( $archive_url ); ?>"><?php echo esc_html( $user->display_name ); ?></a>
					</h3>

					<?php if ( $show_post_count ) : ?>
						<p class="vaarta-team-member__count">
							<?php
							printf(
								/* translators: %s: formatted post count. */
								esc_html__( '%s stories', 'vaarta' ),
								esc_html( number_format_i18n( $post_count ) )
							);
							?>
						</p>
					<?php endif; ?>

					<?php if ( $show_bio && $bio ) : ?>
						<p class="vaarta-team-member__bio"><?php echo esc_html( $bio ); ?></p>
					<?php endif; ?>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>
