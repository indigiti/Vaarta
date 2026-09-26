<?php
/**
 * Custom Styles
 *
 * @package Caards
 */

if ( csco_get_site_background( 'color' ) ) {
	?>
	/* Site Background */
	:root, [data-site-scheme="default"] {
		--cs-color-site-background: <?php csco_site_background( 'color' ); ?>;
	}
	<?php
}

if ( csco_get_site_background( 'color', 'dark' ) ) {
	?>
	[data-site-scheme="dark"] {
		--cs-color-site-background: <?php csco_site_background( 'color', 'dark' ); ?>;
	}
	<?php
}

$front_only = get_theme_mod( 'site_background_front_only', true );

$background_enabled = $front_only ? is_front_page() : __return_true();

if ( $background_enabled && csco_get_site_background( 'image' ) ) {
	?>
	:root .cs-site,
	[data-site-scheme="default"] .cs-site {
		background-image: url('<?php csco_site_background( 'image' ); ?>');
		background-repeat: <?php csco_site_background( 'repeat' ); ?>;
		background-position: <?php csco_site_background( 'position' ); ?>;
		background-size: <?php csco_site_background( 'size' ); ?>;
		background-attachment: <?php csco_site_background( 'attachment' ); ?>;
	}
	<?php
}

$front_only = get_theme_mod( 'site_background_front_only_dark', true );

$background_enabled = $front_only ? is_front_page() : __return_true();

if ( $background_enabled && csco_get_site_background( 'image', 'dark' ) ) {
	?>
	[data-site-scheme="dark"] .cs-site {
		background-image: url('<?php csco_site_background( 'image', 'dark' ); ?>');
		background-repeat: <?php csco_site_background( 'repeat', 'dark' ); ?>;
		background-position: <?php csco_site_background( 'position', 'dark' ); ?>;
		background-size: <?php csco_site_background( 'size', 'dark' ); ?>;
		background-attachment: <?php csco_site_background( 'attachment', 'dark' ); ?>;
	}
	<?php
} else {
	?>
	[data-site-scheme="dark"] .cs-site {
		background-image: none;
	}
	<?php
}


if ( csco_get_fullscreen_background( 'color' ) ) {
	?>
	/* Fullscreen Background */
	:root, [data-site-scheme="default"] {
		--cs-color-fullscreen-menu-background: <?php csco_fullscreen_background( 'color' ); ?>;
	}
	<?php
}

if ( csco_get_fullscreen_background( 'color', 'dark' ) ) {
	?>
	[data-site-scheme="dark"] {
		--cs-color-fullscreen-menu-background: <?php csco_fullscreen_background( 'color', 'dark' ); ?>;
	}
	<?php
}

if ( csco_get_fullscreen_background( 'image' ) ) {
	?>
	:root .cs-fullscreen-menu,
	[data-site-scheme="default"] .cs-fullscreen-menu {
		background-image: url('<?php csco_fullscreen_background( 'image' ); ?>');
		background-repeat: <?php csco_fullscreen_background( 'repeat' ); ?>;
		background-position: <?php csco_fullscreen_background( 'position' ); ?>;
		background-size: <?php csco_fullscreen_background( 'size' ); ?>;
		background-attachment: <?php csco_fullscreen_background( 'attachment' ); ?>;
	}
	<?php
}

if ( csco_get_fullscreen_background( 'image', 'dark' ) ) {
	?>
	[data-site-scheme="dark"] .cs-fullscreen-menu {
		background-image: url('<?php csco_fullscreen_background( 'image', 'dark' ); ?>');
		background-repeat: <?php csco_fullscreen_background( 'repeat', 'dark' ); ?>;
		background-position: <?php csco_fullscreen_background( 'position', 'dark' ); ?>;
		background-size: <?php csco_fullscreen_background( 'size', 'dark' ); ?>;
		background-attachment: <?php csco_fullscreen_background( 'attachment', 'dark' ); ?>;
	}
	<?php
} else {
	?>
	[data-site-scheme="dark"] .cs-fullscreen-menu {
		background-image: none;
	}
	<?php
}
