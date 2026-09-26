<?php
/**
 * Theme mods
 *
 * @package Caards
 */

/**
 * Vaarta multicheck compatibility normalization.
 *
 * Loaded before the legacy field definitions are registered so the Customizer
 * write sanitizer is available, while its read-time filters attach after the
 * complete field catalog exists.
 */
require_once get_theme_file_path( '/inc/vaarta-multicheck-compat.php' );

/**
 * Register Theme Mods
 */
function csco_register_theme_mods() {

	/**
	 * Site Identity.
	 */
	require get_template_directory() . '/inc/theme-mods/site-identity.php';

	/**
	* Design.
	*/
	require get_template_directory() . '/inc/theme-mods/design-settings.php';

	/**
	 * Typography.
	 */
	require get_template_directory() . '/inc/theme-mods/typography-settings.php';

	/**
	 * Header Settings.
	 */
	require get_template_directory() . '/inc/theme-mods/header-settings.php';

	/**
	* Footer Settings.
	*/
	require get_template_directory() . '/inc/theme-mods/footer-settings.php';

	/**
	* Homepage Settings.
	*/
	require get_template_directory() . '/inc/theme-mods/homepage-settings.php';

	/**
	* Archive Settings.
	*/
	require get_template_directory() . '/inc/theme-mods/archive-settings.php';

	/**
	* Category Settings.
	*/
	require get_template_directory() . '/inc/theme-mods/category-settings.php';

	/**
	* Posts Settings.
	*/
	require get_template_directory() . '/inc/theme-mods/post-settings.php';

	/**
	* Pages Settings.
	*/
	require get_template_directory() . '/inc/theme-mods/page-settings.php';

	/**
	* Miscellaneous Settings.
	*/
	require get_template_directory() . '/inc/theme-mods/miscellaneous-settings.php';

	/**
	 * Vaarta registers complex read-time sanitizers only after every legacy
	 * Customizer field is known. This keeps direct get_theme_mod() consumers on
	 * the same sanitized data contract as the Customizer/output-style engine.
	 */
	if ( function_exists( 'vaarta_register_complex_theme_mod_filters' ) ) {
		vaarta_register_complex_theme_mod_filters();
	}
}
add_action( 'after_setup_theme', 'csco_register_theme_mods', 20 );
