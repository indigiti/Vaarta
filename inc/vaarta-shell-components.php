<?php
/**
 * Vaarta-owned site-shell components.
 *
 * The existing templates still call csco_component(), so this module exposes
 * compatibility wrappers with the established csco_* names. The actual render
 * implementations live behind Vaarta-owned functions and an explicit registry.
 * Loading this file before inc/theme-tags.php causes the matching legacy
 * conditional definitions to remain dormant without editing that fallback file.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Navigation walker used by Vaarta's primary header menu.
 */
class Vaarta_Nav_Walker extends Walker_Nav_Menu {
	/**
	 * Start a submenu while preserving the existing scheme markup contract.
	 *
	 * @param string   $output Used to append additional content.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   Menu arguments.
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$indent  = str_repeat( $t, $depth );
		$classes = array( 'sub-menu' );
		$scheme  = csco_color_scheme(
			get_theme_mod( 'color_site_secondary_elements_background', '#f6f7f8' ),
			get_theme_mod( 'color_site_secondary_elements_background_dark', '#50525C' )
		);

		$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<ul$class_names {$scheme}>{$n}";
	}
}

// Keep the established walker class available to child themes/integrations.
if ( ! class_exists( 'CSCO_NAV_Walker' ) ) {
	class CSCO_NAV_Walker extends Vaarta_Nav_Walker {}
}

/**
 * Return the shell-component registry adopted by Vaarta.
 *
 * @return array<string,callable>
 */
function vaarta_get_shell_component_registry() {
	$registry = array(
		'header_nav_menu'             => 'vaarta_render_header_nav_menu',
		'fullscreen_nav_menu'         => 'vaarta_render_fullscreen_nav_menu',
		'header_logo'                 => 'vaarta_render_header_logo',
		'header_tagline'              => 'vaarta_render_header_tagline',
		'header_search_form'           => 'vaarta_render_header_search_form',
		'header_multi_column_widgets'  => 'vaarta_render_header_multi_column_widgets',
		'header_multi_column_posts'    => 'vaarta_render_header_multi_column_posts',
		'header_fullscreen_widgets'    => 'vaarta_render_header_fullscreen_widgets',
		'header_button'               => 'vaarta_render_header_button',
		'header_social_links'         => 'vaarta_render_header_social_links',
		'header_featured_columns'     => 'vaarta_render_header_featured_columns',
		'footer_logo'                 => 'vaarta_render_footer_logo',
		'footer_description'          => 'vaarta_render_footer_description',
		'footer_copyright'            => 'vaarta_render_footer_copyright',
		'footer_menu'                 => 'vaarta_render_footer_menu',
		'footer_nav_menu'             => 'vaarta_render_footer_nav_menu',
		'footer_nav_menu_additional'  => 'vaarta_render_footer_nav_menu_additional',
		'footer_social_links'         => 'vaarta_render_footer_social_links',
		'footer_subscription_form'    => 'vaarta_render_footer_subscription_form',
	);

	/**
	 * Filter Vaarta's adopted site-shell components.
	 *
	 * @param array<string,callable> $registry Component-name to callable map.
	 */
	return apply_filters( 'vaarta_shell_component_registry', $registry );
}

/**
 * Render one registered shell component.
 *
 * @param string $name     Component name without a prefix.
 * @param array  $settings Component settings.
 * @return void
 */
function vaarta_render_shell_component( $name, $settings = array() ) {
	$name     = sanitize_key( $name );
	$registry = vaarta_get_shell_component_registry();

	if ( empty( $registry[ $name ] ) || ! is_callable( $registry[ $name ] ) ) {
		return;
	}

	call_user_func( $registry[ $name ], is_array( $settings ) ? $settings : array() );
}

/**
 * Render the primary header navigation.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_header_nav_menu( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	if ( ! vaarta_get_setting( 'header_navigation_menu' ) || ! has_nav_menu( 'primary' ) ) {
		return;
	}

	wp_nav_menu(
		array(
			'menu_class'      => 'cs-header__nav-inner',
			'theme_location'  => 'primary',
			'container'       => 'nav',
			'container_class' => 'cs-header__nav',
			'walker'          => new CSCO_NAV_Walker(),
		)
	);
}

/**
 * Render fullscreen navigation.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_fullscreen_nav_menu( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	if ( ! vaarta_get_setting( 'header_fullscreen_menu' ) || ! has_nav_menu( 'fullscreen' ) ) {
		return;
	}

	$items_wrap_after = '<div class="cs-fullscreen-menu__nav-col cs-fullscreen-menu__nav-col-first"></div>
					<div class="cs-fullscreen-menu__nav-col cs-fullscreen-menu__nav-col-last"></div>';

	wp_nav_menu(
		array(
			'theme_location'  => 'fullscreen',
			'container_class' => 'cs-fullscreen-menu__nav',
			'menu_class'      => 'cs-fullscreen-menu__nav-inner',
			'items_wrap'      => '<ul class="%2$s">%3$s</ul>' . wp_kses( $items_wrap_after, 'csco' ),
			'fallback_cb'     => '__return_empty_string',
		)
	);
}

/**
 * Render the header logo.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_header_logo( $settings = array() ) {
	$settings = wp_parse_args(
		$settings,
		array(
			'variant' => null,
		)
	);

	$logo_default_name = 'logo';
	$logo_dark_name    = 'logo_dark';
	$logo_class        = null;
	$logo_hide_class   = null;

	if ( 'hide' === $settings['variant'] ) {
		$logo_hide_class = ' cs-logo-hide';
	}

	if ( 'large' === $settings['variant'] ) {
		$logo_default_name = 'large_logo';
		$logo_dark_name    = 'large_logo_dark';
		$logo_class        = 'cs-logo-large';
	}

	$logo_url  = get_theme_mod( $logo_default_name );
	$logo_id   = attachment_url_to_postid( $logo_url );
	$logo_mode = $logo_id ? 'cs-logo-default' : 'cs-logo-once';
	?>
	<div class="cs-logo<?php echo esc_attr( $logo_hide_class ); ?>">
		<a class="cs-header__logo <?php echo esc_attr( $logo_mode ); ?> <?php echo esc_attr( $logo_class ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php
			if ( $logo_id ) {
				csco_get_retina_image( $logo_id, array( 'alt' => get_bloginfo( 'name' ) ) );
			} else {
				bloginfo( 'name' );
			}
			?>
		</a>

		<?php
		if ( 'cs-logo-default' === $logo_mode ) {
			$logo_dark_url = get_theme_mod( $logo_dark_name ) ? get_theme_mod( $logo_dark_name ) : $logo_url;
			$logo_dark_id  = attachment_url_to_postid( $logo_dark_url );

			if ( $logo_dark_id ) {
				?>
				<a class="cs-header__logo cs-logo-dark <?php echo esc_attr( $logo_class ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php csco_get_retina_image( $logo_dark_id, array( 'alt' => get_bloginfo( 'name' ) ) ); ?>
				</a>
				<?php
			}
		}
		?>
	</div>
	<?php
}

/**
 * Render the site tagline in the header.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_header_tagline( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	$tagline = get_option( 'blogdescription' );

	if ( ! $tagline ) {
		return;
	}
	?>
	<div class="cs-header__tag-line">
		<?php echo esc_html( $tagline ); ?>
	</div>
	<?php
}

/**
 * Render the legacy inline header search form.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_header_search_form( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	if ( ! vaarta_get_setting( 'header_search_form' ) ) {
		return;
	}
	?>
	<form role="search" method="get" class="cs-search__nav-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="cs-search__group">
			<button class="cs-search__submit">
				<i class="cs-icon cs-icon-search"></i>
			</button>

			<input required class="cs-search__input" data-swpparentel=".cs-header .cs-search-live-result-container" data-swplive="true" type="search" value="<?php the_search_query(); ?>" name="s" placeholder="<?php echo esc_attr( get_theme_mod( 'misc_search_placeholder', esc_html__( 'Enter keyword', 'caards' ) ) ); ?>">

			<button class="cs-search__close">
				<i class="cs-icon cs-icon-x"></i>
			</button>
		</div>
	</form>
	<?php
}

/**
 * Render the multi-column header panel.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_header_multi_column_widgets( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	if ( ! vaarta_get_setting( 'header_multi_column_display' ) ) {
		return;
	}

	$widgets_enabled = is_active_sidebar( 'sidebar-multicolumn' ) || is_active_sidebar( 'sidebar-multicolumn-2' ) || is_active_sidebar( 'sidebar-multicolumn-3' ) || is_active_sidebar( 'sidebar-multicolumn-4' );
	$posts_enabled   = vaarta_get_setting( 'header_multi_column_posts' );

	if ( ! $widgets_enabled && ! $posts_enabled ) {
		return;
	}

	$scheme = csco_color_scheme(
		get_theme_mod( 'color_site_secondary_elements_background', '#f6f7f8' ),
		get_theme_mod( 'color_site_secondary_elements_background_dark', '#50525C' )
	);
	?>
	<div <?php csco_site_submenu_class( array( 'cs-header__multi-column' ) ); ?>>
		<span class="cs-header__multi-column-toggle">
			<i class="cs-icon cs-icon-more-horizontal"></i>
		</span>

		<div class="cs-header__multi-column-container" <?php echo wp_kses( $scheme, 'csco' ); ?>>
			<div class="cs-container">
				<?php if ( $widgets_enabled ) { ?>
					<div class="cs-header__multi-column-row">
						<div class="cs-header__multi-column-col cs-header__widgets-column cs-widget-area"><?php dynamic_sidebar( 'sidebar-multicolumn' ); ?></div>
						<div class="cs-header__multi-column-col cs-header__widgets-column cs-widget-area"><?php dynamic_sidebar( 'sidebar-multicolumn-2' ); ?></div>
						<div class="cs-header__multi-column-col cs-header__widgets-column cs-widget-area"><?php dynamic_sidebar( 'sidebar-multicolumn-3' ); ?></div>
						<div class="cs-header__multi-column-col cs-header__widgets-column cs-widget-area"><?php dynamic_sidebar( 'sidebar-multicolumn-4' ); ?></div>
					</div>
				<?php } ?>

				<?php
				if ( $posts_enabled ) {
					vaarta_render_header_multi_column_posts();
				}
				?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Render header multi-column posts.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_header_multi_column_posts( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	if ( ! vaarta_get_setting( 'header_multi_column_posts' ) ) {
		return;
	}

	$query_args = array(
		'order'               => get_theme_mod( 'header_multi_column_posts_order', 'DESC' ),
		'post_type'           => 'post',
		'ignore_sticky_posts' => true,
		'posts_per_page'      => 4,
	);

	$orderby = get_theme_mod( 'header_multi_column_posts_orderby', 'date' );
	if ( 'post_views' === $orderby ) {
		if ( class_exists( 'Post_Views_Counter' ) ) {
			$query_args['orderby']                     = 'post_views';
			$query_args['views_query']['hide_empty'] = false;
			$time_frame = get_theme_mod( 'header_multi_column_time_frame' );
			if ( $time_frame ) {
				$query_args['date_query'] = array(
					array(
						'column' => 'post_date_gmt',
						'after'  => $time_frame . ' ago',
					),
				);
			}
		} else {
			$query_args['orderby'] = 'date';
		}
	} else {
		$query_args['orderby'] = $orderby;
	}

	$filter_posts = get_theme_mod( 'header_multi_column_filter_posts' );
	if ( $filter_posts ) {
		$query_args['post__in'] = array_map( 'trim', explode( ',', $filter_posts ) );
	}

	$filter_categories = get_theme_mod( 'header_multi_column_filter_categories' );
	if ( $filter_categories ) {
		$filter_categories       = array_map( 'trim', explode( ',', $filter_categories ) );
		$query_args['tax_query'] = array(
			array(
				'taxonomy'         => 'category',
				'field'            => 'slug',
				'terms'            => $filter_categories,
				'include_children' => true,
			),
		);
	}

	$filter_tags = get_theme_mod( 'header_multi_column_filter_tags' );
	if ( $filter_tags ) {
		$query_args['tag'] = array_map( 'trim', explode( ',', $filter_tags ) );
	}

	$items = new WP_Query( $query_args );

	if ( $items->have_posts() ) {
		$heading = get_theme_mod( 'header_multi_column_posts_heading', esc_html__( 'Popular', 'caards' ) );
		$options = array(
			'image_orientation' => get_theme_mod( 'header_multi_column_image_orientation', 'landscape-16-9' ),
			'image_size'        => get_theme_mod( 'header_multi_column_image_size', 'csco-thumbnail' ),
		);
		$options = csco_block_normalize_meta( $options, 'header_multi_column_posts_meta' );
		?>
		<div class="cs-header__multi-column-posts-wrapper">
			<?php if ( $heading ) { ?>
				<div class="cs-header__multi-column-posts-title"><?php echo wp_kses( $heading, 'post' ); ?></div>
			<?php } ?>

			<div class="cs-header__multi-column-posts">
				<?php
				while ( $items->have_posts() ) {
					$items->the_post();
					?>
					<article <?php post_class( 'mega-menu-item menu-post-item' ); ?>>
						<div class="cs-entry__outer">
							<div class="cs-entry__inner cs-entry__content">
								<?php csco_get_post_meta( 'category', false, true, 'header_multi_column_posts_meta' ); ?>
								<?php the_title( '<h5 class="cs-entry__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h5>' ); ?>
								<?php csco_get_post_meta( array( 'author', 'date', 'comments' ), false, true, 'header_multi_column_posts_meta' ); ?>
							</div>

							<?php if ( has_post_thumbnail() ) { ?>
								<div class="cs-entry__inner cs-entry__overlay cs-entry__thumbnail cs-overlay-ratio cs-ratio-<?php echo esc_attr( $options['image_orientation'] ); ?>" data-scheme="inverse">
									<div class="cs-overlay-background cs-overlay-transparent"><?php the_post_thumbnail( $options['image_size'] ); ?></div>
									<a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link"></a>
								</div>
							<?php } ?>

							<?php csco_block_post_footer( $options, null, true, null, array() ); ?>
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link"></a>
						</div>
					</article>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}

	wp_reset_postdata();
}

/**
 * Render fullscreen widget area.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_header_fullscreen_widgets( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	if ( ! is_active_sidebar( 'sidebar-fullscreen' ) ) {
		return;
	}
	?>
	<div class="cs-fullscreen-menu__widgets cs-widget-area">
		<?php dynamic_sidebar( 'sidebar-fullscreen' ); ?>
	</div>
	<?php
}

/**
 * Render header CTA button.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_header_button( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	$button = get_theme_mod( 'header_button_label', esc_html__( 'Buy Now', 'caards' ) );
	$link   = vaarta_get_setting( 'header_button_link' );
	$target = vaarta_get_setting( 'header_button_target' ) ? ' target="_blank"' : '';

	if ( ! $button || ! $link ) {
		return;
	}
	?>
	<div class="cs-header__cta">
		<a href="<?php echo esc_url( $link ); ?>" class="cs-header__cta-link"<?php echo wp_kses( $target, 'csco' ); ?>>
			<?php echo wp_kses( $button, 'csco' ); ?>
		</a>
	</div>
	<?php
}

/**
 * Render header social links.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_header_social_links( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	if ( ! vaarta_get_setting( 'header_social_links' ) || ! vaarta_has_social_links_integration() ) {
		return;
	}

	// Preserve the renderer's historical fallback values to avoid visual changes.
	$scheme  = get_theme_mod( 'header_social_links_scheme', 'default' );
	$maximum = get_theme_mod( 'header_social_links_maximum', 3 );
	$counts  = get_theme_mod( 'header_social_links_counts', true );
	?>
	<div class="cs-navbar-social-links">
		<?php powerkit_social_links( false, false, $counts, 'nav', $scheme, 'mixed', $maximum ); ?>
	</div>
	<?php
}

/**
 * Render the featured header widget columns.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_header_featured_columns( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	if ( ! get_theme_mod( 'header_featured_columns', true ) ) {
		return;
	}

	if ( ! is_active_sidebar( 'sidebar-featured' ) && ! is_active_sidebar( 'sidebar-featured-2' ) && ! is_active_sidebar( 'sidebar-featured-3' ) && ! is_active_sidebar( 'sidebar-featured-4' ) ) {
		return;
	}

	$scheme = csco_color_scheme(
		get_theme_mod( 'color_header_elements_background', '#f6f7f8' ),
		get_theme_mod( 'color_header_elements_background_dark', '#2f323d' )
	);
	?>
	<div <?php csco_site_submenu_class( array( 'cs-header__featured-column' ) ); ?>>
		<span class="cs-header__featured-column-toggle">
			<?php if ( get_theme_mod( 'header_featured_columns_icon', true ) ) { ?>
				<?php echo wp_kses( get_theme_mod( 'header_featured_columns_icon', '<i class="cs-icon cs-icon-flashlight"></i>' ), 'csco' ); ?>
			<?php } ?>
			<?php echo esc_html( get_theme_mod( 'header_featured_columns_title', esc_html__( 'Features', 'caards' ) ) ); ?>
		</span>
		<div class="cs-header__featured-column-container" <?php echo wp_kses( $scheme, 'csco' ); ?>>
			<div class="cs-container">
				<div class="cs-header__featured-column-row">
					<div class="cs-header__featured-column-col cs-widget-area"><?php dynamic_sidebar( 'sidebar-featured' ); ?></div>
					<div class="cs-header__featured-column-col cs-widget-area"><?php dynamic_sidebar( 'sidebar-featured-2' ); ?></div>
					<div class="cs-header__featured-column-col cs-widget-area"><?php dynamic_sidebar( 'sidebar-featured-3' ); ?></div>
					<div class="cs-header__featured-column-col cs-widget-area"><?php dynamic_sidebar( 'sidebar-featured-4' ); ?></div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Render the footer logo.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_footer_logo( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	$logo_url  = get_theme_mod( 'footer_logo' );
	$logo_id   = attachment_url_to_postid( $logo_url );
	$logo_mode = $logo_id ? 'cs-logo-default' : 'cs-logo-once';
	?>
	<div class="cs-logo">
		<a class="cs-footer__logo <?php echo esc_attr( $logo_mode ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php
			if ( $logo_id ) {
				csco_get_retina_image( $logo_id, array( 'alt' => get_bloginfo( 'name' ) ) );
			} else {
				bloginfo( 'name' );
			}
			?>
		</a>

		<?php
		if ( 'cs-logo-default' === $logo_mode ) {
			$logo_dark_url = get_theme_mod( 'footer_logo_dark' ) ? get_theme_mod( 'footer_logo_dark' ) : $logo_url;
			$logo_dark_id  = attachment_url_to_postid( $logo_dark_url );
			if ( $logo_dark_id ) {
				?>
				<a class="cs-footer__logo cs-logo-dark" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php csco_get_retina_image( $logo_dark_id, array( 'alt' => get_bloginfo( 'name' ) ) ); ?>
				</a>
				<?php
			}
		}
		?>
	</div>
	<?php
}

/**
 * Render footer description.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_footer_description( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	$description = get_theme_mod( 'footer_description' );
	if ( ! $description ) {
		return;
	}
	?>
	<div class="cs-footer__info">
		<?php echo do_shortcode( $description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Sanitized by the established Customizer callback; shortcodes may return markup. ?>
	</div>
	<?php
}

/**
 * Render footer copyright.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_footer_copyright( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	$copyright = get_theme_mod(
		'footer_copyright',
		sprintf(
			esc_html__( 'All Rights Reserved © %s Caards %s', 'caards' ),
			date( 'Y' ),
			'<a href="' . esc_url( csco_get_theme_data( 'AuthorURI' ) ) . '">Code Supply Co.</a>'
		)
	);

	if ( ! $copyright ) {
		return;
	}
	?>
	<div class="cs-footer__copyright">
		<?php echo do_shortcode( $copyright ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Preserve the established sanitized rich-text/shortcode contract. ?>
	</div>
	<?php
}

/**
 * Render one labelled footer menu column.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_footer_menu( $settings = array() ) {
	$settings = wp_parse_args(
		$settings,
		array(
			'menu_class' => null,
			'location'   => null,
			'lacation'   => null,
		)
	);

	// Accept the historical misspelling when passed by third-party code.
	if ( ! $settings['location'] && $settings['lacation'] ) {
		$settings['location'] = $settings['lacation'];
	}

	if ( ! $settings['location'] || ! has_nav_menu( $settings['location'] ) ) {
		return;
	}

	$items_wrap_before = '';
	$menu_name         = wp_get_nav_menu_name( $settings['location'] );
	if ( $menu_name ) {
		$items_wrap_before = '<span class="cs-footer__nav-label">' . esc_html( $menu_name ) . '</span>';
	}

	wp_nav_menu(
		array(
			'theme_location'  => $settings['location'],
			'container'       => 'div',
			'container_class' => 'cs-footer__nav-item',
			'menu_class'      => sprintf( 'cs-footer__nav-inner %s', $settings['menu_class'] ),
			'depth'           => 1,
			'fallback_cb'     => '__return_empty_string',
			'items_wrap'      => wp_kses( $items_wrap_before, 'csco' ) . '<ul class="%2$s">%3$s</ul>',
		)
	);
}

/**
 * Render the horizontal footer navigation.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_footer_nav_menu( $settings = array() ) {
	$settings = wp_parse_args( $settings, array( 'menu_class' => null ) );
	if ( ! has_nav_menu( 'footer' ) ) {
		return;
	}
	?>
	<nav class="cs-footer__nav cs-footer__nav-horizontal">
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'footer',
				'container_class' => 'cs-footer__nav-item',
				'menu_class'      => sprintf( 'cs-footer__nav-inner %s', $settings['menu_class'] ),
				'container'       => 'div',
				'depth'           => 1,
				'fallback_cb'     => '__return_empty_string',
			)
		);
		?>
	</nav>
	<?php
}

/**
 * Render the additional horizontal footer navigation.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_footer_nav_menu_additional( $settings = array() ) {
	$settings = wp_parse_args( $settings, array( 'menu_class' => null ) );
	if ( ! has_nav_menu( 'footer-additional' ) ) {
		return;
	}
	?>
	<nav class="cs-footer__nav cs-footer__nav-horizontal cs-footer__nav-additional">
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'footer-additional',
				'container_class' => 'cs-footer__nav-item',
				'menu_class'      => sprintf( 'cs-footer__nav-inner %s', $settings['menu_class'] ),
				'container'       => 'div',
				'depth'           => 1,
				'fallback_cb'     => '__return_empty_string',
			)
		);
		?>
	</nav>
	<?php
}

/**
 * Render footer social links.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_footer_social_links( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	if ( ! vaarta_get_setting( 'footer_social_links' ) || ! vaarta_has_social_links_integration() ) {
		return;
	}

	// Preserve the renderer's historical fallback values to avoid visual changes.
	$scheme  = get_theme_mod( 'footer_social_links_scheme', 'default' );
	$maximum = get_theme_mod( 'footer_social_links_maximum', 3 );
	$counts  = get_theme_mod( 'footer_social_links_counts', true );
	?>
	<div class="cs-footer-social-links">
		<?php powerkit_social_links( false, false, $counts, 'nav', $scheme, 'mixed', $maximum ); ?>
	</div>
	<?php
}

/**
 * Render footer subscription form.
 *
 * @param array $settings Component settings.
 * @return void
 */
function vaarta_render_footer_subscription_form( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	if ( ! vaarta_get_setting( 'footer_subscribe' ) ) {
		return;
	}

	// Preserve historical rendering defaults until an explicit content migration.
	$subscribe_title = get_theme_mod( 'footer_subscribe_title', esc_html__( 'Subscribe to our newsletter', 'caards' ) );
	$subscribe_text  = get_theme_mod( 'footer_subscribe_text', esc_html__( 'Get notified of the best deals on our WordPress themes.', 'caards' ) );
	$subscribe_name  = get_theme_mod( 'footer_subscribe_name', false );

	do_action( 'csco_post_subscribe_before' );
	?>
	<div class="cs-site-subscribe ">
		<div class="cs-container">
			<div class="cs-site-subscribe__item">
				<div class="cs-site-subscribe__form">
					<?php if ( $subscribe_title || $subscribe_text ) { ?>
						<div class="cs-site-subscribe__info">
							<?php if ( $subscribe_title ) { ?>
								<span class="h5 cs-site-subscribe__title"><?php echo wp_kses( $subscribe_title, 'csco' ); ?></span>
							<?php } ?>
							<?php if ( $subscribe_text ) { ?>
								<div class="cs-site-subscribe__info-text"><?php echo wp_kses( $subscribe_text, 'csco' ); ?></div>
							<?php } ?>
						</div>
					<?php } ?>

					<?php echo do_shortcode( sprintf( '[powerkit_subscription_form display_name="%1$s" %2$s="" text=""]', $subscribe_name, 'title' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Shortcode output owns markup escaping. ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Legacy csco_* compatibility wrappers.
 */
if ( ! function_exists( 'csco_header_nav_menu' ) ) {
	function csco_header_nav_menu( $settings = array() ) { vaarta_render_header_nav_menu( $settings ); }
}
if ( ! function_exists( 'csco_fullscreen_nav_menu' ) ) {
	function csco_fullscreen_nav_menu( $settings = array() ) { vaarta_render_fullscreen_nav_menu( $settings ); }
}
if ( ! function_exists( 'csco_header_logo' ) ) {
	function csco_header_logo( $settings = array() ) { vaarta_render_header_logo( $settings ); }
}
if ( ! function_exists( 'csco_header_tagline' ) ) {
	function csco_header_tagline( $settings = array() ) { vaarta_render_header_tagline( $settings ); }
}
if ( ! function_exists( 'csco_header_search_form' ) ) {
	function csco_header_search_form( $settings = array() ) { vaarta_render_header_search_form( $settings ); }
}
if ( ! function_exists( 'csco_header_multi_column_widgets' ) ) {
	function csco_header_multi_column_widgets( $settings = array() ) { vaarta_render_header_multi_column_widgets( $settings ); }
}
if ( ! function_exists( 'csco_header_multi_column_posts' ) ) {
	function csco_header_multi_column_posts( $settings = array() ) { vaarta_render_header_multi_column_posts( $settings ); }
}
if ( ! function_exists( 'csco_header_fullscreen_widgets' ) ) {
	function csco_header_fullscreen_widgets( $settings = array() ) { vaarta_render_header_fullscreen_widgets( $settings ); }
}
if ( ! function_exists( 'csco_header_button' ) ) {
	function csco_header_button( $settings = array() ) { vaarta_render_header_button( $settings ); }
}
if ( ! function_exists( 'csco_header_social_links' ) ) {
	function csco_header_social_links( $settings = array() ) { vaarta_render_header_social_links( $settings ); }
}
if ( ! function_exists( 'csco_header_featured_columns' ) ) {
	function csco_header_featured_columns( $settings = array() ) { vaarta_render_header_featured_columns( $settings ); }
}
if ( ! function_exists( 'csco_footer_logo' ) ) {
	function csco_footer_logo( $settings = array() ) { vaarta_render_footer_logo( $settings ); }
}
if ( ! function_exists( 'csco_footer_description' ) ) {
	function csco_footer_description( $settings = array() ) { vaarta_render_footer_description( $settings ); }
}
if ( ! function_exists( 'csco_footer_copyright' ) ) {
	function csco_footer_copyright( $settings = array() ) { vaarta_render_footer_copyright( $settings ); }
}
if ( ! function_exists( 'csco_footer_menu' ) ) {
	function csco_footer_menu( $settings = array() ) { vaarta_render_footer_menu( $settings ); }
}
if ( ! function_exists( 'csco_footer_nav_menu' ) ) {
	function csco_footer_nav_menu( $settings = array() ) { vaarta_render_footer_nav_menu( $settings ); }
}
if ( ! function_exists( 'csco_footer_nav_menu_additional' ) ) {
	function csco_footer_nav_menu_additional( $settings = array() ) { vaarta_render_footer_nav_menu_additional( $settings ); }
}
if ( ! function_exists( 'csco_footer_social_links' ) ) {
	function csco_footer_social_links( $settings = array() ) { vaarta_render_footer_social_links( $settings ); }
}
if ( ! function_exists( 'csco_footer_subscription_form' ) ) {
	function csco_footer_subscription_form( $settings = array() ) { vaarta_render_footer_subscription_form( $settings ); }
}
