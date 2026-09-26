<?php
/**
 * Vaarta-owned editorial card renderers.
 *
 * Existing block/template layouts continue to call the established csco_*
 * functions. Those names are compatibility wrappers around the Vaarta-owned
 * implementations below, preserving the current DOM and CSS contracts while
 * removing card presentation ownership from the legacy template-tags file.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render a post thumbnail for editorial cards.
 *
 * @param array       $options    Layout options.
 * @param array       $attributes Block attributes retained for compatibility.
 * @param string|null $prefix     Field prefix.
 * @param array       $meta       Meta configuration.
 * @return void
 */
function vaarta_render_card_thumbnail( $options, $attributes, $prefix = null, $meta = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	$prefix = $prefix ? sprintf( '%s_', $prefix ) : null;

	if ( ! has_post_thumbnail() ) {
		return;
	}

	$options['thumbnail_meta']    = cnvs_block_post_meta( $options, $meta, false );
	$options['thumbnail_content'] = isset( $options['thumbnail_content'] ) ? $options['thumbnail_content'] : false;
	$options['video_template']    = isset( $options['video_template'] ) ? $options['video_template'] : 'default';
	$options['video_controls']    = isset( $options['video_controls'] ) ? $options['video_controls'] : false;
	$options['image_ratio']       = isset( $options[ $prefix . 'image_orientation' ] ) ? sprintf( 'cs-overlay-ratio cs-ratio-%s', $options[ $prefix . 'image_orientation' ] ) : false;
	?>

	<?php if ( $options['thumbnail_meta'] || $options['thumbnail_content'] ) { ?>
		<div class="cs-entry__inner cs-entry__thumbnail cs-entry__overlay <?php echo esc_attr( $options['image_ratio'] ); ?>" data-scheme="inverse">
	<?php } else { ?>
		<div class="cs-entry__inner cs-entry__thumbnail cs-entry__overlay <?php echo esc_attr( $options['image_ratio'] ); ?>">
	<?php } ?>

		<?php if ( $options['thumbnail_meta'] || $options['thumbnail_content'] ) { ?>
			<div class="cs-overlay-background">
				<?php the_post_thumbnail( $options[ $prefix . 'image_size' ] ); ?>
			</div>
		<?php } else { ?>
			<div class="cs-overlay-background cs-overlay-transparent">
				<?php the_post_thumbnail( $options[ $prefix . 'image_size' ] ); ?>
			</div>
		<?php } ?>

		<?php
		if ( isset( $options['video'] ) && $options['video'] ) {
			csco_get_video_background( null, null, $options['video_template'], $options['video_controls'], $options['video_controls'] );
		}
		?>

		<?php
		if ( isset( $options['post_format'] ) && $options['post_format'] ) {
			csco_the_post_format_icon();
		}
		?>

		<?php if ( $options['thumbnail_meta'] || $options['thumbnail_content'] ) { ?>
			<div class="cs-overlay-content">
				<?php cnvs_block_post_meta( $options, $meta ); ?>
			</div>
		<?php } ?>

		<a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link"></a>
	</div>
	<?php
}

/**
 * Render the background layer used by overlay cards.
 *
 * @param array       $options    Layout options.
 * @param array       $attributes Block attributes retained for compatibility.
 * @param string|null $prefix     Field prefix.
 * @return void
 */
function vaarta_render_card_overlay_thumbnail( $options, $attributes, $prefix = null ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	$prefix = $prefix ? sprintf( '%s_', $prefix ) : null;

	$options['video_template'] = isset( $options['video_template'] ) ? $options['video_template'] : 'default';
	$options['video_controls'] = isset( $options['video_controls'] ) ? $options['video_controls'] : false;
	?>
	<div class="cs-overlay-background">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( $options[ $prefix . 'image_size' ] );
		}

		if ( isset( $options['video'] ) && $options['video'] ) {
			csco_get_video_background( null, null, $options['video_template'], $options['video_controls'], $options['video_controls'] );
		}
		?>
	</div>
	<?php
}

/**
 * Render a card title.
 *
 * @param array       $options Layout options.
 * @param string|null $prefix  Field prefix.
 * @param string      $class   Additional title class.
 * @return void
 */
function vaarta_render_card_title( $options, $prefix = null, $class = '' ) {
	$prefix = $prefix ? sprintf( '%s_', $prefix ) : null;
	$tag    = isset( $options[ $prefix . 'typography_heading_tag' ] ) ? $options[ $prefix . 'typography_heading_tag' ] : 'h2';
	?>
	<<?php echo esc_html( $tag ); ?> class="cs-entry__title <?php echo esc_html( $class ); ?>">
		<?php if ( isset( $options['withoutLink'] ) && $options['withoutLink'] ) { ?>
			<span><?php the_title(); ?></span>
		<?php } else { ?>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		<?php } ?>
	</<?php echo esc_html( $tag ); ?>>
	<?php
}

/**
 * Render a card excerpt.
 *
 * @param array       $options Layout options.
 * @param string|null $prefix  Field prefix.
 * @return void
 */
function vaarta_render_card_excerpt( $options, $prefix = null ) {
	$prefix = $prefix ? sprintf( '%s_', $prefix ) : null;

	if ( empty( $options[ $prefix . 'display_excerpt' ] ) ) {
		return;
	}

	$content = csco_get_the_excerpt( (int) $options[ $prefix . 'excerpt_length' ] );
	if ( ! $content ) {
		return;
	}
	?>
	<div class="cs-entry__excerpt">
		<?php echo esc_html( $content ); ?>
	</div>
	<?php
}

/**
 * Render a card read-more link.
 *
 * @param array       $options Layout options.
 * @param string|null $prefix  Field prefix.
 * @return void
 */
function vaarta_render_card_more( $options, $prefix = null ) {
	$prefix = $prefix ? sprintf( '%s_', $prefix ) : null;

	if ( empty( $options[ $prefix . 'display_more_button' ] ) ) {
		return;
	}
	?>
	<div class="cs-entry__read-more">
		<a href="<?php the_permalink(); ?>">
			<?php echo esc_html( apply_filters( 'csco_filter_label_more', $options[ $prefix . 'more_button_label' ] ) ); ?>
		</a>
	</div>
	<?php
}

/**
 * Render card footer metadata and read-more affordances.
 *
 * @param array       $options  Layout options.
 * @param string|null $prefix   Field prefix.
 * @param bool|null   $readmore Explicit read-more visibility.
 * @param array       $settings Additional renderer settings.
 * @return void
 */
function vaarta_render_card_footer( $options = array(), $prefix = null, $readmore = null, $settings = array() ) {
	$prefix = $prefix ? sprintf( '%s_', $prefix ) : null;

	if ( ! empty( $options[ $prefix . 'display_more_button' ] ) && null === $readmore ) {
		$readmore = true;
	}
	if ( ! empty( $options[ $prefix . 'more_button_label' ] ) ) {
		$settings['readmore_label'] = $options[ $prefix . 'more_button_label' ];
	}

	$options['meta-settings']['container'] = false;
	$options_shares                        = $options;
	$options_shares['meta-settings']['shares_total'] = true;
	$options_shares['meta-settings']['shares_link']  = false;

	$reading_time = false;
	$views        = false;
	$shares       = false;

	if ( ! empty( $options['display_meta_reading_time'] ) && csco_get_meta_reading_time() ) {
		$reading_time = true;
	}

	if ( ! empty( $options['display_meta_views'] ) && csco_get_meta_views() ) {
		$views = true;
	}

	if (
		! empty( $options['display_meta_shares'] )
		&& csco_get_meta_shares(
			'div',
			false,
			array(
				'shares_location' => 'post-meta',
				'shares_total'    => false,
				'shares_link'     => true,
			)
		)
	) {
		$shares = true;
	}

	if ( ! $reading_time && ! $views && ! $readmore && ! $shares ) {
		return;
	}
	?>
	<div class="cs-entry__footer">
		<div class="cs-entry__footer-wrapper">
			<?php if ( $reading_time || $views || $shares ) { ?>
				<div class="cs-entry__footer-item">
					<?php if ( $reading_time || $views ) { ?>
						<div class="cs-entry__footer-inner">
							<?php csco_block_post_meta( $options, array( 'reading_time', 'views' ) ); ?>
						</div>
					<?php } ?>

					<?php if ( $shares ) { ?>
						<div class="cs-entry__footer-inner">
							<?php csco_block_post_meta( $options_shares, array( 'shares' ) ); ?>
						</div>
					<?php } ?>
				</div>
			<?php } ?>

			<?php if ( $readmore || $shares ) { ?>
				<div class="cs-entry__footer-item cs-entry__footer-item-hidden">
					<?php if ( $readmore ) { ?>
						<?php $readmore_label = ! empty( $settings['readmore_label'] ) ? $settings['readmore_label'] : esc_html__( 'Read More', 'caards' ); ?>
						<div class="cs-entry__footer-inner">
							<div class="cs-entry__read-more">
								<a href="<?php the_permalink(); ?>">
									<?php echo esc_attr( get_theme_mod( 'misc_label_more', $readmore_label ) ); ?>
								</a>
							</div>
						</div>
					<?php } ?>

					<?php if ( $shares ) { ?>
						<div class="cs-entry__footer-inner">
							<?php csco_block_post_meta( $options, array( 'shares' ) ); ?>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php
}

/**
 * Render the author treatment used at the top of editorial cards.
 *
 * @param array       $options Layout options.
 * @param string|null $prefix  Field prefix retained for compatibility.
 * @return void
 */
function vaarta_render_card_author( $options = array(), $prefix = null ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	if ( ! isset( $options['top_meta'] ) || 'author' !== $options['top_meta'] ) {
		return;
	}

	$post_author_details = isset( $options['post_author_details'] ) ? $options['post_author_details'] : true;
	$author_id           = get_the_author_meta( 'ID' );
	?>
	<div class="cs-entry__post-meta">
		<div class="cs-entry__details-author">
			<div class="cs-author-avatar">
				<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" rel="author">
					<?php echo get_avatar( $author_id, 48 ); ?>
				</a>
			</div>

			<?php if ( $post_author_details ) { ?>
				<div class="cs-entry__details-author-meta">
					<div class="cs-entry__author-meta">
						<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
							<?php the_author_meta( 'display_name', $author_id ); ?>
						</a>

						<?php if ( vaarta_has_social_links_integration() && function_exists( 'powerkit_author_social_links' ) ) { ?>
							<?php powerkit_author_social_links( $author_id ); ?>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php
}

/**
 * Render the category treatment used by editorial cards.
 *
 * @param array       $options Layout options.
 * @param string|null $prefix  Field prefix retained for compatibility.
 * @return void
 */
function vaarta_render_card_category( $options = array(), $prefix = null ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	$category = vaarta_get_primary_category_data();
	if ( ! $category ) {
		return;
	}

	$category_label = isset( $options['post_category_label'] ) ? $options['post_category_label'] : true;
	?>
	<div class="cs-entry__category">
		<a href="<?php echo esc_url( $category['link'] ); ?>" class="cs-entry__category-letter" <?php echo wp_kses( sprintf( '%s="%s"', 'style', $category['styles'] ), 'content' ); ?>><?php echo esc_html( $category['letter'] ); ?></a>

		<?php if ( $category_label ) { ?>
			<a href="<?php echo esc_url( $category['link'] ); ?>" class="cs-entry__category-label"><?php echo esc_html( $category['name'] ); ?></a>
		<?php } ?>
	</div>
	<?php
}

// Legacy compatibility wrappers. Loading before inc/theme-tags.php leaves its
// conditional implementations dormant while keeping the public API unchanged.
if ( ! function_exists( 'csco_block_post_thumbnail' ) ) {
	function csco_block_post_thumbnail( $options, $attributes, $prefix = null, $meta = array() ) {
		vaarta_render_card_thumbnail( $options, $attributes, $prefix, $meta );
	}
}

if ( ! function_exists( 'csco_block_post_overlay_thumbnail' ) ) {
	function csco_block_post_overlay_thumbnail( $options, $attributes, $prefix = null ) {
		vaarta_render_card_overlay_thumbnail( $options, $attributes, $prefix );
	}
}

if ( ! function_exists( 'csco_block_post_title' ) ) {
	function csco_block_post_title( $options, $prefix = null, $class = '' ) {
		vaarta_render_card_title( $options, $prefix, $class );
	}
}

if ( ! function_exists( 'csco_block_post_excerpt' ) ) {
	function csco_block_post_excerpt( $options, $prefix = null ) {
		vaarta_render_card_excerpt( $options, $prefix );
	}
}

if ( ! function_exists( 'csco_block_post_more' ) ) {
	function csco_block_post_more( $options, $prefix = null ) {
		vaarta_render_card_more( $options, $prefix );
	}
}

if ( ! function_exists( 'csco_block_post_footer' ) ) {
	function csco_block_post_footer( $options = array(), $prefix = null, $readmore = null, $settings = array() ) {
		vaarta_render_card_footer( $options, $prefix, $readmore, $settings );
	}
}

if ( ! function_exists( 'csco_block_post_author' ) ) {
	function csco_block_post_author( $options = array(), $prefix = null ) {
		vaarta_render_card_author( $options, $prefix );
	}
}

if ( ! function_exists( 'csco_block_post_category' ) ) {
	function csco_block_post_category( $options = array(), $prefix = null ) {
		vaarta_render_card_category( $options, $prefix );
	}
}
