<?php
/**
 * Vaarta-owned post metadata pipeline.
 *
 * The established csco_* functions remain available as compatibility wrappers
 * so legacy templates, blocks, child themes, and integrations retain their
 * public API while metadata rendering is owned by Vaarta.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the core metadata types supported by Vaarta.
 *
 * @return string[]
 */
function vaarta_get_post_meta_types() {
	return array( 'category', 'author', 'date', 'comments', 'views', 'shares', 'reading_time' );
}

/**
 * Render metadata configured by an editorial block/card.
 *
 * @param array $settings Block settings.
 * @param mixed $meta     Requested metadata types.
 * @param bool  $echo     Echo or return.
 * @param bool  $compact  Compact display mode.
 * @return string|void|null
 */
function vaarta_block_post_meta( $settings, $meta, $echo = true, $compact = false ) {
	$allowed = array();
	$prefix  = isset( $settings['meta-settings']['prefix'] ) ? sprintf( '%s_', $settings['meta-settings']['prefix'] ) : null;

	foreach ( vaarta_get_post_meta_types() as $type ) {
		if ( ! empty( $settings[ $prefix . 'display_meta_' . $type ] ) ) {
			$allowed[] = $type;
		}
	}

	if ( ! empty( $settings[ $prefix . 'display_meta_compact' ] ) ) {
		$compact = true;
	}

	$allowed = apply_filters( 'csco_allowed_block_post_meta', $allowed, $settings, $meta, $echo, $compact );
	if ( ! $allowed ) {
		return;
	}

	$meta_settings = array(
		'shares_location' => 'block-posts',
	);

	if ( isset( $settings['meta-settings'] ) && is_array( $settings['meta-settings'] ) ) {
		$meta_settings = array_merge( $meta_settings, $settings['meta-settings'] );
	}

	return vaarta_get_post_meta( $meta, $compact, $echo, $allowed, $meta_settings );
}

/**
 * Normalize one Customizer metadata selection into block display flags.
 *
 * @param array  $params      Existing block parameters.
 * @param string $option_name Theme-mod option name.
 * @return array
 */
function vaarta_block_normalize_meta( $params, $option_name ) {
	$option_default = array();

	if ( isset( CSCO_Customizer::$fields[ $option_name ]['default'] ) ) {
		$option_default = CSCO_Customizer::$fields[ $option_name ]['default'];
	}

	$value = get_theme_mod( $option_name, $option_default );
	$value = is_array( $value ) ? $value : array();

	foreach ( vaarta_get_post_meta_types() as $type ) {
		$params[ 'display_meta_' . $type ] = in_array( $type, $value, true );
	}

	return $params;
}

/**
 * Return the renderer registry for known metadata types.
 *
 * @return array<string,callable>
 */
function vaarta_get_post_meta_renderer_registry() {
	$registry = array(
		'category'     => 'vaarta_get_meta_category',
		'author'       => 'vaarta_get_meta_author',
		'date'         => 'vaarta_get_meta_date',
		'comments'     => 'vaarta_get_meta_comments',
		'views'        => 'vaarta_get_meta_views',
		'shares'       => 'vaarta_get_meta_shares',
		'reading_time' => 'vaarta_get_meta_reading_time',
	);

	/**
	 * Filter Vaarta's post-metadata renderer registry.
	 *
	 * @param array<string,callable> $registry Metadata renderer map.
	 */
	return apply_filters( 'vaarta_post_meta_renderer_registry', $registry );
}

/**
 * Render one metadata type while retaining csco_get_meta_* extension support.
 *
 * @param string $type     Metadata type.
 * @param string $tag      Element tag.
 * @param bool   $compact  Compact display mode.
 * @param array  $settings Renderer settings.
 * @return string
 */
function vaarta_render_post_meta_type( $type, $tag, $compact, $settings ) {
	$type     = sanitize_key( $type );
	$registry = vaarta_get_post_meta_renderer_registry();

	if ( isset( $registry[ $type ] ) && is_callable( $registry[ $type ] ) ) {
		return (string) call_user_func( $registry[ $type ], $tag, $compact, $settings );
	}

	// Preserve child-theme/plugin extensions that historically registered a
	// custom csco_get_meta_{type}() renderer through the csco_post_meta filter.
	$compatibility_callback = 'csco_get_meta_' . $type;
	if ( function_exists( $compatibility_callback ) ) {
		return (string) call_user_func( $compatibility_callback, $tag, $compact, $settings );
	}

	return '';
}

/**
 * Build or output post metadata.
 *
 * @param mixed $meta     Requested metadata types.
 * @param bool  $compact  Compact display mode.
 * @param bool  $output   Output or return.
 * @param mixed $allowed  Allowed metadata configuration.
 * @param array $settings Renderer settings.
 * @return string|int|null
 */
function vaarta_get_post_meta( $meta, $compact = false, $output = true, $allowed = null, $settings = array() ) {
	if ( ! $meta ) {
		return;
	}

	$meta = (array) $meta;

	$settings = array_merge(
		array(
			'icon'            => false,
			'author_avatar'   => false,
			'shares_location' => 'post-meta',
			'shares_total'    => false,
			'shares_link'     => true,
			'container'       => true,
		),
		$settings
	);

	if ( is_string( $allowed ) || true === $allowed ) {
		$option_default = null;
		$option_name    = is_string( $allowed ) ? $allowed : csco_get_archive_option( 'post_meta' );

		if ( isset( CSCO_Customizer::$fields[ $option_name ]['default'] ) ) {
			$option_default = CSCO_Customizer::$fields[ $option_name ]['default'];
		}

		$allowed = get_theme_mod( $option_name, $option_default );
	}

	if ( ! is_array( $allowed ) && ! $allowed ) {
		$allowed = apply_filters( 'csco_post_meta', vaarta_get_post_meta_types() );
	}

	$allowed = is_array( $allowed ) ? $allowed : array();
	$meta    = array_intersect( $meta, $allowed );
	$markup  = '';

	foreach ( $meta as $type ) {
		$markup .= vaarta_render_post_meta_type( $type, 'div', $compact, $settings );
	}

	if ( $markup && $settings['container'] ) {
		$scheme = apply_filters( 'csco_post_meta_scheme', null, $settings );
		$markup = sprintf( '<div class="cs-entry__post-meta" %s>%s</div>', $scheme, $markup );
	}

	if ( $output ) {
		return printf( '%s', $markup ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	return $markup;
}

/**
 * Render category metadata.
 *
 * @param string $tag      Element tag.
 * @param bool   $compact  Compact display mode.
 * @param array  $settings Renderer settings.
 * @return string
 */
function vaarta_get_meta_category( $tag = 'div', $compact = false, $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	$output  = '<' . esc_html( $tag ) . ' class="cs-meta-category">';
	$output .= get_the_category_list( '', '', get_the_ID() );
	$output .= '</' . esc_html( $tag ) . '>';

	return $output;
}

/**
 * Render date metadata.
 *
 * @param string $tag      Element tag.
 * @param bool   $compact  Compact display mode.
 * @param array  $settings Renderer settings.
 * @return string
 */
function vaarta_get_meta_date( $tag = 'div', $compact = false, $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	$output      = '<' . esc_html( $tag ) . ' class="cs-meta-date">';
	$time_string = $compact ? get_the_date( 'd.m.y' ) : get_the_date();

	if ( get_the_time( 'd.m.Y H:i' ) !== get_the_modified_time( 'd.m.Y H:i' ) && ! get_theme_mod( 'misc_published_date', true ) ) {
		$time_string = get_the_modified_date();
	}

	$output .= apply_filters( 'csco_post_meta_date_output', $time_string );
	$output .= '</' . esc_html( $tag ) . '>';

	return $output;
}

/**
 * Render author metadata.
 *
 * @param string $tag      Element tag.
 * @param bool   $compact  Compact display mode.
 * @param array  $settings Renderer settings.
 * @return string
 */
function vaarta_get_meta_author( $tag = 'div', $compact = true, $settings = array() ) {
	$authors = array( get_the_author_meta( 'ID' ) );
	$output  = '<' . esc_attr( $tag ) . ' class="cs-meta-author">';

	if ( csco_coauthors_enabled() ) {
		$authors = csco_get_coauthors();
	}

	if ( $authors ) {
		$counter = 0;

		foreach ( $authors as $author ) {
			$output .= $counter > 0 ? sprintf( '<span class="cs-sep">%s</span>', esc_html__( 'and', 'caards' ) ) : '';

			$author_id     = isset( $author->ID ) ? $author->ID : $author;
			$display_name  = isset( $author->display_name ) ? $author->display_name : get_the_author_meta( 'display_name', $author_id );
			$posts_url     = get_author_posts_url( $author_id, isset( $author->user_nicename ) ? $author->user_nicename : '' );
			$author_avatar = '';

			if ( false === $compact && ! empty( $settings['author_avatar'] ) ) {
				$author_avatar = sprintf( '<span class="cs-photo">%s</span>', get_avatar( $author_id, apply_filters( 'csco_meta_avatar_size', 26 ) ) );
			}

			$output .= sprintf(
				'<a class="cs-meta-author-inner url fn n" href="%1$s" title="%2$s">%4$s<span class="cs-author">%3$s</span></a>',
				esc_url( $posts_url ),
				/* translators: %s: author name */
				esc_attr( sprintf( __( 'View all posts by %s', 'caards' ), $display_name ) ),
				$display_name,
				$author_avatar
			);

			$counter++;
		}
	}

	$output .= '</' . esc_html( $tag ) . '>';
	return $output;
}

/**
 * Render comments metadata.
 *
 * @param string $tag      Element tag.
 * @param bool   $compact  Compact display mode.
 * @param array  $settings Renderer settings.
 * @return string|void
 */
function vaarta_get_meta_comments( $tag = 'div', $compact = false, $settings = array() ) {
	if ( ! comments_open( get_the_ID() ) ) {
		return;
	}

	$output = '<' . esc_html( $tag ) . ' class="cs-meta-comments">';
	if ( ! empty( $settings['icon'] ) ) {
		$output .= '<span class="cs-meta-icon"><i class="cs-icon cs-icon-message-square"></i></span>';
	}

	ob_start();
	if ( $compact ) {
		comments_popup_link( '0', '1', '%', 'comments-link', '' );
	} else {
		comments_popup_link( esc_html__( 'No comments', 'caards' ), esc_html__( 'One comment', 'caards' ), '% ' . esc_html__( 'comments', 'caards' ), 'comments-link', '' );
	}
	$output .= ob_get_clean();
	$output .= '</' . esc_html( $tag ) . '>';

	return $output;
}

/**
 * Render reading-time metadata when Powerkit provides it.
 *
 * @param string $tag      Element tag.
 * @param bool   $compact  Compact display mode.
 * @param array  $settings Renderer settings.
 * @return string|void
 */
function vaarta_get_meta_reading_time( $tag = 'div', $compact = false, $settings = array() ) {
	if ( ! csco_powerkit_module_enabled( 'reading_time' ) || ! function_exists( 'powerkit_get_post_reading_time' ) ) {
		return;
	}

	$reading_time = powerkit_get_post_reading_time();
	$output       = '<' . esc_html( $tag ) . ' class="cs-meta-reading-time">';

	if ( ! empty( $settings['icon'] ) ) {
		$output .= '<span class="cs-meta-icon"><i class="cs-icon cs-icon-clock"></i></span>';
	}

	if ( $compact ) {
		$output .= intval( $reading_time ) . ' ' . esc_html__( 'min', 'caards' );
	} else {
		/* translators: %s number of minutes */
		$output .= esc_html( sprintf( _n( '%s min read', '%s min read', $reading_time, 'caards' ), $reading_time ) );
	}

	$output .= '</' . esc_html( $tag ) . '>';
	return $output;
}

/**
 * Render post-view metadata from the active integration.
 *
 * @param string $tag      Element tag.
 * @param bool   $compact  Compact display mode.
 * @param array  $settings Renderer settings.
 * @return string|void
 */
function vaarta_get_meta_views( $tag = 'div', $compact = false, $settings = array() ) {
	switch ( csco_post_views_enabled() ) {
		case 'post_views':
			if ( ! function_exists( 'pvc_get_post_views' ) ) {
				return;
			}
			$views = pvc_get_post_views();
			break;
		case 'pk_post_views':
			if ( ! function_exists( 'powerkit_get_post_views' ) ) {
				return;
			}
			$views = powerkit_get_post_views( null, false );
			break;
		default:
			return;
	}

	if ( $views < apply_filters( 'csco_minimum_views', 1 ) ) {
		return;
	}

	$output = '<' . esc_html( $tag ) . ' class="cs-meta-views">';
	if ( ! empty( $settings['icon'] ) ) {
		$output .= '<span class="cs-meta-icon"><i class="cs-icon cs-icon-bar-chart"></i></span>';
	}

	$views_rounded = csco_get_round_number( $views );
	if ( $compact ) {
		$output .= esc_html( $views_rounded );
	} elseif ( $views > 1000 ) {
		$output .= $views_rounded . ' ' . esc_html__( 'views', 'caards' );
	} else {
		/* translators: %s number of post views */
		$output .= esc_html( sprintf( _n( '%s view', '%s views', $views, 'caards' ), $views ) );
	}

	$output .= '</' . esc_html( $tag ) . '>';
	return $output;
}

/**
 * Render share metadata when Powerkit provides it.
 *
 * @param string $tag      Element tag.
 * @param bool   $compact  Compact display mode.
 * @param array  $settings Renderer settings.
 * @return string|void
 */
function vaarta_get_meta_shares( $tag = 'div', $compact = false, $settings = array() ) {
	$location = isset( $settings['shares_location'] ) ? $settings['shares_location'] : 'post-meta';

	if ( ! csco_powerkit_module_enabled( 'share_buttons' ) || ! get_option( "powerkit_share_buttons_{$location}_display" ) ) {
		return;
	}

	if ( ! function_exists( 'powerkit_share_buttons_get_total_count' ) || ! function_exists( 'powerkit_share_buttons_count_format' ) ) {
		return;
	}

	$accounts       = get_option( "powerkit_share_buttons_{$location}_multiple_list", array( 'facebook', 'twitter', 'pinterest' ) );
	$shares         = powerkit_share_buttons_get_total_count( $accounts, get_the_ID(), null, true );
	$shares_rounded = powerkit_share_buttons_count_format( $shares );

	if ( $shares < apply_filters( 'csco_minimum_shares', 1 ) ) {
		return;
	}

	$output = '<' . esc_html( $tag ) . ' class="cs-meta-shares">';
	ob_start();

	if ( ! empty( $settings['shares_total'] ) ) {
		?>
		<div class="cs-meta-share-total">
			<div class="cs-total-number">
				<?php
				if ( $compact ) {
					echo esc_html( $shares_rounded );
				} elseif ( $shares > 1000 ) {
					echo esc_html__( 'Shares', 'caards' ) . ' ' . esc_html( $shares_rounded );
				} else {
					/* translators: %s number of shares */
					echo esc_html( sprintf( _n( 'Share %s', 'Shares %s', $shares, 'caards' ), $shares ) );
				}
				?>
			</div>
		</div>
		<?php
	}

	if ( ! empty( $settings['shares_link'] ) && function_exists( 'powerkit_share_buttons_location' ) ) {
		?>
		<div class="cs-meta-share-links">
			<?php powerkit_share_buttons_location( $location ); ?>
		</div>
		<?php
	}

	$output .= ob_get_clean();
	$output .= '</' . esc_html( $tag ) . '>';
	return $output;
}

// -----------------------------------------------------------------------------
// Legacy public API wrappers.
// -----------------------------------------------------------------------------

if ( ! function_exists( 'csco_block_post_meta' ) ) {
	function csco_block_post_meta( $settings, $meta, $echo = true, $compact = false ) {
		return vaarta_block_post_meta( $settings, $meta, $echo, $compact );
	}
}

if ( ! function_exists( 'csco_block_normalize_meta' ) ) {
	function csco_block_normalize_meta( $params, $option_name ) {
		return vaarta_block_normalize_meta( $params, $option_name );
	}
}

if ( ! function_exists( 'csco_get_post_meta' ) ) {
	function csco_get_post_meta( $meta, $compact = false, $output = true, $allowed = null, $settings = array() ) {
		return vaarta_get_post_meta( $meta, $compact, $output, $allowed, $settings );
	}
}

if ( ! function_exists( 'csco_get_meta_category' ) ) {
	function csco_get_meta_category( $tag = 'div', $compact = false, $settings = array() ) {
		return vaarta_get_meta_category( $tag, $compact, $settings );
	}
}

if ( ! function_exists( 'csco_get_meta_date' ) ) {
	function csco_get_meta_date( $tag = 'div', $compact = false, $settings = array() ) {
		return vaarta_get_meta_date( $tag, $compact, $settings );
	}
}

if ( ! function_exists( 'csco_get_meta_author' ) ) {
	function csco_get_meta_author( $tag = 'div', $compact = true, $settings = array() ) {
		return vaarta_get_meta_author( $tag, $compact, $settings );
	}
}

if ( ! function_exists( 'csco_get_meta_comments' ) ) {
	function csco_get_meta_comments( $tag = 'div', $compact = false, $settings = array() ) {
		return vaarta_get_meta_comments( $tag, $compact, $settings );
	}
}

if ( ! function_exists( 'csco_get_meta_reading_time' ) ) {
	function csco_get_meta_reading_time( $tag = 'div', $compact = false, $settings = array() ) {
		return vaarta_get_meta_reading_time( $tag, $compact, $settings );
	}
}

if ( ! function_exists( 'csco_get_meta_views' ) ) {
	function csco_get_meta_views( $tag = 'div', $compact = false, $settings = array() ) {
		return vaarta_get_meta_views( $tag, $compact, $settings );
	}
}

if ( ! function_exists( 'csco_get_meta_shares' ) ) {
	function csco_get_meta_shares( $tag = 'div', $compact = false, $settings = array() ) {
		return vaarta_get_meta_shares( $tag, $compact, $settings );
	}
}
