<?php
/**
 * The template part for displaying off-canvas area.
 *
 * @package Vaarta
 */

if ( csco_offcanvas_exists() ) {

	$scheme = csco_color_scheme(
		get_theme_mod( 'color_header_background', '#ffffff' ),
		get_theme_mod( 'color_header_background_dark', '#1b1c1f' )
	);
	?>

	<div class="cs-site-overlay" aria-hidden="true"></div>

	<div id="vaarta-offcanvas" class="cs-offcanvas" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Site menu', 'caards' ); ?>" aria-hidden="true" tabindex="-1">
		<div class="cs-offcanvas__header" <?php echo wp_kses( $scheme, 'csco' ); ?>>
			<?php do_action( 'csco_offcanvas_header_start' ); ?>

			<nav class="cs-offcanvas__nav" aria-label="<?php esc_attr_e( 'Mobile navigation', 'caards' ); ?>">
				<?php csco_component( 'header_logo' ); ?>

				<span class="cs-offcanvas__toggle" role="button" tabindex="0" aria-controls="vaarta-offcanvas" aria-label="<?php esc_attr_e( 'Close menu', 'caards' ); ?>"><i class="cs-icon cs-icon-x" aria-hidden="true"></i></span>
			</nav>

			<?php do_action( 'csco_offcanvas_header_end' ); ?>
		</div>
		<aside class="cs-offcanvas__sidebar">
			<div class="cs-offcanvas__inner cs-offcanvas__area cs-widget-area">
				<?php
				$locations = get_nav_menu_locations();

				// Get menu by location.
				if ( isset( $locations['primary'] ) || isset( $locations['mobile'] ) ) {

					if ( isset( $locations['primary'] ) ) {
						$location = $locations['primary'];
					}
					if ( isset( $locations['mobile'] ) ) {
						$location = $locations['mobile'];
					}

					the_widget( 'WP_Nav_Menu_Widget', array( 'nav_menu' => $location ), array(
						'before_widget' => '<div class="widget %s cs-d-lg-none">',
						'after_widget'  => '</div>',
					) );
				}
				?>

				<?php dynamic_sidebar( 'sidebar-offcanvas' ); ?>
			</div>
		</aside>
	</div>
	<?php
}
