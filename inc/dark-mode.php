<?php
/**
 * Dark-mode bootstrap.
 *
 * @package Vaarta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Apply the saved/system theme before paint to minimize color flashing.
 */
function vaarta_print_color_scheme_bootstrap(): void {
	?>
	<script>
		( function () {
			try {
				var saved = localStorage.getItem( 'vaarta-theme' );
				var theme = saved === 'light' || saved === 'dark'
					? saved
					: ( window.matchMedia( '(prefers-color-scheme: dark)' ).matches ? 'dark' : 'light' );

				document.documentElement.dataset.vaartaTheme = theme;
				document.documentElement.style.colorScheme = theme;
			} catch ( error ) {
				// Local storage may be unavailable. Fall back to the browser preference.
				var fallback = window.matchMedia( '(prefers-color-scheme: dark)' ).matches ? 'dark' : 'light';
				document.documentElement.dataset.vaartaTheme = fallback;
				document.documentElement.style.colorScheme = fallback;
			}
		}() );
	</script>
	<?php
}
add_action( 'wp_head', 'vaarta_print_color_scheme_bootstrap', 0 );
