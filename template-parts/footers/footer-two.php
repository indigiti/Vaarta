<?php
/**
 * The template for displaying the footer layout 2
 *
 * @package Caards
 */

$scheme = csco_color_scheme(
	get_theme_mod( 'color_footer_background', '#ffffff' ),
	get_theme_mod( 'color_footer_background_dark', '#1b1c1f' )
);
?>

<footer class="cs-footer cs-footer-two" <?php echo wp_kses( $scheme, 'csco' ); ?>>
	<div class="cs-footer__top">
		<div class="cs-container">
			<div class="cs-footer__item">
				<div class="cs-footer__col">
					<div class="cs-footer__inner">
						<?php
							csco_component( 'footer_logo' );
							csco_component( 'footer_nav_menu' );
							csco_component( 'footer_description' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="cs-footer__bottom">
		<div class="cs-container">
			<div class="cs-footer__item">
				<div class="cs-footer__col cs-col-left">
					<div class="cs-footer__inner">
						<?php csco_component( 'footer_nav_menu_additional' ); ?>
					</div>
				</div>
				<div class="cs-footer__col cs-col-right">
					<div class="cs-footer__inner">
						<div class="cs-footer-social-links">
							<?php csco_component( 'footer_social_links' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
