<?php
/**
 * Filters
 *
 * Filtering native WordPress and third-party plugins' functions.
 *
 * @package Caards
 */

if ( ! function_exists( 'csco_kses_allowed_html' ) ) {
	/**
	 * Filters the HTML that is allowed for a given context.
	 *
	 * @param array  $tags Default Allowed HTML Tags.
	 * @param string $context Context to judge allowed tags by.
	 */
	function csco_kses_allowed_html( $tags, $context ) {
		if ( 'csco' === $context ) {
			$tags = array(
				'a'      => array(
					'href'   => array(),
					'target' => array(),
					'id'     => array(),
					'class'  => array(),
					'style'  => array(),
				),
				'p'      => array(
					'class' => array(),
				),
				'span'   => array(
					'id'           => array(),
					'class'        => array(),
					'style'        => array(),
					'aria-current' => array(),
				),
				'i'      => array(
					'class' => array(),
				),
				'em'     => array(),
				'strong' => array(),
				'div'    => array(
					'id'    => array(),
					'class' => array(),
					'style' => array(),
				),
				'br'     => array(),
				'button' => array(
					'id'    => array(),
					'class' => array(),
					'style' => array(),
					'type'  => array(),
				),
				'img'    => array(
					'id'     => array(),
					'class'  => array(),
					'src'    => array(),
					'alt'    => array(),
					'height' => array(),
					'width'  => array(),
				),
				'h1'     => array(
					'class' => array(),
				),
			);
		}

		if ( 'content' === $context ) {
			$tags = array(
				'a'      => array(
					'class'  => true,
					'href'   => true,
					'title'  => true,
					'target' => true,
					'rel'    => true,
				),
				'div'    => array(
					'class' => true,
					'id'    => true,
					'style' => true,
				),
				'span'   => array(
					'class' => true,
					'id'    => true,
					'style' => true,
				),
				'img'    => array(
					'class'  => true,
					'id'     => true,
					'src'    => true,
					'rel'    => true,
					'srcset' => true,
					'size'   => true,
				),
				'br'     => array(),
				'b'      => array(),
				'strong' => array(
					'class' => true,
					'id'    => true,
					'style' => true,
				),
				'i'      => array(
					'class' => true,
					'id'    => true,
					'style' => true,
				),
				'p'      => array(
					'class' => true,
					'id'    => true,
					'style' => true,
				),
				'h1'     => array(
					'class' => true,
					'id'    => true,
					'style' => true,
				),
				'h2'     => array(
					'class' => true,
					'id'    => true,
					'style' => true,
				),
				'h3'     => array(
					'class' => true,
					'id'    => true,
					'style' => true,
				),
				'h4'     => array(
					'class' => true,
					'id'    => true,
					'style' => true,
				),
				'h5'     => array(
					'class' => true,
					'id'    => true,
					'style' => true,
				),
				'h6'     => array(
					'class' => true,
					'id'    => true,
					'style' => true,
				),
			);
		}

		if ( 'common' === $context ) {
			$tags = wp_kses_allowed_html( 'post' );
		}

		return $tags;
	}
}
add_filter( 'wp_kses_allowed_html', 'csco_kses_allowed_html', 10, 2);

if ( ! function_exists( 'csco_body_class' ) ) {
	/**
	 * Adds classes to <body> tag
	 *
	 * @param array $classes is an array of all body classes.
	 */
	function csco_body_class( $classes ) {

		// Page Layout.
		$classes[] = 'cs-page-layout-' . csco_get_page_sidebar();

		// Sticky Navbar.
		if ( get_theme_mod( 'navbar_sticky', true ) ) {
			$classes['navbar_sticky'] = 'cs-navbar-sticky-enabled';

			// Smart Navbar.
			if ( get_theme_mod( 'navbar_smart_sticky', true ) ) {
				$classes['navbar_sticky'] = 'cs-navbar-smart-enabled';
			}
		}

		// Sticky Sidebar.
		if ( get_theme_mod( 'misc_sticky_sidebar', true ) ) {
			$classes[] = 'cs-sticky-sidebar-enabled';

			$classes[] = get_theme_mod( 'misc_sticky_sidebar_method', 'cs-stick-to-top' );
		} else {
			$classes[] = 'cs-sticky-sidebar-disabled';
		}

		$classes[] = 'cs-header-' . csco_get_header_layout_type() . '-type';

		$classes[] = 'cs-search-type-' . csco_get_header_search_type();

		return $classes;
	}
}
add_filter( 'body_class', 'csco_body_class' );

if ( ! function_exists( 'csco_sitecontent_class' ) ) {
	/**
	 * Adds the classes for the site-content element.
	 *
	 * @param array $classes Classes to add to the class list.
	 */
	function csco_sitecontent_class( $classes ) {

		// Page Sidebar.
		if ( 'disabled' !== csco_get_page_sidebar() ) {
			$classes[] = 'cs-sidebar-enabled cs-sidebar-' . csco_get_page_sidebar();
		} else {
			$classes[] = 'cs-sidebar-disabled';
		}

		// Post Metabar.
		if ( csco_has_post_metabar() ) {
			$classes[] = 'cs-metabar-enabled';
		} else {
			$classes[] = 'cs-metabar-disabled';
		}

		// Type entry header.
		if ( is_singular() ) {
			$classes[] = 'cs-singular-header-' . csco_get_page_header_type();
		}

		// Section Heading.
		$classes[] = 'section-heading-default-' . get_theme_mod( 'section_heading', 'style-1' );

		return $classes;
	}
}
add_filter( 'csco_site_content_class', 'csco_sitecontent_class' );

if ( ! function_exists( 'csco_sitesubmenu_class' ) ) {
	/**
	 * Adds the classes for the site-submenu element.
	 *
	 * @param array $classes Classes to add to the class list.
	 */
	function csco_sitesubmenu_class( $classes ) {

		return $classes;
	}
}
add_filter( 'csco_site_submenu_class', 'csco_sitesubmenu_class' );
add_filter( 'csco_sidebar_class', 'csco_sitesubmenu_class' );

if ( ! function_exists( 'csco_set_allowed_post_meta' ) ) {
	/**
	 * Set allowed post meta.
	 *
	 * @param array $allowed The list meta.
	 */
	function csco_set_allowed_post_meta( $allowed ) {
		$allowed['shares'] = esc_html__( 'Shares', 'caards' );

		return $allowed;
	}
}
add_filter( 'powerkit_allowed_post_meta', 'csco_set_allowed_post_meta' );
add_filter( 'canvas_allowed_post_meta', 'csco_set_allowed_post_meta' );
add_filter( 'abr_allowed_post_meta', 'csco_set_allowed_post_meta' );

if ( ! function_exists( 'csco_set_convert_post_meta' ) ) {
	/**
	 * Convert allowed post meta.
	 *
	 * @param array $list The list meta.
	 */
	function csco_set_convert_post_meta( $list ) {
		$allowed['shares'] = 'display_meta_shares';

		return $list;
	}
}
add_filter( 'abr_convert_post_meta', 'csco_set_convert_post_meta' );

if ( ! function_exists( 'csco_set_post_meta_handler' ) ) {
	/**
	 * Set post meta handler.
	 */
	function csco_set_post_meta_handler() {
		return 'csco_get_post_meta';
	}
}
add_filter( 'powerkit_get_post_meta_handler', 'csco_set_post_meta_handler' );
add_filter( 'canvas_get_post_meta_handler', 'csco_set_post_meta_handler' );
add_filter( 'abr_get_post_meta_handler', 'csco_set_post_meta_handler' );

if ( ! function_exists( 'csco_set_block_post_meta_handler' ) ) {
	/**
	 * Set post meta handler.
	 */
	function csco_set_block_post_meta_handler() {
		return 'csco_block_post_meta';
	}
}
add_filter( 'powerkit_get_block_post_meta_handler', 'csco_set_block_post_meta_handler' );
add_filter( 'canvas_get_block_post_meta_handler', 'csco_set_block_post_meta_handler' );
add_filter( 'abr_get_block_post_meta_handler', 'csco_set_block_post_meta_handler' );

if ( ! function_exists( 'csco_filter_label_more' ) ) {
	/**
	 * Output label for more link / button.
	 *
	 * @param string $label The label of button.
	 */
	function csco_filter_label_more( $label ) {

		if ( ! $label ) {
			$label = get_theme_mod( 'misc_label_more', esc_html__( 'Read More', 'caards' ) );
		}

		return $label;
	}
}
add_filter( 'csco_filter_label_more', 'csco_filter_label_more' );

if ( ! function_exists( 'csco_add_entry_class' ) ) {
	/**
	 * Add entry class to post_class
	 *
	 * @param array $classes One or more classes to add to the class list.
	 */
	function csco_add_entry_class( $classes ) {
		array_push( $classes, 'cs-entry', 'cs-video-wrap' );

		return $classes;
	}
}
add_filter( 'post_class', 'csco_add_entry_class' );

if ( ! function_exists( 'csco_remove_hentry_class' ) ) {
	/**
	 * Remove hentry from post_class
	 *
	 * @param array $classes One or more classes to add to the class list.
	 */
	function csco_remove_hentry_class( $classes ) {
		return array_diff( $classes, array( 'hentry' ) );
	}
}
add_filter( 'post_class', 'csco_remove_hentry_class' );


if ( ! function_exists( 'csco_inline_styles' ) ) {
	/**
	 * Output theme inline styles
	 */
	function csco_inline_styles() {
		?><style id="csco-inline-styles"><?php do_action( 'csco_inline_styles' ); ?></style>
		<?php
	}
}
add_filter( 'admin_head', 'csco_inline_styles' );
add_filter( 'wp_head', 'csco_inline_styles' );

if ( ! function_exists( 'csco_theme_typography' ) ) {
	/**
	 * Output theme typography
	 */
	function csco_theme_typography() {
		require get_template_directory() . '/inc/typography.php';
	}
}
add_filter( 'csco_inline_styles', 'csco_theme_typography' );

if ( ! function_exists( 'csco_theme_custom_styles' ) ) {
	/**
	 * Output theme custom styles.
	 */
	function csco_theme_custom_styles() {
		require get_template_directory() . '/inc/custom-styles.php';
	}
}
add_filter( 'csco_inline_styles', 'csco_theme_custom_styles' );

if ( ! function_exists( 'csco_inline_css_variables' ) ) {
	/**
	 * Output inline css translable variables
	 */
	function csco_inline_css_variables() {
		$strings_array = array(
			'follow' => esc_html__( 'Follow me', 'caards' ),
		);

		$strings = "\n";
		foreach ( $strings_array as $key => $string ) {
			$strings .= "\t" . '--cs-str-' . $key . ': "' . $string . '";' . "\n";
		}

		$output = ':root { ' . $strings . ' }' . "\n";

		echo wp_kses( $output, 'csco' );
	}
}
add_filter( 'csco_inline_styles', 'csco_inline_css_variables' );

if ( ! function_exists( 'csco_overwrite_sidebar' ) ) {
	/**
	 * Overwrite Default Sidebar
	 *
	 * @param string $sidebar Sidebar slug.
	 */
	function csco_overwrite_sidebar( $sidebar ) {
		// Check Nonce.
		wp_verify_nonce( null );

		if ( isset( $_REQUEST['action'] ) && 'csco_ajax_load_nextpost' === $_REQUEST['action'] ) { // Input var ok.
			if ( is_active_sidebar( 'sidebar-loaded' ) ) {
				$sidebar = 'sidebar-loaded';
			}
		}
		return $sidebar;
	}
}
add_filter( 'csco_sidebar', 'csco_overwrite_sidebar' );

if ( ! function_exists( 'csco_tiny_mce_refresh_cache' ) ) {
	/**
	 * TinyMCE Refresh Cache.
	 *
	 * @param array $settings An array with TinyMCE config.
	 */
	function csco_tiny_mce_refresh_cache( $settings ) {

		$theme = wp_get_theme();

		$settings['cache_suffix'] = sprintf( 'v=%s', $theme->get( 'Version' ) );

		return $settings;
	}
}
add_filter( 'tiny_mce_before_init', 'csco_tiny_mce_refresh_cache' );

if ( ! function_exists( 'csco_max_srcset_image_width' ) ) {
	/**
	 * Changes max image width in srcset attribute
	 *
	 * @param int   $max_width  The maximum image width to be included in the 'srcset'. Default '1600'.
	 * @param array $size_array Array of width and height values in pixels (in that order).
	 */
	function csco_max_srcset_image_width( $max_width, $size_array ) {
		return 3840;
	}
}
add_filter( 'max_srcset_image_width', 'csco_max_srcset_image_width', 10, 2 );

if ( ! function_exists( 'csco_get_the_archive_title' ) ) {
	/**
	 * Archive Title
	 *
	 * Removes default prefixes, like "Category:" from archive titles.
	 *
	 * @param string $title Archive title.
	 */
	function csco_get_the_archive_title( $title ) {
		if ( is_category() ) {

			$title = single_cat_title( '', false );

		} elseif ( is_tag() ) {

			$title = single_tag_title( '', false );

		} elseif ( is_author() ) {

			$title = get_the_author( '', false );

		}
		return $title;
	}
}
add_filter( 'get_the_archive_title', 'csco_get_the_archive_title' );

if ( ! function_exists( 'csco_excerpt_length' ) ) {
	/**
	 * Excerpt Length
	 *
	 * @param string $length of the excerpt.
	 */
	function csco_excerpt_length( $length ) {
		return 18;
	}
}
add_filter( 'excerpt_length', 'csco_excerpt_length' );

if ( ! function_exists( 'csco_strip_shortcode_from_excerpt' ) ) {
	/**
	 * Strip shortcodes from excerpt
	 *
	 * @param string $content Excerpt.
	 */
	function csco_strip_shortcode_from_excerpt( $content ) {
		$content = strip_shortcodes( $content );
		return $content;
	}
}
add_filter( 'the_excerpt', 'csco_strip_shortcode_from_excerpt' );

if ( ! function_exists( 'csco_strip_tags_from_excerpt' ) ) {
	/**
	 * Strip HTML from excerpt
	 *
	 * @param string $content Excerpt.
	 */
	function csco_strip_tags_from_excerpt( $content ) {
		$content = strip_tags( $content );
		return $content;
	}
}
add_filter( 'the_excerpt', 'csco_strip_tags_from_excerpt' );

if ( ! function_exists( 'csco_excerpt_more' ) ) {
	/**
	 * Excerpt Suffix
	 *
	 * @param string $more suffix for the excerpt.
	 */
	function csco_excerpt_more( $more ) {
		return '&hellip;';
	}
}
add_filter( 'excerpt_more', 'csco_excerpt_more' );

if ( ! function_exists( 'csco_content_more_link' ) ) {
	/**
	 * Content more link
	 */
	function csco_content_more_link() {
		return null;
	}
}
add_filter( 'the_content_more_link', 'csco_content_more_link' );

if ( ! function_exists( 'csco_comment_form_defaults' ) ) {
	/**
	 * Pre processing post meta choices
	 *
	 * @param array $defaults The default comment form arguments.
	 */
	function csco_comment_form_defaults( $defaults ) {

		$defaults['comment_field'] = '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" placeholder="' . esc_attr__( 'Your Comment', 'caards' ) . '" required="required"></textarea></p>';

		return $defaults;
	}
}
add_filter( 'comment_form_defaults', 'csco_comment_form_defaults' );

if ( ! function_exists( 'csco_comment_form_default_fields' ) ) {
	/**
	 * Pre processing post meta choices
	 *
	 * @param string[] $fields Array of the default comment fields.
	 */
	function csco_comment_form_default_fields( $fields ) {
		$commenter = wp_get_current_commenter();
		$user      = wp_get_current_user();
		$req       = get_option( 'require_name_email' );
		$html_req  = ( $req ? " required='required'" : '' );

		$fields['author'] = '<p class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_attr__( 'Your Name', 'caards' ) . ( $req ? ' *' : '' ) . '" size="30" maxlength="245" ' . wp_kses( $html_req, 'csco' ) . '></p>';
		$fields['email']  = '<p class="comment-form-email"><input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . esc_attr__( 'Email Address', 'caards' ) . ( $req ? ' *' : '' ) . '" size="30" maxlength="100" ' . wp_kses( $html_req, 'csco' ) . '></p>';
		$fields['url']    = '<p class="comment-form-url"><input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . esc_attr__( 'Website', 'caards' ) . '" size="30" maxlength="200"></p>';
		return $fields;
	}
}
add_filter( 'comment_form_default_fields', 'csco_comment_form_default_fields' );

if ( ! function_exists( 'csco_post_meta_process' ) ) {
	/**
	 * Pre processing post meta choices
	 *
	 * @param array $data Post meta list.
	 */
	function csco_post_meta_process( $data ) {
		if ( ! csco_powerkit_module_enabled( 'share_buttons' ) && isset( $data['shares'] ) ) {
			unset( $data['shares'] );
		}
		if ( ! csco_powerkit_module_enabled( 'reading_time' ) && isset( $data['reading_time'] ) ) {
			unset( $data['reading_time'] );
		}
		if ( ! csco_post_views_enabled() && isset( $data['views'] ) ) {
			unset( $data['views'] );
		}
		return $data;
	}
}
add_filter( 'csco_post_meta_choices', 'csco_post_meta_process' );

if ( ! function_exists( 'csco_wp_link_pages_args' ) ) {
	/**
	 * Paginated Post Pagination
	 *
	 * @param string $args Paginated posts pagination args.
	 */
	function csco_wp_link_pages_args( $args ) {
		if ( 'next_and_number' === $args['next_or_number'] ) {
			global $page, $numpages, $multipage, $more, $pagenow;
			$args['next_or_number'] = 'number';

			$prev = '';
			$next = '';
			if ( $multipage ) {
				if ( $more ) {
					$i = $page - 1;
					if ( $i && $more ) {
						$prev .= _wp_link_page( $i );
						$prev .= $args['link_before'] . $args['previouspagelink'] . $args['link_after'] . '</a>';
					}
					$i = $page + 1;
					if ( $i <= $numpages && $more ) {
						$next .= _wp_link_page( $i );
						$next .= $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>';
					}
				}
			}
			$args['before'] = $args['before'] . $prev;
			$args['after']  = $next . $args['after'];
		}
		return $args;
	}
}
add_filter( 'wp_link_pages_args', 'csco_wp_link_pages_args' );

if ( ! function_exists( 'csco_post_header_avatar_size' ) ) {
	/**
	 * Set for post header avatar size.
	 *
	 * @param int $size Avatar size.
	 */
	function csco_post_header_avatar_size( $size ) {
		return 40;
	}
}

/**
 * -------------------------------------------------------------------------
 * [ SearchWP Live Ajax Search ]
 * -------------------------------------------------------------------------
 */

if ( ! function_exists( 'csco_searchwp_live_enqueue_scripts' ) ) {
	/**
	 * Enqueue scripts and styles.
	 */
	function csco_searchwp_live_enqueue_scripts() {

		$style = sprintf( '.searchwp-live-search-no-min-chars:after { content: "%s" }', esc_html__( 'Continue typing', 'caards' ) );

		wp_add_inline_style( 'csco-styles', $style );
	}
}
add_action( 'wp_enqueue_scripts', 'csco_searchwp_live_enqueue_scripts' );

/**
 * Remove Output the base styles.
 */
add_filter( 'searchwp_live_search_base_styles', '__return_false' );

/**
 * Change live search template dir location.
 */
function csco_searchwp_live_search_template_dir() {
	return 'template-parts';
}
add_filter( 'searchwp_live_search_template_dir', 'csco_searchwp_live_search_template_dir' );


/**
 * -------------------------------------------------------------------------
 * [ Absolute Reviews ]
 * -------------------------------------------------------------------------
 */

/**
 * Set the correct color scheme for post meta.
 *
 * @param string $scheme   Meta scheme.
 * @param array  $settings The advanced settings.
 */
function abr_csco_post_meta_scheme( $scheme, $settings ) {

	if ( isset( $settings['abr-params']['layout'] ) ) {
		$layout = $settings['abr-params']['layout'];

		if ( in_array( $layout, array( 'reviews-6', 'reviews-7', 'reviews-8' ), true ) ) {
			$scheme = 'data-scheme="inverse"';
		}
	}

	return $scheme;
}
add_filter( 'csco_post_meta_scheme', 'abr_csco_post_meta_scheme', 10, 2 );

/**
 * -------------------------------------------------------------------------
 * [ Rank Math SEO Breadcrumbs ]
 * -------------------------------------------------------------------------
 */
if ( ! function_exists( 'csco_replace_breadcrumb_separator' ) ) {
	/**
	 * Change the breadcrumbs HTML output.
	 *
	 * @param string $html HTML output.
	 */
	function csco_replace_breadcrumb_separator( $html ) {
		$html = preg_replace( '#<span class="separator">(.*?)</span>#', '<span class="cs-separator"></span>', $html );
		return $html;
	}
}
add_filter( 'rank_math/frontend/breadcrumb/html', 'csco_replace_breadcrumb_separator' );


/**
 * -------------------------------------------------------------------------
 * [ AMP ]
 * -------------------------------------------------------------------------
 */

/**
 * AMP unregister blocks.
 */
function csco_amp_unregister_blocks() {
	if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
		unregister_block_type( 'canvas/posts' );
		unregister_block_type( 'sight/portfolio' );
	}
}
add_action( 'template_redirect', 'csco_amp_unregister_blocks' );
