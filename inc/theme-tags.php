<?php
/**
 * Template Tags
 *
 * Functions that are called directly from template parts or within actions.
 *
 * @package Caards
 */

if ( ! function_exists( 'csco_header_nav_menu' ) ) {
	class CSCO_NAV_Walker extends Walker_Nav_Menu {
		/**
		 * Starts the list before the elements are added.
		 *
		 * @since 3.0.0
		 *
		 * @see Walker::start_lvl()
		 *
		 * @param string   $output Used to append additional content (passed by reference).
		 * @param int      $depth  Depth of menu item. Used for padding.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 */
		public function start_lvl( &$output, $depth = 0, $args = null ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );

			$classes = array( 'sub-menu' );

			$scheme = csco_color_scheme(
				get_theme_mod( 'color_site_secondary_elements_background', '#f6f7f8' ),
				get_theme_mod( 'color_site_secondary_elements_background_dark', '#50525C' )
			);

			/**
			 * Filters the CSS class(es) applied to a menu list element.
			 *
			 * @since 4.8.0
			 *
			 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
			 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
			 * @param int      $depth   Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$output .= "{$n}{$indent}<ul$class_names {$scheme}>{$n}";
		}
	}

	/**
	 * Header Nav Menu
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_nav_menu( $settings = array() ) {
		if ( ! get_theme_mod( 'header_navigation_menu', true ) ) {
			return;
		}

		if ( has_nav_menu( 'primary' ) ) {
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
	}
}

if ( ! function_exists( 'csco_fullscreen_nav_menu' ) ) {
	/**
	 * Fullscreen Nav Menu
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_fullscreen_nav_menu( $settings = array() ) {
		if ( ! get_theme_mod( 'header_fullscreen_menu', false ) ) {
			return;
		}

		$items_wrap_after = '<div class="cs-fullscreen-menu__nav-col cs-fullscreen-menu__nav-col-first"></div>
					<div class="cs-fullscreen-menu__nav-col cs-fullscreen-menu__nav-col-last"></div>';

		if ( has_nav_menu( 'fullscreen' ) ) {
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
	}
}

if ( ! function_exists( 'csco_header_logo' ) ) {
	/**
	 * Header Logo
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_logo( $settings = array() ) {

		$logo_default_name = 'logo';
		$logo_dark_name    = 'logo_dark';
		$logo_class        = null;
		$logo_hide_class   = null;

		$settings = array_merge(
			array(
				'variant' => null,
			),
			$settings
		);

		// For hide logo.
		if ( 'hide' === $settings['variant'] ) {
			$logo_hide_class = ' cs-logo-hide';
		}

		// For large logo.
		if ( 'large' === $settings['variant'] ) {
			$logo_default_name = 'large_logo';
			$logo_dark_name    = 'large_logo_dark';
			$logo_class        = 'cs-logo-large';
		}

		// Get default logo.
		$logo_url = get_theme_mod( $logo_default_name );

		$logo_id = attachment_url_to_postid( $logo_url );

		// Set mode of logo.
		$logo_mode = 'cs-logo-once';

		// Check display mode.
		if ( $logo_id ) {
			$logo_mode = 'cs-logo-default';
		}
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

				$logo_dark_id = attachment_url_to_postid( $logo_dark_url );

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
}

if ( ! function_exists( 'csco_header_tagline' ) ) {
	/**
	 * Header Tagline
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_tagline( $settings = array() ) {
		if ( get_option( 'blogdescription' ) ) {
			?>
			<div class="cs-header__tag-line">
				<?php echo esc_html( get_option( 'blogdescription' ) ); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_header_offcanvas_toggle' ) ) {
	/**
	 * Header Offcanvas Toggle
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_offcanvas_toggle( $settings = array() ) {
		if ( csco_offcanvas_exists() ) {
			?>
				<span class="cs-header__offcanvas-toggle cs-d-lg-none" role="button">
					<span></span>
				</span>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_header_search_toggle' ) ) {
	/**
	 * Header Search Toggle
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_search_toggle( $settings = array() ) {
		if ( ! get_theme_mod( 'header_search_button', true ) ) {
			return;
		}
		?>
		<span class="cs-header__search-toggle" role="button">
			<i class="cs-icon cs-icon-search"></i>
		</span>
		<?php
	}
}

if ( ! function_exists( 'csco_header_search_form' ) ) {
	/**
	 * Header Search Form
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_search_form( $settings = array() ) {
		if ( ! get_theme_mod( 'header_search_form', true ) ) {
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
}

if ( ! function_exists( 'csco_header_scheme_toggle' ) ) {
	/**
	 * Header Scheme Toggle
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_scheme_toggle( $settings = array() ) {
		if ( ! get_theme_mod( 'color_scheme_toggle', true ) ) {
			return;
		}
		?>
			<span role="button" class="cs-header__scheme-toggle cs-site-scheme-toggle">
				<span class="cs-header__scheme-toggle-icons">
					<i class="cs-header__scheme-toggle-icon cs-icon cs-icon-light-mode"></i>
					<i class="cs-header__scheme-toggle-icon cs-icon cs-icon-dark-mode"></i>
				</span>
			</span>
		<?php
	}
}

if ( ! function_exists( 'csco_header_fullscreen_menu_toggle' ) ) {
	/**
	 * Header Fullscreen Menu Toggle
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_fullscreen_menu_toggle( $settings = array() ) {
		if ( ! get_theme_mod( 'header_fullscreen_menu', false ) ) {
			return;
		}
		?>
		<span class="cs-header__fullscreen-menu-toggle" role="button">
			<span></span>
		</span>
		<?php
	}
}

if ( ! function_exists( 'csco_header_scheme_toggle_mobile' ) ) {
	/**
	 * Header Scheme Toggle Mobile
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_scheme_toggle_mobile( $settings = array() ) {
		if ( ! get_theme_mod( 'color_scheme_toggle', true ) ) {
			return;
		}
		?>
		<span role="button" class="cs-header__scheme-toggle cs-header__scheme-toggle-mobile cs-site-scheme-toggle">
			<i class="cs-header__scheme-toggle-icon cs-icon cs-icon-light-mode"></i>
			<i class="cs-header__scheme-toggle-icon cs-icon cs-icon-dark-mode"></i>
		</span>
		<?php
	}
}

if ( ! function_exists( 'csco_header_multi_column_widgets' ) ) {
	/**
	 * Header Multi-Column Widgets
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_multi_column_widgets( $settings = array() ) {

		if ( ! get_theme_mod( 'header_multi_column_display', false ) ) {
			return;
		}

		$multicolumn_widgets_enabled = is_active_sidebar( 'sidebar-multicolumn' ) || is_active_sidebar( 'sidebar-multicolumn-2' ) || is_active_sidebar( 'sidebar-multicolumn-3' ) || is_active_sidebar( 'sidebar-multicolumn-4' );

		$multicolumn_posts_enabled = get_theme_mod( 'header_multi_column_posts', true );

		if ( $multicolumn_widgets_enabled || $multicolumn_posts_enabled ) {
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
						<?php if ( $multicolumn_widgets_enabled ) { ?>
							<div class="cs-header__multi-column-row">
								<div class="cs-header__multi-column-col cs-header__widgets-column cs-widget-area">
									<?php dynamic_sidebar( 'sidebar-multicolumn' ); ?>
								</div>
								<div class="cs-header__multi-column-col cs-header__widgets-column cs-widget-area">
									<?php dynamic_sidebar( 'sidebar-multicolumn-2' ); ?>
								</div>
								<div class="cs-header__multi-column-col cs-header__widgets-column cs-widget-area">
									<?php dynamic_sidebar( 'sidebar-multicolumn-3' ); ?>
								</div>
								<div class="cs-header__multi-column-col cs-header__widgets-column cs-widget-area">
									<?php dynamic_sidebar( 'sidebar-multicolumn-4' ); ?>
								</div>
							</div>
						<?php } ?>

						<?php
						if ( $multicolumn_posts_enabled ) {
							csco_header_multi_column_posts();
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_header_multi_column_posts' ) ) {
	/**
	 * Header Multi Column Posts
	 */
	function csco_header_multi_column_posts() {

		if ( ! get_theme_mod( 'header_multi_column_posts', true ) ) {
			return;
		}

		$image_size = get_theme_mod( 'header_multi_column_image_size', 'csco-small' );

		$query_args = array(
			'order'               => get_theme_mod( 'header_multi_column_posts_order', 'DESC' ),
			'post_type'           => 'post',
			'ignore_sticky_posts' => true,
			'posts_per_page'      => 4,
		);

		// Post orderby.
		$orderby = get_theme_mod( 'header_multi_column_posts_orderby', 'date' );
		if ( 'post_views' === $orderby ) {
			if ( class_exists( 'Post_Views_Counter' ) ) {
				// Post Views.
				$query_args['orderby'] = 'post_views';
				// Don't hide posts without views.
				$query_args['views_query']['hide_empty'] = false;
				// Time Frame for Post Views.
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

		// Filter by posts.
		$filter_posts = get_theme_mod( 'header_multi_column_filter_posts' );
		if ( $filter_posts ) {
			$query_args['post__in'] = array_map( 'trim', explode( ',', $filter_posts ) );
		}

		// Filter by categories.
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

		// Filter by tags.
		$filter_tags = get_theme_mod( 'header_multi_column_filter_tags' );
		if ( $filter_tags ) {
			$query_args['tag'] = array_map( 'trim', explode( ',', $filter_tags ) );
		}

		// WP Query.
		$items = new WP_Query( $query_args );

		if ( $items->have_posts() ) {
			$heading = get_theme_mod( 'header_multi_column_posts_heading', esc_html__( 'Popular', 'caards' ) );

			// Set options.
			$options = array(
				'image_orientation' => get_theme_mod( 'header_multi_column_image_orientation', 'landscape-16-9' ),
				'image_size'        => get_theme_mod( 'header_multi_column_image_size', 'csco-thumbnail' ),
			);

			$options = csco_block_normalize_meta( $options, 'header_multi_column_posts_meta' );
			?>
			<div class="cs-header__multi-column-posts-wrapper">
				<?php if ( $heading ) { ?>
					<div class="cs-header__multi-column-posts-title">
						<?php echo wp_kses( $heading, 'post' ); ?>
					</div>
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

										<div class="cs-overlay-background cs-overlay-transparent">
											<?php the_post_thumbnail( $options['image_size'] ); ?>
										</div>

										<a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link"></a>
									</div>
								<?php } ?>

								<?php csco_block_post_footer( $options, null, true, null, array() ); ?>

								<a href="<?php echo esc_url( get_permalink() ); ?>" class="cs-overlay-link"></a>
							</div>
						</article>
					<?php } ?>
				</div>
			</div>
			<?php
		}

		wp_reset_postdata();

	}
}

if ( ! function_exists( 'csco_header_fullscreen_widgets' ) ) {
	/**
	 * Header Fullscreen Widgets
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_fullscreen_widgets( $settings = array() ) {

		if ( ! is_active_sidebar( 'sidebar-fullscreen' ) ) {
			return;
		}

		?>
		<div class="cs-fullscreen-menu__widgets cs-widget-area">
			<?php dynamic_sidebar( 'sidebar-fullscreen' ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'csco_header_button' ) ) {
	/**
	 * Header Button
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_button( $settings = array() ) {
		$button = get_theme_mod( 'header_button_label', esc_html__( 'Buy Now', 'caards' ) );
		$link   = get_theme_mod( 'header_button_link' );
		$target = get_theme_mod( 'header_button_target' );
		if ( $target ) {
			$target = ' target="_blank"';
		} else {
			$target = '';
		}

		if ( $button && $link ) {
			?>
			<div class="cs-header__cta">
				<a href="<?php echo esc_url( $link ); ?>" class="cs-header__cta-link"<?php echo wp_kses( $target, 'csco' );?>>
					<?php echo wp_kses( $button, 'csco' ); ?>
				</a>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_header_social_links' ) ) {
	/**
	 * Header Social Links
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_social_links( $settings = array() ) {

		if ( ! get_theme_mod( 'header_social_links', false ) ) {
			return;
		}

		if ( ! csco_powerkit_module_enabled( 'social_links' ) ) {
			return;
		}

		$scheme  = get_theme_mod( 'header_social_links_scheme', 'default' );
		$maximum = get_theme_mod( 'header_social_links_maximum', 3 );
		$counts  = get_theme_mod( 'header_social_links_counts', true );
		?>
		<div class="cs-navbar-social-links">
			<?php powerkit_social_links( false, false, $counts, 'nav', $scheme, 'mixed', $maximum ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'csco_header_featured_columns' ) ) {
	/**
	 * Header Featured Columns
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_header_featured_columns( $settings = array() ) {

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
						<div class="cs-header__featured-column-col cs-widget-area">
							<?php dynamic_sidebar( 'sidebar-featured' ); ?>
						</div>
						<div class="cs-header__featured-column-col cs-widget-area">
							<?php dynamic_sidebar( 'sidebar-featured-2' ); ?>
						</div>
						<div class="cs-header__featured-column-col cs-widget-area">
							<?php dynamic_sidebar( 'sidebar-featured-3' ); ?>
						</div>
						<div class="cs-header__featured-column-col cs-widget-area">
							<?php dynamic_sidebar( 'sidebar-featured-4' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'csco_footer_logo' ) ) {
	/**
	 * Footer Logo
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_footer_logo( $settings = array() ) {
		$logo_url = get_theme_mod( 'footer_logo' );

		$logo_id = attachment_url_to_postid( $logo_url );

		$logo_mode = 'cs-logo-once';

		if ( $logo_id ) {
			$logo_mode = 'cs-logo-default';
		}
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

				$logo_dark_id = attachment_url_to_postid( $logo_dark_url );

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
}

if ( ! function_exists( 'csco_footer_description' ) ) {
	/**
	 * Footer Description
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_footer_description( $settings = array() ) {
		/* translators: %s: Author name. */
		$footer_description = get_theme_mod( 'footer_description' );
		if ( $footer_description ) {
			?>
			<div class="cs-footer__info">
				<?php echo do_shortcode( $footer_description ); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_footer_copyright' ) ) {
	/**
	 * Footer Copyright
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_footer_copyright( $settings = array() ) {
		/* translators: %s: Author name. */
		$footer_copyright = get_theme_mod( 'footer_copyright', sprintf( esc_html__( 'All Rights Reserved © %s Caards %s', 'caards' ), date( 'Y' ), '<a href="' . esc_url( csco_get_theme_data( 'AuthorURI' ) ) . '">Code Supply Co.</a>' ) );
		if ( $footer_copyright ) {
			?>
			<div class="cs-footer__copyright">
				<?php echo do_shortcode( $footer_copyright ); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_footer_menu' ) ) {
	/**
	 * Footer Menu
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_footer_menu( $settings = array() ) {

		$settings = array_merge( array(
			'menu_class' => null,
			'lacation'   => null,
		), $settings );

		if ( has_nav_menu( $settings['location'] ) ) {
			$items_wrap_before = '';

			$menu_name = wp_get_nav_menu_name( $settings['location'] );
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
	}
}

if ( ! function_exists( 'csco_footer_nav_menu' ) ) {
	/**
	 * Footer Nav Menu
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_footer_nav_menu( $settings = array() ) {

		$settings = array_merge( array(
			'menu_class' => null,
		), $settings );

		if ( has_nav_menu( 'footer' ) ) {
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
	}
}

if ( ! function_exists( 'csco_footer_nav_menu_additional' ) ) {
	/**
	 * Footer Additional Nav Menu
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_footer_nav_menu_additional( $settings = array() ) {

		$settings = array_merge( array(
			'menu_class' => null,
		), $settings );

		if ( has_nav_menu( 'footer-additional' ) ) {
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
	}
}

if ( ! function_exists( 'csco_footer_social_links' ) ) {
	/**
	 * Footer Social Links
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_footer_social_links( $settings = array() ) {

		if ( ! get_theme_mod( 'footer_social_links', false ) ) {
			return;
		}

		if ( ! csco_powerkit_module_enabled( 'social_links' ) ) {
			return;
		}

		$scheme  = get_theme_mod( 'footer_social_links_scheme', 'default' );
		$maximum = get_theme_mod( 'footer_social_links_maximum', 3 );
		$counts  = get_theme_mod( 'footer_social_links_counts', true );
		?>
		<div class="cs-footer-social-links">
			<?php powerkit_social_links( false, false, $counts, 'nav', $scheme, 'mixed', $maximum ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'csco_footer_subscription_form' ) ) {
	/**
	 * Footer Subscription Form
	 *
	 * @param array $settings The advanced settings.
	 */
	function csco_footer_subscription_form( $settings = array() ) {

		$settings = array_merge( array(
			'container' => false,
		), $settings );

		if ( ! get_theme_mod( 'footer_subscribe', false ) ) {
			return;
		}

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
									<span class="h5 cs-site-subscribe__title">
										<?php echo wp_kses( $subscribe_title, 'csco' ); ?>
									</span>
								<?php } ?>

								<?php if ( $subscribe_text ) { ?>
									<div class="cs-site-subscribe__info-text"><?php echo wp_kses( $subscribe_text, 'csco' ); ?></div>
								<?php } ?>
							</div>
						<?php } ?>

						<?php echo do_shortcode( sprintf( '[powerkit_subscription_form display_name="%1$s" %2$s="" text=""]', $subscribe_name, 'title' ) ); ?>
					</div>

				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'csco_the_post_format_icon' ) ) {
	/**
	 * Post Format Icon
	 *
	 * @param string $content After content.
	 */
	function csco_the_post_format_icon( $content = '' ) {
		$post_format = get_post_format();

		if ( $post_format ) {
			?>
			<span class="cs-entry-format">
				<a class="cs-format-icon cs-format-<?php echo esc_attr( $post_format ); ?>" href="<?php the_permalink(); ?>">
					<?php echo wp_kses( $content, 'csco' ); ?>
				</a>
			</span>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_post_subtitle' ) ) {
	/**
	 * Post Subtitle
	 */
	function csco_post_subtitle() {
		if ( ! is_single() ) {
			return;
		}

		if ( get_theme_mod( 'post_subtitle', false ) ) {
			$subtitle = apply_filters( 'plugins/wp_subtitle/get_subtitle', '', array(
				'before'  => '',
				'after'   => '',
				'post_id' => get_the_ID(),
			) );

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
	}
}

if ( ! function_exists( 'csco_post_category' ) ) {
	/**
	 * Post Category
	 *
	 * @param string $location The location.
	 */
	function csco_post_category( $location = 'header' ) {

		if ( ! csco_has_post_meta( 'category' ) ) {
			return;
		}

		if ( 'metabar' === $location && ( 'large' === csco_get_page_header_type() || 'full' === csco_get_page_header_type() ) ) {
			return;
		}

		$first_category = false;

		$post_categories = wp_get_post_categories( get_the_ID(), array( 'fields' => 'all' ) );

		if ( ! empty( $post_categories ) && ! is_wp_error( $post_categories ) ) {
			$first_category  = array_shift( $post_categories );
			$category_name   = $first_category->name;
			$category_id     = $first_category->term_id;
			$category_link   = get_term_link( $category_id );
			$category_letter = mb_substr( $category_name, 0, 1 );
		}

		if ( $first_category ) {
			// Colors.
			$letter_color = get_term_meta( $category_id, 'csco_letter_color', true );
			$start_color  = get_term_meta( $category_id, 'csco_gradient_start_color', true );
			$end_color    = get_term_meta( $category_id, 'csco_gradient_end_color', true );

			$styles = __return_empty_string();
			if ( $letter_color ) {
				$styles .= '--cs-color-category-letter-contrast: ' . $letter_color . ';';
			}
			if ( $start_color ) {
				$styles .= '--cs-color-category-letter-gradient-top: ' . $start_color . ';';
			}
			if ( $end_color ) {
				$styles .= '--cs-color-category-letter-gradient-bottom: ' . $end_color . ';';
			}
			?>
			<?php if ( 'header' === $location ) { ?>
				<div class="cs-entry__header-category">
					<div class="cs-entry__header-category-inner">
			<?php } ?>

					<div class="cs-entry__category">
						<a href="<?php echo esc_url( $category_link ); ?>" class="cs-entry__category-letter" <?php echo wp_kses( sprintf( '%s="%s"', 'style', $styles ), 'content' ); ?>><?php echo esc_html( $category_letter ); ?></a>

						<a href="<?php echo esc_url( $category_link ); ?>" class="cs-entry__category-label"><?php echo esc_html( $category_name ); ?></a>
					</div>

			<?php if ( 'header' === $location ) { ?>
					</div>
				</div>
			<?php } ?>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_post_author' ) ) {
	/**
	 * Post Author Details
	 *
	 * @param int $id Author ID.
	 */
	function csco_post_author( $id = null ) {
		if ( ! $id ) {
			$id = get_the_author_meta( 'ID' );
		}
		?>
		<div class="cs-entry__author-inner">
			<div class="cs-entry__author-photo-wrapper">
				<a href="<?php echo esc_url( get_author_posts_url( $id ) ); ?>" class="cs-entry__author-photo">
					<?php echo get_avatar( $id, '96' ); ?>
				</a>
				<?php if ( csco_powerkit_module_enabled( 'social_links' ) ) { ?>
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
}

if ( ! function_exists( 'csco_archive_post_description' ) ) {
	/**
	 * Post Description in Archive Pages
	 */
	function csco_archive_post_description() {
		$description = get_the_archive_description();
		if ( $description ) {
			?>
			<div class="cs-page__archive-description">
				<?php echo do_shortcode( $description ); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_archive_post_count' ) ) {
	/**
	 * Post Count in Archive Pages
	 */
	function csco_archive_post_count() {
		global $wp_query;
		$found_posts = $wp_query->found_posts;
		?>
		<div class="cs-page__archive-count">
			<?php
			/* translators: 1: Singular, 2: Plural. */
			echo esc_html( apply_filters( 'csco_article_full_count', sprintf( _n( '%s post', '%s posts', $found_posts, 'caards' ), $found_posts ), $found_posts ) );
			?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'csco_subcategories' ) ) {
	/**
	 * Subcategories
	 */
	function csco_subcategories() {

		if ( false === get_theme_mod( 'category_subcategories', false ) ) {
			return;
		}

		if ( ! is_category() ) {
			return;
		}

		$args = apply_filters(
			'csco_subcategories_args',
			array(
				'parent' => get_query_var( 'cat' ),
			)
		);

		$categories = get_categories( $args );

		if ( $categories ) {
			?>
			<div class="cs-page__subcategories">
				<?php csco_section_heading( esc_html__( 'Subcategories', 'caards' ) ); ?>

				<div class="cs-page__tags">
					<ul>
						<?php
						foreach ( $categories as $category ) {
							// Translators: category name.
							$title = sprintf( esc_html__( 'View all posts in %s', 'caards' ), $category->name );
							$link  = get_category_link( $category->term_id )
							?>
								<li>
									<a href="<?php echo esc_url( $link ); ?>" title="<?php echo esc_attr( $title ); ?>">
										<?php echo esc_html( $category->name ); ?>
									</a>
								</li>
							<?php
						}
						?>
					</ul>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_block_post_thumbnail' ) ) {
	/**
	 * Output post thumbnail of layout.
	 *
	 * @param array  $options    The options.
	 * @param array  $attributes The attributes.
	 * @param string $prefix     The field prefix.
	 * @param array  $meta       The meta.
	 */
	function csco_block_post_thumbnail( $options, $attributes, $prefix = null, $meta = array() ) {

		$prefix = $prefix ? sprintf( '%s_', $prefix ) : null;

		if ( has_post_thumbnail() ) {
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
	}
}

if ( ! function_exists( 'csco_block_post_overlay_thumbnail' ) ) {
	/**
	 * Output post overlay thumbnail of layout.
	 *
	 * @param array  $options    The options.
	 * @param array  $attributes The attributes.
	 * @param string $prefix     The field prefix.
	 */
	function csco_block_post_overlay_thumbnail( $options, $attributes, $prefix = null ) {

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
}

if ( ! function_exists( 'csco_block_post_title' ) ) {
	/**
	 * Output post title of layout.
	 *
	 * @param array  $options The options.
	 * @param string $prefix  The field prefix.
	 * @param string $class   The title class.
	 */
	function csco_block_post_title( $options, $prefix = null, $class = '' ) {

		$prefix = $prefix ? sprintf( '%s_', $prefix ) : null;

		$tag = isset( $options[ $prefix . 'typography_heading_tag' ] ) ? $options[ $prefix . 'typography_heading_tag' ] : 'h2';
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
}

if ( ! function_exists( 'csco_block_post_excerpt' ) ) {
	/**
	 * Output post excerpt of layout.
	 *
	 * @param array  $options The options.
	 * @param string $prefix  The field prefix.
	 */
	function csco_block_post_excerpt( $options, $prefix = null ) {

		$prefix = $prefix ? sprintf( '%s_', $prefix ) : null;

		if ( isset( $options[ $prefix . 'display_excerpt' ] ) && $options[ $prefix . 'display_excerpt' ] ) {

			$content = csco_get_the_excerpt( (int) $options[ $prefix . 'excerpt_length' ] );

			if ( $content ) {
				?>
				<div class="cs-entry__excerpt">
					<?php echo esc_html( $content ); ?>
				</div>
				<?php
			}
		}
	}
}

if ( ! function_exists( 'csco_block_post_more' ) ) {
	/**
	 * Output post more of layout.
	 *
	 * @param array  $options The options.
	 * @param string $prefix  The field prefix.
	 */
	function csco_block_post_more( $options, $prefix = null ) {

		$prefix = $prefix ? sprintf( '%s_', $prefix ) : null;

		if ( isset( $options[ $prefix . 'display_more_button' ] ) && $options[ $prefix . 'display_more_button' ] ) {
			?>
			<div class="cs-entry__read-more">
				<a href="<?php the_permalink(); ?>">
					<?php echo esc_html( apply_filters( 'csco_filter_label_more', $options[ $prefix . 'more_button_label' ] ) ); ?>
				</a>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_block_post_footer' ) ) {
	/**
	 * Output post footer
	 *
	 * @param array  $options  The options.
	 * @param string $prefix   The field prefix.
	 * @param bool   $readmore Display readmore.
	 * @param array  $settings The settings.
	 */
	function csco_block_post_footer( $options = array(), $prefix = null, $readmore = null, $settings = array() ) {
		$prefix = $prefix ? sprintf( '%s_', $prefix ) : null;

		if ( isset( $options[ $prefix . 'display_more_button' ] ) && $options[ $prefix . 'display_more_button' ] && null === $readmore ) {
			$readmore = true;
		}
		if ( isset( $options[ $prefix . 'more_button_label' ] ) && $options[ $prefix . 'more_button_label' ] ) {
			$settings['readmore_label'] = $options[ $prefix . 'more_button_label' ];
		}

		$options['meta-settings']['container'] = false;

		$options_shares = $options;

		$options_shares['meta-settings']['shares_total'] = true;
		$options_shares['meta-settings']['shares_link']  = false;

		$reading_time = __return_false();
		$views        = __return_false();
		$shares       = __return_false();

		if ( isset( $options['display_meta_reading_time'] ) && $options['display_meta_reading_time'] && csco_get_meta_reading_time() ) {
			$reading_time = __return_true();
		}

		if ( isset( $options['display_meta_views'] ) && $options['display_meta_views'] && csco_get_meta_views() ) {
			$views = __return_true();
		}

		if ( isset( $options['display_meta_shares'] ) && $options['display_meta_shares'] && csco_get_meta_shares( 'div', false, array(
			'shares_location' => 'post-meta',
			'shares_total'    => false,
			'shares_link'     => true,
		) ) ) {
			$shares = __return_true();
		}

		if ( $reading_time || $views || $readmore || $shares ) {
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
							<?php
							if ( $readmore ) {
								$readmore_label = ( isset( $settings['readmore_label'] ) && $settings['readmore_label'] ) ? $settings['readmore_label'] : esc_html__( 'Read More', 'caards' );
								?>
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
	}
}

if ( ! function_exists( 'csco_block_post_author' ) ) {
	/**
	 * Output post author
	 *
	 * @param array  $options        The options.
	 * @param string $prefix         The field prefix.
	 */
	function csco_block_post_author( $options = array(), $prefix = null ) {
		$prefix = $prefix ? sprintf( '%s_', $prefix ) : null;

		if ( ! isset( $options['top_meta'] ) || 'author' !== $options['top_meta'] ) {
			return;
		}

		$post_author_details = true;

		if ( isset( $options['post_author_details'] ) ) {
			$post_author_details = $options['post_author_details'];
		}

		$author_id = get_the_author_meta( 'ID' );
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

							<?php if ( csco_powerkit_module_enabled( 'social_links' ) ) { ?>
								<?php powerkit_author_social_links( $author_id ); ?>
							<?php } ?>

						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'csco_block_post_category' ) ) {
	/**
	 * Output post category letter
	 *
	 * @param array  $options        The options.
	 * @param string $prefix         The field prefix.
	 */
	function csco_block_post_category( $options = array(), $prefix = null ) {
		$prefix = $prefix ? sprintf( '%s_', $prefix ) : null;

		$first_category  = false;
		$post_categories = wp_get_post_categories( get_the_ID(), array( 'fields' => 'all' ) );
		if ( ! empty( $post_categories ) && ! is_wp_error( $post_categories ) ) {
			$first_category  = array_shift( $post_categories );
			$category_name   = $first_category->name;
			$category_id     = $first_category->term_id;
			$category_link   = get_term_link( $category_id );
			$category_letter = mb_substr( $category_name, 0, 1 );
		}

		$category_label = true;

		if ( isset( $options['post_category_label'] ) ) {
			$category_label = $options['post_category_label'];
		}

		if ( $first_category ) {
			// Colors.
			$letter_color = get_term_meta( $category_id, 'csco_letter_color', true );
			$start_color  = get_term_meta( $category_id, 'csco_gradient_start_color', true );
			$end_color    = get_term_meta( $category_id, 'csco_gradient_end_color', true );

			$styles = __return_empty_string();
			if ( $letter_color ) {
				$styles .= '--cs-color-category-letter-contrast: ' . $letter_color . ';';
			}
			if ( $start_color ) {
				$styles .= '--cs-color-category-letter-gradient-top: ' . $start_color . ';';
			}
			if ( $end_color ) {
				$styles .= '--cs-color-category-letter-gradient-bottom: ' . $end_color . ';';
			}
			?>
			<div class="cs-entry__category">
				<a href="<?php echo esc_url( $category_link ); ?>" class="cs-entry__category-letter" <?php echo wp_kses( sprintf( '%s="%s"', 'style', $styles ), 'content' ); ?>><?php echo esc_html( $category_letter ); ?></a>

				<?php if ( $category_label ) { ?>
					<a href="<?php echo esc_url( $category_link ); ?>" class="cs-entry__category-label"><?php echo esc_html( $category_name ); ?></a>
				<?php } ?>
			</div>
			<?php
		}

	}
}
