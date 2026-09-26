<?php
/**
 * The template for displaying the footer layout 4
 *
 * @package Caards
 */

$scheme = csco_color_scheme(
	get_theme_mod( 'color_footer_background', '#ffffff' ),
	get_theme_mod( 'color_footer_background_dark', '#1b1c1f' )
);
?>

<footer class="cs-footer cs-footer-four" <?php echo wp_kses( $scheme, 'csco' ); ?>>
	<div class="cs-container">
		<div class="cs-footer__wrapper">
			<div class="cs-footer__top">
				<div class="cs-footer__item">
					<div class="cs-footer__col cs-col-left">
						<div class="cs-footer__inner">
							<?php
								csco_component( 'footer_logo' );
								csco_component( 'footer_description' );
							?>
						</div>
					</div>
					<div class="cs-footer__col cs-col-center">
						<div class="cs-footer__inner">
							<nav class="cs-footer__nav">
								<?php
								csco_component( 'footer_menu', true,
									array(
										'location' => 'footer-col-1',
									)
								);

								csco_component( 'footer_menu', true,
									array(
										'location' => 'footer-col-2',
									)
								);
								?>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<div class="cs-footer__bottom">
				<div class="cs-footer__item">
					<div class="cs-footer__col cs-col-left">
						<div class="cs-footer__inner">
							<?php csco_component( 'footer_nav_menu' ); ?>
						</div>
					</div>
					<div class="cs-footer__col cs-col-right">
						<div class="cs-footer__inner"><?php csco_component( 'footer_copyright' ); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
