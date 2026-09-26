<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the "cs-site" div and all content after.
 *
 * @package Vaarta
 */

?>

							<?php do_action( 'csco_main_content_end' ); ?>

						</div>

						<?php do_action( 'csco_main_content_after' ); ?>

					</div>

					<?php do_action( 'csco_site_content_end' ); ?>

				</div>

				<?php do_action( 'csco_site_content_after' ); ?>

			</main>

		<?php do_action( 'csco_footer_before' ); ?>

		<?php vaarta_render_site_footer(); ?>

		<?php do_action( 'csco_footer_after' ); ?>

	</div>

	<?php do_action( 'csco_site_end' ); ?>

</div>

<?php do_action( 'csco_site_after' ); ?>

<?php wp_footer(); ?>

</body>
</html>
