<?php
/**
 * These functions are used to load template parts (partials) or actions when used within action hooks,
 * and they probably should never be updated or modified.
 *
 * @package Caards
 */

if ( ! function_exists( 'csco_singular_post_type_before' ) ) {
	/**
	 * Add Before Singular Hooks for specific post type.
	 */
	function csco_singular_post_type_before() {
		if ( 'post' === get_post_type() ) {
			do_action( 'csco_post_content_before' );
		}
		if ( 'page' === get_post_type() ) {
			do_action( 'csco_page_content_before' );
		}
	}
}

if ( ! function_exists( 'csco_singular_post_type_after' ) ) {
	/**
	 * Add After Singular Hooks for specific post type.
	 */
	function csco_singular_post_type_after() {
		if ( 'post' === get_post_type() ) {
			do_action( 'csco_post_content_after' );
		}
		if ( 'page' === get_post_type() ) {
			do_action( 'csco_page_content_after' );
		}
	}
}

if ( ! function_exists( 'csco_offcanvas' ) ) {
	/**
	 * Off-canvas
	 */
	function csco_offcanvas() {
		get_template_part( 'template-parts/offcanvas' );
	}
}

if ( ! function_exists( 'csco_fullscreen_menu' ) ) {
	/**
	 * Fullscreen Menu
	 */
	function csco_fullscreen_menu() {
		if ( ! get_theme_mod( 'header_fullscreen_menu', false ) ) {
			return;
		}
		get_template_part( 'template-parts/fullscreen-menu' );
	}
}

if ( ! function_exists( 'csco_site_scheme' ) ) {
	/**
	 * Site Scheme
	 */
	function csco_site_scheme() {
		$data = csco_site_scheme_data();

		call_user_func( 'printf', '%s', "data-scheme='{$data['scheme']}' data-site-scheme='{$data['site_scheme']}'" );
	}
}

if ( ! function_exists( 'csco_site_search' ) ) {
	/**
	 * Site Search
	 */
	function csco_site_search() {
		if ( ! get_theme_mod( 'header_search_button', true ) ) {
			return;
		}
		get_template_part( 'template-parts/site-search' );
	}
}

if ( ! function_exists( 'csco_site_nav_mobile' ) ) {
	/**
	 * Site Nav Mobile
	 */
	function csco_site_nav_mobile() {
		get_template_part( 'template-parts/site-nav-mobile' );
	}
}

if ( ! function_exists( 'csco_breadcrumbs' ) ) {
	/**
	 * SEO Breadcrumbs
	 */
	function csco_breadcrumbs() {
		if ( ! apply_filters( 'csco_breadcrumbs', true ) ) {
			return;
		}

		if ( is_front_page() || is_category() ) {
			return;
		}

		if ( csco_doing_request() ) {
			return;
		}

		if ( ! function_exists( 'yoast_breadcrumb' ) && ! function_exists( 'rank_math_the_breadcrumbs') ) {
			return;
		}

		ob_start();

		$wrap_before = '<div class="cs-breadcrumbs" id="breadcrumbs">';
		$wrap_after  = '</div>';

		if ( function_exists( 'yoast_breadcrumb' ) ) {

			yoast_breadcrumb( $wrap_before, $wrap_after );

		} elseif ( function_exists( 'rank_math_the_breadcrumbs' ) ) {

			$args = array(
				'wrap_before' => $wrap_before,
				'wrap_after'  => $wrap_after,
			);
			rank_math_the_breadcrumbs( $args );

		}

		// Check the number of levels in breadcrumbs.
		preg_match_all( '/<\/a>/', ob_get_contents(), $matches );

		if ( ! isset( $matches[0] ) || count( $matches[0] ) <= 1 ) {
			ob_end_clean();

			return;
		}

		return ob_end_flush();
	}
}

if ( ! function_exists( 'csco_page_header' ) ) {
	/**
	 * Page Header
	 */
	function csco_page_header() {
		if ( ! ( is_archive() || is_search() || is_404() ) ) {
			return;
		}
		get_template_part( 'template-parts/page-header' );
	}
}

if ( ! function_exists( 'csco_page_pagination' ) ) {
	/**
	 * Post Pagination
	 */
	function csco_page_pagination() {
		if ( ! is_singular() ) {
			return;
		}

		do_action( 'csco_pagination_before' );

		wp_link_pages(
			array(
				'before'           => '<div class="navigation pagination"><div class="nav-links">',
				'after'            => '</div></div>',
				'link_before'      => '<span class="page-number">',
				'link_after'       => '</span>',
				'next_or_number'   => 'next_and_number',
				'separator'        => ' ',
				'nextpagelink'     => esc_html__( 'Next page', 'caards' ),
				'previouspagelink' => esc_html__( 'Previous page', 'caards' ),
			)
		);

		do_action( 'csco_pagination_after' );
	}
}

if ( ! function_exists( 'csco_meet_team' ) ) {
	/**
	 * Meet Team
	 */
	function csco_meet_team() {
		if ( is_page_template( 'template-meet-team.php' ) ) {
			get_template_part( 'template-parts/meet-team' );
		}
	}
}

if ( ! function_exists( 'csco_entry_breadcrumbs' ) ) {
	/**
	 * Entry Breadcrumbs
	 */
	function csco_entry_breadcrumbs() {
		csco_breadcrumbs();
	}
}

if ( ! function_exists( 'csco_entry_header' ) ) {
	/**
	 * Entry Header Standard
	 */
	function csco_entry_header() {
		if ( ! is_singular() ) {
			return;
		}
		if ( 'none' === csco_get_page_header_type() ) {
			return;
		}
		if ( 'large' === csco_get_page_header_type() ) {
			return;
		}
		if ( 'full' === csco_get_page_header_type() ) {
			return;
		}
		get_template_part( 'template-parts/entry/entry-header' );
	}
}

if ( ! function_exists( 'csco_entry_header_large' ) ) {
	/**
	 * Entry Media Large
	 */
	function csco_entry_header_large() {
		if ( ! is_singular() ) {
			return;
		}
		if ( 'large' !== csco_get_page_header_type() ) {
			return;
		}
		get_template_part( 'template-parts/entry/entry-header-large' );
	}
}

if ( ! function_exists( 'csco_entry_header_full' ) ) {
	/**
	 * Entry Media Large
	 */
	function csco_entry_header_full() {
		if ( ! is_singular() ) {
			return;
		}
		if ( 'full' !== csco_get_page_header_type() ) {
			return;
		}
		get_template_part( 'template-parts/entry/entry-header-full' );
	}
}

if ( ! function_exists( 'csco_entry_metabar' ) ) {
	/**
	 * Entry Metabar
	 */
	function csco_entry_metabar() {
		if ( ! csco_has_post_metabar() ) {
			return;
		}
		?>
		<div class="cs-entry__metabar">
			<?php if ( csco_has_post_metas( array( 'category', 'reading_time', 'views' ), 'post_meta' ) ) { ?>
				<div class="cs-entry__metabar-post-meta">
					<div class="cs-entry__metabar-item">
						<?php csco_post_category( 'metabar' ); ?>

						<?php
						csco_get_post_meta( array( 'reading_time', 'views' ), false, true, 'post_meta', array(
							'icon' => true,
						) );
						?>
					</div>
				</div>
			<?php } ?>

			<?php if ( function_exists( 'powerkit_share_buttons_exists' ) && powerkit_share_buttons_exists( 'metabar-post' ) ) { ?>
				<div class="cs-entry__metabar-inner">
					<div class="cs-entry__metabar-item">
						<?php powerkit_share_buttons_location( 'metabar-post' ); ?>
					</div>
				</div>
			<?php } ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'csco_entry_tags' ) ) {
	/**
	 * Entry Tags
	 */
	function csco_entry_tags() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}
		if ( false === get_theme_mod( 'post_tags', true ) ) {
			return;
		}

		the_tags( '<div class="cs-entry__tags"><ul><li>', '</li><li>', '</li></ul></div>' );
	}
}

if ( ! function_exists( 'csco_entry_share' ) ) {
	/**
	 * Entry Share
	 */
	function csco_entry_share() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		$post_share_link = get_theme_mod( 'post_share_link', true );

		$post_share_buttons = __return_false();

		if ( csco_powerkit_module_enabled( 'share_buttons' ) ) {
			if ( powerkit_share_buttons_exists( 'after-post' ) ) {
				$post_share_buttons = __return_true();
			}
		}

		if ( $post_share_link || $post_share_buttons ) {
			?>
			<div class="cs-entry__after-share-buttons">
				<div class="cs-entry__after-share-buttons-title">
					<h5><?php esc_html_e( 'Share this article', 'caards' ); ?></h5>
				</div>

				<?php
				if ( $post_share_buttons ) {
					powerkit_share_buttons_location( 'after-post' );
				}
				?>

				<?php if ( $post_share_link ) { ?>
					<div class="cs-entry__after-share-buttons-link">
						<div class="cs-entry__after-share-buttons-input-group">
							<input class="cs-entry__after-share-buttons-text" type="text" value="<?php the_permalink(); ?>">
							<button class="cs-entry__after-share-buttons-copy">
								<span class="cs-icon cs-icon-copy"></span>
							</button>
						</div>
						<span class="cs-entry__after-share-buttons-text"><?php esc_html_e( 'Shareable URL', 'caards' ); ?></span>
					</div>
				<?php } ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_entry_author' ) ) {
	/**
	 * Entry Author
	 */
	function csco_entry_author() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}
		if ( false === get_theme_mod( 'post_author', false ) ) {
			return;
		}
		get_template_part( 'template-parts/entry/entry-author' );
	}
}

if ( ! function_exists( 'csco_entry_comments' ) ) {
	/**
	 * Entry Comments
	 */
	function csco_entry_comments() {
		if ( post_password_required() ) {
			return;
		}

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	}
}

if ( ! function_exists( 'csco_entry_subscribe' ) ) {
	/**
	 * Post Subscribe
	 */
	function csco_entry_subscribe() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}
		if ( false === get_theme_mod( 'post_subscribe', false ) ) {
			return;
		}

		if ( csco_powerkit_module_enabled( 'opt_in_forms' ) ) {
			get_template_part( 'template-parts/entry/entry-subscribe' );
		}
	}
}

if ( ! function_exists( 'csco_entry_prev_next' ) ) {
	/**
	 * Entry Prev Next
	 */
	function csco_entry_prev_next() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}
		if ( false === get_theme_mod( 'post_prev_next', true ) ) {
			return;
		}
		get_template_part( 'template-parts/entry/entry-prev-next' );
	}
}

if ( ! function_exists( 'csco_entry_related' ) ) {
	/**
	 * Entry Related
	 */
	function csco_entry_related() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}
		if ( csco_doing_request() ) {
			return;
		}
		if ( false === get_theme_mod( 'related', true ) ) {
			return;
		}
		get_template_part( 'template-parts/entry/entry-related' );
	}
}

if ( ! function_exists( 'csco_site_subscribe' ) ) {
	/**
	 * Site Subscribe
	 */
	function csco_site_subscribe() {
		csco_component( 'footer_subscription_form' );
	}
}
