<?php
/**
 * The template for displaying the header one
 *
 * @package Caards
 */

$scheme = csco_color_scheme(
	get_theme_mod( 'color_header_background', '#ffffff' ),
	get_theme_mod( 'color_header_background_dark', '#1b1c1f' )
);
?>

<div class="cs-header-before"></div>

<header class="cs-header cs-header-one" <?php echo wp_kses( $scheme, 'csco' ); ?>>
	<div class="cs-container">
		<div class="cs-header__wrapper">
			<div class="cs-header__inner cs-header__inner-desktop">
				<div class="cs-header__col cs-col-left">
					<?php
						csco_component( 'header_logo' );
						csco_component( 'header_nav_menu' );
						csco_component( 'header_multi_column_widgets' );
					?>
				</div>
				<div class="cs-header__col cs-col-right">
					<?php
						csco_component( 'header_tagline' );
						csco_component( 'header_social_links' );
						csco_component( 'header_featured_columns' );
						csco_component( 'header_scheme_toggle' );
						csco_component( 'wc_header_cart' );
						csco_component( 'header_search_toggle' );
						csco_component( 'header_fullscreen_menu_toggle' );
					?>
				</div>
			</div>

			<?php
				csco_site_nav_mobile();
				csco_site_search();
			?>
		</div>
	</div>
</header>
