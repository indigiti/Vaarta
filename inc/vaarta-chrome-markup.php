<?php
/**
 * Accessible server-side markup for Vaarta site chrome.
 *
 * Legacy class names remain unchanged so existing styles and interaction code
 * continue to work while keyboard and ARIA semantics are available before the
 * progressive JavaScript layer runs.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'csco_header_offcanvas_toggle' ) ) {
	/**
	 * Header off-canvas toggle.
	 */
	function csco_header_offcanvas_toggle( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
		if ( csco_offcanvas_exists() ) {
			?>
			<span class="cs-header__offcanvas-toggle cs-d-lg-none" role="button" tabindex="0" aria-controls="vaarta-offcanvas" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open menu', 'caards' ); ?>">
				<span aria-hidden="true"></span>
			</span>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_header_search_toggle' ) ) {
	/**
	 * Header search toggle.
	 */
	function csco_header_search_toggle( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
		if ( ! get_theme_mod( 'header_search_button', true ) ) {
			return;
		}
		?>
		<span class="cs-header__search-toggle" role="button" tabindex="0" aria-controls="vaarta-site-search" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open search', 'caards' ); ?>">
			<i class="cs-icon cs-icon-search" aria-hidden="true"></i>
		</span>
		<?php
	}
}

if ( ! function_exists( 'csco_header_fullscreen_menu_toggle' ) ) {
	/**
	 * Header full-screen menu toggle.
	 */
	function csco_header_fullscreen_menu_toggle( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
		if ( ! get_theme_mod( 'header_fullscreen_menu', false ) ) {
			return;
		}
		?>
		<span class="cs-header__fullscreen-menu-toggle" role="button" tabindex="0" aria-controls="vaarta-fullscreen-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open full-screen menu', 'caards' ); ?>">
			<span aria-hidden="true"></span>
		</span>
		<?php
	}
}

if ( ! function_exists( 'csco_header_scheme_toggle' ) ) {
	/**
	 * Header color-scheme toggle.
	 */
	function csco_header_scheme_toggle( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
		if ( ! get_theme_mod( 'color_scheme_toggle', true ) ) {
			return;
		}
		?>
		<span role="button" tabindex="0" class="cs-header__scheme-toggle cs-site-scheme-toggle" aria-label="<?php esc_attr_e( 'Toggle color scheme', 'caards' ); ?>">
			<span class="cs-header__scheme-toggle-icons" aria-hidden="true">
				<i class="cs-header__scheme-toggle-icon cs-icon cs-icon-light-mode"></i>
				<i class="cs-header__scheme-toggle-icon cs-icon cs-icon-dark-mode"></i>
			</span>
		</span>
		<?php
	}
}

if ( ! function_exists( 'csco_header_scheme_toggle_mobile' ) ) {
	/**
	 * Mobile color-scheme toggle.
	 */
	function csco_header_scheme_toggle_mobile( $settings = array() ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
		if ( ! get_theme_mod( 'color_scheme_toggle', true ) ) {
			return;
		}
		?>
		<span role="button" tabindex="0" class="cs-header__scheme-toggle cs-header__scheme-toggle-mobile cs-site-scheme-toggle" aria-label="<?php esc_attr_e( 'Toggle color scheme', 'caards' ); ?>">
			<i class="cs-header__scheme-toggle-icon cs-icon cs-icon-light-mode" aria-hidden="true"></i>
			<i class="cs-header__scheme-toggle-icon cs-icon cs-icon-dark-mode" aria-hidden="true"></i>
		</span>
		<?php
	}
}

/**
 * Output a keyboard skip link before the legacy off-canvas/full-screen layers.
 */
function vaarta_skip_link() {
	?>
	<a class="vaarta-skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'caards' ); ?></a>
	<?php
}
add_action( 'csco_site_before', 'vaarta_skip_link', 1 );
