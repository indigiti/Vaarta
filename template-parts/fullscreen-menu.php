<?php
/**
 * The template part for displaying fullscreen menu area.
 *
 * @package Caards
 */

$scheme = csco_color_scheme(
	get_theme_mod( 'color_site_elements_background', '#f6f7f8' ),
	get_theme_mod( 'color_site_elements_background_dark', '#1b1c1f' )
);
?>

<div class="cs-fullscreen-menu cs-fullscreen-menu-<?php echo esc_attr( csco_get_header_layout_type() ); ?>" <?php echo wp_kses( $scheme, 'csco' ); ?>>
	<div class="cs-fullscreen-menu__inner">
		<div class="cs-fullscreen-menu__header">
			<span class="cs-fullscreen-menu__header-toggle" role="button">
				<span></span>
			</span>

			<?php csco_component( 'header_logo' ); ?>

			<?php if ( get_option( 'blogdescription' ) ) { ?>
				<div class="cs-fullscreen-menu__header-tag-line"><?php echo esc_html( get_option( 'blogdescription' ) ); ?></div>
			<?php } ?>
		</div>

		<div class="cs-fullscreen-menu__row">
			<?php csco_component( 'fullscreen_nav_menu' ); ?>

			<div class="cs-fullscreen-menu__col">
				<?php csco_component( 'header_fullscreen_widgets' ); ?>
			</div>
		</div>
	</div>
</div>
