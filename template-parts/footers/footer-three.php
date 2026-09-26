<?php
/**
 * The template for displaying the footer layout 3
 *
 * @package Caards
 */

$scheme = csco_color_scheme(
	get_theme_mod( 'color_footer_background', '#ffffff' ),
	get_theme_mod( 'color_footer_background_dark', '#1b1c1f' )
);
?>

<footer class="cs-footer cs-footer-three" <?php echo wp_kses( $scheme, 'csco' ); ?>>
	<div class="cs-container">
		<div class="cs-footer__item">
			<div class="cs-footer__col cs-col-left">
				<div class="cs-footer__inner">
					<?php csco_component( 'footer_copyright' ); ?>
				</div>
			</div>
			<div class="cs-footer__col cs-col-center">
				<div class="cs-footer__inner">
					<?php csco_component( 'footer_nav_menu' ); ?>
				</div>
			</div>
			<div class="cs-footer__col cs-col-right">
				<div class="cs-footer__inner">
					<?php csco_component( 'footer_social_links' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
