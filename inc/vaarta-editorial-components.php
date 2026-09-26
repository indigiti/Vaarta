<?php
/**
 * Vaarta-owned editorial context components.
 *
 * These renderers own post-level presentation that previously lived in the
 * monolithic legacy template-tags file. The established csco_* functions remain
 * available as compatibility wrappers so existing templates, hooks, child
 * themes, and integrations keep their public API.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return presentation data for the current post's first category.
 *
 * @param int|null $post_id Optional post ID.
 * @return array<string,mixed>|false
 */
function vaarta_get_primary_category_data( $post_id = null ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();

	if ( ! $post_id ) {
		return false;
	}

	$post_categories = wp_get_post_categories( $post_id, array( 'fields' => 'all' ) );
	if ( empty( $post_categories ) || is_wp_error( $post_categories ) ) {
		return false;
	}

	$category      = array_shift( $post_categories );
	$category_link = get_term_link( $category->term_id );
	if ( is_wp_error( $category_link ) ) {
		return false;
	}

	$letter_color = get_term_meta( $category->term_id, 'csco_letter_color', true );
	$start_color  = get_term_meta( $category->term_id, 'csco_gradient_start_color', true );
	$end_color    = get_term_meta( $category->term_id, 'csco_gradient_end_color', true );
	$styles       = '';

	if ( $letter_color ) {
		$styles .= '--cs-color-category-letter-contrast: ' . $letter_color . ';';
	}
	if ( $start_color ) {
		$styles .= '--cs-color-category-letter-gradient-top: ' . $start_color . ';';
	}
	if ( $end_color ) {
		$styles .= '--cs-color-category-letter-gradient-bottom: ' . $end_color . ';';
	}

	return array(
		'id'     => (int) $category->term_id,
		'name'   => (string) $category->name,
		'link'   => (string) $category_link,
		'letter' => mb_substr( (string) $category->name, 0, 1 ),
		'styles' => $styles,
	);
}

/**
 * Render the current post-format icon.
 *
 * @param string $content Optional icon content.
 * @return void
 */
function vaarta_render_post_format_icon( $content = '' ) {
	$post_format = get_post_format();

	if ( ! $post_format ) {
		return;
	}
	?>
	<span class="cs-entry-format">
		<a class="cs-format-icon cs-format-<?php echo esc_attr( $post_format ); ?>" href="<?php the_permalink(); ?>">
			<?php echo wp_kses( $content, 'csco' ); ?>
		</a>
	</span>
	<?php
}

/**
 * Render the single-post subtitle or excerpt fallback.
 *
 * @return void
 */
function vaarta_render_post_subtitle() {
	if ( ! is_single() || ! get_theme_mod( 'post_subtitle', false ) ) {
		return;
	}

	$subtitle = apply_filters(
		'plugins/wp_subtitle/get_subtitle',
		'',
		array(
			'before'  => '',
			'after'   => '',
			'post_id' => get_the_ID(),
		)
	);

	if ( $subtitle ) {
		?>
		<div class="cs-entry__subtitle">
			<?php echo wp_kses( $subtitle, 'csco' ); ?>
		</div>
		<?php
	} elseif ( has_excerpt() ) {
		?>
		<div class="cs-entry__subtitle">
			<?php the_excerpt(); ?>
		</div>
		<?php
	}
}

/**
 * Render the current post's first category.
 *
 * @param string $location Header or metabar location.
 * @return void
 */
function vaarta_render_post_category( $location = 'header' ) {
	if ( ! csco_has_post_meta( 'category' ) ) {
		return;
	}

	if ( 'metabar' === $location && in_array( csco_get_page_header_type(), array( 'large', 'full' ), true ) ) {
		return;
	}

	$category = vaarta_get_primary_category_data();
	if ( ! $category ) {
		return;
	}
	?>
	<?php if ( 'header' === $location ) { ?>
		<div class="cs-entry__header-category">
			<div class="cs-entry__header-category-inner">
	<?php } ?>

		<div class="cs-entry__category">
			<a href="<?php echo esc_url( $category['link'] ); ?>" class="cs-entry__category-letter" <?php echo wp_kses( sprintf( '%s="%s"', 'style', $category['styles'] ), 'content' ); ?>><?php echo esc_html( $category['letter'] ); ?></a>
			<a href="<?php echo esc_url( $category['link'] ); ?>" class="cs-entry__category-label"><?php echo esc_html( $category['name'] ); ?></a>
		</div>

	<?php if ( 'header' === $location ) { ?>
			</div>
		</div>
	<?php } ?>
	<?php
}

/**
 * Render post author details.
 *
 * @param int|null $id Optional author ID.
 * @return void
 */
function vaarta_render_post_author( $id = null ) {
	$id = $id ? (int) $id : (int) get_the_author_meta( 'ID' );
	?>
	<div class="cs-entry__author-inner">
		<div class="cs-entry__author-photo-wrapper">
			<a href="<?php echo esc_url( get_author_posts_url( $id ) ); ?>" class="cs-entry__author-photo">
				<?php echo get_avatar( $id, '96' ); ?>
			</a>
			<?php if ( vaarta_has_social_links_integration() && function_exists( 'powerkit_author_social_links' ) ) { ?>
				<div class="cs-entry__author-social">
					<?php powerkit_author_social_links( $id ); ?>
				</div>
			<?php } ?>
		</div>

		<div class="cs-entry__author-info">
			<div class="cs-entry__author-name-wrapper">
				<a href="<?php echo esc_url( get_author_posts_url( $id ) ); ?>" class="cs-entry__author-name">
					<?php the_author_meta( 'display_name', $id ); ?>
				</a>
			</div>

			<?php if ( get_the_author_meta( 'description', $id ) ) { ?>
				<div class="cs-entry__author-description"><?php the_author_meta( 'description', $id ); ?></div>
			<?php } ?>
		</div>
	</div>
	<?php
}

/**
 * Render archive description.
 *
 * @return void
 */
function vaarta_render_archive_post_description() {
	$description = get_the_archive_description();
	if ( ! $description ) {
		return;
	}
	?>
	<div class="cs-page__archive-description">
		<?php echo do_shortcode( $description ); ?>
	</div>
	<?php
}

/**
 * Render archive post count.
 *
 * @return void
 */
function vaarta_render_archive_post_count() {
	global $wp_query;

	$found_posts = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;
	?>
	<div class="cs-page__archive-count">
		<?php
		/* translators: 1: Singular, 2: Plural. */
		echo esc_html( apply_filters( 'csco_article_full_count', sprintf( _n( '%s post', '%s posts', $found_posts, 'caards' ), $found_posts ), $found_posts ) );
		?>
	</div>
	<?php
}

/**
 * Render direct subcategories of the current category archive.
 *
 * @return void
 */
function vaarta_render_subcategories() {
	if ( false === get_theme_mod( 'category_subcategories', false ) || ! is_category() ) {
		return;
	}

	$args = apply_filters(
		'csco_subcategories_args',
		array(
			'parent' => get_query_var( 'cat' ),
		)
	);

	$categories = get_categories( $args );
	if ( ! $categories ) {
		return;
	}
	?>
	<div class="cs-page__subcategories">
		<?php csco_section_heading( esc_html__( 'Subcategories', 'caards' ) ); ?>

		<div class="cs-page__tags">
			<ul>
				<?php foreach ( $categories as $category ) { ?>
					<?php
					/* translators: %s: category name. */
					$title = sprintf( esc_html__( 'View all posts in %s', 'caards' ), $category->name );
					$link  = get_category_link( $category->term_id );
					?>
					<li>
						<a href="<?php echo esc_url( $link ); ?>" title="<?php echo esc_attr( $title ); ?>">
							<?php echo esc_html( $category->name ); ?>
						</a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<?php
}

// Legacy compatibility wrappers. These definitions intentionally load before
// inc/theme-tags.php so the old conditional implementations remain dormant.
if ( ! function_exists( 'csco_the_post_format_icon' ) ) {
	function csco_the_post_format_icon( $content = '' ) {
		vaarta_render_post_format_icon( $content );
	}
}

if ( ! function_exists( 'csco_post_subtitle' ) ) {
	function csco_post_subtitle() {
		vaarta_render_post_subtitle();
	}
}

if ( ! function_exists( 'csco_post_category' ) ) {
	function csco_post_category( $location = 'header' ) {
		vaarta_render_post_category( $location );
	}
}

if ( ! function_exists( 'csco_post_author' ) ) {
	function csco_post_author( $id = null ) {
		vaarta_render_post_author( $id );
	}
}

if ( ! function_exists( 'csco_archive_post_description' ) ) {
	function csco_archive_post_description() {
		vaarta_render_archive_post_description();
	}
}

if ( ! function_exists( 'csco_archive_post_count' ) ) {
	function csco_archive_post_count() {
		vaarta_render_archive_post_count();
	}
}

if ( ! function_exists( 'csco_subcategories' ) ) {
	function csco_subcategories() {
		vaarta_render_subcategories();
	}
}
